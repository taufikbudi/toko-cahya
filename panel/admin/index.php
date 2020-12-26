<?php require_once('../../Connections/toko_cahya.php');
include'../head.php';
include'../menu.php'; ?>
<a href="tambah.php" id="tambah"> Tambah Data </a>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_halamn_utama = 10;
$pageNum_halamn_utama = 0;
if (isset($_GET['pageNum_halamn_utama'])) {
  $pageNum_halamn_utama = $_GET['pageNum_halamn_utama'];
}
$startRow_halamn_utama = $pageNum_halamn_utama * $maxRows_halamn_utama;

mysql_select_db($database_toko_cahya, $toko_cahya);
$query_halamn_utama = "SELECT * FROM `admin`";
$query_limit_halamn_utama = sprintf("%s LIMIT %d, %d", $query_halamn_utama, $startRow_halamn_utama, $maxRows_halamn_utama);
$halamn_utama = mysql_query($query_limit_halamn_utama, $toko_cahya) or die(mysql_error());
$row_halamn_utama = mysql_fetch_assoc($halamn_utama);

if (isset($_GET['totalRows_halamn_utama'])) {
  $totalRows_halamn_utama = $_GET['totalRows_halamn_utama'];
} else {
  $all_halamn_utama = mysql_query($query_halamn_utama);
  $totalRows_halamn_utama = mysql_num_rows($all_halamn_utama);
}
$totalPages_halamn_utama = ceil($totalRows_halamn_utama/$maxRows_halamn_utama)-1;

$queryString_halamn_utama = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_halamn_utama") == false && 
        stristr($param, "totalRows_halamn_utama") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_halamn_utama = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_halamn_utama = sprintf("&totalRows_halamn_utama=%d%s", $totalRows_halamn_utama, $queryString_halamn_utama);

?>

<table border="1" align="center">
  <tr>
    <td>id_admin</td>
    <td>username</td>
    <td>password</td>
    <td>Pilihan</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="detail.php?recordID=<?php echo $row_halamn_utama['id_admin']; ?>"> <?php echo $row_halamn_utama['id_admin']; ?>&nbsp; </a></td>
      <td><?php echo $row_halamn_utama['username']; ?>&nbsp; </td>
      <td><?php echo $row_halamn_utama['password']; ?>&nbsp; </td>
      <td><a href="edit.php?id_admin=<?php echo $row_halamn_utama['id_admin']; ?>">Edit </a>| <a href="hapus.php?id_admin=<?php echo $row_halamn_utama['id_admin']; ?>">Hapus</a></td>
    </tr>
    <?php } while ($row_halamn_utama = mysql_fetch_assoc($halamn_utama)); ?>
</table>
<br>
<table border="0">
  <tr>
    <td><?php if ($pageNum_halamn_utama > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_halamn_utama=%d%s", $currentPage, 0, $queryString_halamn_utama); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_halamn_utama > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_halamn_utama=%d%s", $currentPage, max(0, $pageNum_halamn_utama - 1), $queryString_halamn_utama); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_halamn_utama < $totalPages_halamn_utama) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_halamn_utama=%d%s", $currentPage, min($totalPages_halamn_utama, $pageNum_halamn_utama + 1), $queryString_halamn_utama); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_halamn_utama < $totalPages_halamn_utama) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_halamn_utama=%d%s", $currentPage, $totalPages_halamn_utama, $queryString_halamn_utama); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_halamn_utama + 1) ?> to <?php echo min($startRow_halamn_utama + $maxRows_halamn_utama, $totalRows_halamn_utama) ?> of <?php echo $totalRows_halamn_utama ;

mysql_free_result($halamn_utama);?> 