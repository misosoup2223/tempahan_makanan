<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header dan fail kawalan-admin.php
include('header.php');
include('kawalan-admin.php');
include('connection.php');

# Menyemak kewujudan data GET.
if(empty($_GET)) {
    die("<script>window.location.href='menu-senarai.php';</script>");
}
# Mendapatkan maklumat menu
$sql_menu = "select * from menu, kategori where 
             menu.id_kategori = kategori.id_kategori
             and menu.id_menu = '".$_GET['id_menu']."' ";
$lak_menu = mysqli_query($condb,$sql_menu);
$m        = mysqli_fetch_array($lak_menu);

# Mendapatkan data kategori
$sql_kat     = "select * from kategori";
$laksana_kat = mysqli_query($condb,$sql_kat);
?>

<h3>Kemaskini Pengguna Baru</h3>
<form enctype='multipart/form-data' method='POST' 
action='menu-kemaskini-proses.php?id_menu=<?= $_GET['id_menu'] ?>' >

Nama Menu
<input required type='text'  name='nama_menu' value='<?= $m['nama_menu'] ?>'><br>

Keterangan
<input required type='text'  name='keterangan' value='<?= $m['keterangan'] ?>'><br>

Harga
<input required type='number' name='harga' step='0.01' value='<?= $m['harga'] ?>'><br>

Kategori
<select name='id_kategori'>
<option value ='<?= $m['id_kategori'] ?>'><?= $m['kategori_menu'] ?></option>

<?php while($k = mysqli_fetch_array($laksana_kat)): 
        if($k['id_kategori'] != $m['id_kategori']): ?>
               <option value ='<?= $k['id_kategori'] ?>'>
               <?= $k['kategori_menu'] ?>
               </option>

     <?php endif; endwhile; ?>
</select><br>

Gambar
<input type='file' name='gambar'><br>

<input type='submit' value='Kemaskini'>
</form>

<?php include ('footer.php'); ?>