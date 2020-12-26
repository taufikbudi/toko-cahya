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

$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['id_barang'])) {
  $colname_DetailRS1 = $_GET['id_barang'];
}
mysql_select_db($database_toko_cahya, $toko_cahya);
$query_DetailRS1 = sprintf("SELECT * FROM list_barang,kategori_barang WHERE list_barang.id_kategori=kategori_barang.id_kategori AND id_barang = %s", GetSQLValueString($colname_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $toko_cahya) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?>
<div class="detail">
<div class="gambar">
<img src="foto/<?php echo $row_DetailRS1['foto_barang']; ?>">
</div>
<div class="detail-keterangan">
	<li> <?php echo $row_DetailRS1['nama_barang']; ?></li>
    <li>Kategori : <a href="kategori.php?id_kategori=<?php echo $row_DetailRS1['id_kategori']; ?>"> <?php echo $row_DetailRS1['nama_kategori']; ?></a></li>
    <li>Stok : 
	<?php
	$stok = $row_DetailRS1['stok'];
	if ($stok <1 ) {
		echo "<b>STOK HABIS</b>";
	}
	else {
		echo $stok." Unit";
	}
	; ?>
	</li>
    <li>
   <?php echo $row_DetailRS1['deskripsi_barang']; ?>
    </li>
    <li class="harga"> Rp.<?php echo format_rupiah($row_DetailRS1['harga_barang']); ?>,- </li>
     <?php if ($stok <1 ) { ?>
	 
    <li class="beli"> STOK HABIS</li>
       <?php }
	   else {
	    ?>   
    <li class="beli"><a href="beli.php?id_barang=<?php echo $row_DetailRS1['id_barang']; ?>"> Beli Sekarang</a></li>
   <?php } ?>
</div>
</div>

<?php
mysql_free_result($DetailRS1);
?>