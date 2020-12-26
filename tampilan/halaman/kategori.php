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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_tampil_konten = 8;
$pageNum_tampil_konten = 0;
if (isset($_GET['pageNum_tampil_konten'])) {
  $pageNum_tampil_konten = $_GET['pageNum_tampil_konten'];
}
$startRow_tampil_konten = $pageNum_tampil_konten * $maxRows_tampil_konten;

$colname_tampil_konten = "-1";
if (isset($_GET['id_kategori'])) {
  $colname_tampil_konten = $_GET['id_kategori'];
}
mysql_select_db($database_toko_cahya, $toko_cahya);
$query_tampil_konten = sprintf("SELECT * FROM list_barang,kategori_barang WHERE list_barang.id_kategori=kategori_barang.id_kategori AND list_barang.id_kategori=%s", GetSQLValueString($colname_tampil_konten, "int"));
$query_limit_tampil_konten = sprintf("%s LIMIT %d, %d", $query_tampil_konten, $startRow_tampil_konten, $maxRows_tampil_konten);
$tampil_konten = mysql_query($query_limit_tampil_konten, $toko_cahya) or die(mysql_error());
$row_tampil_konten = mysql_fetch_assoc($tampil_konten);

if (isset($_GET['totalRows_tampil_konten'])) {
  $totalRows_tampil_konten = $_GET['totalRows_tampil_konten'];
} else {
  $all_tampil_konten = mysql_query($query_tampil_konten);
  $totalRows_tampil_konten = mysql_num_rows($all_tampil_konten);
}
$totalPages_tampil_konten = ceil($totalRows_tampil_konten/$maxRows_tampil_konten)-1;

$queryString_tampil_konten = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_tampil_konten") == false && 
        stristr($param, "totalRows_tampil_konten") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_tampil_konten = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_tampil_konten = sprintf("&totalRows_tampil_konten=%d%s", $totalRows_tampil_konten, $queryString_tampil_konten);
?>

      <?php do { ?>
<div class="produk">
	<div class="produk-title"><?php echo $row_tampil_konten['nama_barang']; ?> </div>
    <p> Kategori : <?php echo $row_tampil_konten['nama_kategori']; ?>&nbsp;  </p>
    <p><img src="foto/<?php echo $row_tampil_konten['foto_barang']; ?>"/></p>
    <p class="produk-keterangan"><?php echo $row_tampil_konten['deskripsi_barang']; ?><br>
<strong>Stok : <?php echo $row_tampil_konten['stok']; ?> Unit
</strong></p>
    <li class="harga"> Harga : Rp.<?php echo $row_tampil_konten['harga_barang']; ?>,- </li>
    <p><a href="beli.php?id_barang=<?php echo $row_tampil_konten['id_barang']; ?>" class="button-beli">Beli</a>
    	
        <a href="detail.php?id_barang=<?php echo $row_tampil_konten['id_barang']; ?>" class="button-beli"> Lihat Detail</a>
    </p>
</div>
  <?php } while ($row_tampil_konten = mysql_fetch_assoc($tampil_konten)); ?>
  <div class="clear"></div>
  <div class="pagging">
   
   
   <?php if ($pageNum_tampil_konten > 0) { // Show if not first page ?>
            <a class="next" href="<?php printf("%s?pageNum_tampil_konten=%d%s", $currentPage, 0, $queryString_tampil_konten); ?>">Halaman Utama</a>
            <?php } // Show if not first page ?>
            
			<?php if ($pageNum_tampil_konten > 0) { // Show if not first page ?>
            <a class="prev" href="<?php printf("%s?pageNum_tampil_konten=%d%s", $currentPage, max(0, $pageNum_tampil_konten - 1), $queryString_tampil_konten); ?>">Sebelumnya</a>
            <?php } // Show if not first page ?>
            
			<?php if ($pageNum_tampil_konten < $totalPages_tampil_konten) { // Show if not last page ?>
            <a class="next" href="<?php printf("%s?pageNum_tampil_konten=%d%s", $currentPage, min($totalPages_tampil_konten, $pageNum_tampil_konten + 1), $queryString_tampil_konten); ?>">Selanjutnya</a>
            <?php } // Show if not last page ?>
            
			<?php if ($pageNum_tampil_konten < $totalPages_tampil_konten) { // Show if not last page ?>
            <a class="prev" href="<?php printf("%s?pageNum_tampil_konten=%d%s", $currentPage, $totalPages_tampil_konten, $queryString_tampil_konten); ?>">Halaman Akhir</a>
            
            <?php } // Show if not last page ?>
     <div class="clear"></div>
</div>

<?php
mysql_free_result($tampil_konten);
?>
