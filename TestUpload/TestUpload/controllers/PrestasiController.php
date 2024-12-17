<?php

require_once 'models/PrestasiModel.php';

class PrestasiController
{
    private $model;

    public function __construct($conn)
    {
        $this->model = new PrestasiModel($conn);
    }

    public function handlePostRequest()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Data utama prestasi
        $data = [
            'tgl_pengajuan' => date('Y-m-d H:i:s', strtotime($_POST['tgl_pengajuan'])),
            'program_studi' => $_POST['program_studi'],
            'thn_akademik' => $_POST['thn_akademik'],
            'jenis_kompetisi' => $_POST['jenis_kompetisi'],
            'juara' => $_POST['juara'],
            'tingkat_kompetisi' => $_POST['tingkat_kompetisi'],
            'judul_kompetisi' => $_POST['judul_kompetisi'],
            'tempat_kompetisi' => $_POST['tempat_kompetisi'],
            'url_kompetisi' => $_POST['url_kompetisi'],
            'jumlah_pt' => $_POST['jumlah_pt'],
            'jumlah_peserta' => $_POST['jumlah_peserta'],
            'no_surat_tugas' => $_POST['no_surat_tugas'],
            'tgl_surat_tugas' => date('Y-m-d', strtotime($_POST['tgl_surat_tugas'])),
            'foto_kegiatan' => isset($_FILES['foto_kegiatan']) && $_FILES['foto_kegiatan']['error'] == 0 ? file_get_contents($_FILES['foto_kegiatan']['tmp_name']) : NULL,
            'file_surat_tugas' => isset($_FILES['file_surat_tugas']) && $_FILES['file_surat_tugas']['error'] == 0 ? file_get_contents($_FILES['file_surat_tugas']['tmp_name']) : NULL,
            'file_sertifikat' => isset($_FILES['file_sertifikat']) && $_FILES['file_sertifikat']['error'] == 0 ? file_get_contents($_FILES['file_sertifikat']['tmp_name']) : NULL,
            'file_poster' => isset($_FILES['file_poster']) && $_FILES['file_poster']['error'] == 0 ? file_get_contents($_FILES['file_poster']['tmp_name']) : NULL,
            'lampiran_hasil_kompetisi' => isset($_FILES['lampiran_hasil_kompetisi']) && $_FILES['lampiran_hasil_kompetisi']['error'] == 0 ? file_get_contents($_FILES['lampiran_hasil_kompetisi']['tmp_name']) : NULL,
        ];

        // Data Mahasiswa (Multi-input)
        $mahasiswaData = [];
        if (isset($_POST['id_mahasiswa']) && is_array($_POST['id_mahasiswa'])) {
            foreach ($_POST['id_mahasiswa'] as $index => $id_mahasiswa) {
                $mahasiswaData[] = [
                    'id_mahasiswa' => $id_mahasiswa,
                    'peran_mahasiswa' => $_POST['peran_mahasiswa'][$index] ?? null,
                ];
            }
        }

        // Data Dosen (Multi-input)
        $dosenData = [];
        if (isset($_POST['id_dosen']) && is_array($_POST['id_dosen'])) {
            foreach ($_POST['id_dosen'] as $index => $id_dosen) {
                $dosenData[] = [
                    'id_dosen' => $id_dosen,
                    'peran_pembimbing' => $_POST['peran_pembimbing'][$index] ?? null,
                ];
            }
        }

        // Gabungkan data ke dalam array final
        $data['mahasiswa_data'] = $mahasiswaData;
        $data['dosen_data'] = $dosenData;

        // Simpan data ke model
        $success = $this->model->insertPrestasi($data);

        if ($success) {
            echo "Data berhasil disimpan.";
        } else {
            echo "Data gagal disimpan.";
        }
        exit;
    }
}


    public function showForm()
    {
        $mahasiswaList = $this->model->getMahasiswaList();
        $dosenList = $this->model->getDosenList();

        include 'views/prestasi_form.php';
    }
}
