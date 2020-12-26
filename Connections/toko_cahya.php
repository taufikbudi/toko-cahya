<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_toko_cahya = "localhost";
$database_toko_cahya = "taufik";
$username_toko_cahya = "root";
$password_toko_cahya = "";
$toko_cahya = mysql_pconnect($hostname_toko_cahya, $username_toko_cahya, $password_toko_cahya) or trigger_error(mysql_error(),E_USER_ERROR); 
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);

function format_rupiah($angka){
  $rupiah=number_format($angka,0,',','.');
  return $rupiah;
}

?>