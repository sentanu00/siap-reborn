<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
	<title>Pemeliharaan Sistem - SIAP REBORN BKPSDM Kab. Probolinggo</title>
	<!-- Google Fonts & Bootstrap 5 (Ringan & Modern) -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome 6 (Icons) -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			background: linear-gradient(135deg, #e9f0fc 0%, #f1f6fe 100%);
			font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px;
		}

		/* Card utama */
		.maintenance-card {
			background: #ffffff;
			border-radius: 32px;
			box-shadow: 0 25px 45px -12px rgba(0, 32, 64, 0.2);
			overflow: hidden;
			max-width: 580px;
			width: 100%;
			transition: transform 0.2s ease;
			border: 1px solid rgba(13, 110, 253, 0.15);
		}

		.maintenance-header {
			background: linear-gradient(105deg, #0b2b5c 0%, #0f3b7a 100%);
			padding: 30px 25px 25px 25px;
			text-align: center;
			color: white;
		}

		.logo-area {
			display: flex;
			justify-content: center;
			align-items: center;
			gap: 12px;
			margin-bottom: 16px;
			flex-wrap: wrap;
		}

		.logo-icon {
			font-size: 48px;
			background: rgba(255, 255, 255, 0.2);
			width: 70px;
			height: 70px;
			border-radius: 60px;
			display: inline-flex;
			align-items: center;
			justify-content: center;
		}

		.maintenance-header h2 {
			font-weight: 700;
			font-size: 1.8rem;
			letter-spacing: -0.3px;
			margin: 10px 0 5px;
		}

		.maintenance-header p {
			opacity: 0.9;
			font-size: 0.95rem;
			margin-bottom: 0;
		}

		.body-content {
			padding: 35px 30px 40px;
		}

		.status-badge {
			background: #ffedd5;
			color: #b45309;
			display: inline-flex;
			align-items: center;
			gap: 10px;
			padding: 8px 20px;
			border-radius: 40px;
			font-weight: 600;
			font-size: 0.85rem;
			margin-bottom: 25px;
			border-left: 4px solid #f59e0b;
		}

		.info-text {
			font-size: 1rem;
			line-height: 1.5;
			color: #1e293b;
			margin-bottom: 20px;
		}

		.alert-contact {
			background: #eef2ff;
			border-radius: 20px;
			padding: 16px 22px;
			margin-top: 20px;
			border-left: 6px solid #2563eb;
			font-size: 0.9rem;
		}

		.footer-note {
			text-align: center;
			font-size: 0.75rem;
			color: #6c757d;
			border-top: 1px solid #ecf3fa;
			padding-top: 20px;
			margin-top: 20px;
		}

		.blink-text {
			animation: softPulse 1.8s infinite;
		}

		@keyframes softPulse {
			0% {
				opacity: 0.7;
			}

			50% {
				opacity: 1;
			}

			100% {
				opacity: 0.7;
			}
		}

		@media (max-width: 480px) {
			.body-content {
				padding: 25px 20px;
			}

			.maintenance-header h2 {
				font-size: 1.4rem;
			}
		}
	</style>
</head>

<body>

	<div class="maintenance-card">
		<div class="maintenance-header">
			<div class="logo-area">
				<div class="logo-icon">
					<i class="fas fa-database fa-2x"></i>
				</div>
			</div>
			<h2><i class="fas fa-tools me-2"></i> SIAP REBORN</h2>
		</div>

		<div class="body-content">
			<div class="status-badge">
				<i class="fas fa-clock"></i> <span class="blink-text">Sedang dalam Pemeliharaan</span>
			</div>

			<div class="info-text">
				<strong>Yth. Bapak/Ibu Pegawai & Pengguna SIAP REBORN,</strong><br><br>
				Saat ini kami sedang melakukan <strong>pemeliharaan sistem</strong> untuk meningkatkan kualitas layanan kepegawaian.<br>
				Mohon maaf atas ketidaknyamanannya.
			</div>

			<div class="footer-note">
				<i class="far fa-clock"></i> Sistem akan kembali normal setelah maintenance selesai.<br>
				Terima kasih atas pengertian & kerjasamanya.
			</div>
		</div>
	</div>

	<script>
		// Refresh otomatis setiap 120 detik (2 menit) untuk mengecek apakah server sudah kembali
		setTimeout(function() {
			window.location.reload();
		}, 1200000);
	</script>
</body>

</html>