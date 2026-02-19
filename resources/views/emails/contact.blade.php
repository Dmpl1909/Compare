<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contacto</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #4f46e5;">Nova mensagem de contacto</h2>
        
        <div style="background: #f9fafb; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <p><strong>Nome:</strong> {{ $contactData['name'] }}</p>
            <p><strong>Email:</strong> {{ $contactData['email'] }}</p>
            <p><strong>Assunto:</strong> {{ $contactData['subject'] }}</p>
        </div>

        <div style="background: #fff; padding: 20px; border: 1px solid #e5e7eb; border-radius: 8px;">
            <p><strong>Mensagem:</strong></p>
            <p>{{ $contactData['message'] }}</p>
        </div>

        <p style="color: #6b7280; font-size: 14px; margin-top: 20px;">
            Esta mensagem foi enviada através do formulário de contacto do site Compare.
        </p>
    </div>
</body>
</html>
