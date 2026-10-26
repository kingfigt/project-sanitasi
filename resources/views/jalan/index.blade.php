<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Jalan - Sistem Informasi Program Sanitasi</title>
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

        /* Konten */
        .container { padding: 24px; max-width: 1200px; margin: 0 auto; }
        
        .card {
            background-color: #FFFFFF;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 24px;
        }
        .card h2 { font-size: 18px; margin-bottom: 16px; color: #166534; border-bottom: 2px solid #166534; padding-bottom: 8px; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px; color: #374151; }
        .form-group select, .form-group input { 
            width: 100%; padding: 10px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 14px; 
        }
        
        .btn-submit {
            background-color: #15803D; color: white; border: none; padding: 10px 20px; font-size: 14px; font-weight: bold; border-radius: 6px; cursor: pointer; transition: background 0.2s;
        }
        .btn-submit:hover { background-color: #166534; }

        .btn-delete {
            background-color: #DC2626; color: white; border: none; padding: 6px 12px; font-size: 12px; font-weight: bold; border-radius: 4px; cursor: pointer; transition: background 0.2s;
        }
        .btn-delete:hover { background-color: #B91C1C; }

        /* Tabel */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 6px;
            overflow: hidden;
            margin-top: 10px;
        }
        .data-table th, .data-table td { padding: 12px 16px; text-align: left; font-size: 14px; border: 1px solid #E5E7EB; }
        .data-table th { background-color: #15803D; color: white; }
        .data-table tr:nth-child(even) { background-color: #F5F7FA; }
        
        .alert-success { background-color: #D1FAE5; color: #065F46; padding: 12px; border-radius: 6px; margin-bottom: 16px; border: 1px solid #A7F3D0; }
        
    </style>
</head>
<body>
    <header class="header-bar">
        <div class="brand">
            <div class="brand-text">
                <h1>DPUPR KOTA KEDIRI</h1>
                <p>Sistem Informasi Program Sanitasi</p>
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
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.data_sanitasi') }}">Data sanitasi</a>
        <a href="{{ route('users.create') }}">Manajemen User</a>
        <a href="{{ route('jalan.index') }}" class="active">Manajemen Jalan</a>
    </nav>

    <main class="container">
        @if(session('success'))
            <div class="alert-success">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <h2>Tambah Jalan Baru</h2>
            <form action="{{ route('jalan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="kelurahan">Kelurahan</label>
                    <select id="kelurahan" name="kelurahan" required>
                        <option value="">-- Pilih Kelurahan --</option>
                        <option value="Mojoroto">Mojoroto</option>
                        <option value="Pojok">Pojok</option>
                        <option value="Sukorame">Sukorame</option>
                        <option value="Bandar Lor">Bandar Lor</option>
                        <option value="Bandar Kidul">Bandar Kidul</option>
                        <option value="Campurejo">Campurejo</option>
                        <option value="Lirboyo">Lirboyo</option>
                        <option value="Mrican">Mrican</option>
                        <option value="Dermo">Dermo</option>
                        <option value="Ngampel">Ngampel</option>
                        <option value="Gayam">Gayam</option>
                        <option value="Bujel">Bujel</option>
                        <option value="Banjarmlati">Banjarmlati</option>
                        <option value="Tamanan">Tamanan</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="nama_jalan">Nama Jalan</label>
                    <input type="text" id="nama_jalan" name="nama_jalan" placeholder="Masukkan nama jalan..." required>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-plus"></i> Tambah Jalan
                </button>
            </form>
        </div>

        <div class="card">
            <h2>Daftar Jalan Terdaftar</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelurahan</th>
                        <th>Nama Jalan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jalans as $index => $jalan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $jalan->kelurahan }}</td>
                        <td>{{ $jalan->nama_jalan }}</td>
                        <td>
                            <form action="{{ route('jalan.destroy', $jalan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jalan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete"><i class="fa-solid fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Belum ada data jalan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
