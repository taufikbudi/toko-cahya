<?php require_once('../../Connections/toko_cahya.php');
include'../head.php';
include'../menu.php';
 ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE user_order SET status_order=%s WHERE id_order=%s",
                       GetSQLValueString(1, "int"),
                       GetSQLValueString($_POST['id_order'], "int"));

  mysql_select_db($database_toko_cahya, $toko_cahya);
  $Result1 = mysql_query($updateSQL, $toko_cahya) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$tolak = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $tolak .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "tolak")) {
  $updateSQL = sprintf("UPDATE user_order SET status_order=%s WHERE id_order=%s",
                       GetSQLValueString(0, "int"),
                       GetSQLValueString($_POST['id_order'], "int"));

  mysql_select_db($database_toko_cahya, $toko_cahya);
 $Result1= mysql_query($updateSQL, $toko_cahya) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_index_order = 10;
$pageNum_index_order = 0;
if (isset($_GET['pageNum_index_order'])) {
  $pageNum_index_order = $_GET['pageNum_index_order'];
}
$startRow_index_order = $pageNum_index_order * $maxRows_index_order;

mysql_select_db($database_toko_cahya, $toko_cahya);
$query_index_order = "SELECT * FROM user,user_order,list_barang WHERE user.userName=user_order.userName AND user_order.id_barang=list_barang.id_barang";
$query_limit_index_order = sprintf("%s LIMIT %d, %d", $query_index_order, $startRow_index_order, $maxRows_index_order);
$index_order = mysql_query($query_limit_index_order, $toko_cahya) or die(mysql_error());
$row_index_order = mysql_fetch_assoc($index_order);

if (isset($_GET['totalRows_index_order'])) {
  $totalRows_index_order = $_GET['totalRows_index_order'];
} else {
  $all_index_order = mysql_query($query_index_order);
  $totalRows_index_order = mysql_num_rows($all_index_order);
}
$totalPages_index_order = ceil($totalRows_index_order/$maxRows_index_order)-1;

$queryString_index_order = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_index_order") == false && 
        stristr($param, "totalRows_index_order") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_index_order = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_index_order = sprintf("&totalRows_index_order=%d%s", $totalRows_index_order, $queryString_index_order);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
p {
	display:none
}
</style>
</head>

<body>
<table border="1" align="center" width="100%">
  <tr>
    <td>id_order</td>
    <td>Kostumer</td>
    <td>Barang Pesanan</td>
    <td>jumlah_order</td>
    <td>tanggal_order</td>
    <td>status_order</td>
    <td>Total Bayar</td>
    <td width="200">Pilihan</td>
  </tr>
  <?php do {
	  $number =$row_index_order['total_bayar'];
$format_indonesia = number_format ($number, 6, ',', '.');
	   ?>
    <tr>
      <td>Order ID = <?php echo $row_index_order['id_order']; ?><a href="detail.php?recordID=<?php echo $row_index_order['id_order']; ?>"> </a></td>
      <td><a href="http://cahyacyber.gq/panel/user/detail.php?recordID=<?php echo $row_index_order['id_user']; ?>"><?php echo $row_index_order['nama_lengkap']; ?>&nbsp; </a></td>
      <td><?php echo $row_index_order['nama_barang']; ?>&nbsp; </td>
      <td><?php echo $row_index_order['jumlah_order']; ?>  Unit </td>
      <td><?php echo $row_index_order['tanggal_order']; ?>&nbsp; </td>
        
      <p>&nbsp;</p></td>
      <td><?php $sts = $row_index_order['status_order'];
	  if ($sts == 1) {
		  echo "Diterima";
	  }
	  else {
		  echo "Ditolak";
	  }
	   ?>&nbsp; </td>
      <td>Rp.<?php echo format_rupiah($number) ; ?>&nbsp; </td>
      <td>
      <?php $status = $row_index_order['status_order'];
	  if ($status == 0) { ?>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">          
              <input type="submit" value="Terima" />          
          <input type="hidden" name="MM_update" value="form1" />
          <input type="hidden" name="id_order" value="<?php echo $row_index_order['id_order']; ?>" />
        </form>
        <?php } 
		else {
		?>
        <form action="<?php echo $tolak; ?>" method="post" name="tolak" id="tolak">          
              <input type="submit" value="Tolak" />          
          <input type="hidden" name="MM_update" value="tolak" />
          <input type="hidden" name="id_order" value="<?php echo $row_index_order['id_order']; ?>" />
        </form>
        <?php } ?>
        <a href="hapus.php?id_order=<?php echo $row_index_order['id_order']; ?>">Hapus</a>
        </td>
       
    <?php } while ($row_index_order = mysql_fetch_assoc($index_order)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_index_order > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_index_order=%d%s", $currentPage, 0, $queryString_index_order); ?>">First</a>
    <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_index_order > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_index_order=%d%s", $currentPage, max(0, $pageNum_index_order - 1), $queryString_index_order); ?>">Previous</a>
    <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_index_order < $totalPages_index_order) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_index_order=%d%s", $currentPage, min($totalPages_index_order, $pageNum_index_order + 1), $queryString_index_order); ?>">Next</a>
    <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_index_order < $totalPages_index_order) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_index_order=%d%s", $currentPage, $totalPages_index_order, $queryString_index_order); ?>">Last</a>
    <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_index_order + 1) ?> to <?php echo min($startRow_index_order + $maxRows_index_order, $totalRows_index_order) ?> of <?php echo $totalRows_index_order ?>
</body>
</html>
<?php
mysql_free_result($index_order);
?>
