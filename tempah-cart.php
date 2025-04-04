<?php
# Memulakan fungsi session dan memanggil fail header.php
session_start();
include('header.php');
include('connection.php');
$jumlah_harga = 0;

# menyemak jika tatasusunan order kosong
if(!isset($_SESSION['order']) or count($_SESSION['orders'])==0){
    die("<script>
        alert("Cart anda kosong");
        window.location.href='menu.php';
       </script>"); 
} else {

# dapatkan bilangan setiap elemen
$bilangan = array_count_values($_SESSION['orders']);

# Filter elemen yang muncul lebih dari satu kali
$sama = array_filter($bilangan, function($count) {
    return $count > 1;
});

# Memaparkan menu yang ditemapah
echo "<table align='center' border='1' 'width= 50%;'>
      <tr align='center'>
       <td>Menu</td>
       <td>Kuantiti</td>  
       <td>Harga<br>seunit</td> 
       <td>Harga</td>
     </tr>";

     foreach($sama as $key => $bill) {
        $sql = "select* from menu where id_menu = '$key'";
        $lak = mysqli_query($condb,$sql);
        $m= mysqli_fetch_array($lak);

?>
    <tr>
         <td><? $m['menu'] ?></td>
         <td align= 'centre'>
            <!-- butang menambah bilangan menu -->
            <a href='tempah-tempah tambah.php?page=cart&id_menu=<?= $m['id_menu'] ?>'>
            [ + ]</a>
            
            <?= $bill ?>

            <!-- butang membuang bilangan menu -->
             <a href='tempah-padam.php?id_menu=<?= $m['id_menu'] ?>'>
             [ - ]</a>

         </td>
         <td align='right'><?= $m['harga'] ?></td>
         <td align='right'><?php
         $harga = $bill * $m['harga'];
         $jumlah_harga = $jumlah_harga + $harga;   
         echo number_format($harga,2); ?></td>
    </tr>
<?php
# memaparkan jenis tempahan
echo "<tr align='right' bgcolor='cyan'>
        <td colspan='3'>Jumlah Bayaran (RM) </td>
        <td>".number_format($jumlah_harga,2)."</td>
      </tr>";
echo "</table>";
?> <br>
<form action='tempah-sah.php' method='POST'>
<table align='centre' border='1' width='50%'>
<tr>
    <td>Jenis Tempahan</td>
    <td>
       <select name='jenis_tempahan'>
          <option>BUNGKUS</option>
          <?php
              for($i=1; $i<=10; $i++){
                  echo "<option>Meja $i </option>";
              } ?>
        </select>
    </td>
</tr>
<tr>
   <td>Sahkan Tempahan</td>
   <td><input type='submit' value='Sah tempahan'></td>
</tr>
</table>
</form>

<?php } ?>
