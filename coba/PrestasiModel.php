<?php

class PrestasiModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function getAllPrestasi()
    {
        $query = "SELECT * FROM data_prestasi";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPrestasiByMahasiswa($id_mahasiswa)
    {
        $query = "SELECT * FROM data_prestasi WHERE id_mahasiswa = :id_mahasiswa";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_mahasiswa', $id_mahasiswa, PDO::PARAM_INT);

        $stmt->execute();

        $prestasiList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $prestasiList;
    }

    public function insertPrestasi($data)
    {

        $sql = "INSERT INTO [dbo].[data_prestasi] 
            ([tgl_pengajuan], [thn_akademik], [jenis_kompetisi], [juara], [url_kompetisi], [program_studi], 
             [tingkat_kompetisi], [judul_kompetisi], [tempat_kompetisi], [jumlah_pt], [jumlah_peserta], 
             [foto_kegiatan], [no_surat_tugas], [tgl_surat_tugas], [file_surat_tugas], 
             [file_sertifikat], [file_poster], [lampiran_hasil_kompetisi], [status_pengajuan],[id_mahasiswa]) 
        VALUES 
            (:tgl_pengajuan, :thn_akademik, :jenis_kompetisi, :juara, :url_kompetisi, :program_studi, 
             :tingkat_kompetisi, :judul_kompetisi, :tempat_kompetisi, :jumlah_pt, :jumlah_peserta, 
             CONVERT(VARBINARY(MAX), :foto_kegiatan), :no_surat_tugas, :tgl_surat_tugas, 
             CONVERT(VARBINARY(MAX), :file_surat_tugas), CONVERT(VARBINARY(MAX), :file_sertifikat), 
             CONVERT(VARBINARY(MAX), :file_poster), CONVERT(VARBINARY(MAX), :lampiran_hasil_kompetisi), 
             'Waiting for Approval',:id_mahasiswa)";

        $stmt = $this->conn->prepare($sql);
        $stmt->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_SYSTEM);
        try {
            $stmt->execute([
                ':tgl_pengajuan' => $data['tgl_pengajuan'],
                ':thn_akademik' => $data['thn_akademik'],
                ':jenis_kompetisi' => $data['jenis_kompetisi'],
                ':juara' => $data['juara'],
                ':url_kompetisi' => $data['url_kompetisi'],
                ':program_studi' => $data['program_studi'],
                ':tingkat_kompetisi' => $data['tingkat_kompetisi'],
                ':judul_kompetisi' => $data['judul_kompetisi'],
                ':tempat_kompetisi' => $data['tempat_kompetisi'],
                ':jumlah_pt' => $data['jumlah_pt'],
                ':jumlah_peserta' => $data['jumlah_peserta'],
                ':foto_kegiatan' => $data['foto_kegiatan'],
                ':no_surat_tugas' => $data['no_surat_tugas'],
                ':tgl_surat_tugas' => $data['tgl_surat_tugas'],
                ':file_surat_tugas' => $data['file_surat_tugas'],
                ':file_sertifikat' => $data['file_sertifikat'],
                ':file_poster' => $data['file_poster'],
                ':lampiran_hasil_kompetisi' => $data['lampiran_hasil_kompetisi'],
                ':id_mahasiswa' => $data['id_mahasiswa']
            ]);
            return true;
        } catch (PDOException $e) {
            die("Error inserting data: " . $e->getMessage());
        }
    }





    public function getPrestasiById($id_prestasi)
    {
        // Query untuk mendapatkan data prestasi
        $query = "SELECT 
        dp.id_prestasi, 
        dp.tgl_pengajuan,
        dp.program_studi,
        dp.url_kompetisi,
        dp.thn_akademik, 
        dp.jenis_kompetisi, 
        dp.juara, 
        dp.tingkat_kompetisi, 
        dp.judul_kompetisi, 
        dp.tempat_kompetisi, 
        dp.jumlah_pt, 
        dp.jumlah_peserta, 
        dp.status_pengajuan,
        dp.no_surat_tugas,
        dp.tgl_surat_tugas,
        dp.file_surat_tugas,
        dp.file_sertifikat,
        dp.foto_kegiatan,
        dp.file_poster,
        dp.lampiran_hasil_kompetisi

    FROM 
        data_prestasi dp
    WHERE dp.id_prestasi = :id_prestasi";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_prestasi', $id_prestasi, PDO::PARAM_INT);
        $stmt->execute();

        $prestasi = $stmt->fetch(PDO::FETCH_ASSOC);

        $queryMahasiswa = "SELECT m.nama_mahasiswa
                       FROM mahasiswa m
                       INNER JOIN mahasiswa_prestasi mp ON m.id_mahasiswa = mp.id_mahasiswa
                       WHERE mp.id_prestasi = :id_prestasi";
        $stmtMahasiswa = $this->conn->prepare($queryMahasiswa);
        $stmtMahasiswa->bindParam(':id_prestasi', $id_prestasi, PDO::PARAM_INT);
        $stmtMahasiswa->execute();
        $mahasiswa = $stmtMahasiswa->fetchAll(PDO::FETCH_COLUMN);

        $queryDosen = "SELECT d.nama_dosen
                   FROM dosen d
                   INNER JOIN dosen_prestasi dpd ON d.id_dosen = dpd.id_dosen
                   WHERE dpd.id_prestasi = :id_prestasi";
        $stmtDosen = $this->conn->prepare($queryDosen);
        $stmtDosen->bindParam(':id_prestasi', $id_prestasi, PDO::PARAM_INT);
        $stmtDosen->execute();
        $dosen = $stmtDosen->fetchAll(PDO::FETCH_COLUMN);

        $prestasi['nama_mahasiswa'] = implode('<br>', $mahasiswa);
        $prestasi['nama_dosen'] = implode('<br>', $dosen);

        return $prestasi;
    }



    public function getAllMahasiswa()
    {
        $query = "SELECT * FROM mahasiswa";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllDosen()
    {
        $query = "SELECT id_dosen, nama_dosen FROM dosen";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPrestasi($data_prestasi, $mahasiswa_ids, $dosen_ids, $files)
    {
        try {
            $this->conn->beginTransaction();

            $data_prestasi['tgl_pengajuan'] = date('Y-m-d H:i:s');

            var_dump($data_prestasi['tgl_pengajuan']);

            // Menangani file upload dan mengubah file menjadi data biner
            $file_surat_tugas = $this->uploadFileAsBinary($files['surat_tugas']);
            $file_sertifikat = $this->uploadFileAsBinary($files['sertifikat']);
            $foto_kegiatan = $this->uploadFileAsBinary($files['foto_kegiatan']);
            $file_poster = $this->uploadFileAsBinary($files['poster']);
            $lampiran_hasil_kompetisi = $this->uploadFileAsBinary($files['lampiran_hasil_kompetisi']);

            // Cek jika tanggal_selesai tidak kosong, jika kosong set dengan NULL
            $tanggal_selesai = isset($data_prestasi['tanggal_selesai']) && !empty($data_prestasi['tanggal_selesai'])
                ? $data_prestasi['tanggal_selesai']
                : '1900-01-01';

            // Menambahkan status_pengajuan ke dalam data_prestasi
            $status_pengajuan = $data_prestasi['status_pengajuan'] ?? 'belum disetujui'; // Default value jika kosong

            // Simpan data ke database
            $query = "INSERT INTO data_prestasi 
            (judul_kompetisi, thn_akademik, jenis_kompetisi, juara, tingkat_kompetisi, tempat_kompetisi, 
            jumlah_pt, jumlah_peserta, program_studi, url_kompetisi, no_surat_tugas, tgl_surat_tugas,
            status_pengajuan, tanggal_selesai, file_surat_tugas, file_sertifikat, foto_kegiatan, file_poster, lampiran_hasil_kompetisi) 
            VALUES 
            (:judul_kompetisi, :thn_akademik, :jenis_kompetisi, :juara, :tingkat_kompetisi, :tempat_kompetisi, 
            :jumlah_pt, :jumlah_peserta, :program_studi, :url_kompetisi, :no_surat_tugas, :tgl_surat_tugas,
            :status_pengajuan, :tanggal_selesai, CONVERT(VARBINARY(MAX), :file_surat_tugas), CONVERT(VARBINARY(MAX), :file_sertifikat), 
            CONVERT(VARBINARY(MAX), :foto_kegiatan), CONVERT(VARBINARY(MAX), :file_poster), 
            CONVERT(VARBINARY(MAX), :lampiran_hasil_kompetisi))";

            $stmt = $this->conn->prepare($query);
            $stmt->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_SYSTEM);
            $stmt->execute([
                ':judul_kompetisi' => $data_prestasi['judul_kompetisi'],
                ':thn_akademik' => $data_prestasi['thn_akademik'],
                ':jenis_kompetisi' => $data_prestasi['jenis_kompetisi'],
                ':juara' => $data_prestasi['juara'],
                ':tingkat_kompetisi' => $data_prestasi['tingkat_kompetisi'],
                ':tempat_kompetisi' => $data_prestasi['tempat_kompetisi'],
                ':jumlah_pt' => $data_prestasi['jumlah_pt'],
                ':jumlah_peserta' => $data_prestasi['jumlah_peserta'],
                ':program_studi' => $data_prestasi['program_studi'],
                ':url_kompetisi' => $data_prestasi['url_kompetisi'],
                ':no_surat_tugas' => $data_prestasi['no_surat_tugas'],
                ':tgl_surat_tugas' => $data_prestasi['tgl_surat_tugas'],
                ':status_pengajuan' => $status_pengajuan,
                ':tanggal_selesai' => $tanggal_selesai,
                ':file_surat_tugas' => $file_surat_tugas,
                ':file_sertifikat' => $file_sertifikat,
                ':foto_kegiatan' => $foto_kegiatan,
                ':file_poster' => $file_poster,
                ':lampiran_hasil_kompetisi' => $lampiran_hasil_kompetisi // Menambahkan ID mahasiswa
            ]);

            // Ambil ID prestasi yang baru saja disimpan
            $prestasi_id = $this->conn->lastInsertId();

            // Validasi mahasiswa_ids tidak kosong
            foreach ($mahasiswa_ids as $id_mahasiswa) {
                $query_mahasiswa = "INSERT INTO mahasiswa_prestasi id_mahasiswa, id_prestasi
                            VALUES (:id_mahasiswa, :id_prestasi)";
                $stmt_mahasiswa = $this->conn->prepare($query_mahasiswa);
                $stmt_mahasiswa->execute(['id_mahasiswa' => $id_mahasiswa, 'id_prestasi' => $id_prestasi]);
            }

            foreach ($dosen_ids as $id_dosen) {
                $query_dosen = "INSERT INTO dosen_prestasi id_dosen, id_prestasi
                        VALUES (:id_dosen, :id_prestasi)";
                $stmt_dosen = $this->conn->prepare($query_dosen);
                $stmt_dosen->execute(['id_dosen' => $id_dosen, 'id_prestasi' => $id_prestasi]);
            }

            // Commit transaksi
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }




    private function uploadFileAsBinary($file, $saveToLocal = false)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('File upload error: ' . $file['error']);
        }

        // Memastikan file valid sebelum melanjutkan
        if ($file['size'] > 0 && $file['tmp_name']) {
            // Jika diset untuk menyimpan di server lokal
            if ($saveToLocal) {
                $uploadDir = '../public/uploads/'; // Menentukan direktori tempat file disimpan
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Membuat direktori jika belum ada
                }

                $fileName = basename($file['name']);
                $targetPath = $uploadDir . $fileName;

                if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                    throw new Exception('Gagal menyimpan file ke server lokal');
                }
            }

            // Mengembalikan file sebagai data biner (untuk disimpan di database)
            return file_get_contents($file['tmp_name']);
        }

        return null; // Jika tidak ada file yang diupload
    }






    public function deletePrestasi($id_prestasi)
    {
        $sql = "DELETE FROM data_prestasi WHERE id_prestasi = :id_prestasi";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_prestasi', $id_prestasi, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function editPrestasi($id_prestasi, $data_prestasi, $mahasiswa_ids, $dosen_ids)
    {
        try {
            $this->conn->beginTransaction();

            // Update data prestasi
            $query_update_prestasi = "UPDATE [dbo].[data_prestasi]
            SET [thn_akademik] = :thn_akademik,
                [jenis_kompetisi] = :jenis_kompetisi,
                [juara] = :juara,
                [tingkat_kompetisi] = :tingkat_kompetisi,
                [judul_kompetisi] = :judul_kompetisi,
                [tempat_kompetisi] = :tempat_kompetisi,
                [jumlah_pt] = :jumlah_pt,
                [jumlah_peserta] = :jumlah_peserta,
                [status_pengajuan] = :status_pengajuan
            WHERE [id_prestasi] = :id_prestasi";

            $stmt = $this->conn->prepare($query_update_prestasi);
            $data_prestasi['id_prestasi'] = $id_prestasi;
            $stmt->execute($data_prestasi);

            // Hapus relasi lama di mahasiswa_prestasi
            $query_delete_mahasiswa = "DELETE FROM mahasiswa_prestasi WHERE id_prestasi = :id_prestasi";
            $stmt_delete_mahasiswa = $this->conn->prepare($query_delete_mahasiswa);
            $stmt_delete_mahasiswa->execute(['id_prestasi' => $id_prestasi]);

            // Masukkan relasi baru di mahasiswa_prestasi
            foreach ($mahasiswa_ids as $id_mahasiswa) {
                $query_insert_mahasiswa = "INSERT INTO mahasiswa_prestasi (id_mahasiswa, id_prestasi) 
                                       VALUES (:id_mahasiswa, :id_prestasi)";
                $stmt_insert_mahasiswa = $this->conn->prepare($query_insert_mahasiswa);
                $stmt_insert_mahasiswa->execute(['id_mahasiswa' => $id_mahasiswa, 'id_prestasi' => $id_prestasi]);
            }

            // Hapus relasi lama di dosen_prestasi
            $query_delete_dosen = "DELETE FROM dosen_prestasi WHERE id_prestasi = :id_prestasi";
            $stmt_delete_dosen = $this->conn->prepare($query_delete_dosen);
            $stmt_delete_dosen->execute(['id_prestasi' => $id_prestasi]);

            // Masukkan relasi baru di dosen_prestasi
            foreach ($dosen_ids as $id_dosen) {
                $query_insert_dosen = "INSERT INTO dosen_prestasi (id_dosen, id_prestasi) 
                                   VALUES (:id_dosen, :id_prestasi)";
                $stmt_insert_dosen = $this->conn->prepare($query_insert_dosen);
                $stmt_insert_dosen->execute(['id_dosen' => $id_dosen, 'id_prestasi' => $id_prestasi]);
            }

            $this->conn->commit();

            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function updateStatusPrestasi($id_prestasi, $status)
    {
        $sql = "UPDATE data_prestasi SET status_pengajuan = :status WHERE id_prestasi = :id_prestasi";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id_prestasi', $id_prestasi, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function insertHistoryApproval($id_prestasi, $status, $alasan = null)
    {
        $sql = "INSERT INTO history_approval (id_prestasi, status_approval, alasan) 
                VALUES (:id_prestasi, :status_approval, :alasan)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_prestasi', $id_prestasi);
        $stmt->bindParam(':status_approval', $status);
        $stmt->bindParam(':alasan', $alasan);
        return $stmt->execute();
    }

    public function getApprovalHistory($id_prestasi)
    {
        $sql = "SELECT * FROM history_approval WHERE id_prestasi = :id_prestasi ORDER BY tgl_approval DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_prestasi', $id_prestasi, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updatePrestasi($data)
{
    // Pastikan data biner untuk file diambil menggunakan file_get_contents
    if (!empty($data['file_surat_tugas'])) {
        $file_surat_tugas_content = file_get_contents($data['file_surat_tugas']); // Mengambil konten file sebagai data biner
    } else {
        $file_surat_tugas_content = null; // Jika tidak ada file, set null
    }

    // SQL query untuk memperbarui prestasi
    $sql = "UPDATE data_prestasi SET 
                thn_akademik = :thn_akademik,
                jenis_kompetisi = :jenis_kompetisi,
                juara = :juara,
                url_kompetisi = :url_kompetisi,
                program_studi = :program_studi,
                tingkat_kompetisi = :tingkat_kompetisi,
                judul_kompetisi = :judul_kompetisi,
                tempat_kompetisi = :tempat_kompetisi,
                jumlah_pt = :jumlah_pt,
                jumlah_peserta = :jumlah_peserta,
                no_surat_tugas = :no_surat_tugas,
                tgl_surat_tugas = :tgl_surat_tugas,
                status_pengajuan = :status_pengajuan,
                file_surat_tugas = CONVERT(varbinary(max), :file_surat_tugas)  -- Pastikan file disimpan sebagai biner
            WHERE id_prestasi = :id_prestasi";
    
    // Persiapkan query
    $stmt = $this->conn->prepare($sql);

    // Bind parameter dengan data yang diterima
    $stmt->bindParam(':thn_akademik', $data['thn_akademik']);
    $stmt->bindParam(':jenis_kompetisi', $data['jenis_kompetisi']);
    $stmt->bindParam(':juara', $data['juara']);
    $stmt->bindParam(':url_kompetisi', $data['url_kompetisi']);
    $stmt->bindParam(':program_studi', $data['program_studi']);
    $stmt->bindParam(':tingkat_kompetisi', $data['tingkat_kompetisi']);
    $stmt->bindParam(':judul_kompetisi', $data['judul_kompetisi']);
    $stmt->bindParam(':tempat_kompetisi', $data['tempat_kompetisi']);
    $stmt->bindParam(':jumlah_pt', $data['jumlah_pt']);
    $stmt->bindParam(':jumlah_peserta', $data['jumlah_peserta']);
    $stmt->bindParam(':no_surat_tugas', $data['no_surat_tugas']);
    $stmt->bindParam(':tgl_surat_tugas', $data['tgl_surat_tugas']);
    $stmt->bindParam(':status_pengajuan', $data['status_pengajuan']);
    $stmt->bindParam(':id_prestasi', $data['id_prestasi'], PDO::PARAM_INT);
    
    // Pastikan file disertakan jika ada
    if ($file_surat_tugas_content !== null) {
        $stmt->bindParam(':file_surat_tugas', $file_surat_tugas_content, PDO::PARAM_LOB); // Binding file sebagai data biner
    } else {
        $stmt->bindParam(':file_surat_tugas', $file_surat_tugas_content, PDO::PARAM_NULL); // Jika tidak ada file, set null
    }

    // Eksekusi query
    return $stmt->execute();
}

}
