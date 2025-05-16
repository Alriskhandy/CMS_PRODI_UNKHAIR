<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Undangan Bergabung</title>
</head>

<body>
    <h1>Ajakan Baru</h1>
    <p>Anda telah diundang untuk bergabung ke sistem kami.</p>
    <p>Silakan klik link berikut untuk menyelesaikan proses pendaftaran:</p>
    <p><a href="{{ url('invitation/accept?token=' . $token) }}">Terima Undangan</a></p>
    <p>Terima kasih.</p>
</body>

</html>