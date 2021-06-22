<?php
session_start();
$cno = $_SESSION['cno'];

$dbuser="D201902721";
$dbpass="hancihu0079";
$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');

if ($_POST['mode'] == 1){
	$query = "select CNO, count(CNO) C from EBOOK group by CNO";
	$stmt = oci_parse($conn, $query);
	oci_execute($stmt);
	
	while ($row = oci_fetch_assoc($stmt)){
		if ($row['CNO'] == $cno){
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

else if ($_POST['mode'] == 2){
	$isbn = $_POST['isbn'];
	$query = "update EBOOK set CNO=${cno}, EXTTIMES=0, DATERENTED=TO_DATE(SYSDATE,'YYYY/MM/DD'), DATEDUE=TO_DATE(SYSDATE,'YYYY/MM/DD')+7 WHERE ISBN = ${isbn}";
	$stmt = oci_parse($conn, $query);
	oci_execute($stmt);
}

oci_free_statement($stmt);
oci_close($conn);

echo "OK";
?>