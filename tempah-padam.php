<?php
# Memulakan session
session_start();

# Mencari id menu pada tatasusun session['orders']
$key = array_search($_GET['id_menu'], $_SESSION['orders']);

# Jika ada, buang id menu tersebut menggunaakan unset
if ($key !== false) {
    unset($_SESSION['orders'][$key]);
} 
# menyusun semula indeks elemen pada tatasusun session['orders']
$_SESSION['orders'] = array_values($_SESSION['orders']);

echo "<script>window.location.href='tempah-cart.php';</script>";
?>