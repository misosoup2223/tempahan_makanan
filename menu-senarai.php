<?php
# memulakan fungsi session
session_start();

#memanggil fail header.php, connection.php dan kawalan-admin.php
include('header.php');
include('connection.php');
include('kawalan-admin.php');

# syarat tambahan yang akan dimasukkan dalam arahan(query) senarai pengguna
$tambahan="";
if(!empty($_POST['nama_menu']))
{
    $tambahan=" and menu.nama_menu like '%".$_POST['nama_menu']."%'";
}

# arahan query untuk mencari senarai nama pengguna
$arahan_papar="select * from menu , kategori 
where menu.id_kategori = kategori.id_kategori 
$tambahan order by menu.id_kategori, menu.nama_menu ";

# laksanakan arahan mencari data pengguna
$laksana = mysqli_query($condb,$arahan_papar);

?>
<!-- Header bagi jadual untuk memaparkan senarai pengguna -->
<h3 align='center'>Senarai Menu</h3>

<table align='center' width='100%' border='1' id='saiz'>
  <tr bgcolor='cyan'>
    <td colspan='2'>
        <form action='' method='POST' style='margin:0; padding:0;'>
            <input type='text' name='nama_menu' placeholder='Carian Menu'>
            <input type='submit' value='Cari'>
        </form>
    </td>
    <td colspan='4' align='right'>
        | <a href='menu-daftar.php'>Daftar Menu Baru</a> | 
        | <a href='menu-upload.php'>Upload Menu Baru</a> | <br>
        <?php include('butang-saiz.php'); ?>
    </td>
</tr>
<tr bgcolor='yellow'>
    <td width='15%'></td>
    <td width='35%'>Menu</td>
    <td width='10%'>Harga (RM)</td>
    <td width='10%'>Kategori</td>
    <td width='20%'>Tindakan</td>
</tr>

<?php
# Mengambil data yang ditemui
      while($m = mysqli_fetch_array($laksana))
{
    # memaparkan senarai nama dalam jadual
    echo"<tr>
    <td><img src='gambar/".$m['gambar']."' width='100%'></td>
    <td>".$m['nama_menu']."<br>".$m['keterangan']."</td>
    <td>".$m['harga']."</td>
    <td>".$m['kategori_menu']."</td>";

    # memaparkan navigasi untuk kemaskini dan hapus data pengguna
    echo"<td>
    | <a href='menu-kemaskini-borang.php?id_menu=".$m['id_menu']."'>Kemaskini</a>

    | <a href='menu-padam-proses.php?id_menu=".$m['id_menu']."'
    onClick=\"return confirm('Anda pasti anda ingin memadam data ini.')\">
    Hapus</a>|

    </td>
    </tr>";
  }
  
?>
</table>
<?php include ('footer.php'); ?>