<?php require_once('Connections/toko_cahya.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
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
$colname_edit_user_tampil_barang = "-1";
if (isset($_GET['id_barang'])) {
  $colname_edit_user_tampil_barang = $_GET['id_barang'];
}

mysql_select_db($database_toko_cahya, $toko_cahya);
$query_tampil_barang = sprintf("SELECT * FROM list_barang,kategori_barang WHERE id_barang = %s AND list_barang.id_kategori=kategori_barang.id_kategori", GetSQLValueString($colname_edit_user_tampil_barang, ""));
$tampil_barang = mysql_query($query_tampil_barang, $toko_cahya) or die(mysql_error());
$row_tampil_barang = mysql_fetch_assoc($tampil_barang);
$totalRows_tampil_barang = mysql_num_rows($tampil_barang);

$colname_edit_user = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_edit_user = $_SESSION['MM_Username'];
}
mysql_select_db($database_toko_cahya, $toko_cahya);
$query_user = sprintf("SELECT * FROM `user` WHERE userName = %s", GetSQLValueString($colname_edit_user, "text"));
$user = mysql_query($query_user, $toko_cahya) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);

$colname_total_belanja = "-1";
if (isset($_GET['MM_Username'])) {
  $colname_total_belanja = $_GET['MM_Username'];
}
mysql_select_db($database_toko_cahya, $toko_cahya);
$query_total_belanja = sprintf("SELECT * FROM user_order WHERE userName = %s", GetSQLValueString($colname_total_belanja, "text"));
$total_belanja = mysql_query($query_total_belanja, $toko_cahya) or die(mysql_error());
$row_total_belanja = mysql_fetch_assoc($total_belanja);
$totalRows_total_belanja = mysql_num_rows($total_belanja);


$barang = $row_tampil_barang['id_barang'];
$harga =$row_tampil_barang['harga_barang'];
$stoknya =$row_tampil_barang['stok'];
$user = $row_user['userName'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
	$jam = date('H:i:s');
	$tgl = date('Y-m-d');
	$jmlh_order = $_POST['jumlah_order'];
	$bayar = $_POST['jumlah_order'] * $harga;
	
if ($jmlh_order > $stoknya) {
		echo "<div class='peringatan'>Maaf stok barang yang tersedia hanya $stoknya unit, Anda tidak diperkenankan untuk order lebih dari stok</div>";
	}
else if($jmlh_order == "0") {
	echo "<div class='peringatan'>Harap masukkan jumlah order anda dengan benar</div>";
}
	else {
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	  $insertSQL = sprintf("INSERT INTO user_order (userName, id_barang, jumlah_order, tanggal_order, jam_order, status_order,total_bayar) VALUES (%s, %s, %s, %s, %s, %s,%s)",
                       GetSQLValueString($user, "text"),
                       GetSQLValueString($barang, "int"),
                       GetSQLValueString($jmlh_order, "int"),
                       GetSQLValueString($tgl, "date"),
                       GetSQLValueString($jam, "date"),
                       GetSQLValueString(0, "int"),
                       GetSQLValueString($bayar, "text"));

  mysql_select_db($database_toko_cahya, $toko_cahya);
  $Result1 = mysql_query($insertSQL, $toko_cahya) or die(mysql_error());
  
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE list_barang SET stok=%s WHERE id_barang=%s",
                       GetSQLValueString($row_tampil_barang['stok'] - $_POST['jumlah_order'], "int"),
                       GetSQLValueString($barang, "int"));

  mysql_select_db($database_toko_cahya, $toko_cahya);
  $Result1 = mysql_query($updateSQL, $toko_cahya) or die(mysql_error());
}

  $insertGoTo = "keranjang.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

}





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>


<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
<div class="detail">
<div class="gambar">
<img src="foto/<?php echo $row_tampil_barang['foto_barang']; ?>">
</div>
<div class="detail-keterangan">
<li><?php echo $row_user['nama_lengkap'] ?> </li>
	<li> <?php echo $row_tampil_barang['nama_barang']; ?></li>
    <li>Kategori : <a href="kategori.php?id_kategori=<?php echo $row_tampil_barang['id_kategori']; ?>"> <?php echo $row_tampil_barang['nama_kategori']; ?></a></li>
    <li>Stok : <?php
	$stok = $row_tampil_barang['stok'];
	if ($stok <1 ) {
		echo "<b>STOK HABIS</b>";
	}
	else {
		echo $stok." Unit";
	}
	; ?></li>
    <li>
   <?php echo $row_tampil_barang['deskripsi_barang']; ?>
    </li>
    <li class="harga"> Rp.<?php echo format_rupiah($row_tampil_barang['harga_barang']); ?>,- </li>
   <?php if ($stok <1 ) { ?>
	 
    <li class="beli">  <input class="submit" type="submit" value="Beli" disabled="disabled" /></li>
       <?php }
	   else {
	    ?>
       
    <li>Jumlah Order : <input class="input" type="number" name="jumlah_order" id="jumlah_order" value="" size="32" required="required" /> Unit</li>
    <li class="beli">
   <input class="submit" type="submit" value="Beli" /></li>
   <?php } ?>
   
</div>
</div>
  
    
   
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php

mysql_free_result($tampil_barang);

mysql_free_result($user);

mysql_free_result($total_belanja);

?>
