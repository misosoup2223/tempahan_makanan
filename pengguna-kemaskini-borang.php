<?php
# Memulakan fungsi session
session_start();

# Memanggil fail header dan fail kawalan-admin.php
include('header.php');
include('kawalan-admin.php');
include('connection.php');

# Menyemak kewujudan data GET. Jika data GET empty, buka fail pengguna-senarai.php
if(empty($_GET)) {
    die("<script>window.location.href='pengguna-senarai.php';</script>");
}

# Mendapatkan data daripada pangkalan data
$sql        =  "select * from pengguna where notel = '".$_GET['notel']."' ";
$laksana    =   mysqli_query($condb, $sql);
$m          =   mysqli_fetch_array($laksana);
?>

<h3>Kemaskini Pengguna</h3>

<form action='pengguna-kemaskini-proses.php?notel_lama=<?= $_GET['notel'] ?>' 
method='POST'>
nama
<input type='text' name='nama' value='<?= $m['nama'] ?>' required><br>

notel
<input type='text' name='notel' value='<?= $m['notel'] ?>' required><br>

 katalaluan
<input type='text' name='katalaluan' value='<?= $m['katalaluan'] ?>' required><br>

Tahap
<select name='tahap'><br>
<option value='<?= $m['tahap'] ?>'> <?= $m['tahap'] ?> </option>
<?php

# Proses memaparkan senarai tahap dalam bentuk drop down list
$arahan_sql_tahap      = "select tahap from pengguna group by tahap order by tahap";
$laksana_arahan_tahap  = mysqli_query($condb,$arahan_sql_tahap);

        while($n=mysqli_fetch_array($laksana_arahan_tahap))
        {
            if($n['tahap'] != $m['tahap']){
                echo "<option value='".$n['tahap']."'>
                    ".$n['tahap']."
                </option>";
            }
        }
?>
</select> <br>

<input type='submit' value='Kemaskini'>

</form>
<?php include ('footer.php'); ?>