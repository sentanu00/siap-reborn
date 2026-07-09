<!DOCTYPE html>
<html>

<head>
    <title>Lupa Password - SIAP REBORN BKPSDM</title>
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
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #0b2b5c;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #0b2b5c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #1e4a7a;
        }

        .alert {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .text-center {
            text-align: center;
        }

        .info {
            font-size: 13px;
            color: #888;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>🔐 Lupa Password?</h2>
        <p style="text-align: center; font-size: 14px; color: #555;">
            Masukkan <strong>Username</strong> dan <strong>Email</strong> Anda.
        </p>

        <?php if ($this->session->flashdata('message')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('message'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo site_url('user/send_reset_link'); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Username Anda" required>
            </div>
            <div class="form-group">
                <label>Email Terdaftar</label>
                <input type="email" name="email" placeholder="email@anda.com" required>
            </div>
            <button type="submit">Kirim Link Reset</button>
        </form>

        <div class="text-center" style="margin-top: 15px;">
            <a href="<?php echo site_url('user/login'); ?>">← Kembali ke Login</a>
        </div>

        <div class="info text-center">
            Link reset akan dikirim ke email Anda. Cek juga folder spam.
        </div>
    </div>
</body>

</html>