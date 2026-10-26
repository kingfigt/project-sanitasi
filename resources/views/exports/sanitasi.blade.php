<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Sanitasi</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-family: sans-serif; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; vertical-align: middle; }
        th { background-color: #d3d3d3; font-weight: bold; }
        .text-center { text-align: center; }
        img { max-height: 80px; object-fit: contain; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Laporan Data Sanitasi - {{ strtoupper($type) }}</h2>
    
    <table>
        <thead>
            @if($type == 'rt')
                <tr>
                    <th>No</th> <th>Tgl Terkirim</th> <th>No KK</th> <th>Kepala Keluarga</th> <th>Kelurahan / Alamat</th> <th>Jamban</th> <th>Status</th> <th>Buangan Akhir</th> <th>Foto/Bukti</th>
                </tr>
            @elseif($type == 'komunal')
                <tr>
                    <th>No</th> <th>Tgl Terkirim</th> <th>ID MCK</th> <th>Wilayah</th> <th>Jumlah WC</th> <th>Pembuangan Akhir</th> <th>Status Kelayakan</th>
                </tr>
            @elseif($type == 'spal')
                <tr>
                    <th>No</th> <th>Tgl Terkirim</th> <th>ID Temuan</th> <th>Nama Kepala Keluarga</th> <th>Alamat / ID RT</th> <th>Kategori Jalur Pembuangan</th> <th>Keterangan Sistem</th> <th>Foto/Bukti</th>
                </tr>
            @elseif($type == 'laporan')
                <tr>
                    <th>No</th> <th>Tgl Terkirim</th> <th>Lokasi MCK Diadukan</th> <th>Rincian Masalah Teknis</th> <th>Kondisi Jamban</th> <th>Pembuangan</th> <th>Perbaikan Bangunan?</th> <th>Foto/Bukti</th>
                </tr>
            @endif
        </thead>
        <tbody>
            @foreach($data as $index => $item)
                @if($type == 'rt')
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') : '-' }}</td>
                        <td>{{ $item->no_kk }}</td>
                        <td>{{ $item->kepala_keluarga }}</td>
                        <td>{{ $item->kelurahan }}<br>{{ $item->alamat }}</td>
                        <td>{{ $item->jenis_jamban }} ({{ $item->kepemilikan_jamban }})</td>
                        <td>{{ $item->status_kelayakan ?? $item->status ?? '-' }}</td>
                        <td>{{ $item->pembuangan }}</td>
                        <td class="text-center" style="width: 120px; height: 100px;">
                            @if(isset($is_pdf) && $is_pdf && !empty($item->foto_dokumen))
                                @foreach(explode(',', $item->foto_dokumen) as $foto)
                                    @php $path = storage_path('app/public/dokumen/' . trim($foto)); @endphp
                                    @if(file_exists($path))
                                        <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($path)) }}" style="margin-bottom: 5px;">
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @elseif($type == 'komunal')
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') : '-' }}</td>
                        <td>MCK-KM-0{{ $item->id_komunal }}</td>
                        <td>Kel. {{ $item->kelurahan ?? 'N/A' }} / RW {{ $item->rw ?? '-' }}</td>
                        <td class="text-center">{{ $item->jml_wc }}</td>
                        <td>{{ $item->nama_sistem ?? '-' }}</td>
                        <td>{{ $item->status_kelayakan ?? $item->status ?? '-' }}</td>
                    </tr>
                @elseif($type == 'spal')
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') : '-' }}</td>
                        <td>SPAL-{{ $item->id_babs }}</td>
                        <td>{{ $item->kepala_keluarga ?? '-' }}</td>
                        <td>Kel. {{ $item->kelurahan ?? '-' }} (ID RT: {{ $item->id_rt ?? '-' }})</td>
                        <td>{{ $item->pembuangan ?? 'Tidak Layak' }}</td>
                        <td>{{ $item->simpan_keterangan ?? '-' }}</td>
                        <td class="text-center" style="width: 120px; height: 100px;">
                            @if(isset($is_pdf) && $is_pdf && !empty($item->foto_dokumen))
                                @foreach(explode(',', $item->foto_dokumen) as $foto)
                                    @php $path = storage_path('app/public/dokumen/' . trim($foto)); @endphp
                                    @if(file_exists($path))
                                        <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($path)) }}" style="margin-bottom: 5px;">
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @elseif($type == 'laporan')
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') : '-' }}</td>
                        <td>{{ $item->alamat_mck }}</td>
                        <td>{{ $item->deskrip_masalah }}</td>
                        <td>{{ $item->status_kelayakan ?? $item->status ?? '-' }}</td>
                        <td>{{ $item->kondisi_buangan }}</td>
                        <td>{{ ucfirst($item->status_perbaikan ?? 'Belum') }}</td>
                        <td class="text-center" style="width: 120px; height: 100px;">
                            @if(isset($is_pdf) && $is_pdf && !empty($item->foto_bukti))
                                @foreach(explode(',', $item->foto_bukti) as $foto)
                                    @php $path = storage_path('app/public/laporan/' . trim($foto)); @endphp
                                    @if(file_exists($path))
                                        <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($path)) }}" style="margin-bottom: 5px;">
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>
