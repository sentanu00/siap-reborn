<?php
$from_switch = isset($from_switch) ? $from_switch : false;
$from_force = isset($from_force) ? $from_force : false;
?>
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
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-danger {
            background: #dc3545;
        }

        .btn-primary {
            background: #0b2b5c;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-primary:hover {
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
        <?php if ($from_switch || $from_force): ?>
            <p>Token baru telah dibuat. Untuk menggunakannya, Anda harus logout dan login kembali.</p>
            <a href="<?php echo site_url('user/logout'); ?>" class="btn btn-danger">Logout & Kembali ke Login</a>
        <?php else: ?>
            <a href="<?php echo site_url('user/login'); ?>" class="btn btn-primary">Kembali ke Login</a>
        <?php endif; ?>
        <div class="info">
            * Setelah login, Anda dapat mengganti metode autentikasi ke Google Authenticator di menu Profil.
        </div>
    </div>
</body>

</html>