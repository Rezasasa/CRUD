<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "akademik";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database");
}
$nim      = "";
$nama     = "";
$alamat   = "";
$fakultas = "";
$Succes   = "";
$Error    = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id     = $_GET['id'];
    $sql1   = "delete from mahasiswa where id = '$id'";
    $q1     = mysqli_query($koneksi,$sql1);
    if($q1){
        $Succes = "Berhasil hapus data";
    }else{
        $Error  = "Gagal melakukan delete data";
    }

}
if ($op == 'edit') {
    $id          =  $_GET['id'];
    $sql1        = "select * from mahasiswa where id = '$id'";
    $q1          = mysqli_query($koneksi, $sql1);
    $r1          = mysqli_fetch_array($q1);
    $nim         = $r1['nim'];
    $nama        = $r1['nama'];
    $alamat      = $r1['alamat'];
    $fakultas    = $r1['Fakultas'];

    if ($nim == '') {
        $Error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) {
    $nim      = $_POST['nim'];
    $nama     = $_POST['nama'];
    $alamat   = $_POST['alamat'];
    $fakultas = $_POST['fakultas'];

    if ($nim && $nama && $alamat && $fakultas) {
        if ($op == 'edit') {
            $sql1   = "update mahasiswa set nim = '$nim',nama ='$nama',alamat = '$alamat',Fakultas ='$fakultas' where id = '$id'";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $Succes = "Data berhasil diupdate";
            } else {
                $Error = "Data gagal update";
            }
        } else {
            $sql1 = "insert into mahasiswa(nim,nama,alamat,Fakultas) values ('$nim','$nama','$alamat','$fakultas')";
            $q1   = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $Succes    =   " Berhasil memasukan data baru ";
            } else {
                $Error     =   " Gagal memasukan data ";
            }
        }
    } else {
        $Error = "Silahkan masukan semua data";
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($Error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $Error ?>
                    </div>
                <?php
                }
                ?>
                <?php
                if ($Succes) {
                ?>
                    <div class="alert alert-Succes" role="alert">
                        <?php echo $Succes ?>
                    </div>
                <?php
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="fakultas" id="fakultas">
                                <option value="">- Pilih Fakultas -</option>
                                <option value="Teknik" <?php if ($fakultas == "Teknik") echo "selected" ?>>Teknik</option>
                                <option value="Manajemen" <?php if ($fakultas == "Manajemen") echo "selected" ?>>Manajemen</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>


        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2   =   "select * from mahasiswa order by id desc";
                        $q2     =   mysqli_query($koneksi, $sql2);
                        $urut   =   1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id         =   $r2['id'];
                            $nim        =   $r2['nim'];
                            $nama       =   $r2['nama'];
                            $alamat     =   $r2['alamat'];
                            $fakultas   =   $r2['Fakultas'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nim ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $alamat ?></td>
                                <td scope="row"><?php echo $fakultas ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                        <?php
                        }

                        ?>
                    </tbody>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</body>

</html>