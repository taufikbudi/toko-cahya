<?php require_once('../../Connections/toko_cahya.php');include'../head.php';
include'../menu.php';
include('../../Connections/upload.php');
$lokasi_file = $_FILES['fupload']['tmp_name'];
$nama_file   = $_FILES['fupload']['name'];
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	if (!empty($lokasi_file)){ 
	UploadFoto($nama_file) ;
  $updateSQL = sprintf("UPDATE list_barang SET id_kategori=%s, nama_barang=%s, foto_barang=%s, deskripsi_barang=%s, stok=%s, tanggal_input=%s, harga_barang=%s WHERE id_barang=%s",
                       GetSQLValueString($_POST['id_kategori'], "int"),
                       GetSQLValueString($_POST['nama_barang'], "text"),
                       GetSQLValueString($nama_file, "text"),
                       GetSQLValueString($_POST['deskripsi_barang'], "text"),
                       GetSQLValueString($_POST['stok'], "int"),
                       GetSQLValueString($_POST['tanggal_input'], "date"),
                       GetSQLValueString($_POST['harga_barang'], "text"),
                       GetSQLValueString($_POST['id_barang'], "int"));

  mysql_select_db($database_toko_cahya, $toko_cahya);
  $Result1 = mysql_query($updateSQL, $toko_cahya) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
else {
$updateSQL = sprintf("UPDATE list_barang SET id_kategori=%s, nama_barang=%s, deskripsi_barang=%s, stok=%s, tanggal_input=%s, harga_barang=%s WHERE id_barang=%s",
                       GetSQLValueString($_POST['id_kategori'], "int"),
                       GetSQLValueString($_POST['nama_barang'], "text"),
                       GetSQLValueString($_POST['deskripsi_barang'], "text"),
                       GetSQLValueString($_POST['stok'], "int"),
                       GetSQLValueString($_POST['tanggal_input'], "date"),
                       GetSQLValueString($_POST['harga_barang'], "text"),
                       GetSQLValueString($_POST['id_barang'], "int"));

  mysql_select_db($database_toko_cahya, $toko_cahya);
  $Result1 = mysql_query($updateSQL, $toko_cahya) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));

}
}

$colname_edit = "-1";
if (isset($_GET['id_barang'])) {
  $colname_edit = $_GET['id_barang'];
}
mysql_select_db($database_toko_cahya, $toko_cahya);
$query_edit = sprintf("SELECT * FROM list_barang WHERE id_barang = %s", GetSQLValueString($colname_edit, "int"));
$edit = mysql_query($query_edit, $toko_cahya) or die(mysql_error());
$row_edit = mysql_fetch_assoc($edit);
$totalRows_edit = mysql_num_rows($edit);

mysql_select_db($database_toko_cahya, $toko_cahya);
$query_kategori = "SELECT * FROM kategori_barang";
$kategori = mysql_query($query_kategori, $toko_cahya) or die(mysql_error());
$row_kategori = mysql_fetch_assoc($kategori);
$totalRows_kategori = mysql_num_rows($kategori);

?>

<form action="<?php echo $editFormAction; ?>" method="post"  name="form1" enctype="multipart/form-data">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Id_barang:</td>
      <td><?php echo $row_edit['id_barang']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Id_kategori:</td>
      <td><select name="id_kategori" id="id_kategori">
        <?php
do {  
?>
        <option value="<?php echo $row_kategori['id_kategori']?>"<?php if (!(strcmp($row_kategori['id_kategori'], $row_edit['id_kategori']))) {echo "selected=\"selected\"";} ?>><?php echo $row_kategori['nama_kategori']?></option>
        <?php
} while ($row_kategori = mysql_fetch_assoc($kategori));
  $rows = mysql_num_rows($kategori);
  if($rows > 0) {
      mysql_data_seek($kategori, 0);
	  $row_kategori = mysql_fetch_assoc($kategori);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nama_barang:</td>
      <td><input type="text" name="nama_barang" value="<?php echo htmlentities($row_edit['nama_barang'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Foto_barang:</td>
      <td><input type="file" name="fupload" id="fupload" />
    <?php echo htmlentities($row_edit['foto_barang'], ENT_COMPAT, ''); ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Deskripsi_barang:</td>
      <td><input type="text" name="deskripsi_barang" value="<?php echo htmlentities($row_edit['deskripsi_barang'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Stok:</td>
      <td><input type="text" name="stok" value="<?php echo htmlentities($row_edit['stok'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tanggal_input:</td>
      <td><input type="text" name="tanggal_input" value="<?php echo htmlentities($row_edit['tanggal_input'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Harga_barang:</td>
      <td><input type="text" name="harga_barang" value="<?php echo htmlentities($row_edit['harga_barang'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_barang" value="<?php echo $row_edit['id_barang']; ?>">
</form>
<p>&nbsp;</p>
<?php 
mysql_free_result($edit);

mysql_free_result($kategori);
?>
