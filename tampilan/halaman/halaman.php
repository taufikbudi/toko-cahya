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

$colname_halaman = "-1";
if (isset($_GET['id_halaman'])) {
  $colname_halaman = $_GET['id_halaman'];
}
mysql_select_db($database_toko_cahya, $toko_cahya);
$query_halaman = sprintf("SELECT * FROM halaman WHERE id_halaman = %s", GetSQLValueString($colname_halaman, "int"));
$halaman = mysql_query($query_halaman, $toko_cahya) or die(mysql_error());
$row_halaman = mysql_fetch_assoc($halaman);
$totalRows_halaman = mysql_num_rows($halaman);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $row_halaman['judul_halaman']; ?></title>
</head>

<body>

<div class="detail">
<?php echo $row_halaman['isi_halaman']; ?>
</div>
</body>
</html>
<?php
mysql_free_result($halaman);
?>
