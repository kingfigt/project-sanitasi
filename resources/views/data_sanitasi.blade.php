<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Pengelolaan Data Program Sanitasi - Data Sanitasi</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #E5E5E5; color: #121212; }

        /* Style Header */
        .header-bar { background-color: #166534; color: #FFFFFF; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .logo-section h1 { font-size: 13px; color: #FFEB3B; text-transform: uppercase; }
        .logo-section p { font-size: 17px; font-weight: bold; margin-top: 2px; }
        .profile-section { display: flex; align-items: center; gap: 10px; font-size: 15px; }

        /* Navigasi */
        .nav-bar { background-color: #15803D; padding: 12px 30px; display: flex; gap: 25px; }
        .nav-bar a { text-decoration: none; color: #FFFFFF; font-weight: 600; font-size: 14px; transition: background 0.2s; }
        .nav-bar a.active { background-color: #22C55E; color: white; border-radius: 4px; padding: 6px 12px; }
        /* Style tambahan agar link non-active memiliki jarak padding seimbang saat di-hover */
        .nav-bar a:not(.active) { padding: 6px 12px; }
        .nav-bar a:not(.active):hover { background-color: #166534; border-radius: 4px; }

        .main-container { padding: 20px; max-width: 1400px; margin: 0 auto; display: flex; flex-direction: column; gap: 20px; }

        /* Style Peta Geotagging OSM */
        .map-card { background-color: #BDBDBD; padding: 15px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .map-card h2 { font-size: 14px; text-transform: uppercase; margin-bottom: 10px; border-bottom: 1px solid #757575; padding-bottom: 5px; }
        #map { height: 350px; width: 100%; border-radius: 4px; border: 1px solid #999; }

        /* Style Area Tabel & Navigasi Tab */
        .table-card { background-color: #BDBDBD; padding: 20px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .tab-menu { display: flex; gap: 10px; margin-bottom: 15px; border-bottom: 2px solid #757575; padding-bottom: 8px; }
        .tab-btn { background-color: #1A1A1A; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-size: 13px; font-weight: bold; transition: 0.2s; }
        .tab-btn.active { background-color: #007AFF; }
        
        .tab-content { display: none; background-color: white; border-radius: 4px; overflow-x: auto; box-shadow: inset 0 0 4px rgba(0,0,0,0.1); }
        .tab-content.active { display: block; }

        /* Desain Tabel Responsive */
        .data-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; min-width: 900px; }
        .data-table th, .data-table td { padding: 10px 12px; border: 1px solid #E0E0E0; }
        .data-table th { background-color: #2C2C2C; color: white; font-weight: 600; }
        .data-table tr:nth-child(even) { background-color: #F9F9F9; }
        
        /* DataTables Custom Styles */
        .dataTables_wrapper .dataTables_filter input { padding: 5px; border-radius: 4px; border: 1px solid #ccc; margin-bottom: 10px; }
        .dt-button { display: inline-block; background-color: #166534 !important; color: white !important; border: none !important; border-radius: 4px !important; padding: 6px 12px !important; font-weight: bold !important; margin-right: 5px; text-decoration: none; }
        .dt-button:hover { background-color: #15803D !important; }
        
        .badge { padding: 3px 6px; border-radius: 3px; font-size: 11px; font-weight: bold; color: white; }
        .bg-success { background-color: #2E7D32; }
        .bg-danger { background-color: #C62828; }
        .bg-warning { background-color: #EF6C00; }
        .bg-info { background-color: #0277BD; }

        /* Style Baru Dropdown Aksi */
        .select-status {
            padding: 5px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 4px;
            border: 1px solid #ccc;
            cursor: pointer;
            background-color: #fff;
        }
        .status-belum { color: #C62828; border-color: #C62828; }
        .status-proses { color: #EF6C00; border-color: #EF6C00; }
        .status-selesai { color: #2E7D32; border-color: #2E7D32; }
        
        /* Alert Notifikasi Sukses */
        .alert-success {
            padding: 12px;
            background-color: #2E7D32;
            color: white;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: bold;
        }

        /* Responsiveness untuk HP dan Tablet */
        @media (max-width: 768px) {
            .header-bar { flex-direction: column; text-align: center; gap: 15px; padding: 15px; }
            .profile-section { width: 100%; justify-content: center; }
            .profile-section form, .profile-section button { width: 100%; justify-content: center; }
            
            .nav-bar { flex-direction: column; text-align: center; gap: 5px; padding: 10px; }
            .nav-bar a { display: block; width: 100%; padding: 10px; }
            
            .main-container { padding: 10px; }
            .map-card h2 { text-align: center; font-size: 13px; }
            #map { height: 300px; }
            
            .tab-menu { flex-direction: column; gap: 5px; }
            .tab-btn { width: 100%; font-size: 13px; padding: 12px; }
            
            .table-card { padding: 10px; }
        }
    </style>
</head>
<body>

    <div style="position: sticky; top: 0; z-index: 9999; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <header class="header-bar">
        <div class="logo-section">
            <h1>Kecamatan Mojoroto</h1>
            <p>Sistem Informasi pengelolaan data program sanitasi</p>
        </div>
        <div class="profile-section">
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
        <a href="{{ route('admin.data_sanitasi') }}" class="active">Data sanitasi</a>
        <a href="{{ route('users.create') }}">Manajemen User</a>
    </nav>
    </div>

    <main class="main-container">
        
        {{-- Menampilkan Notifikasi jika berhasil simpan perubahan --}}
        @if(session('success'))
            <div class="alert-success">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        
        <section class="map-card">
            <h2><i class="fa-solid fa-map-location-dot"></i> Peta Sebaran Lokasi Geotagging Sanitasi & Pelaporan</h2>
            <div id="map"></div>
        </section>

        <section class="table-card">
            <div class="tab-menu">
                <button class="tab-btn active" onclick="openTab(event, 'tab-rt')">Sanitasi RT</button>
                <button class="tab-btn" onclick="openTab(event, 'tab-komunal')">Sanitasi Komunal</button>
                <button class="tab-btn" onclick="openTab(event, 'tab-babs')">Data Sambungan SPAL</button>
                <button class="tab-btn" onclick="openTab(event, 'tab-lapor')">Pelaporan Masalah</button>
            </div>

            <div id="tab-rt" class="tab-content active">
                <div style="margin-bottom: 15px;">
                    <a href="{{ route('admin.export_data', ['type' => 'rt', 'format' => 'excel']) }}" class="dt-button"><i class="fa-solid fa-file-excel"></i> Export Excel</a>
                    <a href="{{ route('admin.export_data', ['type' => 'rt', 'format' => 'pdf']) }}" class="dt-button" style="background-color: #D32F2F !important;"><i class="fa-solid fa-file-pdf"></i> Export PDF</a>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tgl Terkirim</th> <th>No KK</th> <th>Kepala Keluarga</th> <th>Kelurahan / Alamat</th> <th>Jamban</th> <th>Status</th> <th>Buangan Akhir</th> <th>Foto/Bukti</th> <th>Aksi Peta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataRt as $rt)
                        <tr>
                            <td>{{ $rt->created_at ? \Carbon\Carbon::parse($rt->created_at)->format('d M Y H:i') : '-' }}</td>
                            <td>{{ $rt->no_kk }}</td>
                            <td>{{ $rt->kepala_keluarga }}</td>
                            <td>{{ $rt->kelurahan }}<br>{{ $rt->alamat }}</td>
                            <td>{{ $rt->jenis_jamban }} ({{ $rt->kepemilikan_jamban }})</td>
                            <td>
                                @php $stRt = isset($rt->status) ? $rt->status : (isset($rt->status_kelayakan) ? $rt->status_kelayakan : ''); @endphp
                                <span class="badge {{ $stRt == 'Layak' ? 'bg-success' : 'bg-danger' }}">{{ $stRt ?: '-' }}</span>
                            </td>
                            <td>{{ $rt->pembuangan }}</td>
                            <td>
                                @if(!empty($rt->foto_dokumen))
                                    @foreach(explode(',', $rt->foto_dokumen) as $index => $foto)
                                        <a href="{{ asset('storage/dokumen/' . trim($foto)) }}" target="_blank" class="badge bg-info" style="text-decoration: none; display:block; margin-bottom: 2px;">
                                            <i class="fa-solid fa-image"></i> Lihat Foto {{ $index + 1 }}
                                        </a>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(!empty($rt->latitude) && !empty($rt->longitude))
                                    <button onclick="focusMap({{ $rt->latitude }}, {{ $rt->longitude }}, '{{ addslashes($rt->kepala_keluarga) }}')" class="badge bg-info"><i class="fa-solid fa-crosshairs"></i> Lihat</button>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="tab-komunal" class="tab-content">
                <div style="margin-bottom: 15px;">
                    <a href="{{ route('admin.export_data', ['type' => 'komunal', 'format' => 'excel']) }}" class="dt-button"><i class="fa-solid fa-file-excel"></i> Export Excel</a>
                    <a href="{{ route('admin.export_data', ['type' => 'komunal', 'format' => 'pdf']) }}" class="dt-button" style="background-color: #D32F2F !important;"><i class="fa-solid fa-file-pdf"></i> Export PDF</a>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tgl Terkirim</th> <th>ID MCK</th> <th>Wilayah</th> <th>Jumlah WC</th> <th>Pembuangan Akhir</th> <th>Status Kelayakan</th> <th>Aksi Peta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataKomunal as $km)
                        <tr>
                            <td>{{ $km->created_at ? \Carbon\Carbon::parse($km->created_at)->format('d M Y H:i') : '-' }}</td>
                            <td>MCK-KM-0{{ $km->id_komunal }}</td>
                            <td>Kel. {{ $km->kelurahan ?? 'N/A' }} / RW {{ $km->rw ?? '-' }}</td>
                            <td style="text-align: center;">{{ $km->jml_wc }}</td>
                            <td>{{ $km->nama_sistem ?? '-' }}</td>
                            <td>
                                @php $statusSekarang = isset($km->status) ? $km->status : (isset($km->status_kelayakan) ? $km->status_kelayakan : ''); @endphp
                                <span class="badge {{ $statusSekarang == 'Layak' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $statusSekarang ?: 'Tidak Diketahui' }}
                                </span>
                            </td>
                            <td>
                                @if(!empty($km->latitude) && !empty($km->longitude))
                                    <button onclick="focusMap({{ $km->latitude }}, {{ $km->longitude }}, 'MCK Komunal 0{{ $km->id_komunal }}')" class="badge bg-info"><i class="fa-solid fa-crosshairs"></i> Lihat</button>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="tab-babs" class="tab-content">
                <div style="margin-bottom: 15px;">
                    <a href="{{ route('admin.export_data', ['type' => 'spal', 'format' => 'excel']) }}" class="dt-button"><i class="fa-solid fa-file-excel"></i> Export Excel</a>
                    <a href="{{ route('admin.export_data', ['type' => 'spal', 'format' => 'pdf']) }}" class="dt-button" style="background-color: #D32F2F !important;"><i class="fa-solid fa-file-pdf"></i> Export PDF</a>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tgl Terkirim</th> <th>ID Temuan</th> <th>Nama Kepala Keluarga</th> <th>Alamat / ID RT</th> <th>Kategori Jalur Pembuangan</th> <th>Keterangan Sistem</th> <th>Foto/Bukti</th> <th>Aksi Peta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataBabs as $bb)
                        <tr>
                            <td>{{ $bb->created_at ? \Carbon\Carbon::parse($bb->created_at)->format('d M Y H:i') : '-' }}</td>
                            <td>SPAL-{{ $bb->id_babs }}</td>
                            <td>{{ $bb->kepala_keluarga ?? '-' }}</td>
                            <td>Kel. {{ $bb->kelurahan ?? '-' }} (ID RT: {{ $bb->id_rt ?? '-' }})</td>
                            <td style="color: #C62828; font-weight: bold;">{{ $bb->pembuangan ?? 'Tidak Layak' }}</td>
                            <td>{{ $bb->simpan_keterangan ?? '-' }}</td>
                            <td>
                                @if(!empty($bb->foto_dokumen))
                                    @foreach(explode(',', $bb->foto_dokumen) as $index => $foto)
                                        <a href="{{ asset('storage/dokumen/' . trim($foto)) }}" target="_blank" class="badge bg-info" style="text-decoration: none; display:block; margin-bottom: 2px;">
                                            <i class="fa-solid fa-image"></i> Lihat Foto {{ $index + 1 }}
                                        </a>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(!empty($bb->latitude) && !empty($bb->longitude))
                                    <button onclick="focusMap({{ $bb->latitude }}, {{ $bb->longitude }}, 'Sambungan SPAL: {{ addslashes($bb->kepala_keluarga) }}')" class="badge bg-info"><i class="fa-solid fa-crosshairs"></i> Lihat</button>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="tab-lapor" class="tab-content">
                <div style="margin-bottom: 15px;">
                    <a href="{{ route('admin.export_data', ['type' => 'laporan', 'format' => 'excel']) }}" class="dt-button"><i class="fa-solid fa-file-excel"></i> Export Excel</a>
                    <a href="{{ route('admin.export_data', ['type' => 'laporan', 'format' => 'pdf']) }}" class="dt-button" style="background-color: #D32F2F !important;"><i class="fa-solid fa-file-pdf"></i> Export PDF</a>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tgl Terkirim</th> <th>Lokasi MCK Diadukan</th> <th>Rincian Masalah Teknis</th> <th>Kondisi Jamban</th> <th>Pembuangan</th> <th>Perbaikan Bangunan? (Aksi Admin)</th> <th>Foto/Bukti</th> <th>Aksi Peta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataPelaporan as $lp)
                        <tr>
                            <td>{{ $lp->created_at ? \Carbon\Carbon::parse($lp->created_at)->format('d M Y H:i') : '-' }}</td>
                            <td><strong>{{ $lp->alamat_mck }}</strong></td>
                            <td>{{ $lp->deskrip_masalah }}</td>
                            <td>
                                @php $stLp = isset($lp->status) ? $lp->status : (isset($lp->status_kelayakan) ? $lp->status_kelayakan : ''); @endphp
                                <span class="badge {{ $stLp == 'Layak' ? 'bg-success' : 'bg-danger' }}">{{ $stLp ?: '-' }}</span>
                            </td>
                            <td>{{ $lp->kondisi_buangan }}</td>
                            
                            <td>
                                <form action="{{ route('admin.update_status_perbaikan') }}" method="POST" style="margin:0; padding:0;">
                                    @csrf
                                    <input type="hidden" name="id_laporan" value="{{ $lp->id_laporan }}">
                                    
                                    @php
                                        $currentStatus = strtolower($lp->status_perbaikan);
                                        $selectClass = 'status-belum';
                                        if($currentStatus == 'proses') { $selectClass = 'status-proses'; }
                                        elseif($currentStatus == 'selesai') { $selectClass = 'status-selesai'; }
                                    @endphp

                                    <select name="status_perbaikan" class="select-status {{ $selectClass }}" onchange="this.form.submit()">
                                        <option value="belum" {{ $currentStatus == 'belum' ? 'selected' : '' }}>Belum (Antrean)</option>
                                        <option value="proses" {{ $currentStatus == 'proses' ? 'selected' : '' }}>Proses (Dikerjakan)</option>
                                        <option value="selesai" {{ $currentStatus == 'selesai' ? 'selected' : '' }}>Selesai (Aman)</option>
                                    </select>
                                </form>
                            </td>
                            
                            <td>
                                @if(!empty($lp->foto_bukti))
                                    @foreach(explode(',', $lp->foto_bukti) as $index => $foto)
                                        <a href="{{ asset('storage/laporan/' . trim($foto)) }}" target="_blank" class="badge bg-info" style="text-decoration: none; display:block; margin-bottom: 2px;">
                                            <i class="fa-solid fa-image"></i> Lihat Foto {{ $index + 1 }}
                                        </a>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(!empty($lp->latitude) && !empty($lp->longitude))
                                    <button onclick="focusMap({{ $lp->latitude }}, {{ $lp->longitude }}, 'Laporan Masalah: {{ addslashes($lp->alamat_mck) }}')" class="badge bg-info"><i class="fa-solid fa-crosshairs"></i> Lihat</button>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([-7.816, 112.010], 14);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // 1. Marker Rumah Tangga
        @foreach($dataRt as $rt)
            @if(!empty($rt->latitude) && !empty($rt->longitude))
                @php $mapStRt = isset($rt->status) ? $rt->status : (isset($rt->status_kelayakan) ? $rt->status_kelayakan : '-'); @endphp
                L.marker([{{ $rt->latitude }}, {{ $rt->longitude }}]).addTo(map)
                    .bindPopup("<b>Sanitasi RT: {{ addslashes($rt->kepala_keluarga) }}</b><br>Status: {{ $mapStRt }}<br>Buangan: {{ $rt->pembuangan }}");
            @endif
        @endforeach

        // 2. Marker Komunal
        @foreach($dataKomunal as $km)
            @if(!empty($km->latitude) && !empty($km->longitude))
                @php $mapStKm = isset($km->status) ? $km->status : (isset($km->status_kelayakan) ? $km->status_kelayakan : '-'); @endphp
                L.marker([{{ $km->latitude }}, {{ $km->longitude }}]).addTo(map)
                    .bindPopup("<b>MCK Komunal: 0{{ $km->id_komunal }}</b><br>Kelurahan: {{ $km->kelurahan ?? 'N/A' }}<br>Kondisi: {{ $mapStKm }}");
            @endif
        @endforeach

        // 3. Marker Pelaporan
        @foreach($dataPelaporan as $lp)
            @if(!empty($lp->latitude) && !empty($lp->longitude))
                L.marker([{{ $lp->latitude }}, {{ $lp->longitude }}]).addTo(map)
                    .bindPopup("<b>⚠️ ADUAN KERUSAKAN</b><br>Lokasi: {{ addslashes($lp->alamat_mck) }}<br>Masalah: {{ addslashes($lp->deskrip_masalah) }}");
            @endif
        @endforeach

        function focusMap(lat, lon, title) {
            map.setView([lat, lon], 18, { animate: true, duration: 1 });
            L.popup().setLatLng([lat, lon]).setContent("<b>" + title + "</b>").openOn(map);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function openTab(evt, tabId) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) { tabcontent[i].style.display = "none"; }
            tablinks = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tablinks.length; i++) { tablinks[i].className = tablinks[i].className.replace(" active", ""); }
            document.getElementById(tabId).style.display = "block";
            evt.currentTarget.className += " active";
            
            // Adjust DataTables columns on tab switch
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        }
    </script>

    <!-- DataTables & Plugins JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                order: [], // Menonaktifkan pengurutan default agar mengikuti urutan dari server (terbaru)
                language: {
                    search: "Cari Data:",
                    lengthMenu: "Tampilkan _MENU_ baris",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "Lanjut",
                        previous: "Kembali"
                    }
                }
            });
        });
    </script>
</body>
</html>