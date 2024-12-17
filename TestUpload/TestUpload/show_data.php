<?php
$serverName = "LAPTOP-CACRPO0M\SQLEXPRESS";
$connectionOptions = array(
    "Database" => "PBLSIPRESMA",
    "Uid" => "",
    "PWD" => ""
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
    die(print_r(sqlsrv_errors(), true));
}

$sql = "SELECT DISTINCT 
    dp.id_prestasi, dp.tgl_pengajuan, dp.program_studi, dp.thn_akademik, dp.jenis_kompetisi, dp.juara, 
    dp.tingkat_kompetisi, dp.judul_kompetisi, dp.tempat_kompetisi, dp.jumlah_pt, dp.jumlah_peserta, 
    dp.foto_kegiatan, dp.no_surat_tugas, dp.tgl_surat_tugas, dp.file_surat_tugas, dp.file_sertifikat, 
    dp.file_poster, dp.lampiran_hasil_kompetisi, 
    m.nama_mahasiswa, 
    d.nama_dosen
FROM 
    data_prestasi dp
INNER JOIN 
    prestasi_mahasiswa mp ON dp.id_prestasi = mp.id_prestasi
INNER JOIN 
    mahasiswa m ON m.id_mahasiswa = mp.id_mahasiswa
INNER JOIN 
    pembimbing_prestasi dpd ON dp.id_prestasi = dpd.id_prestasi
INNER JOIN 
    dosen d ON d.id_dosen = dpd.id_dosen
";

$stmt = sqlsrv_query($conn, $sql);

if (!$stmt) {
    die(print_r(sqlsrv_errors(), true));
}

// Group data by id_prestasi
$data = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $id_prestasi = $row['id_prestasi'];

    if (!isset($data[$id_prestasi])) {
        $data[$id_prestasi] = $row;
        $data[$id_prestasi]['mahasiswa_list'] = [];
        $data[$id_prestasi]['dosen_list'] = [];
    }

    // Add mahasiswa and dosen names to their respective lists
    $data[$id_prestasi]['mahasiswa_list'][] = $row['nama_mahasiswa'];
    $data[$id_prestasi]['dosen_list'][] = $row['nama_dosen'];
}

// Display the results
echo "<h1>Data Prestasi Mahasiswa</h1>";
echo "<table border='1'>";
echo "<tr>
        <th>ID Prestasi</th>
        <th>Tanggal Pengajuan</th>
        <th>Prodi</th>
        <th>Tahun Akademik</th>
        <th>Jenis Kompetisi</th>
        <th>Juara</th>
        <th>Tingkat Kompetisi</th>
        <th>Judul Kompetisi</th>
        <th>Tempat Kompetisi</th>
        <th>Jumlah PT</th>
        <th>Jumlah Peserta</th>
        <th>Foto Kegiatan</th>
        <th>No Surat Tugas</th>
        <th>Tanggal Surat Tugas</th>
        <th>File Surat Tugas</th>
        <th>File Sertifikat</th>
        <th>File Poster</th>
        <th>Lampiran Hasil Kompetisi</th>
        <th>Mahasiswa</th>
        <th>Dosen</th>
      </tr>";

foreach ($data as $row) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id_prestasi'] ?? '') . "</td>";

    $tgl_pengajuan = $row['tgl_pengajuan'];
    if ($tgl_pengajuan instanceof DateTime) {
        $tgl_pengajuan = $tgl_pengajuan->format('Y-m-d H:i:s');
    }
    echo "<td>" . htmlspecialchars($tgl_pengajuan ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['program_studi'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['thn_akademik'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['jenis_kompetisi'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['juara'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['tingkat_kompetisi'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['judul_kompetisi'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['tempat_kompetisi'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['jumlah_pt'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['jumlah_peserta'] ?? '') . "</td>";

    // Foto Kegiatan
    if ($row['foto_kegiatan'] !== null) {
        $fotoFilePath = 'uploads/foto_' . $row['id_prestasi'] . '.jpg';
        file_put_contents($fotoFilePath, $row['foto_kegiatan']);
        echo "<td><a href='" . $fotoFilePath . "' target='_blank'><button>View Foto</button></a> ";
        echo "<a href='" . $fotoFilePath . "' download><button>Download Foto</button></a></td>";
    } else {
        echo "<td>No photo available</td>";
    }

    // No Surat Tugas
    echo "<td>" . htmlspecialchars($row['no_surat_tugas'] ?? '') . "</td>";

    // Tanggal Surat Tugas
    $tgl_surat_tugas = $row['tgl_surat_tugas'];
    if ($tgl_surat_tugas instanceof DateTime) {
        $tgl_surat_tugas = $tgl_surat_tugas->format('Y-m-d');
    }
    echo "<td>" . htmlspecialchars($tgl_surat_tugas ?? '') . "</td>";

    // Surat Tugas
    if ($row['file_surat_tugas'] !== null) {
        $filePathSuratTugas = 'uploads/surat_' . $row['id_prestasi'] . '.pdf';
        file_put_contents($filePathSuratTugas, $row['file_surat_tugas']);
        echo "<td><a href='" . $filePathSuratTugas . "' target='_blank'><button>View</button></a> ";
        echo "<a href='" . $filePathSuratTugas . "' download><button>Download</button></a></td>";
    } else {
        echo "<td>No file available</td>";
    }

    // Sertifikat
    if ($row['file_sertifikat'] !== null) {
        $filePathSertifikat = 'uploads/sertifikat_' . $row['id_prestasi'] . '.pdf';
        file_put_contents($filePathSertifikat, $row['file_sertifikat']);
        echo "<td><a href='" . $filePathSertifikat . "' target='_blank'><button>View</button></a> ";
        echo "<a href='" . $filePathSertifikat . "' download><button>Download</button></a></td>";
    } else {
        echo "<td>No file available</td>";
    }

    // Poster
    if ($row['file_poster'] !== null) {
        $filePathPoster = 'uploads/poster_' . $row['id_prestasi'] . '.pdf';
        file_put_contents($filePathPoster, $row['file_poster']);
        echo "<td><a href='" . $filePathPoster . "' target='_blank'><button>View</button></a> ";
        echo "<a href='" . $filePathPoster . "' download><button>Download</button></a></td>";
    } else {
        echo "<td>No file available</td>";
    }

    // Lampiran Hasil Kompetisi
    if ($row['lampiran_hasil_kompetisi'] !== null) {
        $filePathLampiran = 'uploads/lampiran_' . $row['id_prestasi'] . '.pdf';
        file_put_contents($filePathLampiran, $row['lampiran_hasil_kompetisi']);
        echo "<td><a href='" . $filePathLampiran . "' target='_blank'><button>View</button></a> ";
        echo "<a href='" . $filePathLampiran . "' download><button>Download</button></a></td>";
    } else {
        echo "<td>No file available</td>";
    }

    // Remove duplicates in Mahasiswa and Dosen lists
    $uniqueMahasiswa = array_unique($row['mahasiswa_list']);
    $uniqueDosen = array_unique($row['dosen_list']);

    // Display Mahasiswa and Dosen
    echo "<td>" . htmlspecialchars(implode(", ", $uniqueMahasiswa)) . "</td>";
    echo "<td>" . htmlspecialchars(implode(", ", $uniqueDosen)) . "</td>";
    echo "</tr>";
}

echo "</table>";

sqlsrv_close($conn);
?>
