<?php
# Memulakan fungsi session
session_start();

# Memanggil fail kawalan-admin.php
include('kawalan-admin.php');

# Menyemak kewujudan data POST
if(!empty($_POST))
{
    # Memanggil fail connection.php
    include('connection.php');

    # Pengesahan data (validation) notel pengguna
    if(strlen($_POST['notel']) < 10 or strlen($_POST['notel']) > 13)
    {
        die("<script>alert('Ralat notel');
        window.history.back();</script>");
    }

    # arahan SQL (query) untuk kemaskini maklumat pengguna
    $arahan     = "update pengguna set 
    nama        = '".$_POST['nama']."',
    notel       = '".$_POST['notel']."',
    katalaluan  = '".$_POST['katalaluan']."',
    tahap       = '".$_POST['tahap']."'
    where 
    notel       = '".$_GET['notel_lama']."' ";

    # melaksana dan menyemak proses kemaskini
    if(mysqli_query($condb,$arahan))
    {
        # kemaskini berjaya
        echo "<script>alert('Kemaskini Berjaya');
        window.location.href='pengguna-senarai.php';</script>";
    }
    else
    {
        # kemaskini gagal
        # die(mysqli_error($condb)); echo $arahan;
        echo "<script>alert('Kemaskini Gagal');
        window.history.back();</script>";
    }
}
else
{
    # Jika data GET tidak wujud, kembali ke fail pengguna-senarai.php
    die("<script>alert('Sila lengkapkan data');
    window.location.href='pengguna-senarai.php';</script>");
}
?>