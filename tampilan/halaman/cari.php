
<?php require_once('Connections/toko_cahya.php'); ?>
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

$maxRows_cari_barang = 100;
$pageNum_cari_barang = 0;
if (isset($_GET['pageNum_cari_barang'])) {
  $pageNum_cari_barang = $_GET['pageNum_cari_barang'];
}
$startRow_cari_barang = $pageNum_cari_barang * $maxRows_cari_barang;

mysql_select_db($database_toko_cahya, $toko_cahya);
$query_cari_barang = "SELECT * FROM list_barang,kategori_barang WHERE nama_barang LIKE '%$_POST[nama_barang]%' AND list_barang.id_kategori=kategori_barang.id_kategori";
$query_limit_cari_barang = sprintf("%s LIMIT %d, %d", $query_cari_barang, $startRow_cari_barang, $maxRows_cari_barang);
$cari_barang = mysql_query($query_limit_cari_barang, $toko_cahya) or die(mysql_error());
$row_cari_barang = mysql_fetch_assoc($cari_barang);

if (isset($_GET['totalRows_cari_barang'])) {
  $totalRows_cari_barang = $_GET['totalRows_cari_barang'];
} else {
  $all_cari_barang = mysql_query($query_cari_barang);
  $totalRows_cari_barang = mysql_num_rows($all_cari_barang);
}
$totalPages_cari_barang = ceil($totalRows_cari_barang/$maxRows_cari_barang)-1; ?>
   
<?php if ($totalRows_cari_barang > 0) { // Show if recordset not empty ?>
<center><?php echo "Menampilkan hasil dari kata kunci <b>".$_POST['nama_barang']."</b>"; ?></center><div class="clear"></div>

      <?php do { ?>
<div class="produk">
	<div class="produk-title"><?php echo $row_cari_barang['nama_barang']; ?> </div>
    <p> Kategori : <a href="kategori.php?id_kategori=<?php echo $row_cari_barang['id_kategori']; ?>"><?php echo $row_cari_barang['nama_kategori']; ?></a>&nbsp;  </p>
    <p><img src="foto/<?php echo $row_cari_barang['foto_barang']; ?>"/></p>
    <p class="produk-keterangan"><?php echo $row_cari_barang['deskripsi_barang']; ?><br>
<strong>Stok : <?php echo $row_cari_barang['stok']; ?> Unit
</strong></p>
    <li class="harga"> Harga : Rp.<?php echo format_rupiah($row_cari_barang['harga_barang']); ?>,- </li>
    <p><a href="beli.php?id_barang=<?php echo $row_cari_barang['id_barang']; ?>" class="button-beli">Beli</a>
    	<a href="detail.php?id_barang=<?php echo $row_cari_barang['id_barang']; ?>" class="button-beli"> Lihat Detail</a>
    </p>
</div>
  <?php } while ($row_cari_barang = mysql_fetch_assoc($cari_barang)); ?>
  <div class="clear"></div>
 
<?php }
else {
	echo "<div class='detail'> Maaf Kata kunci <b>$_POST[nama_barang]</b> tidak ditemukan</div>";
}
?>
<?php mysql_free_result($cari_barang);
?>
