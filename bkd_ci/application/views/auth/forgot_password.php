<!DOCTYPE html>
<html>

<head>
    <title>Lupa Password - SIAP REBORN</title>
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
            width: 90%;
            margin: 10px;
        }

        button {
            padding: 10px 20px;
            background: #0b2b5c;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>🔐 Lupa Password?</h2>
        <p>Masukkan email Anda, kami akan kirim link untuk reset password.</p>

        <?php if ($this->session->flashdata('message')): ?>
            <p style="color: green;"><?php echo $this->session->flashdata('message'); ?></p>
        <?php endif; ?>

        <form action="<?php echo base_url('auth/send_reset_link'); ?>" method="post">
            <input type="email" name="email" placeholder="Email Anda" required>
            <br>
            <button type="submit">Kirim Link Reset</button>
        </form>
        <p><a href="<?php echo base_url('login'); ?>">Kembali ke Login</a></p>
    </div>
</body>

</html>