<?php
session_start();
$cno = $_SESSION['cno'];
$isbn = $_POST['isbn'];

$dbuser="D201902721";
$dbpass="hancihu0079";
$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');

$query = "delete from reserve where cno=${cno} and isbn=${isbn}";
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

oci_free_statement($stmt);
oci_close($conn);

echo "OK";
?>