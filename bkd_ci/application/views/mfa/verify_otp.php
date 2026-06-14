<!DOCTYPE html>
<html>

<head>
    <title>Verifikasi MFA - SIAP REBORN</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            padding: 50px;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 10px;
        }

        input {
            padding: 10px;
            font-size: 18px;
            text-align: center;
            width: 150px;
            margin: 10px;
        }

        button {
            padding: 10px 20px;
            background: #0b2b5c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>🔐 Verifikasi Dua Langkah</h2>
        <p>Buka aplikasi <strong>Google Authenticator</strong> di HP Anda.</p>
        <p>Masukkan kode 6 digit yang ditampilkan:</p>

        <?php if ($this->session->flashdata('error')): ?>
            <p class="error"><?php echo $this->session->flashdata('error'); ?></p>
        <?php endif; ?>

        <form action="<?php echo site_url('user/do_verify_otp'); ?>" method="post">
            <input type="text" name="otp_code" maxlength="6" autocomplete="off" required>
            <br>
            <button type="submit">Verifikasi & Login</button>
        </form>
    </div>
</body>

</html>