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

$maxRows_list_bayar = 10;
$pageNum_list_bayar = 0;
if (isset($_GET['pageNum_list_bayar'])) {
  $pageNum_list_bayar = $_GET['pageNum_list_bayar'];
}
$startRow_list_bayar = $pageNum_list_bayar * $maxRows_list_bayar;

$colname_keranjang = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_keranjang = $_SESSION['MM_Username'];
}
mysql_select_db($database_toko_cahya, $toko_cahya);
$query_list_bayar = sprintf("SELECT * FROM bayar, user WHERE bayar.userName=user.userName AND user.userName=%s AND bayar.status=1", GetSQLValueString($colname_keranjang, "text"));
$query_limit_list_bayar = sprintf("%s LIMIT %d, %d", $query_list_bayar, $startRow_list_bayar, $maxRows_list_bayar);
$list_bayar = mysql_query($query_limit_list_bayar, $toko_cahya) or die(mysql_error());
$row_list_bayar = mysql_fetch_assoc($list_bayar);

if (isset($_GET['totalRows_list_bayar'])) {
  $totalRows_list_bayar = $_GET['totalRows_list_bayar'];
} else {
  $all_list_bayar = mysql_query($query_list_bayar);
  $totalRows_list_bayar = mysql_num_rows($all_list_bayar);
}
$totalPages_list_bayar = ceil($totalRows_list_bayar/$maxRows_list_bayar)-1;

$queryString_list_bayar = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_list_bayar") == false && 
        stristr($param, "totalRows_list_bayar") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_list_bayar = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_list_bayar = sprintf("&totalRows_list_bayar=%d%s", $totalRows_list_bayar, $queryString_list_bayar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div class="detail">
<table border="1" width="100%" align="center">
  <tr>
    <td>judul</td>
    <td>foto_transfer</td>
    <td>Pembayaran </td>
    <td>tanggal_bayar</td>
    <td>Status Pembayaran</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_list_bayar['judul']; ?>&nbsp;</td>
      <td><img src="foto/bukti-transfer/<?php echo $row_list_bayar['foto_transfer']; ?>" />&nbsp; </td>
      <td>ID Order : <?php echo $row_list_bayar['id_order']; ?></td>
      <td><?php echo $row_list_bayar['tanggal_bayar']; ?>&nbsp; </td>
      <td><?php
	  $st = $row_list_bayar['status'] ;
	  if ($st == 0) {
		  echo"Belum di terima";
	  }
	  else {
		  echo"Diterima";
	  }
	  ?>&nbsp; </td>
    </tr>
    <?php } while ($row_list_bayar = mysql_fetch_assoc($list_bayar)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_list_bayar > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_list_bayar=%d%s", $currentPage, 0, $queryString_list_bayar); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_list_bayar > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_list_bayar=%d%s", $currentPage, max(0, $pageNum_list_bayar - 1), $queryString_list_bayar); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_list_bayar < $totalPages_list_bayar) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_list_bayar=%d%s", $currentPage, min($totalPages_list_bayar, $pageNum_list_bayar + 1), $queryString_list_bayar); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_list_bayar < $totalPages_list_bayar) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_list_bayar=%d%s", $currentPage, $totalPages_list_bayar, $queryString_list_bayar); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>

</div>
</body>
</html>
<?php
mysql_free_result($list_bayar);
?>
