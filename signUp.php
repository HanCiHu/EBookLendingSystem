<?php
$email = $_POST['email'];

$dbuser="D201902721";
$dbpass="hancihu0079";
$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');

$query = 'select email from CUSTOMER';
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

while($row = oci_fetch_assoc($stmt))
{
	if ($row['EMAIL'] == $email){
		echo "DENY";
		exit;
	}
}

$query = 'select name from CUSTOMER';
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

while($row = oci_fetch_assoc($stmt))
{
	echo $row['NAME'];
}
?>