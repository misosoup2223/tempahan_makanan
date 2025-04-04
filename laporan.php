<?php
# Memulakan fungsi session dan memanggil fail connection & header.php
session_start();
include('header.php');
include('connection.php');
include('kawalan-admin.php');

if(isset($_POST['tarikh_semasa'])){
    $tarikhsemasa = $_POST['tarikh_semasa'];
}else{
    $tarikhsemasa = date("Y-m-d");
}

# Dapatkan Senarai tarikh
$sqltarikh = "SELECT DATE(tarikh) AS tarikh, count(*) as bilangan
FROM resit
GROUP BY DATE(tarikh)
ORDER BY DATE(tarikh) DESC";
$laktarikh = mysqli_query($condb,$sqltarikh);

# dapatkan semua senarai tempahan
$sql = "SELECT *, 
     (SELECT sum(tempahan.kuantiti * tempahan.harga_asal) 
     FROM tempahan 
     WHERE tempahan.no_resit=resit.no_resit) AS jum
     FROM resit
     where resit.tarikh like '%$tarikhsemasa%'
     ORDER BY resit.tarikh DESC";
$laksql = mysqli_query($condb,$sql);
?>

<h3>Laporan Tempahan</h3>
<form action='' method='POST'>
Pilih Tarikh
<select name='tarikh_semasa'>
    <option value='<?= $tarikhsemasa ?>'>
        <?= date_format(date_create($tarikhsemasa),"d/m/Y"); ?></option>
    <option disabled>Pilih Tarikh Lain Di bawah</option>
    <?php while($mm = mysqli_fetch_array($laktarikh)): ?>
        <option value='<?= $mm['tarikh'] ?>'>
            <?= date_format(date_create($mm['tarikh']),"d/m/Y") ?>
        </option>
    <?php endwhile; ?>

</select>
<input type='submit' value='PAPAR'>
</form>

<!-- Memaparkan senarai tempahan berdasarkan tarikh -->
<table align='center' border='1' width='50%'>
    <tr align='center'>
        <td>No Resit</td>
        <td>Tarikh</td>
        <td>Status<br>Tempahan</td>
        <td>Jumlah<br>Bayaran (RM)</td>
        <td>Tindakan</td>
    </tr>

<?php while($m = mysqli_fetch_array($laksql)){ ?>

<tr align='center'>
    <td align='left'>
        
<?php 
    echo "<b><u>".$m['no_resit']."</u></b><br>";

     # mendapatkan data tempahan
    $sqlpaparmenu ="SELECT * FROM tempahan, menu 
    Where tempahan.id_menu = menu.id_menu 
    and tempahan.no_resit  = '".$m['no_resit']."'";
    $lakpaparmenu = mysqli_query($condb,$sqlpaparmenu);

    $menu="<br>";
    while($mm=mysqli_fetch_array($lakpaparmenu)){
        echo $mm['nama_menu']." ( ".$mm['kuantiti']." x RM".$mm['harga_asal'].")<br>";

    }
        ?></td>
        <td><?php 
            $tarikh=date_create($m['tarikh']);
            echo "Tarikh : ".date_format($tarikh,"d/m/Y")."<br>"
                   Masa : ".date_format($tarikh,"H:i:s");

            ?>

        </td>
        <td><?= $m['status_tempah']."<br><i>".$m['jenis_tempah']."</i>" ?></td>
        <td><?= $m['jum'] ?></td>
        <td>
        <?php 
        if($m['status_tempah']!='SIAP'){
                echo "&#9989;";
        } else {
             echo "<a href='tempah-siap.php?no_resit=".$m['no_resit']."'>&#10060;</a>";
        }
        ?>
        </td>
    </tr>
<?php } ?>