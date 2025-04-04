<?php  
# Memulakan fungsi session  
session_start();  
include('header.php');  
include('connection.php');  
$menu="<br>";  

# mendapatkan semua data tempahan pengguna yang ada.  
$sql = "SELECT *,  
(SELECT sum(tempahan.kuantiti * tempahan.harga_asal) from tempahan  
WHERE tempahan.no_resit=resit.no_resit) AS jum  
FROM resit  
WHERE notel ='".$_SESSION['notel']."'  
ORDER BY resit.tarikh DESC";  
$laksql = mysqli_query($condb,$sql);  

# jika terdapat data GET['no_resit'] di url  
if(isset($_GET['no_resit'])):  
    # Dapatkan menu yang telah ditempah  
    $sqlpaparmenu ="select* from tempahan, menu  
    where tempahan.id_menu = menu.id_menu  
    and tempahan.no_resit ='".$_GET['no_resit']."' ";  
    $lakpaparmenu = mysqli_query($condb,$sqlpaparmenu);  
    $menu="<br>";  
while($mm=mysqli_fetch_array($lakpaparmenu)):  
$menu=$menu.$mm['nama_menu']." ( ".$mm['kuantiti']." X RM ".$mm['harga_asal']." )<br>";  
endwhile;  
endif;  
?>  
<!-- Memaparkan sejarah tempahan individu -->  
<h3>Sejarah Tempahan</h3>  
<?php if(mysqli_num_rows($laksql) > 0){ ?>  
<table align='center' border='1' width='50%'>  
    <tr align='center'>  
        <td >No Resit</td>  
        <td>Tarikh</td>  
        <td>Status<br>Tempahan</td>  
        <td>Jumlah<br>Bayaran (RM)</td>  
    </tr>  

<?php while($m = mysqli_fetch_array($laksql)){ ?>

    <tr align='center'>  
        <td align='left'>  
        <?php  
echo"<a href='tempah-sejarah.php?no_resit=".$m['no_resit']."'>".$m['no_resit']."</a>";  
        if(isset($_GET['no_resit']) and $m['no_resit']==$_GET['no_resit']) echo $menu;  
        ?></td>  
        <td><?php 
                $tarikh=date_create($m['tarikh']);  
                echo "Tarikh : ".
                                  date_format($tarikh,"d/m/Y")."<br>  
                      Masa : ".   date_format($tarikh,"H:i:s");  
        ?></td>  
       <td><?= $m['status_tempah']."<br><i>".$m['jenis_tempah']."</i>"; ?></td>  
       <td><?= $m['jum'] ?></td>  
   </tr>  
<?php } } else { echo "<p align='center'>Tiada Sejarah Tempahan</p>"; } ?>  
</table>