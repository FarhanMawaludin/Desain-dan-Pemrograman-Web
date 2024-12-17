<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Data mahasiswa dari PHP
        const mahasiswaList = <?php echo json_encode($mahasiswaList); ?>;

        // Referensi ke elemen input dan dropdown
        const searchInput = document.getElementById("searchInput_1");
        const dropdownOptions = document.getElementById("dropdownOptions1");

        // Fungsi untuk mencari mahasiswa berdasarkan input
        function searchMahasiswa(inputElement) {
            const searchValue = inputElement.value.toLowerCase();
            dropdownOptions.style.display = "block"; // Menampilkan dropdown

            const filteredMahasiswa = mahasiswaList.filter(function(mahasiswa) {
                return mahasiswa.nama_mahasiswa.toLowerCase().includes(searchValue);
            });

            dropdownOptions.innerHTML = ""; // Kosongkan dropdown sebelumnya

            filteredMahasiswa.forEach(function(mahasiswa) {
                const option = document.createElement("li");
                option.classList.add("dropdown-item");
                option.textContent = `${mahasiswa.nama_mahasiswa} (NIM: ${mahasiswa.NIM})`;
                option.dataset.id = mahasiswa.id_mahasiswa; // Menyimpan ID mahasiswa di data-id

                // Menangani klik pada dropdown
                option.addEventListener("click", function() {
                    inputElement.value = `${mahasiswa.nama_mahasiswa} (${mahasiswa.NIM})`;
                    document.getElementById("mahasiswa_id_hidden").value = mahasiswa.id_mahasiswa;
                    dropdownOptions.style.display = "none";
                });

                dropdownOptions.appendChild(option);
            });

            // Menyembunyikan dropdown jika tidak ada hasil pencarian
            if (filteredMahasiswa.length === 0) {
                dropdownOptions.style.display = "none";
            }
        }

        // Bind pencarian ke input pertama mahasiswa
        searchInput.addEventListener("input", function() {
            searchMahasiswa(this);
        });

        // Menutup dropdown jika pengguna klik di luar area input atau dropdown
        document.addEventListener("click", function(event) {
            // Cek jika klik terjadi di luar input atau dropdown
            if (!searchInput.contains(event.target) && !dropdownOptions.contains(event.target)) {
                dropdownOptions.style.display = "none"; // Sembunyikan dropdown
            }
        });

        // Menangani klik pada tombol "Tambah"
        document.querySelector('.addInputBtn1').addEventListener('click', function() {
            const mahasiswaId = document.getElementById("mahasiswa_id_hidden").value;
            if (mahasiswaId) {
                // Tambahkan ID mahasiswa ke array mahasiswa_ids[]
                var mahasiswaIdsInput = document.querySelector('input[name="mahasiswa_ids[]"]');
                mahasiswaIdsInput.value = mahasiswaIdsInput.value ? mahasiswaIdsInput.value + ',' + mahasiswaId : mahasiswaId;
            }
        });
    });
</script>

<style>
    #dropdownOptions1 {
        position: absolute;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
    }

    #dropdownOptions1 .dropdown-item {
        padding: 8px 12px;
        cursor: pointer;
        font-size: 14px;
        color: #333;
        background-color: #fff;
        transition: background-color 0.3s ease;
    }

    /* Highlight item dropdown saat hover */
    #dropdownOptions1 .dropdown-item:hover {
        background-color: #f0f0f0;
        color: #007bff;
    }

    /* Styling ketika input kosong atau tidak ada hasil */
    #dropdownOptions1.empty {
        display: none;
        /* Sembunyikan dropdown jika tidak ada hasil */
    }

    /* Menambahkan padding dan margin untuk container */
    .input-group {
        position: relative;
    }
</style>