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

$sql = "SELECT id_prestasi, tgl_pengajuan, thn_akademik, jenis_kompetisi, juara,url_kompetisi,program_studi, 
               tingkat_kompetisi, judul_kompetisi, tempat_kompetisi, jumlah_pt, jumlah_peserta, 
               foto_kegiatan, no_surat_tugas, tgl_surat_tugas, file_surat_tugas, 
               file_sertifikat, file_poster, lampiran_hasil_kompetisi 
        FROM dbo.data_prestasi";

$stmt = sqlsrv_query($conn, $sql);

if (!$stmt) {
    die(print_r(sqlsrv_errors(), true));
}

echo "<h1>Data Prestasi Mahasiswa</h1>";
echo "<table border='1'>";
echo "<tr>
        <th>ID Prestasi</th>
        <th>Tanggal Pengajuan</th>
        <th>Tahun Akademik</th>
        <th>Jenis Kompetisi</th>
        <th>Juara</th>
        <th>Program Studi</th>
        <th>URL Kompetisi</th>
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
      </tr>";

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id_prestasi'] ?? '') . "</td>";

    $tgl_pengajuan = $row['tgl_pengajuan'];
    if ($tgl_pengajuan instanceof DateTime) {
        $tgl_pengajuan = $tgl_pengajuan->format('Y-m-d H:i:s');
    }
    echo "<td>" . htmlspecialchars($tgl_pengajuan ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['thn_akademik'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['jenis_kompetisi'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['juara'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['program_studi'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['url_kompetisi'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['tingkat_kompetisi'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['judul_kompetisi'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['tempat_kompetisi'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['jumlah_pt'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($row['jumlah_peserta'] ?? '') . "</td>";

    if ($row['foto_kegiatan'] !== null) {
        $fotoFilePath = 'uploads/foto_' . $row['id_prestasi'] . '.jpg';
        file_put_contents($fotoFilePath, $row['foto_kegiatan']);
        echo "<td><a href='" . $fotoFilePath . "' target='_blank'><button>View Foto Kegiatan</button></a> ";
        echo "<a href='" . $fotoFilePath . "' download><button>Download Foto Kegiatan</button></a></td>";
    } else {
        echo "<td>No photo available</td>";
    }

    echo "<td>" . htmlspecialchars($row['no_surat_tugas'] ?? '') . "</td>";

    $tgl_surat_tugas = $row['tgl_surat_tugas'];
    if ($tgl_surat_tugas instanceof DateTime) {
        $tgl_surat_tugas = $tgl_surat_tugas->format('Y-m-d');
    }
    echo "<td>" . htmlspecialchars($tgl_surat_tugas ?? '') . "</td>";

    if ($row['file_surat_tugas'] !== null) {
        $filePath = 'uploads/' . $row['no_surat_tugas'] . '.pdf';
        file_put_contents($filePath, $row['file_surat_tugas']);
        echo "<td><a href='" . $filePath . "' target='_blank'><button>View Surat Tugas</button></a> ";
        echo "<a href='" . $filePath . "' download><button>Download Surat Tugas</button></a></td>";
    } else {
        echo "<td>No file available</td>";
    }

    if ($row['file_sertifikat'] !== null) {
        $filePath = 'uploads/' . $row['id_prestasi'] . '.pdf';
        file_put_contents($filePath, $row['file_sertifikat']);
        echo "<td><a href='" . $filePath . "' target='_blank'><button>View Surat Tugas</button></a> ";
        echo "<a href='" . $filePath . "' download><button>Download Surat Tugas</button></a></td>";
    } else {
        echo "<td>No file available</td>";
    }

    if ($row['file_poster'] !== null) {
        $filePath = 'uploads/' . $row['id_prestasi'] . '.pdf';
        file_put_contents($filePath, $row['file_poster']);
        echo "<td><a href='" . $filePath . "' target='_blank'><button>View </button></a> ";
        echo "<a href='" . $filePath . "' download><button>Download</button></a></td>";
    } else {
        echo "<td>No file available</td>";
    }

    if ($row['lampiran_hasil_kompetisi'] !== null) {
        $filePath = 'uploads/' . $row['id_prestasi'] . '.pdf';
        file_put_contents($filePath, $row['file_poster']);
        echo "<td><a href='" . $filePath . "' target='_blank'><button>View </button></a> ";
        echo "<a href='" . $filePath . "' download><button>Download</button></a></td>";
    } else {
        echo "<td>No file available</td>";
    }

    echo "</tr>";
}

echo "</table>";

sqlsrv_close($conn);
