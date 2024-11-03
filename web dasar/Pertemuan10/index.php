<?php
include('koneksi.php');
?>
<head>
   <link rel="stylesheet" href="style.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/5hb7g5g5g5g5g5g5g5g5g5g5g5g5g5g5g5g5g5" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-1n1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1g1" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Data Anggota</title>
</head>
<body>
    <div class="container">
        <h2>Data Anggota</h2>
        <a href="create.php" class="btn-tambah">Tambah Anggota</a>
        <br><br>
            <?php
            $query = "SELECT * FROM anggota order by id desc";
            $result = mysqli_query($koneksi, $query);
?>
<table class="table">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>No. Telp</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $kelamin = ($row["jenis_kelamin"] === "L" ? 'Laki-laki':"Perempuan");
            ?>
            <tr>
            <td><?=$no++?></td>
            <td><?=$row["nama"]?></td>
            <td><?=$kelamin?></td>
            <td><?=$row["alamat"]?></td>
            <td><?=$row["no_telp"]?></td>
                <td>
                <a class="btn btn-primary" href="edit.php?id=<?=$row['id']?>">Edit</a>
                <a href="proses.php?aksi=hapus&id=<?=$row['id']?>" class="btn btn-danger">Hapus</a>
                </td>
            </tr>
            <!-- Modal Hapus -->
             <div class="modal fade" id="hapusModal<?=$row['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Anggota</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus data anggota <?=$row['nama']?>?
                        </div>
                        <div class="modal-footer">
                            <a href="proses.php?aksi=hapus&id<?=$row['id']?>" class="btn btn-danger">Hapus</a>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>            
        </div>
    </div>
            </div>
            <?php
            }
            ?>
        </tbody>
        </table>
        </div>
   
</body>
</html>