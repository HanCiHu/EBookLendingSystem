<?php
session_start();

if (!isset($_SESSION['isbn'])){
	echo "<script>alert('잘못된 접근입니다.');</script>";
	exit;
}

$isbn = $_SESSION['isbn'];

$dbuser="D201902721";
$dbpass="hancihu0079";
$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');
$query = "select isbn, title, publisher, year from Ebook where isbn=${isbn}";

$stmt = oci_parse($conn,$query);
oci_execute($stmt);

$row = oci_fetch_assoc($stmt);
?>

<html>
	<head>
		<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
		<link rel="stylesheet" href="./sign.css" type="text/css">
		<meta charset="utf-8"/>
	</head>
	<body>
		ISBN : <?php echo $isbn; ?><br><br>
		제목 : <?php echo $row['TITLE']; ?><br><br>
		출판사 : <?php echo $row['PUBLISHER']; ?><br><br>
		출판연도 : <?php echo $row['YEAR']; ?><br><br>

		<?php
		$query = "select ISBN, AUTHOR from authors where isbn=".$isbn;

		$stmt = oci_parse($conn,$query);
		oci_execute($stmt);

		while ($row = oci_fetch_assoc($stmt)) {
			echo "저자 : ".$row['AUTHOR']."<br><br>";
		}

		oci_free_statement($stmt);
		oci_close($conn); 
		?>
		<button onclick="window.close();">닫기</button>
	</body>
</html>