<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sedang Pemeliharaan - {{ $settings['store_name'] ?? 'Toko Pesan Roti' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            background-color: #FAF3DF;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #4A3B32;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .maintenance-card {
            background: #FFFFFF;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(74, 59, 50, 0.08);
            border: 1px solid #EADBCE;
            max-width: 640px;
            width: 100%;
            overflow: hidden;
            text-align: center;
        }

        .maintenance-hero {
            background: linear-gradient(135deg, #F9EBD0 0%, #FAF3DF 100%);
            padding: 40px 20px;
            border-bottom: 1px solid #EADBCE;
            position: relative;
        }

        .icon-circle {
            width: 90px;
            height: 90px;
            background: #FFFFFF;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 25px rgba(200, 157, 124, 0.25);
            border: 3px solid #C89D7C;
        }

        .btn-caramel {
            background-color: #C89D7C;
            color: #FFFFFF;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-caramel:hover {
            background-color: #B58A69;
            color: #FFFFFF;
            transform: translateY(-2px);
        }

        .btn-whatsapp {
            background-color: #25D366;
            color: #FFFFFF;
            font-weight: 600;
            border: none;
        }
        .btn-whatsapp:hover {
            background-color: #1EBE5D;
            color: #FFFFFF;
        }
    </style>
</head>
<body>
    <div class="maintenance-card">
        <!-- Hero Header -->
        <div class="maintenance-hero">
            <div class="icon-circle">
                <i class="fa-solid fa-wheat-awn fs-1 text-caramel"></i>
            </div>
            <span class="badge px-3 py-2 rounded-pill mb-2 fw-semibold" style="background-color: #FCE4D6; color: #C65911; font-size: 0.75rem; letter-spacing: 0.5px;">
                <i class="fa-solid fa-screwdriver-wrench me-1"></i> MODE PEMELIHARAAN SISTEM
            </span>
            <h2 class="font-serif fw-bold text-primary mb-2" style="color: #4A3B32;">{{ $settings['store_name'] ?? 'Toko Pesan Roti' }}</h2>
            <p class="text-muted small mb-0" style="font-size: 0.9rem;">Kehangatan di Setiap Gigitan</p>
        </div>

        <!-- Body Content -->
        <div class="p-4 p-md-5">
            <h4 class="font-serif fw-bold text-primary mb-3">Toko Roti Sedang Pemeliharaan Routine</h4>
            <p class="text-muted mb-4" style="line-height: 1.7; font-size: 0.95rem;">
                Kami sedang merawat dan memperbarui sistem oven digital kami untuk menghadirkan pengalaman belanja roti artisanal yang lebih segar, lancar, dan terbaik bagi Anda. Silakan kembali beberapa saat lagi.
            </p>

            <!-- Footer & Admin Link -->
            <div class="border-top border-light pt-3 d-flex justify-content-between align-items-center">
                <span class="text-muted small" style="font-size: 0.78rem;">
                    &copy; {{ date('Y') }} {{ $settings['store_name'] ?? 'Toko Pesan Roti' }}.
                </span>
                <a href="{{ route('admin.login') }}" class="text-decoration-none text-muted small" style="font-size: 0.78rem;">
                    <i class="fa-solid fa-lock me-1"></i> Login Administrator
                </a>
            </div>
        </div>
    </div>
</body>
</html>
