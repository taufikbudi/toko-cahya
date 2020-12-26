<?php require_once('Connections/toko_cahya.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
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

$maxRows_halaman_menu = 3;
$pageNum_halaman_menu = 0;
if (isset($_GET['pageNum_halaman_menu'])) {
  $pageNum_halaman_menu = $_GET['pageNum_halaman_menu'];
}
$startRow_halaman_menu = $pageNum_halaman_menu * $maxRows_halaman_menu;

mysql_select_db($database_toko_cahya, $toko_cahya);
$query_halaman_menu = "SELECT * FROM halaman";
$query_limit_halaman_menu = sprintf("%s LIMIT %d, %d", $query_halaman_menu, $startRow_halaman_menu, $maxRows_halaman_menu);
$halaman_menu = mysql_query($query_limit_halaman_menu, $toko_cahya) or die(mysql_error());
$row_halaman_menu = mysql_fetch_assoc($halaman_menu);

if (isset($_GET['totalRows_halaman_menu'])) {
  $totalRows_halaman_menu = $_GET['totalRows_halaman_menu'];
} else {
  $all_halaman_menu = mysql_query($query_halaman_menu);
  $totalRows_halaman_menu = mysql_num_rows($all_halaman_menu);
}
$totalPages_halaman_menu = ceil($totalRows_halaman_menu/$maxRows_halaman_menu)-1;
?>
<body>
<div class="tengah">
<div class="kepala">
Toko Cahya Cyber
</div>
<div class="menu">
<div class="menu-kiri">
	  <li><a href="index.php"> Beranda </a></li>
	<?php do { ?>
     <li><a href="halaman.php?id_halaman=<?php echo $row_halaman_menu['id_halaman']; ?>"><?php echo $row_halaman_menu['judul_halaman']; ?></a></li>
	    <?php } while ($row_halaman_menu = mysql_fetch_assoc($halaman_menu)); ?>
    
    <?php 


if (isset($_SESSION['MM_Username'])? $_SESSION['MM_Username'] : null) {
	echo "<li> <a href='$logoutAction'>Keluar</a></li>
	<li><a href='user.php'> Panel User</a></li>
	<li><a href='keranjang.php'> Keranjang Belanja</a></li>
	";
	}
else {
 ?>
    </a>

    <li><a href="login.php">Login</a></li> 
    <li><a href="daftar.php">Daftar</a></li>    
    <?php } ?>
</div>
<div class="menu-kanan">
<form action="cari.php" method="post">
<input name="nama_barang" type="text" placeholder="Cari Produk" />
<input name="" type="submit" value="Cari" />
</form>
</div>

<div class="clear"></div>
</div>

<div class="konten">
<?php
mysql_free_result($halaman_menu);
?>
