<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_kategori = 5;
$pageNum_kategori = 0;
if (isset($_GET['pageNum_kategori'])) {
  $pageNum_kategori = $_GET['pageNum_kategori'];
}
$startRow_kategori = $pageNum_kategori * $maxRows_kategori;

mysql_select_db($database_toko_cahya, $toko_cahya);
$query_kategori = "SELECT * FROM kategori_barang";
$query_limit_kategori = sprintf("%s LIMIT %d, %d", $query_kategori, $startRow_kategori, $maxRows_kategori);
$kategori = mysql_query($query_limit_kategori, $toko_cahya) or die(mysql_error());
$row_kategori = mysql_fetch_assoc($kategori);

if (isset($_GET['totalRows_kategori'])) {
  $totalRows_kategori = $_GET['totalRows_kategori'];
} else {
  $all_kategori = mysql_query($query_kategori);
  $totalRows_kategori = mysql_num_rows($all_kategori);
}
$totalPages_kategori = ceil($totalRows_kategori/$maxRows_kategori)-1;

$maxRows_produk = 10;
$pageNum_produk = 0;
if (isset($_GET['pageNum_produk'])) {
  $pageNum_produk = $_GET['pageNum_produk'];
}
$startRow_produk = $pageNum_produk * $maxRows_produk;

mysql_select_db($database_toko_cahya, $toko_cahya);
$query_produk = "SELECT * FROM list_barang";
$query_limit_produk = sprintf("%s LIMIT %d, %d", $query_produk, $startRow_produk, $maxRows_produk);
$produk = mysql_query($query_limit_produk, $toko_cahya) or die(mysql_error());
$row_produk = mysql_fetch_assoc($produk);

if (isset($_GET['totalRows_produk'])) {
  $totalRows_produk = $_GET['totalRows_produk'];
} else {
  $all_produk = mysql_query($query_produk);
  $totalRows_produk = mysql_num_rows($all_produk);
}
$totalPages_produk = ceil($totalRows_produk/$maxRows_produk)-1;
?>


<?php include'Connections/sidebar_keranjang.php'?>
<div class="sidebar">
<div class="sidebar-title">Total Belanja </div>
<div class="sidebar-konten">
<?php
$bayaran=$row_Recordset1['sum( total_bayar)'];
 if ($bayaran >0){ ?>
<b>Rp.<?php
$bayar = $row_Recordset1['sum( total_bayar)'];
 echo format_rupiah($bayar); ?>,-</b></li>
 <a href="bayar.php"> Bayar Sekarang </a>
 <?php }
 else {
	 echo "Keranjang anda kosong . <li class='beli'><a href='index.php'>Pilih Barang</a></li>";
 }
  ?>
 </div>
	<div class="sidebar-title"> Kategori </div>
    <div class="sidebar-konten"> 
      <?php do { ?>
      <li><a href="http://cahyacyber.gq/kategori.php?id_kategori=<?php echo $row_kategori['id_kategori']; ?>"><?php echo $row_kategori['nama_kategori']; ?></a></li>
        <?php } while ($row_kategori = mysql_fetch_assoc($kategori)); ?>
    </div>
    
    <div class="sidebar-title"> Produk Terbaru </div>
    <div class="sidebar-konten"> 
      <?php do { ?>
      <li><a href="http://cahyacyber.gq/detail.php?id_barang=<?php echo $row_produk['id_barang']; ?>"><?php echo $row_produk['nama_barang']; ?></a></li>
        <?php } while ($row_produk = mysql_fetch_assoc($produk)); ?>
    </div>
</div>
<?php
mysql_free_result($kategori);

mysql_free_result($produk);
?>
