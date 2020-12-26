<?php
if (!isset($_SESSION)) {
  session_start();
}
 	include 'tampilan/kepala.php';
		include 'tampilan/menu.php';
		include 'tampilan/halaman/beli.php';
		include 'tampilan/sidebar.php';
		include 'tampilan/kaki.php';
?>