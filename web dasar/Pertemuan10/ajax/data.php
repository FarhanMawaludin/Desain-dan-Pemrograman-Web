
<table id="data-table" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>No Telp</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "koneksi.php";

        $no = 1;
        $query = "SELECT * FROM anggota ORDER BY id DESC";
        $sql = $db1->prepare($query);
        $sql->execute();
        $res1 = $sql->get_result();

        if ($res1->num_rows > 0) {
            while ($row = $res1->fetch_assoc()) {
                $id = $row['id'];
                $nama = $row['nama'];
                $jenis_kelamin = ($row['jenis_kelamin'] == 'L') ? 'Laki-Laki' : 'Perempuan';
                $alamat = $row['alamat'];
                $no_telp = $row['no_telp'];
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $nama; ?></td>
            <td><?php echo $jenis_kelamin; ?></td>
            <td><?php echo $alamat; ?></td>
            <td><?php echo $no_telp; ?></td>
            <td>
                <button id="<?php echo $id; ?>" class="btn btn-success btn-sm edit_data">
                    <i class="fa fa-edit"></i> Edit
                </button>
                <button id="<?php echo $id; ?>" class="btn btn-danger btn-sm hapus_data">
                    <i class="fa fa-trash"></i> Hapus
                </button>
            </td>
        </tr>
        <?php
            }
        } else {
        ?>
        <tr>
            <td colspan="7">Tidak ada data ditemukan</td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table').DataTable();
    });
</script>
