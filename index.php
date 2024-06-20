<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "psas";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {  //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$nuptk = "";
$nama = "";
$alamat = "";
$guru_mapel = "";
$sukses = "";
$error = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}
if($op == 'delete'){
    $id = $_GET['id'];
    $sql1 = "delete from guru where id = '$id'";
    $q1 = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses ="Berhasil hapus data";
    }else{
        $error = "Gagal melakukan hapus data";
    }
}
if($op == 'edit'){
    $id = $_GET['id'];
    $sql1 = "select * from guru where id = '$id'";
    $q1 = mysqli_query($koneksi,$sql1);
    $r1 = mysqli_fetch_array($q1);
    $nuptk = $r1['nuptk'];
    $nama = $r1['nama'];
    $alamat = $r1['alamat'];
    $guru_mapel = $r1['guru_mapel'];

    if($nuptk == ''){
        $error = "Data tidak ditemukkan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nuptk = $_POST['nuptk'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $guru_mapel = $_POST['guru_mapel'];

    if ($nuptk && $nama && $alamat && $guru_mapel) {
        if($op == 'edit'){ //untuk update
            $sql1 = "update guru set nuptk = '$nuptk',nama='$nama',alamat='$alamat',guru_mapel='$guru_mapel' where id = '$id'";
            $q1 = mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses = "Data berhasil diperbarui";
            }else{
                $error = "Data gagal diperbarui";
            }
        }else{ // untuk insert
            $sql1 = "insert into guru(nuptk,nama,alamat,guru_mapel) values('$nuptk','$nama','$alamat','$guru_mapel') ";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukkan data baru";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
       
    } else {
        $error = "Silahkan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                    <?php
                        header("refresh:0;url=index.php");//detik
                }
                ?>
                <?php
                if ($sukses) {
                    ?>
                    <div class="alert alert-succes" role="alert">
                        <?php echo $sukses ?>
                    </div>
                    <?php
                        header("refresh:0;url=index.php"); 
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nuptk" class="col-sm-2 col-form-label">NUPTK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nuptk" name="nuptk"
                                value="<?php echo $nuptk ?>">
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
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="guru_mapel" class="col-sm-2 col-form-label">Guru Mapel</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="guru_mapel" id="guru_mapel">
                                <option value="">- Pilih Mapel -</option>
                                <option value="Matematika" <?php if ($guru_mapel == "Matematika")
                                    echo "selected" ?>>
                                        Matematika</option>
                                    <option value="Sosiologi" <?php if ($guru_mapel == "Sosiologi")
                                    echo "selected" ?>>Sosiologi
                                    </option>
                                    <option value="B. Jepang" <?php if ($guru_mapel == "B. Jepang")
                                    echo "selected" ?>>B. Jepang
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        </div>
                    </form>
                </div>

                <!-- untuk mengeluarkan data -->
                <div class="card">
                    <div class="card-header text-white bg-secondary">
                        Data Guru
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">NUPTK</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Guru Mapel</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            <tbody>
                                <?php
                                $sql2 = "select * from guru order by id desc";
                                $q2 = mysqli_query($koneksi, $sql2);
                                $urut = 1;
                                while ($r2 = mysqli_fetch_array($q2)) {
                                    $id = $r2['id'];
                                    $nuptk = $r2['nuptk'];
                                    $nama = $r2['nama'];
                                    $alamat = $r2['alamat'];
                                    $guru_mapel = $r2['guru_mapel'];

                                    ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++ ?></th>
                                    <td scope="row"><?php echo $nuptk ?></td>
                                    <td scope="row"><?php echo $nama ?></td>
                                    <td scope="row"><?php echo $alamat ?></td>
                                    <td scope="row"><?php echo $guru_mapel ?></td>
                                    <td scope="row">
                                        <a href="index.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                        <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                        
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