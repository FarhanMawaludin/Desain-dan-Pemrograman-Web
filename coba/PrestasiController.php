<?php

require_once __DIR__ . '/../models/PrestasiModel.php';

class PrestasiController
{
    private $prestasiModel;

    public function __construct($conn)
    {
        $this->prestasiModel = new PrestasiModel($conn);
    }
    public function getMahasiswaList()
    {
        return $this->prestasiModel->getAllMahasiswa();
    }

    public function showPrestasi($id_mahasiswa)
    {
        // Ambil daftar prestasi berdasarkan id mahasiswa
        return $this->prestasiModel->getPrestasiByMahasiswa($id_mahasiswa);
    }

    public function getDosenList()
    {
        return $this->prestasiModel->getAllDosen();
    }

    public function showPrestasiDetail($id_prestasi)
    {
        $prestasi = $this->prestasiModel->getPrestasiById($id_prestasi);
        include '../app/views/dosen/dosen_prestasi_detail.php';
    }

    public function showPrestasiDetailMahasiswa($id_prestasi)
    {
        $prestasi = $this->prestasiModel->getPrestasiById($id_prestasi);
        include '../app/views/mahasiswa/prestasidetail.php';
    }

    public function submitForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Path direktori upload
            $uploadDir = realpath(__DIR__ . '/../../public/uploads/') . '/';

            // Pastikan folder `uploads` ada
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Menangani file upload
            $file_surat_tugas = $this->handleFileUpload($_FILES['file_surat_tugas'], $uploadDir, 'surat_tugas_');
            $foto_kegiatan = $this->handleFileUpload($_FILES['foto_kegiatan'], $uploadDir, 'foto_kegiatan_');
            $file_sertifikat = $this->handleFileUpload($_FILES['file_sertifikat'], $uploadDir, 'sertifikat_');
            $file_poster = $this->handleFileUpload($_FILES['file_poster'], $uploadDir, 'poster_');
            $lampiran_hasil_kompetisi = $this->handleFileUpload($_FILES['lampiran_hasil_kompetisi'], $uploadDir, 'lampiran_');

            $id_mahasiswa = $_SESSION['user']['id_mahasiswa'];

            // Data input
            $data = [
                'tgl_pengajuan' => date('Y-m-d H:i:s'),
                'thn_akademik' => $_POST['thn_akademik'],
                'jenis_kompetisi' => $_POST['jenis_kompetisi'],
                'juara' => $_POST['juara'],
                'url_kompetisi' => $_POST['url_kompetisi'],
                'program_studi' => $_POST['program_studi'],
                'tingkat_kompetisi' => $_POST['tingkat_kompetisi'],
                'judul_kompetisi' => $_POST['judul_kompetisi'],
                'tempat_kompetisi' => $_POST['tempat_kompetisi'],
                'jumlah_pt' => $_POST['jumlah_pt'],
                'jumlah_peserta' => $_POST['jumlah_peserta'],
                'foto_kegiatan' => $foto_kegiatan,
                'no_surat_tugas' => $_POST['no_surat_tugas'],
                'tgl_surat_tugas' => date('Y-m-d', strtotime($_POST['tgl_surat_tugas'])),
                'file_surat_tugas' => $file_surat_tugas,
                'file_sertifikat' => $file_sertifikat,
                'file_poster' => $file_poster,
                'lampiran_hasil_kompetisi' => $lampiran_hasil_kompetisi,
                'id_mahasiswa' => $id_mahasiswa
            ];

            // Simpan ke database
            $success = $this->prestasiModel->insertPrestasi($data);

