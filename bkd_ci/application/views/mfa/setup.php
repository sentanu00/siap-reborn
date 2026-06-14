<!DOCTYPE html>
<html>

<head>
    <title>Setup MFA - SIAP REBORN</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            padding: 50px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 10px;
        }

        .qrcode {
            margin: 20px 0;
        }

        input {
            padding: 10px;
            font-size: 18px;
            text-align: center;
            width: 150px;
        }

        button {
            padding: 10px 20px;
            background: #0b2b5c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .secret {
            background: #f0f0f0;
            padding: 8px;
            font-family: monospace;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>🔐 Setup Google Authenticator</h2>
        <p>Scan QR Code di bawah dengan aplikasi <strong>Google Authenticator</strong> di HP Anda.</p>
        <div class="qrcode">
            <img src="<?php echo site_url('user/qrcode?data=' . urlencode($totp_uri)); ?>" alt="QR Code">
        </div>
        <p>Atau masukkan kode manual: <strong class="secret"><?php echo $secret; ?></strong></p>

        <?php if ($this->session->flashdata('error')): ?>
            <p style="color:red;"><?php echo $this->session->flashdata('error'); ?></p>
        <?php endif; ?>


        <form action="<?php echo site_url('user/verify_mfa_setup'); ?>" method="post">
            <p>Masukkan kode 6 digit dari Google Authenticator untuk verifikasi:</p>
            <input type="text" name="otp_code" maxlength="6" required>
            <br><br>
            <button type="submit">Aktifkan MFA</button>
        </form>
    </div>
</body>

</html>