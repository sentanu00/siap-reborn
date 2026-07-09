<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ganti Password Wajib - SIAP REBORN BKPSDM</title>
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
            width: 450px;
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
            padding-right: 35px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .alert {
            padding: 10px;
            background: #f8d7da;
            color: #721c24;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .info {
            font-size: 13px;
            color: #555;
            margin-top: 10px;
        }

        /* Sembunyikan input palsu dengan cara yang lebih ekstrem */
        .hidden-input {
            position: absolute !important;
            left: -9999px !important;
            top: -9999px !important;
            width: 1px !important;
            height: 1px !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }

        .email-container {
            margin-bottom: 15px;
        }

        .email-container input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>🔐 Ganti Password Wajib</h2>
        <p>Kebijakan keamanan mengharuskan Anda mengganti password. Password baru harus memenuhi kriteria:</p>
        <ul class="info">
            <li>Minimal 8 karakter</li>
            <li>Minimal 1 huruf BESAR</li>
            <li>Minimal 1 huruf kecil</li>
            <li>Minimal 1 angka</li>
            <li>Minimal 1 karakter unik (contoh: ! @ # $ % ^ & * ?)</li>
        </ul>

        <?php if ($this->session->flashdata('errors')): ?>
            <div class="alert">
                <?php foreach ($this->session->flashdata('errors') as $err): ?>
                    <div>- <?php echo $err; ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- FIELD EMAIL DI LUAR FORM (agar tidak terdeteksi sebagai form login) -->
        <div class="email-container">
            <label>Update Email (Aktif dan Bisa Digunakan)</label>
            <input type="text" id="email_field"
                value="<?php echo $user->email; ?>"
                autocomplete="off"
                placeholder="Email aktif">
            <small style="color: #888; font-size: 12px;"></small>
        </div>

        <!-- FORM UTAMA (HANYA PASSWORD) -->
        <form action="<?php echo site_url('user/do_force_change_password'); ?>" method="post" id="passwordForm" autocomplete="off">

            <!-- INPUT PALSU untuk membingungkan browser (sangat tersembunyi) -->
            <input type="text" class="hidden-input" name="fake_username" value="" autocomplete="off">
            <input type="password" class="hidden-input" name="fake_password" value="" autocomplete="off">

            <!-- Hidden input untuk email (diisi oleh JS) -->
            <input type="hidden" name="email" id="email_hidden" value="">

            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" id="password"
                    autocomplete="new-password"
                    readonly onfocus="this.removeAttribute('readonly')"
                    required>
                <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" id="confirm"
                    autocomplete="new-password"
                    readonly onfocus="this.removeAttribute('readonly')"
                    required>
                <span class="toggle-password" onclick="togglePassword('confirm')">👁️</span>
            </div>

            <div id="client-error" class="error" style="display:none;"></div>
            <button type="submit">Simpan Password</button>
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

        // Saat form akan disubmit, ambil nilai email dari field di luar form
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            // Ambil nilai email dari field di luar form
            var email = document.getElementById('email_field').value;
            // Masukkan ke hidden input
            document.getElementById('email_hidden').value = email;

            // Validasi password (seperti sebelumnya)
            var pass = document.getElementById('password').value;
            var confirm = document.getElementById('confirm').value;
            var errorDiv = document.getElementById('client-error');
            var errors = [];

            if (pass.length < 8) errors.push('Password minimal 8 karakter');
            if (!/[A-Z]/.test(pass)) errors.push('Password harus mengandung huruf kapital');
            if (!/[a-z]/.test(pass)) errors.push('Password harus mengandung huruf kecil');
            if (!/[0-9]/.test(pass)) errors.push('Password harus mengandung angka');
            if (!/[^A-Za-z0-9]/.test(pass)) errors.push('Password harus mengandung karakter unik (simbol)');
            if (pass !== confirm) errors.push('Konfirmasi password tidak cocok');

            if (errors.length > 0) {
                e.preventDefault();
                errorDiv.style.display = 'block';
                errorDiv.innerHTML = errors.join('<br>');
            } else {
                errorDiv.style.display = 'none';
            }
        });

        // Kosongkan input password saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('password').value = '';
            document.getElementById('confirm').value = '';
            // Hapus atribut readonly setelah beberapa saat (agar bisa diisi)
            setTimeout(function() {
                document.getElementById('password').removeAttribute('readonly');
                document.getElementById('confirm').removeAttribute('readonly');
            }, 100);
        });
    </script>
</body>

</html>