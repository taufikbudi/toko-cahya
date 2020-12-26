<?php
switch(isset($_GET['bayar'])? $_GET['bayar'] : null){
	default: 
 		include 'tampilan/kepala.php';
		include 'tampilan/menu.php';
		include 'tampilan/halaman/bayar.php';
		include 'tampilan/sidebar.php';
		include 'tampilan/kaki.php';
		break;
		case"list":
		include 'tampilan/kepala.php';
		include 'tampilan/menu.php';
		include 'tampilan/halaman/list-bayar.php';
		include 'tampilan/sidebar.php';
		include 'tampilan/kaki.php';
		break;
		
}
?>