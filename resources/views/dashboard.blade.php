<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Pengelolaan Data Program Sanitasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Geneva, Verdana, sans-serif; }
        body { background-color: #F5F7FA; color: #333; }

        /* Header instansi hijau */
        .header-bar {
            background-color: #166534;
            color: white;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .brand { display: flex; align-items: center; }
        .brand-text h1 { font-size: 14px; color: #FFEB3B; letter-spacing: 1px; }
        .brand-text p { font-size: 16px; font-weight: bold; margin-top: 2px; }
        .admin-profile { display: flex; align-items: center; gap: 8px; font-size: 14px; }

        /* Menu Navigasi */
        .nav-bar {
            background-color: #15803D;
            padding: 10px 24px;
            display: flex;
            gap: 20px;
        }
        .nav-bar a { text-decoration: none; color: #FFFFFF; font-weight: 600; font-size: 14px; padding: 6px 12px; transition: background 0.2s; }
        .nav-bar a:not(.active):hover { background-color: #166534; border-radius: 4px; }
        .nav-bar a.active { background-color: #22C55E; color: white; border-radius: 4px; }

        /* Konten Dashboard */
        .container { padding: 24px; max-width: 1200px; margin: 0 auto; }
        
        /* Layout 3 Kotak Indikator Atas */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }
        .card {
            background-color: #FFFFFF; /* Putih bersih */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 5px solid #166534;
        }
        .card-info h3 { font-size: 13px; text-transform: uppercase; color: #4B5563; margin-bottom: 8px; }
        .card-info p { font-size: 28px; font-weight: bold; color: #111827; }
        .card-icon { font-size: 32px; color: #15803D; opacity: 0.8; }

        /* Kotak Besar Bagian Bawah */
        .bottom-section {
            background-color: #FFFFFF;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .bottom-section h2 { font-size: 16px; margin-bottom: 16px; color: #166534; border-bottom: 2px solid #166534; padding-bottom: 8px; }
        
        /* Rincian Anggaran Transparan di Dalam Menu */
        .budget-summary-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 6px;
            overflow: hidden;
            margin-top: 10px;
        }
        .budget-summary-table th, .budget-summary-table td { padding: 12px 16px; text-align: left; font-size: 14px; border: 1px solid #E5E7EB; }
        .budget-summary-table th { background-color: #15803D; color: white; }
        .budget-summary-table tr:nth-child(even) { background-color: #F5F7FA; }
        
        .badge-used { background-color: #FFCDD2; color: #B71C1C; padding: 4px 8px; border-radius: 4px; font-weight: bold; }
        .badge-remaining { background-color: #C8E6C9; color: #1B5E20; padding: 4px 8px; border-radius: 4px; font-weight: bold; }

        /* Responsiveness untuk HP dan Tablet */
        @media (max-width: 768px) {
            .header-bar { flex-direction: column; text-align: center; gap: 15px; padding: 15px; }
            .admin-profile { width: 100%; justify-content: center; }
            .admin-profile form, .admin-profile button { width: 100%; justify-content: center; }
            
            .nav-bar { flex-direction: column; text-align: center; gap: 5px; padding: 10px; }
            .nav-bar a { display: block; width: 100%; padding: 10px; }
            
            .container { padding: 10px; }
            .metrics-grid { grid-template-columns: 1fr; gap: 10px; }
            .bottom-section { padding: 15px; overflow-x: auto; }
            .budget-summary-table { min-width: 500px; } /* Paksa scroll mendatar agar tak hancur */
            .budget-summary-table th, .budget-summary-table td { padding: 8px 10px; font-size: 12px; }
            .card { padding: 15px; }
            .card-info p { font-size: 24px; }
        }
    </style>
</head>
<body>

    <div style="position: sticky; top: 0; z-index: 9999; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <header class="header-bar">
        <div class="brand">
            <div class="brand-text">
                <h1>Kecamatan Mojoroto</h1>
                <p>Sistem Informasi Pengelolaan Data Program Sanitasi</p>
            </div>
        </div>
        <div class="admin-profile">
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="background: none; border: none; color: white; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: bold; padding: 8px 12px; background-color: #D32F2F; border-radius: 4px; transition: background 0.2s;">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </header>

    <nav class="nav-bar">
        <a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a>
        <a href="{{ route('admin.data_sanitasi') }}">Data sanitasi</a>
        <a href="{{ route('users.create') }}">Manajemen User</a>
    </nav>
    </div>

    <main class="container">
        
        <section class="metrics-grid">
            <div class="card">
                <div class="card-info">
                    <h3>Sanitasi Rumah Tangga</h3>
                    <p>{{ number_format($jumlahRt) }}</p>
                </div>
                <div class="card-icon"><i class="fa-solid fa-house-chimney"></i></div>
            </div>

            <div class="card">
                <div class="card-info">
                    <h3>Sanitasi Komunal</h3>
                    <p>{{ number_format($jumlahKomunal) }}</p>
                </div>
                <div class="card-icon"><i class="fa-solid fa-users-gear"></i></div>
            </div>

            <div class="card">
                <div class="card-info">
                    <h3>Jaringan SPAL</h3>
                    <p>{{ number_format($jumlahSpal) }}</p>
                </div>
                <div class="card-icon"><i class="fa-solid fa-water"></i></div>
            </div>
        </section>

        <section class="bottom-section">
            <h2><i class="fa-solid fa-clipboard-list"></i> Ringkasan Total Data Sanitasi</h2>
            
            <table class="budget-summary-table">
                <thead>
                    <tr>
                        <th>Kategori Data</th>
                        <th>Total Keseluruhan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Fasilitas Komunal</td>
                        <td style="color: #0277BD;"><strong>{{ number_format($jumlahKomunal) }} Data</strong></td>
                    </tr>
                    <tr>
                        <td>Total Sanitasi Rumah Tangga (Kategori Layak)</td>
                        <td style="color: #2E7D32;"><strong>{{ number_format($totalLayak) }} Data</strong></td>
                    </tr>
                    <tr>
                        <td><span class="badge-used" style="background-color: #E0E0E0; color: #121212;">Total Keseluruhan Data Masuk</span> (RT + Komunal + SPAL)</td>
                        <td><strong>{{ number_format($totalSemuaData) }} Data</strong></td>
                    </tr>
                </tbody>
            </table>
        </section>

    </main>

</body>
</html>