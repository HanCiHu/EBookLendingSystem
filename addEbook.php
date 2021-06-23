<?php
 session_start();

if ($_SESSION['cno'] != 0 && $_SESSION['name'] != 'Admin'){
	echo "<script>alert('잘못된 접근입니다.'); window.close();</script>";
}

$dbuser="D201902721";
$dbpass="hancihu0079";
$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');

$title = $_POST['title'];
$publisher = $_POST['publisher'];
$year = $_POST['year'];
$authors = $_POST['authors'];

$query = "select isbn from ebook order by isbn desc";
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

$isbn = oci_fetch_assoc($stmt)['ISBN'] + 1;

$query = "insert into Ebook (isbn, title, publisher, year) values (${isbn}, '${title}', '${publisher}', ${year})";
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

for ($i = 0; $i < count($authors); $i++){
	$query = "insert into authors values(${isbn},'".$authors[$i]."')";
	$stmt = oci_parse($conn, $query);
	oci_execute($stmt);
}

oci_free_statement($stmt);
oci_close($conn);
echo "OK";
?>