<?php require_once('../../Connections/toko_cahya.php');include'../head.php';
include'../menu.php'; ?><?php
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
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_toko_cahya, $toko_cahya);
$query_DetailRS1 = sprintf("SELECT * FROM `user` WHERE id_user = %s", GetSQLValueString($colname_DetailRS1, "-1"));
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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<table border="1" align="center">
  <tr>
    <td>id_user</td>
    <td><?php echo $row_DetailRS1['id_user']; ?></td>
  </tr>
  <tr>
    <td>user</td>
    <td><?php echo $row_DetailRS1['user']; ?></td>
  </tr>
  <tr>
    <td>pass</td>
    <td><?php echo $row_DetailRS1['pass']; ?></td>
  </tr>
  <tr>
    <td>nama_lengkap</td>
    <td><?php echo $row_DetailRS1['nama_lengkap']; ?></td>
  </tr>
  <tr>
    <td>foto_profil</td>
    <td><?php echo $row_DetailRS1['foto_profil']; ?></td>
  </tr>
  <tr>
    <td>alamat</td>
    <td><?php echo $row_DetailRS1['alamat']; ?></td>
  </tr>
  <tr>
    <td>email</td>
    <td><?php echo $row_DetailRS1['email']; ?></td>
  </tr>
  <tr>
    <td>no_hp</td>
    <td><?php echo $row_DetailRS1['no_hp']; ?></td>
  </tr>
  <tr>
    <td>tanggal_daftar</td>
    <td><?php echo $row_DetailRS1['tanggal_daftar']; ?></td>
  </tr>
</table>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>