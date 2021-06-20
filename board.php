<?php
//session_start();

$dbuser="D201902721";
$dbpass="hancihu0079";

$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');

//$_SESSION["conn"] = $conn;

if(!$conn) {
  echo "No Connection ".oci_error();
  exit;
} else {
 echo "Connect Success!";
}

$query = 'select * from CUSTOMER';

$stmt = oci_parse($conn,$query);
oci_execute($stmt);


while($row = oci_fetch_assoc($stmt))
{
    print_r($row);
}


// 오라클 접속 닫기 
oci_free_statement($stmt);

// 오라클에서 로그아웃 
oci_close($conn); 
?>