<!-- views/prestasi_form.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Insert Prestasi</title>
</head>

<body>
    <h1>Form Pengajuan Prestasi</h1>
    <form method="POST" enctype="multipart/form-data">
        Tanggal Pengajuan: <input type="datetime-local" name="tgl_pengajuan" required><br><br>
        Prodi: <input type="text" name="program_studi" required><br><br>
        Tahun Akademik: <input type="text" name="thn_akademik" required><br><br>
        Jenis Kompetisi: <input type="text" name="jenis_kompetisi" required><br><br>
        Juara: <input type="text" name="juara"><br><br>
        Tingkat Kompetisi: <input type="text" name="tingkat_kompetisi" required><br><br>
        Judul Kompetisi: <input type="text" name="judul_kompetisi" required><br><br>
        Tempat Kompetisi: <input type="text" name="tempat_kompetisi" required><br><br>
        Url Kompetisi: <input type="text" name="url_kompetisi" required><br><br>
        Jumlah PT: <input type="number" name="jumlah_pt" required><br><br>
        Jumlah Peserta: <input type="number" name="jumlah_peserta" required><br><br>
        No. Surat Tugas: <input type="text" name="no_surat_tugas" required><br><br>
        Tanggal Surat Tugas: <input type="date" name="tgl_surat_tugas" required><br><br>
        File Surat Tugas: <input type="file" name="file_surat_tugas"><br><br>
        Foto Kegiatan: <input type="file" name="foto_kegiatan" accept="image/*"><br><br>
        File Sertifikat: <input type="file" name="file_sertifikat"><br><br>
        File Poster: <input type="file" name="file_poster"><br><br>
        Lampiran Hasil Kompetisi: <input type="file" name="lampiran_hasil_kompetisi"><br><br>

        <!-- <div id="mahasiswa-inputs">
            <div class="mahasiswa-row">
                <label for="mahasiswa-1">ID Mahasiswa:</label>
                <input type="text" name="id_mahasiswa[]" class="mahasiswa-input" id="mahasiswa-1" required placeholder="Cari Nama Mahasiswa" autocomplete="off">
                <div class="suggestions" id="suggestions-1"></div>
                <button type="button" class="add-row">Tambah</button><br><br>
                <label for="peran-1">Peran Mahasiswa:</label>
                <select name="peran_mahasiswa[]" required>
                    <option value="Peserta">Peserta</option>
                    <option value="Ketua Tim">Ketua Tim</option>
                </select>
                <button type="button" class="remove-row">Hapus</button>
            </div>
        </div> -->

        <!-- Mahasiswa Section -->
        <div id="mahasiswa-container">
            <div class="mahasiswa-item">
                ID Mahasiswa:
                <select name="id_mahasiswa[]" required>
                    <option value="">Pilih Mahasiswa</option>
                    <?php foreach ($mahasiswaList as $mahasiswa): ?>
                    <option value="<?php echo $mahasiswa['id_mahasiswa']; ?>">
                        <?php echo $mahasiswa['nama_mahasiswa']; ?>
                    </option>
                    <?php endforeach; ?>
                </select><br><br>
                Peran Mahasiswa:
                <select name="peran_mahasiswa[]" required>
                    <option value="Peserta">Peserta</option>
                    <option value="Ketua Tim">Ketua Tim</option>
                </select><br><br>
                <button type="button" class="hapus-mahasiswa" onclick="hapusItem(this)">Hapus</button>
            </div>
        </div>
        <button type="button" onclick="tambahMahasiswa()">Tambah Mahasiswa</button><br><br>

        <!-- Dosen Section -->
        <div id="dosen-container">
            <div class="dosen-item">
                ID Dosen:
                <select name="id_dosen[]" required>
                    <option value="">Pilih Dosen</option>
                    <?php foreach ($dosenList as $dosen): ?>
                    <option value="<?php echo $dosen['id_dosen']; ?>">
                        <?php echo $dosen['nama_dosen']; ?>
                    </option>
                    <?php endforeach; ?>
                </select><br><br>
                Peran Pembimbing:
                <select name="peran_pembimbing[]" required>
                    <option value="Pembimbing Utama">Pembimbing Utama</option>
                    <option value="Pendamping">Pendamping</option>
                </select><br><br>
                <button type="button" class="hapus-dosen" onclick="hapusItem(this)">Hapus</button>
            </div>
        </div>
        <button type="button" onclick="tambahDosen()">Tambah Dosen</button><br><br>

        <button type="submit">Simpan</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script>
    // Fungsi untuk menambah elemen Mahasiswa
    function tambahMahasiswa() {
        const container = document.getElementById('mahasiswa-container');
        const item = document.querySelector('.mahasiswa-item').cloneNode(true);
        // Bersihkan nilai elemen baru
        item.querySelector('select[name="id_mahasiswa[]"]').value = '';
        item.querySelector('select[name="peran_mahasiswa[]"]').value = '';
        container.appendChild(item);
    }

    // Fungsi untuk menambah elemen Dosen
    function tambahDosen() {
        const container = document.getElementById('dosen-container');
        const item = document.querySelector('.dosen-item').cloneNode(true);
        // Bersihkan nilai elemen baru
        item.querySelector('select[name="id_dosen[]"]').value = '';
        item.querySelector('select[name="peran_pembimbing[]"]').value = '';
        container.appendChild(item);
    }

    // Fungsi untuk menghapus elemen
    function hapusItem(button) {
        const container = button.parentElement;
        container.remove();
    }

    // // Data mahasiswa sudah ada di PHP, misalnya
    // const mahasiswaList = 
    // // Function untuk menampilkan suggestion berdasarkan input
    // function showSuggestions(inputId, value) {
    //     const suggestionsContainer = document.getElementById("suggestions-" + inputId);
    //     suggestionsContainer.innerHTML = ''; // Clear existing suggestions

    //     if (value.length > 1) { // Start searching after 2 characters
    //         // Filter mahasiswa yang nama-nya cocok dengan input
    //         const filteredMahasiswa = mahasiswaList.filter(m => m.nama_mahasiswa.toLowerCase().includes(value.toLowerCase()));

    //         // Tampilkan setiap mahasiswa yang cocok
    //         filteredMahasiswa.forEach(mahasiswa => {
    //             const suggestion = document.createElement('div');
    //             suggestion.textContent = mahasiswa.nama_mahasiswa;
    //             suggestion.classList.add('suggestion-item');
    //             suggestion.onclick = function() {
    //                 // Isi input dengan nama mahasiswa yang dipilih
    //                 document.getElementById("mahasiswa-" + inputId).value = mahasiswa.nama_mahasiswa;
    //                 document.getElementById("id-mahasiswa-hidden-" + inputId).value = mahasiswa.id_mahasiswa;
    //                 suggestionsContainer.innerHTML = ''; // Sembunyikan suggestions setelah dipilih
    //             };
    //             suggestionsContainer.appendChild(suggestion);
    //         });
    //     }
    // }

    // // Event listener untuk input mahasiswa
    // document.querySelectorAll(".mahasiswa-input").forEach((input, index) => {
    //     input.addEventListener('input', function() {
    //         showSuggestions(index + 1, this.value);
    //     });
    // });

    // // Add new input row for mahasiswa
    // document.querySelector("#mahasiswa-inputs").addEventListener('click', function(e) {
    //     if (e.target && e.target.classList.contains("add-row")) {
    //         const newRow = document.querySelector(".mahasiswa-row").cloneNode(true);
    //         const rowCount = document.querySelectorAll(".mahasiswa-row").length + 1;

    //         // Clear input and set new ID for the row
    //         newRow.querySelector(".mahasiswa-input").value = '';
    //         newRow.querySelector(".mahasiswa-input").id = "mahasiswa-" + rowCount;
    //         newRow.querySelector(".suggestions").id = "suggestions-" + rowCount;

    //         // Create hidden input for storing mahasiswa ID
    //         const hiddenInput = document.createElement('input');
    //         hiddenInput.type = 'hidden';
    //         hiddenInput.name = 'id_mahasiswa[]';
    //         hiddenInput.id = 'id-mahasiswa-hidden-' + rowCount;
    //         newRow.appendChild(hiddenInput);

    //         // Add new row to the container
    //         document.getElementById("mahasiswa-inputs").appendChild(newRow);

    //         // Attach the event listener for the new input
    //         newRow.querySelector(".mahasiswa-input").addEventListener('input', function() {
    //             showSuggestions(rowCount, this.value);
    //         });
    //     }

    //     // Remove row for mahasiswa
    //     if (e.target && e.target.classList.contains("remove-row")) {
    //         if (document.querySelectorAll(".mahasiswa-row").length > 1) {
    //             e.target.closest(".mahasiswa-row").remove(); // Remove the row
    //         }
    //     }
    // });
    </script>
</body>

</html>