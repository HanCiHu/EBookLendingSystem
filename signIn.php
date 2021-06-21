<?php
$email = strtoupper($_POST['email']);
$pw = strtoupper($_POST['pw']);

$dbuser="D201902721";
$dbpass="hancihu0079";
$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');

$query = 'select email,passwd from customer';
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

while($row = oci_fetch_assoc($stmt))
{
	if ($row['EMAIL'] == $email && $row['PASSWD'] == $pw){
		echo "ACCESS";
		exit;
	}
}
echo "DENY";
?>