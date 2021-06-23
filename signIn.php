<?php

$email = $_POST['email'];
$pw = $_POST['pw'];

$dbuser="D201902721";
$dbpass="hancihu0079";
$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');

$query = 'select * from customer';
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

while($row = oci_fetch_assoc($stmt))
{
	if ($row['EMAIL'] == $email && $row['PASSWD'] == $pw){
		session_start();
		$_SESSION['cno'] = $row['CNO'];
		$_SESSION['name'] = $row['NAME'];
		$_SESSION['order'] = 'ISBN'; //EbookList 정렬 default 값
		echo "ACCESS";
		exit;
	}
}
echo "DENY";

// 오라클 접속 닫기 
oci_free_statement($stmt);

// 오라클에서 로그아웃 
oci_close($conn); 
?>