            if ($success) {
                header('Location: index.php?page=prestasi');
            } else {
                echo "Error inserting data into database.";
            }
        }
    }

    private function handleFileUpload($file, $uploadDir, $prefix)
    {
        if (isset($file) && $file['error'] == 0) {
            $filePath = $uploadDir . $prefix . uniqid() . '_' . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                return str_replace(realpath($uploadDir), '', $filePath); // Simpan relative path
            }
        }
        return '';
    }


    public function addPrestasi($data_prestasi, $mahasiswa_ids, $dosen_ids, $files)
    {
        try {
            // Validasi tambahan jika file kosong
            foreach ($files as $key => $file) {
                if ($file['size'] == 0 || $file['error'] !== UPLOAD_ERR_OK) {
                    $_SESSION['flash_message'] = [
                        'type' => 'danger',
                        'message' => "File $key tidak di-upload atau kosong!"
                    ];
                    header("Location: index.php?page=dosen_prestasi");
                    exit;
                }
            }

            // Panggil model untuk menyimpan data
            $isInserted = $this->prestasiModel->addPrestasi($data_prestasi, $mahasiswa_ids, $dosen_ids, $files);

            if ($isInserted) {
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Prestasi berhasil ditambahkan!'
                ];
                header("Location: index.php?page=dosen_prestasi");
                exit;
            } else {
                $_SESSION['flash_message'] = [
                    'type' => 'danger',
                    'message' => 'Gagal menambahkan prestasi.'
                ];
                header("Location: index.php?page=dosen_prestasi");
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
            header("Location: index.php?page=dosen_prestasi");
            exit;
        }
    }

    public function deletePrestasi($id_prestasi)
    {
        $isDeleted = $this->prestasiModel->deletePrestasi($id_prestasi);

        if ($isDeleted) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Prestasi berhasil dihapus!'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Gagal menghapus prestasi.'
            ];
        }

        header("Location: http://localhost/sipresma/public/index.php?page=dosen_prestasi");
        exit;
    }

    public function showAllPrestasi()
    {
        return $this->prestasiModel->getAllPrestasi();
    }

    public function editPrestasi($id_prestasi, $data_prestasi, $mahasiswa_ids, $dosen_ids)
    {
        $isUpdated = $this->prestasiModel->editPrestasi($id_prestasi, $data_prestasi, $mahasiswa_ids, $dosen_ids);

        if ($isUpdated) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Prestasi berhasil diperbarui!'
            ];
            header("Location: http://localhost/sipresma/public/index.php?page=dosen_prestasi");
            exit;
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Gagal memperbarui prestasi.'
            ];
            header("Location: http://localhost/sipresma/public/index.php?page=dosen_prestasi");
            exit;
        }
    }

    public function setujuiPrestasi($id_prestasi)
    {
        if ($this->prestasiModel->updateStatusPrestasi($id_prestasi, 'disetujui')) {
            $this->prestasiModel->insertHistoryApproval($id_prestasi, 'disetujui');
            $_SESSION['flash_message'] = 'Prestasi telah disetujui.';
            header("Location: ?page=dosen_prestasi_detail&id_prestasi=" . $id_prestasi);
            exit();
        } else {
            echo "Gagal menyetujui prestasi.";
        }
    }

    public function tolakPrestasi($id_prestasi, $alasan)
    {
        if ($this->prestasiModel->updateStatusPrestasi($id_prestasi, 'ditolak')) {
            $this->prestasiModel->insertHistoryApproval($id_prestasi, 'ditolak', $alasan);
            $_SESSION['flash_message'] = 'Prestasi telah ditolak.';
            header("Location: ?page=dosen_prestasi_detail&id_prestasi=" . $id_prestasi);
            exit();
        } else {
            echo "Gagal menolak prestasi.";
        }
    }

    public function editPrestasiMahasiswa()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_prestasi = $_POST['id_prestasi'] ?? 0;
            // Debugging: tampilkan nilai $id_prestasi
            // Tentukan direktori tempat file akan di-upload
            $uploadDir = realpath(__DIR__ . '/../../public/uploads/') . '/';
    
            // Pastikan folder 'uploads' ada
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
    
            // Proses file upload menggunakan fungsi handleFileUpload
            $file_surat_tugas = $this->handleFileUpload($_FILES['file_surat_tugas'], $uploadDir, 'surat_tugas_');
            $foto_kegiatan = $this->handleFileUpload($_FILES['foto_kegiatan'], $uploadDir, 'foto_kegiatan_');
            $file_sertifikat = $this->handleFileUpload($_FILES['file_sertifikat'], $uploadDir, 'sertifikat_');
            $file_poster = $this->handleFileUpload($_FILES['file_poster'], $uploadDir, 'poster_');
            $lampiran_hasil_kompetisi = $this->handleFileUpload($_FILES['lampiran_hasil_kompetisi'], $uploadDir, 'lampiran_');
    
            // Ambil id_mahasiswa dari session
            $id_mahasiswa = $_SESSION['user']['id_mahasiswa'];
    
            // Mengambil ID prestasi dari form POST
            $id_prestasi = $_POST['id_prestasi'] ?? 0;  // Ambil ID dari form
    
            // Validasi ID prestasi
            if ($id_prestasi > 3) {
                $_SESSION['error'] = "ID Prestasi tidak valid.";
                header("Location: index.php?page=prestasi");
                exit();
            }
    
            // Cek apakah prestasi dengan ID tersebut ada di database
            $prestasi = $this->prestasiModel->getPrestasiById($id_prestasi);
            if (!$prestasi) {
                $_SESSION['error'] = "Prestasi tidak ditemukan.";
                header("Location: index.php?page=prestasi");
                exit();
            }
    
            // Ambil data dari form dan buat array untuk pembaruan
            $data = [
                'id_prestasi' => $id_prestasi,
                'tgl_pengajuan' => $_POST['tgl_pengajuan'] ?? date('Y-m-d H:i:s'),
                'thn_akademik' => $_POST['thn_akademik'],
                'jenis_kompetisi' => $_POST['jenis_kompetisi'],
                'juara' => $_POST['juara'],
                'url_kompetisi' => $_POST['url_kompetisi'],
                'program_studi' => $_POST['program_studi'],
                'tingkat_kompetisi' => $_POST['tingkat_kompetisi'],
                'judul_kompetisi' => $_POST['judul_kompetisi'],
                'tempat_kompetisi' => $_POST['tempat_kompetisi'],
                'jumlah_pt' => $_POST['jumlah_pt'],
                'jumlah_peserta' => $_POST['jumlah_peserta'],
                'foto_kegiatan' => $foto_kegiatan,
                'no_surat_tugas' => $_POST['no_surat_tugas'],
                'tgl_surat_tugas' => $_POST['tgl_surat_tugas'],
                'file_surat_tugas' => $file_surat_tugas,
                'file_sertifikat' => $file_sertifikat,
                'file_poster' => $file_poster,
                'lampiran_hasil_kompetisi' => $lampiran_hasil_kompetisi,
                'status_pengajuan' => 'Waiting for Approval',
                'id_mahasiswa' => $id_mahasiswa
            ];
    
            // Panggil metode updatePrestasi untuk memperbarui data prestasi
            $result = $this->prestasiModel->updatePrestasi($data);
    
            // Cek hasil update
            if ($result > 0) {
                // Update session data setelah berhasil update
                $_SESSION['user']['tgl_pengajuan'] = $data['tgl_pengajuan'];
                $_SESSION['user']['thn_akademik'] = $data['thn_akademik'];
                $_SESSION['user']['jenis_kompetisi'] = $data['jenis_kompetisi'];
                $_SESSION['user']['juara'] = $data['juara'];
                $_SESSION['user']['tingkat_kompetisi'] = $data['tingkat_kompetisi'];
                $_SESSION['user']['judul_kompetisi'] = $data['judul_kompetisi'];
                $_SESSION['user']['tempat_kompetisi'] = $data['tempat_kompetisi'];
                $_SESSION['user']['jumlah_pt'] = $data['jumlah_pt'];
                $_SESSION['user']['jumlah_peserta'] = $data['jumlah_peserta'];
                $_SESSION['user']['status_pengajuan'] = $data['status_pengajuan'];
                $_SESSION['user']['foto_kegiatan'] = $data['foto_kegiatan'];
                $_SESSION['user']['no_surat_tugas'] = $data['no_surat_tugas'];
                $_SESSION['user']['tgl_surat_tugas'] = $data['tgl_surat_tugas'];
                $_SESSION['user']['file_surat_tugas'] = $data['file_surat_tugas'];
                $_SESSION['user']['file_sertifikat'] = $data['file_sertifikat'];
                $_SESSION['user']['file_poster'] = $data['file_poster'];
                $_SESSION['user']['lampiran_hasil_kompetisi'] = $data['lampiran_hasil_kompetisi'];
                $_SESSION['user']['id_mahasiswa'] = $data['id_mahasiswa'];
                $_SESSION['user']['url_kompetisi'] = $data['url_kompetisi'];
                $_SESSION['user']['program_studi'] = $data['program_studi'];
    
                // Set pesan sukses dan redirect
                $_SESSION['success'] = "Prestasi berhasil diperbarui!";
                header("Location: index.php?page=prestasi");
                exit();
            } else {
                // Jika tidak ada perubahan yang dibuat
                $_SESSION['error'] = "Tidak ada perubahan yang dibuat pada prestasi.";
                header("Location: index.php?page=prestasiedit");
                exit();
            }
        }
    
        // Jika request bukan POST
        $_SESSION['error'] = "Request tidak valid.";
        header("Location: index.php?page=home");
        exit();
    }
    
}
