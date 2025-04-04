<?php
# Memulakan fungsi session dan memanggil fail header.php
session_start();
include('header.php');
include('connection.php');
$tambahan="";

# Mendapatkan data menu berdasarkan kategori yang dipilih
if(!empty($_GET['jenis'])){
   $tambahan = "where id_kategori = '".$_GET['jenis']."'";
}
$sql = "select* from menu $tambahan order by id_kategori, nama_menu ASC";
$laksana =    mysqli_query($condb,$sql);

# Mendapatkan data kategori
$sql_kategori = "select * from kategori";
$laksana_kategori = mysqli_query($condb,$sql_kategori);
?>

<!-- Memaparkan menu dalam bentuk jadual -->
 <table align= 'center' border='1' width='50%'>
    <caption>
        <a href='menu.php'>SEMUA</a> 
        <?php while($mm = mysqli_fetch_array($laksana_kategori)){ ?>
        | <a href='menu.php?jenis=<?= $mm['id_kategori'] ?>'>
            <?= $mm['kategori_menu'] ?></a>
        <?php } ?>
    </caption>
    <?php
    if(mysqli_num_rows($laksana) != 0){
       while($m= mysqli_fetch_array($laksana)){ ?>
    <tr>
        <td width='30%'>
            <img src='gambar/<?= $m['gambar'] ?>' width='100%'>
        </td>
        <td> width='50%'> 
            <b> <?= $m['nama_menu'] ?> </b>
            <br>
            <?= $m['keterangan'] ?>
        </td>
        <td width='20%'>
            
<!-- Butang tempahan -->
<a href='tempah-tambah.php?page=menu&jenis=<?= $m['id_kategori'] ?>&id_menu=<?= $m['id_menu'] ?>'>Tambah Cart</a>

    </td></tr>
    <?php } }else{
       echo " <tr> <td align='center'>
              <p style='color:red;'>Menu Kategori ini belum didaftarkan<br>
              klik pautan senarai menu di atas dan daftar menu bagi kategori ini<br>
              </p></td></tr>"; 
    } ?>
</table> 