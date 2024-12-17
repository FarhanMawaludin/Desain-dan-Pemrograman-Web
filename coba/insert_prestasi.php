<?php
date_default_timezone_set('Asia/Jakarta');

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $program_studi = $_POST['program_studi'] ?? ''; // Default to empty string if not set
    $url_kompetisi = $_POST['url_kompetisi'] ?? ''; // Default to empty string if not set

    
    $tgl_pengajuan = date('Y-m-d H:i:s');

    $thn_akademik = $_POST['thn_akademik'];
    $jenis_kompetisi = $_POST['jenis_kompetisi'];
    $juara = $_POST['juara'];
    $tingkat_kompetisi = $_POST['tingkat_kompetisi'];
    $judul_kompetisi = $_POST['judul_kompetisi'];
    $tempat_kompetisi = $_POST['tempat_kompetisi'];
    $jumlah_pt = $_POST['jumlah_pt'];
    $jumlah_peserta = $_POST['jumlah_peserta'];

    $no_surat_tugas = $_POST['no_surat_tugas'];
    $tgl_surat_tugas = $_POST['tgl_surat_tugas'];
    $tgl_surat_tugas = date('Y-m-d', strtotime($tgl_surat_tugas));

    if (isset($_FILES['file_surat_tugas']) && $_FILES['file_surat_tugas']['error'] == 0) {
        $file_surat_tugas_data = file_get_contents($_FILES['file_surat_tugas']['tmp_name']);
        $file_surat_tugas = $file_surat_tugas_data;
    } else {
        $file_surat_tugas = NULL;
    }

    if (isset($_FILES['foto_kegiatan']) && $_FILES['foto_kegiatan']['error'] == 0) {
        $foto_kegiatan_data = file_get_contents($_FILES['foto_kegiatan']['tmp_name']);
        $foto_kegiatan = $foto_kegiatan_data;
    } else {
        $foto_kegiatan = NULL;
    }

    if (isset($_FILES['file_sertifikat']) && $_FILES['file_sertifikat']['error'] == 0) {
        $file_sertifikat_data = file_get_contents($_FILES['file_sertifikat']['tmp_name']);
        $file_sertifikat = $file_sertifikat_data;
    } else {

        $file_sertifikat = '';
    }

    if (isset($_FILES['file_poster']) && $_FILES['file_poster']['error'] == 0) {
        $file_poster_data = file_get_contents($_FILES['file_poster']['tmp_name']);
        $file_poster = $file_poster_data;
    } else {

        $file_poster = '';
    }

    if (isset($_FILES['lampiran_hasil_kompetisi']) && $_FILES['lampiran_hasil_kompetisi']['error'] == 0) {
        $lampiran_hasil_kompetisi_data = file_get_contents($_FILES['lampiran_hasil_kompetisi']['tmp_name']);
        $lampiran_hasil_kompetisi = $lampiran_hasil_kompetisi_data;
    } else {

        $lampiran_hasil_kompetisi = '';
    }

    $sql = "INSERT INTO [dbo].[data_prestasi] 
                ([tgl_pengajuan], [thn_akademik], [jenis_kompetisi], [juara],
                [url_kompetisi], [program_studi],[tingkat_kompetisi], [judul_kompetisi], [tempat_kompetisi], 
                 [jumlah_pt], [jumlah_peserta], [status_pengajuan], [foto_kegiatan],
                 [no_surat_tugas], [tgl_surat_tugas], [file_surat_tugas],
                 [file_sertifikat], [file_poster], [lampiran_hasil_kompetisi]) 
            VALUES 
                (?, ?, ?, ?, 
                 ?,?,?, ?, ?, 
                 ?, ?, 'Waiting for Approval', 
                 CONVERT(VARBINARY(MAX), ?),
                 ?, ?, 
                 CONVERT(VARBINARY(MAX), ?),
                 CONVERT(VARBINARY(MAX), ?),
                 CONVERT(VARBINARY(MAX), ?),
                 CONVERT(VARBINARY(MAX), ?));";

    $params = array(
        $tgl_pengajuan,
        $thn_akademik,
        $jenis_kompetisi,
        $juara,
        $url_kompetisi,
        $program_studi,
        $tingkat_kompetisi,
        $judul_kompetisi,
        $tempat_kompetisi,
        $jumlah_pt,
        $jumlah_peserta,
        $foto_kegiatan,
        $no_surat_tugas,
        $tgl_surat_tugas,
        $file_surat_tugas,
        $file_sertifikat,
        $file_poster,
        $lampiran_hasil_kompetisi
    );

    $stmt = sqlsrv_query($conn, $sql, $params);

    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Data successfully inserted!";
    }
}

sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Insert Prestasi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
</head>

<body>
    <h1>Form Pengajuan Prestasi</h1>
    <form method="POST" enctype="multipart/form-data">

        Tahun Akademik: <input type="text" name="thn_akademik" required><br><br>
        Jenis Kompetisi: <input type="text" name="jenis_kompetisi" required><br><br>
        Juara: <input type="text" name="juara"><br><br>
        <label for="program_studi">Program Studi</label>
        <select name="program_studi" required>
            <option value="">Pilih Program Studi</option>
            <option value="Informatika">Informatika</option>
            <option value="Sistem Informasi">Sistem Informasi</option>
            <option value="Teknik Elektro">Teknik Elektro</option>
            <!-- Tambahkan program studi lainnya di sini -->
        </select><br><br>
        URL Kompetisi: <input type="text" name="url_kompetisi"><br><br>
        Tingkat Kompetisi: <input type="text" name="tingkat_kompetisi" required><br><br>
        Judul Kompetisi: <input type="text" name="judul_kompetisi" required><br><br>
        Tempat Kompetisi: <input type="text" name="tempat_kompetisi" required><br><br>
        Jumlah PT: <input type="number" name="jumlah_pt" required><br><br>
        Jumlah Peserta: <input type="number" name="jumlah_peserta" required><br><br>

        <!-- New fields for no_surat_tugas, tgl_surat_tugas, and file_surat_tugas -->
        No. Surat Tugas: <input type="text" name="no_surat_tugas" required><br><br>
        Tanggal Surat Tugas: <input type="date" name="tgl_surat_tugas" required><br><br>
        File Surat Tugas: <input type="file" name="file_surat_tugas"><br><br>

        Foto Kegiatan: <input type="file" name="foto_kegiatan" accept="image/*"><br><br>
        File Sertifikat: <input type="file" name="file_sertifikat"><br><br>
        File Poster: <input type="file" name="file_poster"><br><br>
        Lampiran Hasil Kompetisi: <input type="file" name="lampiran_hasil_kompetisi"><br><br>

        <label for="mahasiswa" class="form-label">Mahasiswa</label>
        <div id="mahasiswa-container">
            <div class="dropdown">
                <input type="text" class="dropdownInputMahasiswa" placeholder="Cari Mahasiswa..." autocomplete="off">
                <div class="dropdown-options"></div>
            </div>
            <input type="hidden" name="mahasiswa_ids[]" class="selectedMahasiswaIds">
        </div>
        <button type="button" id="addMahasiswa" class="btn btn-secondary">Tambah Mahasiswa</button>
        <br><br>

        <label for="dosen" class="form-label">Dosen</label>
        <div id="dosen-container">
            <div class="dropdown">
                <input type="text" class="dropdownInputDosen" placeholder="Cari Dosen..." autocomplete="off">
                <div class="dropdown-options"></div>
            </div>
            <input type="hidden" name="dosen_ids[]" class="selectedDosenIds">
        </div>
        <button type="button" id="addDosen" class="btn btn-secondary">Tambah Dosen</button>
        <br><br>

        <input type="submit" value="Submit">
    </form>

    <script>
    const mahasiswaList = <?php echo json_encode($mahasiswaList); ?>;

    document.getElementById('addMahasiswa').addEventListener('click', () => {
        const newDropdown = document.createElement('div');
        newDropdown.classList.add('dropdown');

        newDropdown.innerHTML = `
        <input type="text" class="dropdownInputMahasiswa" placeholder="Cari Mahasiswa..." autocomplete="off">
        <div class="dropdown-options"></div>
    `;

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'mahasiswa_ids[]';
        hiddenInput.classList.add('selectedMahasiswaIds');

        const mahasiswaContainer = document.getElementById('mahasiswa-container');
        mahasiswaContainer.appendChild(newDropdown);
        mahasiswaContainer.appendChild(hiddenInput);

        initializeDropdowns();
    });

    function initializeDropdowns() {
        const mahasiswaInputs = document.querySelectorAll('.dropdownInputMahasiswa');
        mahasiswaInputs.forEach(input => {
            const dropdownOptions = input.nextElementSibling;
            const hiddenInput = input.parentNode.nextElementSibling;
            createDropdown(input, dropdownOptions, hiddenInput);
        });
    }

    function createDropdown(inputElement, dropdownOptions, hiddenInput) {
        inputElement.addEventListener('input', () => {
            const filter = inputElement.value.toLowerCase();
            const filteredList = mahasiswaList.filter(mahasiswa =>
                mahasiswa.nama_mahasiswa.toLowerCase().includes(filter)
            );
            renderMahasiswaDropdown(filteredList, dropdownOptions);
        });

        dropdownOptions.addEventListener('click', (e) => {
            if (e.target.tagName === 'DIV') {
                inputElement.value = e.target.textContent;
                const selectedId = e.target.getAttribute('data-value');
                hiddenInput.value = selectedId;
                dropdownOptions.style.display = 'none';
            }
        });

        document.addEventListener('click', (e) => {
            if (!inputElement.contains(e.target) && !dropdownOptions.contains(e.target)) {
                dropdownOptions.style.display = 'none';
            }
        });
    }

    function renderMahasiswaDropdown(filteredList, dropdownOptions) {
        dropdownOptions.innerHTML = '';
        filteredList.forEach(mahasiswa => {
            const option = document.createElement('div');
            option.textContent = `${mahasiswa.nama_mahasiswa} (NIM: ${mahasiswa.NIM})`;
            option.setAttribute('data-value', mahasiswa.id_mahasiswa);
            dropdownOptions.appendChild(option);
        });
        dropdownOptions.style.display = filteredList.length > 0 ? 'block' : 'none';
    }

    initializeDropdowns();
    </script>

    <script>
    const dosenList = <?php echo json_encode($dosenList); ?>;

    document.getElementById('addDosen').addEventListener('click', () => {

        const newDropdown = document.createElement('div');
        newDropdown.classList.add('dropdown');

        newDropdown.innerHTML = `
        <input type="text" class="dropdownInputDosen" placeholder="Cari Dosen..." autocomplete="off">
        <div class="dropdown-options"></div>
    `;

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'dosen_ids[]';
        hiddenInput.classList.add('selectedDosenIds');

        const dosenContainer = document.getElementById('dosen-container');
        dosenContainer.appendChild(newDropdown);
        dosenContainer.appendChild(hiddenInput);

        initializeDosenDropdowns();
    });

    function initializeDosenDropdowns() {
        const dosenInputs = document.querySelectorAll('.dropdownInputDosen');
        dosenInputs.forEach(input => {
            const dropdownOptions = input.nextElementSibling;
            const hiddenInput = input.parentNode.nextElementSibling;
            createDosenDropdown(input, dropdownOptions, hiddenInput);
        });
    }

    function createDosenDropdown(inputElement, dropdownOptions, hiddenInput) {
        inputElement.addEventListener('input', () => {
            const filter = inputElement.value.toLowerCase();
            const filteredList = dosenList.filter(dosen =>
                dosen.nama_dosen.toLowerCase().includes(filter)
            );
            renderDosenDropdown(filteredList, dropdownOptions);
        });

        dropdownOptions.addEventListener('click', (e) => {
            if (e.target.tagName === 'DIV') {
                inputElement.value = e.target.textContent;
                const selectedId = e.target.getAttribute('data-value');
                hiddenInput.value = selectedId;
                dropdownOptions.style.display = 'none';
            }
        });

        document.addEventListener('click', (e) => {
            if (!inputElement.contains(e.target) && !dropdownOptions.contains(e.target)) {
                dropdownOptions.style.display = 'none';
            }
        });
    }

    function renderDosenDropdown(filteredList, dropdownOptions) {
        dropdownOptions.innerHTML = '';
        filteredList.forEach(dosen => {
            const option = document.createElement('div');
            option.textContent = `${dosen.nama_dosen} (NIDN: ${dosen.NIDN})`;
            option.setAttribute('data-value', dosen.id_dosen);
            dropdownOptions.appendChild(option);
        });
        dropdownOptions.style.display = filteredList.length > 0 ? 'block' : 'none';
    }

    initializeDosenDropdowns();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

</html>