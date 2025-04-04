<?php
# Memulakan fungsi session dan memanggil fail header.php
session_start();
include('header.php');
# Memanggil fail connection
include('connection.php');

$sql_kat = "select* from kategori";
$lak_kat = mysqli_query($condb,$sql_kat);
?>

<!-- Bahagian Borang(form) Login -->
<h3>Pendaftaran Menu Baru</h3>
<p>Sila Lengkapkan Maklumat di bawah</p>
<form action = '' method = 'POST' enctype='multipart/form-data'>
    ID Menu      <input required type='text'   name='id_menu'><br>
    Nama Menu    <input required type='text'   name='nama_menu'><br>
    Keterangan   <input required type='text'   name='keterangan'><br>
    Harga        <input required type='number' name='harga' step='0.01'><br>
    Kategori     <select name='id_kategori'>
                      <?php while($k = mysqli_fetch_array($lak_kat)): ?>
                      <option value ='<?= $k['id_kategori'] ?>'>
                           <?= $k['kategori_menu'] ?>
                      </option>
                      <?php endwhile; ?>
                   </select><br>
    Gambar         <input required type='file'   name='gambar'><br>
                   <input required type='submit' value='Simpan'>
</form>

<?php
# Menyemak kewujudan data POST
if(!empty($_POST)){
    
    # Mengambil data daripada borang (form)
    $id_menu      = $_POST['id_menu'];
    $nama_menu    = $_POST['nama_menu'];
    $keterangan   = $_POST['keterangan'];
    $id_kategori  = $_POST['id_kategori'];
    $harga        = $_POST['harga'];

    # Mengambil data gambar
    $timestamp    = date('Y-m-d-His');
    $nama_fail    = basename($_FILES['gambar']['name']);
    $format_gambar = pathinfo($nama_fail, PATHINFO_EXTENSION);
    $lokasi       = $_FILES['gambar']['tmp_name'];
    $nama_baru    = $timestamp.".".$format_gambar;

    # Data validation : had atas
    if(!is_numeric($harga) and $harga > 0){
        die("<script>
                 alert('Ralat Harga');
                 location.href='daftar-menu.php';
            </script>");
    }

# Semak id_menu dah wujud atau belum
   $sql_semak   = "select id_menu from menu where id_menu = '$id_menu' ";
   $laksana_semak = mysqli_query($condb,$sql_semak);
   if(mysqli_num_rows($laksana_semak)==1){
       die("<script>
               alert('id_menu telah digunakan. Sila guna id_menu yang lain');
               location.href='menu-daftar.php';
          </script>");
   }

# Proses menyimpan data
$sql_simpan = "insert into menu set
                id_menu      = '$id_menu',
                nama_menu    = '$nama_menu',
                id_kategori  = '$id_kategori',
                keterangan   = '$keterangan',
                harga        = '$harga',
                gambar       = '$nama_baru'
            ";
$laksana = mysqli_query($condb,$sql_simpan);

# Pengujian proses menyimpan data
if($laksana){
    # jika berjaya
    echo " <script>
           alert('Pendaftaran Berjaya');
           location.href='menu-senarai.php';
           </script>";

    # muat naik gambar
    move_uploaded_file($lokasi,"gambar/".$nama_baru);

   }else{
    # jika gagal papar punca error
    echo "<p style='color:red;'>Pendaftaran Gagal</p>";
    echo $sql_simpan.mysqli_error($condb);

    }
}
?>
<?php include('footer.php'); ?>