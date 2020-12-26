<?php 	
switch(isset($_GET['login'])? $_GET['login'] : null){
	default: 
		include 'tampilan/kepala.php';
		include 'tampilan/menu.php'; 
		include 'tampilan/halaman/login.php';
		include 'tampilan/kaki.php';
	break;
	case"berhasil";
		include 'tampilan/kepala.php';
		include 'tampilan/menu.php';
		echo"Anda berhasil terdaftar, silahkan login untuk transaksi berikutnya";
		include 'tampilan/halaman/login.php';
		include 'tampilan/kaki.php';
		break;
		
}?>