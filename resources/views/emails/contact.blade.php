<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Mensagem de Contato</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background: #f9fafb;
            border-radius: 8px;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .header {
            background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            margin: -30px -30px 20px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            color: #4b5563;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .field-value {
            margin-top: 5px;
            padding: 12px;
            background: white;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        .message-box {
            background: white;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 Nova Mensagem de Contato</h1>
        </div>

        <div class="field">
            <div class="field-label">De:</div>
            <div class="field-value">{{ $data['name'] }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email:</div>
            <div class="field-value">
                <a href="mailto:{{ $data['email'] }}" style="color: #06b6d4; text-decoration: none;">
                    {{ $data['email'] }}
                </a>
            </div>
        </div>

        <div class="field">
            <div class="field-label">Assunto:</div>
            <div class="field-value">{{ $data['subject'] }}</div>
        </div>

        <div class="field">
            <div class="field-label">Mensagem:</div>
            <div class="message-box">{{ $data['message'] }}</div>
        </div>

        <div class="footer">
            <p>Esta mensagem foi enviada através do formulário de contato do site.</p>
            <p>Data: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
