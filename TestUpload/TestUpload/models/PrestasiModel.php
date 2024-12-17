<?php

class PrestasiModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function insertPrestasi($data)
{
    sqlsrv_begin_transaction($this->conn);

    try {
        // Insert ke tabel data_prestasi
        $sql = "INSERT INTO [dbo].[data_prestasi] 
            ([tgl_pengajuan], [program_studi], [thn_akademik], [jenis_kompetisi], [juara], 
             [tingkat_kompetisi], [judul_kompetisi], [tempat_kompetisi], [url_kompetisi], 
             [jumlah_pt], [jumlah_peserta], [status_pengajuan], [foto_kegiatan],
             [no_surat_tugas], [tgl_surat_tugas], [file_surat_tugas],
             [file_sertifikat], [file_poster], [lampiran_hasil_kompetisi]) 
        VALUES 
            (?, ?, ?, ?, ?, 
             ?, ?, ?, ?, 
             ?, ?, 'Waiting for Approval', 
             CONVERT(VARBINARY(MAX), ?),
             ?, ?, 
             CONVERT(VARBINARY(MAX), ?),
             CONVERT(VARBINARY(MAX), ?),
             CONVERT(VARBINARY(MAX), ?),
             CONVERT(VARBINARY(MAX), ?));";

        $params = [
            $data['tgl_pengajuan'],
            $data['program_studi'],
            $data['thn_akademik'],
            $data['jenis_kompetisi'],
            $data['juara'],
            $data['tingkat_kompetisi'],
            $data['judul_kompetisi'],
            $data['tempat_kompetisi'],
            $data['url_kompetisi'],
            $data['jumlah_pt'],
            $data['jumlah_peserta'],
            $data['foto_kegiatan'],
            $data['no_surat_tugas'],
            $data['tgl_surat_tugas'],
            $data['file_surat_tugas'],
            $data['file_sertifikat'],
            $data['file_poster'],
            $data['lampiran_hasil_kompetisi']
        ];

        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if (!$stmt) {
            throw new Exception('Insert ke data_prestasi gagal: ' . print_r(sqlsrv_errors(), true));
        }

        // Ambil ID terbaru dari data_prestasi
        $query = "SELECT @@IDENTITY AS id_prestasi";
        $stmt = sqlsrv_query($this->conn, $query);
        if (!$stmt) {
            throw new Exception('Gagal menjalankan @@IDENTITY: ' . print_r(sqlsrv_errors(), true));
        }
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $id_prestasi = $row['id_prestasi'];

        // Insert ke tabel prestasi_mahasiswa (multi-input)
        $sql_mahasiswa = "INSERT INTO [dbo].[prestasi_mahasiswa] 
            ([id_mahasiswa], [id_prestasi], [peran_mahasiswa]) 
        VALUES (?, ?, ?)";
        foreach ($data['mahasiswa_data'] as $mahasiswa) {
            $stmt_mahasiswa = sqlsrv_query($this->conn, $sql_mahasiswa, [
                $mahasiswa['id_mahasiswa'],
                $id_prestasi,
                $mahasiswa['peran_mahasiswa']
            ]);
            if (!$stmt_mahasiswa) {
                throw new Exception('Insert ke prestasi_mahasiswa gagal: ' . print_r(sqlsrv_errors(), true));
            }
        }

        // Insert ke tabel pembimbing_prestasi (multi-input)
        $sql_pembimbing = "INSERT INTO [dbo].[pembimbing_prestasi] 
            ([id_dosen], [id_prestasi], [peran_pembimbing]) 
        VALUES (?, ?, ?)";
        foreach ($data['dosen_data'] as $dosen) {
            $stmt_pembimbing = sqlsrv_query($this->conn, $sql_pembimbing, [
                $dosen['id_dosen'],
                $id_prestasi,
                $dosen['peran_pembimbing']
            ]);
            if (!$stmt_pembimbing) {
                throw new Exception('Insert ke pembimbing_prestasi gagal: ' . print_r(sqlsrv_errors(), true));
            }
        }

        sqlsrv_commit($this->conn);
        return true;
    } catch (Exception $e) {
        sqlsrv_rollback($this->conn);
        error_log('SQL Error: ' . $e->getMessage());
        return false;
    }
}


    public function getMahasiswaList()
    {
        $sql = "SELECT id_mahasiswa, nama_mahasiswa FROM [dbo].[mahasiswa]";
        $stmt = sqlsrv_query($this->conn, $sql);

        if (!$stmt) {
            die('SQL Error: ' . print_r(sqlsrv_errors(), true));
        }

        $mahasiswaList = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $mahasiswaList[] = $row;
        }

        return $mahasiswaList;
    }

    public function getDosenList()
    {
        $sql = "SELECT id_dosen, nama_dosen FROM [dbo].[dosen] WHERE role_dosen = 'dosen'";
        $stmt = sqlsrv_query($this->conn, $sql);

        if (!$stmt) {
            die('SQL Error: ' . print_r(sqlsrv_errors(), true));
        }

        $dosenList = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $dosenList[] = $row;
        }

        return $dosenList;
    }
}
