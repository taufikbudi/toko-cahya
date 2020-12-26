<?php require_once('Connections/toko_cahya.php');
include('Connections/upload-transfer.php');
$lokasi_file = $_FILES['fupload']['tmp_name'];
$nama_file   = $_FILES['fupload']['name']; ?> 

<?php
if (!isset($_SESSION)) {
  session_start();
}
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

$colname_produk_terkait = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_produk_terkait = $_SESSION['MM_Username'];
}
mysql_select_db($database_toko_cahya, $toko_cahya);
$query_produk_terkait = sprintf("SELECT * FROM user_order, list_barang WHERE userName = %s AND user_order.id_barang=list_barang.id_barang AND status_order= 0", GetSQLValueString($colname_produk_terkait, "text"));
$produk_terkait = mysql_query($query_produk_terkait, $toko_cahya) or die(mysql_error());
$row_produk_terkait = mysql_fetch_assoc($produk_terkait);
$totalRows_produk_terkait = mysql_num_rows($produk_terkait);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$username = $_SESSION['MM_Username'];
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if (!empty($lokasi_file)){ 
  UploadTransfer($nama_file) ;
  $insertSQL = sprintf("INSERT INTO bayar (userName,id_order,judul, foto_transfer, keterangan, tanggal_bayar,status) VALUES (%s,%s,%s,%s, %s, %s, %s)",
                       GetSQLValueString($username, "text"),
                       GetSQLValueString($_POST['id_order'], "int"),
                       GetSQLValueString($_POST['judul'], "text"),
                       GetSQLValueString($nama_file, "text"),
                       GetSQLValueString($_POST['keterangan'], "text"),
                       GetSQLValueString($_POST['tanggal_bayar'], "date"),
                       GetSQLValueString(0, "int"));

  mysql_select_db($database_toko_cahya, $toko_cahya);
  $Result1 = mysql_query($insertSQL, $toko_cahya) or die(mysql_error());
  $insertGoTo = "bayar.php?bayar=list";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

}


?>


<div class="detail">
<?php echo $username ?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Perihal:</td>
      <td><input type="text" name="judul" value="" size="32" required="required"></td>
    </tr>
    
    
    <tr valign="baseline">
      <td nowrap align="right">Foto_transfer:</td>
      <td><input type="file" name="fupload" value="" size="32" required="required"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Keterangan:</td>
      <td><textarea name="keterangan" cols="50" rows="5" required="required"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Produk terkait</td>
      <td><label for="id_order"></label>
      <select name="id_order" id="id_order">
        <?php
do {  
?>
        <option value="<?php echo $row_produk_terkait['id_order']?>"<?php if (!(strcmp($row_produk_terkait['id_order'], $row_produk_terkait['id_order']))) {echo "selected=\"selected\"";} ?>><?php echo $row_produk_terkait['nama_barang']?></option>
        <?php
} while ($row_produk_terkait = mysql_fetch_assoc($produk_terkait));
  $rows = mysql_num_rows($produk_terkait);
  if($rows > 0) {
      mysql_data_seek($produk_terkait, 0);
	  $row_produk_terkait = mysql_fetch_assoc($produk_terkait);
  }
?>
      </select>
   </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input class="buton" type="submit" value="Kirim Bukti Pembayaran"></td>
    </tr>
  </table>
  <input type="hidden" name="tanggal_bayar" value="<?php echo date('Y-m-d'); ?>">
  <input type="hidden" name="MM_insert" value="form1">
</form>
</d>
<?php
mysql_free_result($produk_terkait);
?>
</div>