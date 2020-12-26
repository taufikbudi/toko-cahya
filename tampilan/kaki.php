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

$maxRows_kat_ko = 5;
$pageNum_kat_ko = 0;
if (isset($_GET['pageNum_kat_ko'])) {
  $pageNum_kat_ko = $_GET['pageNum_kat_ko'];
}
$startRow_kat_ko = $pageNum_kat_ko * $maxRows_kat_ko;

mysql_select_db($database_toko_cahya, $toko_cahya);
$query_kat_ko = "SELECT * FROM kategori_barang";
$query_limit_kat_ko = sprintf("%s LIMIT %d, %d", $query_kat_ko, $startRow_kat_ko, $maxRows_kat_ko);
$kat_ko = mysql_query($query_limit_kat_ko, $toko_cahya) or die(mysql_error());
$row_kat_ko = mysql_fetch_assoc($kat_ko);

if (isset($_GET['totalRows_kat_ko'])) {
  $totalRows_kat_ko = $_GET['totalRows_kat_ko'];
} else {
  $all_kat_ko = mysql_query($query_kat_ko);
  $totalRows_kat_ko = mysql_num_rows($all_kat_ko);
}
$totalPages_kat_ko = ceil($totalRows_kat_ko/$maxRows_kat_ko)-1;

$maxRows_halaman = 5;
$pageNum_halaman = 0;
if (isset($_GET['pageNum_halaman'])) {
  $pageNum_halaman = $_GET['pageNum_halaman'];
}
$startRow_halaman = $pageNum_halaman * $maxRows_halaman;

mysql_select_db($database_toko_cahya, $toko_cahya);
$query_halaman = "SELECT * FROM halaman";
$query_limit_halaman = sprintf("%s LIMIT %d, %d", $query_halaman, $startRow_halaman, $maxRows_halaman);
$halaman = mysql_query($query_limit_halaman, $toko_cahya) or die(mysql_error());
$row_halaman = mysql_fetch_assoc($halaman);

if (isset($_GET['totalRows_halaman'])) {
  $totalRows_halaman = $_GET['totalRows_halaman'];
} else {
  $all_halaman = mysql_query($query_halaman);
  $totalRows_halaman = mysql_num_rows($all_halaman);
}
$totalPages_halaman = ceil($totalRows_halaman/$maxRows_halaman)-1;
?>




<div class="clear"></div>

</div>

<div class="bawah">
	<div class="bawah-widget">
      <?php do { ?>
      <li><a href="http://cahyacyber.gq/halaman.php?id_halaman=<?php echo $row_halaman['id_halaman']; ?>"> <?php echo $row_halaman['judul_halaman']; ?></a></li>
        <?php } while ($row_halaman = mysql_fetch_assoc($halaman)); ?>
       </div>
	<div class="bawah-widget">
    
	  <?php do { ?>
      <li><a href="http://cahyacyber.gq/kategori.php?id_kategori=<?php echo $row_kat_ko['id_kategori']; ?>"><?php echo $row_kat_ko['nama_kategori']; ?></a></li>
	    <?php } while ($row_kat_ko = mysql_fetch_assoc($kat_ko)); ?>
	  
    </div>
	<div class="bawah-widget">
	  Facebook
    </div>
	<div class="bawah-widget">
	  <li>Cahyacyber adalah toko online terpercaya di kota metro dengan sistem b2b </li>
    </div>
    
<div class="clear"></div>
</div>
</div>
</body>
</html><?php
mysql_free_result($kat_ko);

mysql_free_result($halaman);
?>
