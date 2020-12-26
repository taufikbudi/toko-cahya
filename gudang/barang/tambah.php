<?php require_once('../../Connections/toko_cahya.php'); 
include'../head.php';
include'../menu.php';
include('../../Connections/upload.php');
$lokasi_file = $_FILES['fupload']['tmp_name'];
$nama_file   = $_FILES['fupload']['name'];
?><?php
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if (!empty($lokasi_file)){ 
	UploadFoto($nama_file) ;
  $insertSQL = sprintf("INSERT INTO list_barang (id_kategori,nama_barang, foto_barang, deskripsi_barang, stok, tanggal_input, harga_barang) VALUES (%s, %s, %s, %s, %s, %s,%s)",
                       GetSQLValueString($_POST['id_kategori'], "int"),
                       GetSQLValueString($_POST['nama_barang'], "text"),
                       GetSQLValueString($nama_file, "text"),
                       GetSQLValueString($_POST['deskripsi_barang'], "text"),
                       GetSQLValueString($_POST['stok'], "int"),
                       GetSQLValueString($_POST['tanggal_input'], "date"),
                       GetSQLValueString($_POST['harga_barang'], "text"));

  mysql_select_db($database_toko_cahya, $toko_cahya);
  $Result1 = mysql_query($insertSQL, $toko_cahya) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
else {
	 $insertSQL = sprintf("INSERT INTO list_barang (id_kategori,nama_barang, foto_barang, deskripsi_barang, stok, tanggal_input, harga_barang) VALUES (%s, %s, %s, %s, %s, %s,%s)",
                       GetSQLValueString($_POST['id_kategori'], "int"),
                       GetSQLValueString($_POST['nama_barang'], "text"),
                       GetSQLValueString('gambarkosong.jpg', "text"),
                       GetSQLValueString($_POST['deskripsi_barang'], "text"),
                       GetSQLValueString($_POST['stok'], "int"),
                       GetSQLValueString($_POST['tanggal_input'], "date"),
                       GetSQLValueString($_POST['harga_barang'], "text"));

  mysql_select_db($database_toko_cahya, $toko_cahya);
  $Result1 = mysql_query($insertSQL, $toko_cahya) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
	}

}

mysql_select_db($database_toko_cahya, $toko_cahya);
$query_kategori_barang = "SELECT * FROM kategori_barang";
$kategori_barang = mysql_query($query_kategori_barang, $toko_cahya) or die(mysql_error());
$row_kategori_barang = mysql_fetch_assoc($kategori_barang);
$totalRows_kategori_barang = mysql_num_rows($kategori_barang);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" enctype="multipart/form-data" >
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nama_barang:</td>
      <td><input type="text" name="nama_barang" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kategori barang</td>
      <td><select name="id_kategori" id="id_kategori">
        <?php
do {  
?>
        <option value="<?php echo $row_kategori_barang['id_kategori']?>"<?php if (!(strcmp($row_kategori_barang['id_kategori'], $row_kategori_barang['id_kategori']))) {echo "selected=\"selected\"";} ?>><?php echo $row_kategori_barang['nama_kategori']?></option>
        <?php
} while ($row_kategori_barang = mysql_fetch_assoc($kategori_barang));
  $rows = mysql_num_rows($kategori_barang);
  if($rows > 0) {
      mysql_data_seek($kategori_barang, 0);
	  $row_kategori_barang = mysql_fetch_assoc($kategori_barang);
  }
?>
      </select></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Foto_barang:</td>
      <td><input type="file" name="fupload" id="fupload" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Deskripsi_barang:</td>
      <td><textarea name="deskripsi_barang" cols="50" rows="5"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Stok:</td>
      <td><input type="text" name="stok" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tanggal_input:</td>
      <td><input type="text" name="tanggal_input" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Harga_barang:</td>
      <td><input type="text" name="harga_barang" id="harga_barang" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit"  value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($kategori_barang);
?>
