<?php
# Memulakan fungsi session dan memanggil fail header.php
session_start();
include('header.php');
?>
<!-- Bahagian Borang Login -->
 <h3>Daftar Masuk Pengguna (LOGIN)</h3>
 <p>Sila Lengkapkan Maklumat di bawah</p>
 <form action = '' method = 'POST'>
    Notel   <input type ='text'     name='notel' ><br>
    Pass    <input type ='password' name='pass'  ><br>
            <input type ='submit'   value='Daftar Masuk'>
 </form>

<?php
# Bahagian proses login
# Menyemak kewujudan data POST
if(!empty($_POST)) {

   # Memanggil fail connection
   include('connection.php');

   # Mengambil data daripada form
    $notel = $_POST['notel'];
    $pass  = $_POST['pass'];

    # Arahan SQL untuk login (carian dalam table pengguna)
    $sql = "select * from pengguna
            where notel = '$notel' 
            and katalaluan = '$pass' limit 1";

   # Melaksanakan Arahan SQL
   $laksana   = mysqli_query($condb,$sql);

   # Menyemak jika terdapat data pengguna yang login
   if(mysqli_num_rows($laksana)==1){

      # login berjaya + ambil data pengguna
      $m = mysqli_fetch_array($laksana);
      $_SESSION['notel'] = $m['notel'];
      $_SESSION['tahap'] = $m['tahap'];

      # Buka fail index.php
      echo"<script>window.location.href='menu.php';</script>";
   }else{
       # login gagal. Papar SQL + error
       echo "<p style='color:red;'>Login Gagal</br>";
       echo "Semak No Telefon dan KataLaluan</p>";
   } 
}
?>
<?php include('footer.php'); ?>