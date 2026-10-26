<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Sistem Informasi Pengelolaan Data Program Sanitasi</title>
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

        /* Konten Halaman */
        .container { padding: 24px; max-width: 1300px; margin: 0 auto; display: flex; gap: 20px; flex-wrap: wrap; align-items: flex-start;}
        
        /* Kotak Bagian */
        .bottom-section {
            background-color: #FFFFFF;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .bottom-section h2 { font-size: 16px; margin-bottom: 16px; color: #166534; border-bottom: 2px solid #166534; padding-bottom: 8px; }
        
        /* Style Komponen Form internal */
        .user-form { background: white; padding: 20px; border-radius: 6px; margin-top: 10px; }
        .form-group { margin-bottom: 15px; display: flex; flex-direction: column; gap: 5px; }
        .form-group label { font-size: 14px; font-weight: 600; color: #333; }
        .form-group input, .form-group select { padding: 10px; font-size: 14px; border: 1px solid #CCC; border-radius: 4px; width: 100%; }
        .btn-submit { background-color: #3A86FF; color: white; border: none; padding: 12px; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 14px; width: 100%; margin-top: 10px; transition: background 0.2s; }
        .btn-submit:hover { background-color: #2563EB; }
        
        /* Tabel Data User */
        .table-container { overflow-x: auto; background: white; border-radius: 6px; padding: 10px;}
        .data-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; min-width: 500px;}
        .data-table th, .data-table td { padding: 10px 12px; border: 1px solid #E5E7EB; }
        .data-table th { background-color: #15803D; color: white; font-weight: 600; }
        .data-table tr:nth-child(even) { background-color: #F9FAFB; }
        
        .btn-action { padding: 6px 10px; border: none; border-radius: 4px; color: white; cursor: pointer; font-size: 12px; font-weight: bold; margin-right: 4px;}
        .btn-edit { background-color: #F59E0B; }
        .btn-edit:hover { background-color: #D97706; }
        .btn-delete { background-color: #EF4444; }
        .btn-delete:hover { background-color: #DC2626; }

        /* Modal Edit */
        .modal { display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); align-items: center; justify-content: center;}
        .modal-content { background-color: #FFFFFF; padding: 24px; border-radius: 8px; width: 450px; max-width: 90%; position: relative; box-shadow: 0 10px 15px rgba(0,0,0,0.1);}
        .close-btn { position: absolute; right: 20px; top: 15px; font-size: 24px; font-weight: bold; cursor: pointer; color: #333; }

        /* Responsiveness untuk HP dan Tablet */
        @media (max-width: 768px) {
            .header-bar { flex-direction: column; text-align: center; gap: 15px; padding: 15px; }
            .admin-profile { width: 100%; justify-content: center; }
            .admin-profile form, .admin-profile button { width: 100%; justify-content: center; }
            
            .nav-bar { flex-direction: column; text-align: center; gap: 5px; padding: 10px; }
            .nav-bar a { display: block; width: 100%; padding: 10px; }
            
            .container { padding: 10px; flex-direction: column; }
            .bottom-section { min-width: 100% !important; padding: 15px; }
            .table-container { padding: 5px; }
            .data-table th, .data-table td { padding: 8px; font-size: 12px; }
            
            .modal-content { width: 95%; margin: 10% auto; padding: 15px; }
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
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.data_sanitasi') }}">Data sanitasi</a>
            <a href="{{ route('users.create') }}" class="active">Manajemen User</a>
        </nav>
    </div>

    {{-- Blok Notifikasi Sukses dari Server Laragon --}}
    @if(session('success'))
        <div style="padding: 12px; background-color: #2E7D32; color: white; border-radius: 4px; margin: 24px auto 0 auto; max-width: 1250px; font-size: 14px; font-weight: bold; width: 95%;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <main class="container">
        
        <!-- BAGIAN KIRI: Tabel Daftar User -->
        <section class="bottom-section" style="flex: 2; min-width: 600px;">
            <h2><i class="fa-solid fa-users"></i> Daftar Petugas & Admin</h2>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Wilayah (Kelurahan)</th>
                            <th style="width: 110px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id_user }}</td>
                            <td>{{ $user->username }}</td>
                            <td><strong>{{ $user->role }}</strong></td>
                            <td>{{ $user->kelurahan ?: '-' }}</td>
                            <td>
                                <button type="button" class="btn-action btn-edit" onclick="openEditModal({{ $user->id_user }}, '{{ addslashes($user->username) }}', '{{ addslashes($user->role) }}', '{{ addslashes($user->kelurahan ?? '') }}')"><i class="fa-solid fa-pen"></i></button>
                                <form action="{{ route('admin.users.delete', $user->id_user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus user ini secara permanen?');">
                                    @csrf
                                    <button type="submit" class="btn-action btn-delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @if(count($users) == 0)
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px;">Belum ada data user.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </section>

        <!-- BAGIAN KANAN: Form Tambah User -->
        <section class="bottom-section" style="flex: 1; min-width: 320px;">
            <h2><i class="fa-solid fa-user-plus"></i> Form Tambah User Baru</h2>
            
            <form class="user-form" action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username untuk login..." required>
                </div>
                <div class="form-group">
                    <label>Kata Sandi</label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter..." required>
                </div>
                <div class="form-group">
                    <label>Hak Akses / Role</label>
                    <select name="role" required>
                        <option value="Petugas">Petugas Lapangan</option>
                        <option value="Admin">Administrator (Pusat)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Wilayah Tugas (Opsional)</label>
                    <select name="kelurahan">
                        <option value="">-- Bebas / Semua Wilayah --</option>
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
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-floppy-disk"></i> SIMPAN USER BARU
                </button>
            </form>
        </section>

    </main>

    <!-- MODAL EDIT USER -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
            <h2><i class="fa-solid fa-user-pen"></i> Edit Data User</h2>
            
            <form id="editForm" class="user-form" method="POST">
                @csrf
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="edit_username" required>
                </div>
                <div class="form-group">
                    <label>Kata Sandi (Opsional)</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                </div>
                <div class="form-group">
                    <label>Hak Akses / Role</label>
                    <select name="role" id="edit_role" required>
                        <option value="Petugas">Petugas Lapangan</option>
                        <option value="Admin">Administrator (Pusat)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Wilayah Tugas (Opsional)</label>
                    <select name="kelurahan" id="edit_kelurahan">
                        <option value="">-- Bebas / Semua Wilayah --</option>
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
                <button type="submit" class="btn-submit" style="background-color: #F59E0B;">
                    <i class="fa-solid fa-check"></i> SIMPAN PERUBAHAN
                </button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, username, role, kelurahan) {
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_kelurahan').value = kelurahan;
            
            // Set action URL dinamis berdasarkan ID
            document.getElementById('editForm').action = "/tambah-user/update/" + id;
            
            document.getElementById('editModal').style.display = "flex";
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = "none";
        }

        // Tutup modal jika klik di luar area modal
        window.onclick = function(event) {
            var modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeEditModal();
            }
        }
    </script>
</body>
</html>
