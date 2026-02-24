<?php

namespace App\Console\Commands;

use App\Mail\PriceAlertMail;
use App\Models\PriceAlert;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckPriceAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'price-alerts:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica os alertas de preço e envia notificações por email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando verificação de alertas de preço...');

        // Buscar todos os alertas ativos
        $activeAlerts = PriceAlert::where('active', true)
            ->with(['user', 'product'])
            ->get();

        $notificationsSent = 0;

        foreach ($activeAlerts as $alert) {
            // Buscar o preço mais baixo atual do produto
            $lowestPrice = $alert->product->offers()
                ->where('is_available', true)
                ->min('price');

            if ($lowestPrice && $lowestPrice <= $alert->target_price) {
                // Verificar se já enviámos notificação nas últimas 24 horas
                $lastTriggered = $alert->last_triggered_at;
                if ($lastTriggered && $lastTriggered->diffInHours(now()) < 24) {
                    continue; // Skip se já enviámos nas últimas 24h
                }

                // Enviar notificação
                try {
                    Mail::to($alert->user->email)->send(new PriceAlertMail($alert, $lowestPrice));
                    
                    // Atualizar o timestamp da última notificação
                    $alert->update(['last_triggered_at' => now()]);
                    
                    $notificationsSent++;
                    
                    $this->info("✅ Alerta enviado para {$alert->user->email} - {$alert->product->name} (€{$lowestPrice})");
                } catch (\Exception $e) {
                    $this->error("❌ Erro ao enviar email para {$alert->user->email}: " . $e->getMessage());
                }
            }
        }

        $this->info("Verificação concluída. {$notificationsSent} notificações enviadas.");
        
        return Command::SUCCESS;
    }
}