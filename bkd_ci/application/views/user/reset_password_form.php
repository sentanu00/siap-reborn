<!DOCTYPE html>
<html>

<head>
    <title>Reset Password - SIAP REBORN BKPSDM</title>
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
            position: relative;
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

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .info {
            font-size: 13px;
            color: #888;
            margin-top: 10px;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 38px;
            cursor: pointer;
            user-select: none;
            font-size: 18px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>🔐 Reset Password</h2>
        <p style="text-align: center; font-size: 14px; color: #555;">Buat password baru untuk akun Anda.</p>

        <?php if ($this->session->flashdata('errors')): ?>
            <div class="alert alert-danger">
                <?php foreach ($this->session->flashdata('errors') as $err): ?>
                    <div>- <?php echo $err; ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <ul style="font-size: 13px; color: #555; padding-left: 20px;">
            <li>Minimal 8 karakter</li>
            <li>Minimal 1 huruf BESAR</li>
            <li>Minimal 1 huruf kecil</li>
            <li>Minimal 1 angka</li>
            <li>Minimal 1 karakter unik (! @ # $ % ^ & * ?)</li>
        </ul>

        <form action="<?php echo site_url('user/do_reset_password'); ?>" method="post">
            <input type="hidden" name="token" value="<?php echo $token; ?>">

            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" id="password" required>
                <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="confirm" required>
                <span class="toggle-password" onclick="togglePassword('confirm')">👁️</span>
            </div>

            <button type="submit">Simpan Password Baru</button>
        </form>
    </div>

    <script>
        function togglePassword(fieldId) {
            var field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
            } else {
                field.type = "password";
            }
        }
    </script>
</body>

</html>