<?php
include "auth.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <title>Data Anggota</title>
    
    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/1.11.5/dataTables.bootstrap5.min.css">
    
    <!-- Custom CSS -->
    <style>
        /* Align "Show entries" and "Search" */
        .dataTables_length {
            float: left;
            margin-bottom: 1rem;
        }
        .dataTables_filter {
            float: right;
            text-align: right;
            margin-bottom: 1rem;
        }
        /* Styling for table */
        table.dataTable thead th, table.dataTable thead td {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
        }
        table.dataTable tbody tr td {
            padding: 8px 15px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php" style="color: #fff;">CRUD Dengan AJAX</a>
        </div>
    </nav>

    <div class="container">
        <h2 class="text-center my-4">Data Anggota</h2>

        <form method="post" class="form-data" id="form-data">
            <div class="row align-items-end">
                <div class="col-sm-9">
                    <div class="form-group">
                        <label for="nama">Nama:</label>
                        <input type="hidden" name="id" id="id">
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Jenis Kelamin:</label><br>
                        <input type="radio" name="jenis_kelamin" id="jekel1" value="L" required> Laki-Laki
                        <input type="radio" name="jenis_kelamin" id="jekel2" value="P"> Perempuan
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea name="alamat" id="alamat" class="form-control" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="no_telp">No Telepon:</label>
                <input type="number" name="no_telp" id="no_telp" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <button type="submit" name="simpan" id="simpan" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </div>
        </form>

        <!-- Data Table Output -->
        <div class="data table-responsive mb-5"></div>
    </div>

    <div class="container">
        <div class="text-center my-4" style="color: gray;">&copy; <?php echo date('Y'); ?> - Design Dan Pemrograman Web</div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net/1.11.5/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/1.11.5/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'Csrf-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Load table data and initialize DataTable
        $('.data').load('data.php', function() {
            // Initialize DataTable only after content is loaded
            $('#data-table').DataTable({
                dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>tip',
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50, 100],
                ordering: true,
                search: {
                    caseInsensitive: true
                },
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "Lanjut",
                        previous: "Sebelum"
                    }
                }
            });
        });
    });
</script>
</body>
</html>
