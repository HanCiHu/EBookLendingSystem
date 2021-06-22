<?php
/*
mode 1 : 예약이 가능한지 확인
mode 2 : 해당 도서 예약
*/
session_start();

$dbuser="D201902721";
$dbpass="hancihu0079";
$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');

$cno = $_SESSION['cno'];

if ($_POST['mode'] == 1){

	//한 고객은 최대 3권까지 예약 가능
	$query = "select CNO, count(CNO) C from reserve group by CNO";
	$stmt = oci_parse($conn, $query);
	oci_execute($stmt);
	while ($row = oci_fetch_assoc($stmt)){
		if($row['CNO'] == $cno){
			if ($row['C'] >= 3){
				echo "NO";
				exit;
			}
			else{
				echo "OK";
				exit;
			}
		}
	}
}

else if($_POST['mode'] == 2){
	$isbn = $_POST['ISBN'];
	$query = "insert into reserve values(${isbn},${cno},TO_DATE(SYSDATE,'YYYY/MM/DD'))";
	$stmt = oci_parse($conn, $query);
	oci_execute($stmt);
}

oci_free_statement($stmt);
oci_close($conn);

echo "OK";
?>