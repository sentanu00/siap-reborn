<!DOCTYPE html>
<html>

<head>
    <title>Verifikasi Token - SIAP REBORN</title>
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
        <h2>🔐 Masukkan Token Keamanan</h2>
        <p>Token 6 digit telah dikirim ke email Anda saat pertama kali aktivasi.</p>
        <?php if ($this->session->flashdata('error')): ?>
            <p class="error"><?php echo $this->session->flashdata('error'); ?></p>
        <?php endif; ?>
        <form action="<?php echo site_url('user/do_verify_token'); ?>" method="post">
            <input type="text" name="token" maxlength="6" placeholder="123456" required>
            <br>
            <button type="submit">Verifikasi & Login</button>
        </form>
        <p><a href="<?php echo site_url('user/login'); ?>">Kembali ke Login</a></p>
    </div>
</body>

</html>