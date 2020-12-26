<?php
switch(isset($_GET['user'])? $_GET['user'] : null){
 		default:
		include 'tampilan/kepala.php';
		include 'tampilan/menu.php';
		include 'tampilan/halaman/user-info.php';
		include 'tampilan/kaki.php';
		break;
		case"edit":
		include 'tampilan/kepala.php';
		include 'tampilan/menu.php';
		include 'tampilan/halaman/user-edit.php';
		include 'tampilan/kaki.php';
		break;
		
}
?>