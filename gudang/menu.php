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
	
  $logoutGoTo = "http://localhost/toko/gudang/login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>


<div class="tengah">
<div class="kepala">

</div>
<div class="menu">
<div class="menu-kiri">
	  <li><a href="../index.php"> Home </a></li>
      <li><a href="../barang">Produk</a></li>
      <li><a href="../kategori_barang">Kategori Produk</a></li>
      <li><a href="<?php echo $logoutAction ?>">Log out</a></li>
      </div>
      <div class="clear"></div>
</div>

<div class="konten">

      