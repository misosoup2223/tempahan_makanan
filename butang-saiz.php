<!-- fungsi mengubah saiz tulisan bagi kepelbagaian pengguna-->
<script>

function ubahsaiz(gandaan) {
   //mendapatkan saiz semasa tulisan pada jadual 
    var saiz = document.getElementById("saiz");
    var saiz_semua = saiz.style.fontSize || 1;

    if(gandaan==2) {
        saiz.style.fontSize = "1em";
    } else {
        saiz.style.fontSize = (parseFloat(saiz_semua) + (gandaan * 0.2)) + "em";
    }    
}
</script>

<!-- Kod untuk butang mengubah saiz tulisan -->
| ubah saiz tulisan |
    <input name='rb' type='button' value='reset'          onclick="ubahsaiz(2)" />
    <input name='r' type='button' value='&nbsp; + &nbsp;' onclick="ubahsaiz(1)" />
    <input name='rk' type='button' value='&nbsp; - &nbsp;' onclick="ubahsaiz(-1)" />
|
<button onclick="window.print()">Cetak</button>