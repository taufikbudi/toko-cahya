<?php require_once('Connections/toko_cahya.php');
if (!isset($_SESSION)) {
  session_start();
}
 ?>
 
<div class="detail">
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

$colname_tampil_user = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_tampil_user = $_SESSION['MM_Username'];
}
mysql_select_db($database_toko_cahya, $toko_cahya);
$query_tampil_user = sprintf("SELECT * FROM `user` WHERE userName = %s", GetSQLValueString($colname_tampil_user, "text"));
$tampil_user = mysql_query($query_tampil_user, $toko_cahya) or die(mysql_error());
$row_tampil_user = mysql_fetch_assoc($tampil_user);
$totalRows_tampil_user = mysql_num_rows($tampil_user);

mysql_select_db($database_toko_cahya, $toko_cahya);
$query_Recordset1 =  sprintf("SELECT sum( total_bayar) FROM user_order WHERE user_order.userName = %s AND status_order=1" , GetSQLValueString($colname_tampil_user, "text"));
$Recordset1 = mysql_query($query_Recordset1, $toko_cahya) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_keranjang = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_keranjang = $_SESSION['MM_Username'];
}
mysql_select_db($database_toko_cahya, $toko_cahya);
$query_keranjang = sprintf("SELECT * FROM user,user_order,list_barang WHERE user.userName=user_order.userName AND user_order.id_barang=list_barang.id_barang AND user.userName = %s AND status_order=1", GetSQLValueString($colname_keranjang, "text"));
$keranjang = mysql_query($query_keranjang, $toko_cahya) or die(mysql_error());
$row_keranjang = mysql_fetch_assoc($keranjang);
$totalRows_keranjang = mysql_num_rows($keranjang); ?>


<div class="detail-order">
<li class="harga"> Daftar Barang <?php echo $row_tampil_user['nama_lengkap']; ?> </li>
<?php 
class Status { 
  public $st = 'Status Order';
  function statusnya($stat)
    {		
      if ($stat == '0') {
      $this->st = 'Menunggu';
     } 
	 else if($stat =='1') {
		 $this->st = 'Diterima';
	 }
	 else {
      $this->st = 'Ditolak';
    }
  }
}
	 ?>
     
<?php
if ($totalRows_keranjang > 0 ) {
 do { ?> 
<li><a href="detail.php?id_barang=<?php echo $row_keranjang['id_barang']; ?>"><?php echo $row_keranjang['nama_barang']; ?></a> <strong>(ID Order = <?php echo $row_keranjang['id_order']; ?>)</strong>
<table>
<tr>
<td><img src="foto/<?php echo $row_keranjang['foto_barang']; ?>" width="50"> <br />

</td>
<td>
Jumlah Order : <?php echo $row_keranjang['jumlah_order']; ?> Unit,
</td>
<td>
<span style="float:right"> Status : 
<?php 
$row_st = $row_keranjang['status_order'];
$sta = new Status;
$sta->statusnya($row_st);
echo $sta->st;
?>,
</span>
</td>

<td> Harga Per Unit : Rp.<?php echo format_rupiah($row_keranjang['harga_barang']); ?>,</td>
<td>
</td>
</tr>
</table>
</li>

<?php 
} 
while ($row_keranjang = mysql_fetch_assoc($keranjang)); ?>
<li> Total belanja : <b>Rp.<?php
$bayar = $row_Recordset1['sum( total_bayar)'];
 echo format_rupiah($bayar); ?>,-</b></li>
<?php } 
else {
	echo "<li>Keranjang Masih kosong</li>
	<li class='beli'><a href='index.php'>Ayo Belanja</a></li>";
}
?>
</div>


<?php mysql_free_result($keranjang);
?>
</div>
<?php
mysql_free_result($tampil_user);

mysql_free_result($Recordset1);
?>
