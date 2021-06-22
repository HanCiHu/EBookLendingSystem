<?php
$email = $_POST['email'];

$dbuser="D201902721";
$dbpass="hancihu0079";
$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');

$query = 'select cno, email from CUSTOMER';
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

$cno = 0;
while($row = oci_fetch_assoc($stmt))
{
	$cno = $row['CNO'] + 1;
	if ($row['EMAIL'] == $email){
		echo "DENY";
		exit;
	}
}

$name = $_POST['name'];
$pw = $_POST['pw'];

$query = "insert into customer values(${cno}, '${name}', '${pw}','${email}')";
$stmt = oci_parse($conn, $query);

oci_execute($stmt);

// 오라클 접속 닫기
oci_free_statement($stmt);

// 오라클에서 로그아웃 
oci_close($conn); 
?>