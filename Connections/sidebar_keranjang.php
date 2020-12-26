<?php 
$colname_tampil_user = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_tampil_user = $_SESSION['MM_Username'];
}
mysql_select_db($database_toko_cahya, $toko_cahya);
$query_Recordset1 =  sprintf("SELECT sum( total_bayar) FROM user_order WHERE user_order.userName = %s AND status_order=0" , GetSQLValueString($colname_tampil_user, "text"));
$Recordset1 = mysql_query($query_Recordset1, $toko_cahya) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>