<?php
$dbuser="D201902721";
$dbpass="hancihu0079";
$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');
$isbn = $_POST['isbn'];

//예약이 되어있는 도서인지 확인
if ($_POST['mode'] == 1){
	$query = "select count(isbn) c from reserve where isbn=${isbn} group by ${isbn}";
	$stmt = oci_parse($conn, $query);
	oci_execute($stmt);
	
	$row = oci_fetch_assoc($stmt);
	if (isset($row['C'])){
		echo "NO";
	}
	else{
		echo "OK";
	}
	oci_free_statement($stmt);
}

//반납 기간 연장
else if ($_POST['mode'] == 2){
	session_start();
	$cno = $_SESSION['cno'];
	$query = "update ebook set exttimes = 1, datedue = datedue + 7 where cno=${cno} and isbn=${isbn}";
	$stmt = oci_parse($conn, $query);
	oci_execute($stmt);
	oci_free_statement($stmt);
	echo "OK";
}
oci_close($conn);
?>