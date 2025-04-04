<?php
# memulakan fungsi session & fail header
session_start();
include('header.php');
include('kawalan-admin.php');
?>

<!-- Tajuk Laman -->
<h3>Muat Naik Data Menu (*.txt)</h3>

<!-- Borang untuk memuat naik fail -->
<form action="" method="POST" enctype="multipart/form-data">

    <h3><b>Sila Pilih Fail txt yang ingin diupload</b></h3>
    <input  type="file"   name="data">
    <button type="submit" name="upload">Muat Naik</button>

</form>
<?php include('footer.php'); ?>

<!-- Bahagian Memproses Data yang dimuat naik -->
<?php
# data validation : menyemak kewujudan data dari borang
if (isset($_POST['upload']))
{
    # memanggil fail connection
    include('connection.php');

    # mengambil nama sementara fail
    $namafailsementara = $_FILES['data']['tmp_name'];
    $namafail          = $_FILES['data']['name'];
    $jenisfail         = $_FILES['data']['type'];

    # menguji jenis fail dan saiz fail
    if ($_FILES["data"]["size"] > 0 AND $jenisfail == "text/plain")
    {
        # membuka fail yang diambil
        $fail_data = fopen($namafailsementara, "r");

        $bil = 0;

        # mendapatkan data dari fail baris demi baris
        while (!feof($fail_data))
        {
            # mengambil data sebaris sahaja bg setiap pusingan
            $ambilbarisdata = fgets($fail_data);

            # memecahkan baris data mengikut tanda pipe
            $data = explode("|", $ambilbarisdata);

            # Umpukkan data yang dipecahkan
            $id_menu     = trim($data[0]);
            $nama_menu   = trim($data[1]);
            $id_kategori = trim($data[2]);
            $keterangan  = trim($data[3]);
            $harga       = trim($data[4]);

# semak jika id menu telah ada dalam pangkalan data
$pilih = mysqli_query($condb, "select * from menu where id_menu='" . $id_menu . "'");
if (mysqli_num_rows($pilih)==1){
     echo "<script>
            alert('id_menu $id_menu di fail txt telah ada di pangkalan data. TUKAR id_menu DALAM FAIL TXT');
                </script>";
}else{
     # arahan SQL untuk menyimpan data
    $sql_simpan = "insert into menu set
            id_menu      = '$id_menu',
             nama_menu   = '$nama_menu',
             id_kategori = '$id_kategori',
             keterangan  = '$keterangan',
             harga       = '$harga'
        ";

    # memasukkan data kedalam jadual pengguna
    $laksana_arahan_simpan = mysqli_query($condb, $sql_simpan);
    $bil++;
}
}
    # menutup fail txt yang dibuka
    fclose($fail_data);

        echo "<script>
                alert('Import fail Data Selesai. Sebanyak $bil data telah disimpan. KEMASKINI MENU DAN UPLOAD GAMBAR');
                window.location.href='menu-senarai.php';
              </script>";
    } 
    else 
    {
        # jika fail yang dimuat naik kosong atau tersalah format
        echo "<script>alert('hanya fail berformat txt sahaja dibenarkan');</script>";
    }
}
?>