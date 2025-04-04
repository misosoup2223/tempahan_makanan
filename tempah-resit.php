<?php
# Memulakan fungsi session 
session_start();

include('header.php');
include('connection.php');
$jumlah_harga = 0 ;

# Mendapatkan data tempahan
$sql_pilih = "select* from tempahan, menu, resit 
where
     tempahan.no_resit = resit.no_resit 
 AND tempahan.id_menu  = menu.id_menu    
 AND tempahan.no_resit = '".$_GET['noresit']."' ";
 $laksana = mysqli_query($condb,$sql_pilih);
 ?>

 <!--   Memaparkan data tempahan pada resit -->
 <h3>Resit Tempahan</h3>

 <table id= 'saiz' align='center' border='1' width='50%'>
      <tr>
          <td colspan ='4'><?php include('butang-saiz.php'); ?></td>
        </tr>
        <tr align='center'> bgcolor='#f4f87e'>
            <td>Menu</td>
            <td>Kuantiti</td>
            <td>Harga<br>seunit</td>
            <td>Harga</td>
        </tr>

        <?php while ($m=mysqli_fetch_array($laksana)){ ?>
        <tr>
        <td>                <?=$m['nama_menu'] ?></td>
        <td align='center'> <?= $m['kuantiti'] ?></td>
        <td align='right'>  <?= $m['harga_asal'] ?></td>
        <td align='right'>
         <?php
           $harga = $m['kuantiti'] * $m['harga_asal'];
           $jumlah_harga = $jumlah_harga + $harga;
           echo number_format($harga,2);
         ?>
        </td>
</tr>
<?php } ?>
<tr align='right' bgcolor='#f4f87e'>
    <td colspan='3' >Jumlah Bayaran (RM) </td>
    <td ><?= number_format($jumlah_harga,2) ?></td>
</tr>
</table>