<?php require_once('../../Connections/toko_cahya.php');
include'../head.php';
include'../menu.php'; ?>
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

$maxRows_idnex = 10;
$pageNum_idnex = 0;
if (isset($_GET['pageNum_idnex'])) {
  $pageNum_idnex = $_GET['pageNum_idnex'];
}
$startRow_idnex = $pageNum_idnex * $maxRows_idnex;

mysql_select_db($database_toko_cahya, $toko_cahya);
$query_idnex = "SELECT * FROM bayar";
$query_limit_idnex = sprintf("%s LIMIT %d, %d", $query_idnex, $startRow_idnex, $maxRows_idnex);
$idnex = mysql_query($query_limit_idnex, $toko_cahya) or die(mysql_error());
$row_idnex = mysql_fetch_assoc($idnex);

if (isset($_GET['totalRows_idnex'])) {
  $totalRows_idnex = $_GET['totalRows_idnex'];
} else {
  $all_idnex = mysql_query($query_idnex);
  $totalRows_idnex = mysql_num_rows($all_idnex);
}
$totalPages_idnex = ceil($totalRows_idnex/$maxRows_idnex)-1;

$queryString_idnex = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_idnex") == false && 
        stristr($param, "totalRows_idnex") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_idnex = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_idnex = sprintf("&totalRows_idnex=%d%s", $totalRows_idnex, $queryString_idnex);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1" align="center" width="100%">
  <tr>
    <td>id_order</td>
    <td>userName</td>
    <td>foto_transfer</td>
    <td>tanggal_bayar</td>
    <td>status</td>
    <td>Pilihan</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="detail.php?recordID=<?php echo $row_idnex['id_bayar']; ?>"> <?php echo $row_idnex['id_order']; ?>&nbsp; </a></td>
      <td><?php echo $row_idnex['userName']; ?>&nbsp; </td>
      <td><a href="../../foto/bukti-transfer/<?php echo $row_idnex['foto_transfer']; ?>"><img src="../../foto/bukti-transfer/<?php echo $row_idnex['foto_transfer']; ?>" width="100" /></a>&nbsp; </td>
      <td><?php echo $row_idnex['tanggal_bayar']; ?>&nbsp; </td>
      <td><?php 
	  $status = $row_idnex['status'];
	  if ($status == 1) {
		  echo "<a href='tolak.php?id_bayar=".$row_idnex['id_bayar']."'>Tolak</a>";
	  }
	  else if ($status == 0) {
		  echo "<a href='terima.php?id_bayar=".$row_idnex['id_bayar']."'>Terima</a>";
	  }
	  
	  ; ?>&nbsp; </td>
<td><a href="hapus.php?id_bayar=<?php echo $row_idnex['id_bayar']; ?>">Hapus</a></td>
    </tr>
    <?php } while ($row_idnex = mysql_fetch_assoc($idnex)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_idnex > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_idnex=%d%s", $currentPage, 0, $queryString_idnex); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_idnex > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_idnex=%d%s", $currentPage, max(0, $pageNum_idnex - 1), $queryString_idnex); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_idnex < $totalPages_idnex) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_idnex=%d%s", $currentPage, min($totalPages_idnex, $pageNum_idnex + 1), $queryString_idnex); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_idnex < $totalPages_idnex) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_idnex=%d%s", $currentPage, $totalPages_idnex, $queryString_idnex); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_idnex + 1) ?> to <?php echo min($startRow_idnex + $maxRows_idnex, $totalRows_idnex) ?> of <?php echo $totalRows_idnex ?>
</body>
</html>
<?php
mysql_free_result($idnex);
?>
