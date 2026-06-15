<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Token Keamanan - SIAP REBORN BKPSDM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            text-align: center;
        }

        h2 {
            color: #0b2b5c;
        }

        .token {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 8px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px dashed #0b2b5c;
            display: inline-block;
            margin: 20px 0;
            font-family: monospace;
        }

        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px;
            text-align: left;
            margin: 20px 0;
            border-radius: 5px;
        }

        .btn {
            display: inline-block;
            background: #0b2b5c;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        .btn:hover {
            background: #1e4a7a;
        }

        .info {
            font-size: 14px;
            color: #555;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>🔐 Token Keamanan Anda</h2>
        <p>Kebijakan keamanan mengharuskan autentikasi dua langkah.</p>
        <div class="token"><?php echo $token; ?></div>
        <div class="warning">
            <strong>⚠️ Simpan token ini dengan aman!</strong><br>
            Token 6 digit ini WAJIB dimasukkan setiap kali Anda login setelah memasukkan username dan password.<br>
            Jangan berikan token kepada siapapun, termasuk petugas yang mengaku dari BKPSDM.<br>
            Jika kehilangan token, Anda dapat mereset melalui menu profil (setelah login) atau hubungi admin.
        </div>
        <a href="<?php echo site_url('user/login'); ?>" class="btn">Kembali ke Halaman Login</a>
        <div class="info">
            * Setelah login, Anda dapat mengganti metode autentikasi ke Google Authenticator di menu Profil.
        </div>
    </div>
</body>

</html>