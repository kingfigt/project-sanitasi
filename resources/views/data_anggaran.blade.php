<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Pengelolaan Data Program Sanitasi - Data Anggaran</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #E5E5E5; color: #121212; }

        /* Style Header */
        .header-bar { background-color: #9E9E9E; color: #FFFFFF; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .logo-section h1 { font-size: 13px; color: #FFEB3B; text-transform: uppercase; }
        .logo-section p { font-size: 17px; font-weight: bold; margin-top: 2px; }
        .profile-section { display: flex; align-items: center; gap: 10px; font-size: 15px; }

        /* Navigasi */
        .nav-bar { background-color: #D6D6D6; padding: 12px 30px; display: flex; gap: 25px; }
        .nav-bar a { text-decoration: none; color: #121212; font-weight: 600; font-size: 14px; }
        .nav-bar a.active { background-color: #BDBDBD; border-radius: 4px; padding: 6px 12px; }
        /* Menyelaraskan padding link non-active agar tidak bergeser saat di-hover */
        .nav-bar a:not(.active) { padding: 6px 12px; }

        .main-container { padding: 20px; max-width: 1400px; margin: 0 auto; display: flex; flex-direction: column; gap: 20px; }

        /* Summary Cards Box Keuangan */
        .summary-wrapper { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        .card-box { background-color: white; padding: 20px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border-left: 5px solid; display: flex; justify-content: space-between; align-items: center; }
        .card-pagu { border-left-color: #007AFF; }
        .card-terpakai { border-left-color: #D32F2F; }
        .card-sisa { border-left-color: #388E3C; }
        .card-box h3 { font-size: 12px; text-transform: uppercase; color: #757575; margin-bottom: 5px; }
        .card-box p { font-size: 22px; font-weight: bold; color: #1a1a1a; }
        .card-box i { font-size: 32px; color: #BDBDBD; }

        /* Layout Grid Konten (Kiri Tabel, Kanan Pie Chart) */
        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        @media (max-width: 992px) { .content-grid { grid-template-columns: 1fr; } }

        /* Area Card Tabel */
        .table-card { background-color: #BDBDBD; padding: 20px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .table-card h2 { font-size: 14px; text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid #757575; padding-bottom: 5px; }
        .table-responsive { background-color: white; border-radius: 4px; overflow-x: auto; box-shadow: inset 0 0 4px rgba(0,0,0,0.1); }
        
        /* Desain Tabel */
        .data-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; min-width: 600px; }
        .data-table th, .data-table td { padding: 12px 15px; border: 1px solid #E0E0E0; }
        .data-table th { background-color: #2C2C2C; color: white; font-weight: 600; }
        .data-table tr:nth-child(even) { background-color: #F9F9F9; }

        /* Tombol Nota */
        .btn-nota { background-color: #007AFF; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 11px; font-weight: bold; display: inline-flex; align-items: center; gap: 4px; }
        .btn-nota:hover { background-color: #0056b3; }
        .no-image { color: #757575; font-style: italic; font-size: 11px; }

        /* Area Card Chart */
        .chart-card { background-color: #BDBDBD; padding: 20px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; flex-direction: column; }
        .chart-card h2 { font-size: 14px; text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid #757575; padding-bottom: 5px; }
        .chart-container { background-color: white; padding: 20px; border-radius: 4px; flex-grow: 1; display: flex; justify-content: center; align-items: center; min-height: 300px; }
        #budgetPieChart { max-width: 100%; max-height: 320px; }

        /* MODAL POPUP BACKGROUND STYLING */
        .modal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.7); align-items: center; justify-content: center; padding: 20px; }
        .modal-content { background-color: #fefefe; border-radius: 6px; max-width: 500px; width: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.2); animation: zoomIn 0.3s; overflow: hidden; }
        .modal-header { background-color: #1A1A1A; color: white; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; font-size: 14px; font-weight: bold; }
        .modal-close { color: #aaa; font-size: 24px; font-weight: bold; cursor: pointer; border: none; background: none; }
        .modal-close:hover { color: white; }
        .modal-close:focus { outline: none; }
        .modal-body { padding: 16px; text-align: center; background-color: #f5f5f5; }
        .modal-body img { max-width: 100%; height: auto; max-height: 400px; border-radius: 4px; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }

        @keyframes zoomIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>

    <header class="header-bar">
        <div class="logo-section">
            <h1>Kecamatan Mojoroto</h1>
            <p>Sistem Informasi pengelolaan data program sanitasi</p>
        </div>
        <div class="profile-section">
            <i class="fa-solid fa-circle-user fa-xl"></i>
            <span>Admin</span>
        </div>
    </header>

    <nav class="nav-bar">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.data_sanitasi') }}">Data sanitasi</a>
        <a href="{{ route('admin.data_anggaran') }}" class="active">Data Anggaran</a>
        <a href="{{ route('users.create') }}">Tambah User</a>
    </nav>

    <main class="main-container">
        
        <section class="summary-wrapper">
            <div class="card-box card-pagu">
                <div>
                    <h3>Total Pagu Anggaran</h3>
                    <p>Rp {{ number_format($totalPagu, 0, ',', '.') }}</p>
                </div>
                <i class="fa-solid fa-wallet"></i>
            </div>
            
            <div class="card-box card-terpakai">
                <div>
                    <h3>Anggaran Terpakai</h3>
                    <p style="color: #C62828;">Rp {{ number_format($totalTerpakai, 0, ',', '.') }}</p>
                </div>
                <i class="fa-solid fa-file-invoice-dollar"></i>
            </div>

            <div class="card-box card-sisa">
                <div>
                    <h3>Sisa Saldo Anggaran</h3>
                    <p style="color: #2E7D32;">Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}</p>
                </div>
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
        </section>

        <div class="content-grid">
            
            <section class="table-card">
                <h2><i class="fa-solid fa-list-check"></i> Tabel Penggunaan Anggaran Ter-input</h2>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width: 50px; text-align: center;">No</th>
                                <th>Tanggal Laporan</th>
                                <th>Nama Item / Keperluan</th>
                                <th style="text-align: center;">Jumlah / Satuan</th>
                                <th style="text-align: right;">Total Harga</th>
                                <th style="text-align: center;">Nota / Bukti</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataAnggaran as $index => $anggaran)
                            <tr>
                                <td style="text-align: center;">{{ $index + 1 }}</td>
                                <td>{{ $anggaran->created_at ? date('d-m-Y', strtotime($anggaran->created_at)) : '-' }}</td>
                                <td><strong>{{ $anggaran->nama_item }}</strong></td>
                                <td style="text-align: center;">
                                    {{ $anggaran->volume_item }} {{ $anggaran->satuan ?? '' }}
                                </td>
                                <td style="text-align: right; font-weight: bold; color: #C62828;">
                                    Rp {{ number_format($anggaran->total_harga, 0, ',', '.') }}
                                </td>
                                <td style="text-align: center;">
                                    @if(!empty($anggaran->foto_bukti))
                                        <button class="btn-nota" onclick="showReceipt('{{ asset($anggaran->foto_bukti) }}', '{{ $anggaran->nama_item }}')">
                                            <i class="fa-solid fa-image"></i> Lihat Bukti
                                        </button>
                                    @else
                                        <span class="no-image">Tidak ada</span>
                                    @endif
                                </td>
                                <td>-</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align: center; color: #757575; padding: 20px;">Belum ada data penggunaan anggaran dari aplikasi Android.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="chart-card">
                <h2><i class="fa-solid fa-chart-pie"></i> Proporsi Item Terbanyak</h2>
                <div class="chart-container">
                    <canvas id="budgetPieChart"></canvas>
                </div>
            </section>

        </div>
    </main>

    <div id="receiptModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span id="modalTitle">Nota Bukti Pembelian</span>
                <button class="modal-close" onclick="closeReceipt()">&times;</button>
            </div>
            <div class="modal-body">
                <img id="receiptImage" src="" alt="Foto Nota Transaksi">
            </div>
        </div>
    </div>

    <script>
        const rawChartData = @json($chartData);

        // --- 1. Logika Tampilan Modal Nota ---
        // Menampilkan gambar bukti nota saat tombol diklik
        function showReceipt(imageUrl, itemName) {
            document.getElementById('receiptImage').src = imageUrl;
            document.getElementById('modalTitle').innerText = "Nota Bukti: " + itemName;
            document.getElementById('receiptModal').style.display = "flex";
        }

        // Menutup modal nota
        function closeReceipt() {
            document.getElementById('receiptModal').style.display = "none";
        }

        // Deteksi klik area luar modal untuk menutup
        window.onclick = function(event) {
            const modal = document.getElementById('receiptModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // --- 2. Pemetaan Data dan Inisialisasi Chart.js ---
        const labelsData = rawChartData.map(item => item.nama_item);
        const nominalsData = rawChartData.map(item => item.total_nominal);

        const ctx = document.getElementById('budgetPieChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labelsData,
                datasets: [{
                    label: 'Total Pengeluaran (Rp)',
                    data: nominalsData,
                    backgroundColor: ['#007AFF', '#FF9500', '#34C759', '#FF3B30', '#AF52DE', '#5856D6', '#FFCC00'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 11 } } },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>