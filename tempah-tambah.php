<?php
# memulakan session
session_start();

# mengistihar tatasusun session['orders'] jika belum wujud
if(!isset($_SESSION['orders'])){
    $_SESSION['orders'] = array();
}

# menambah elemen ke dalam tatasusun session['orders']
array_push($_SESSION['orders'],$_GET['id_menu']);
if($_GET['page']=="menu"){
    echo"<script>window.location.href='menu.php?jenis=".$_GET['jenis']."';</script>";
}else{
    echo"<script>window.location.href='tempah-cart.php';</script>";
}

?>