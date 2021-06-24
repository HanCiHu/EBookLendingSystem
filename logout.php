<?php
/*
1. 반납 기간이 지난 도서 중 해당 cno가 빌린 책 가저오기
2. 없으면 OK
3. 있으면 해당 도서의 데이터를 rentalData arr에 저장
4. 해당 도서 대출 가능하게 update
5. privious Rental 테이블에 rentalData arr에 저장된 데이터 추가
6. 도서 예약한 사람 있으면 메일 보내기
*/

session_start();
if ($_SESSION['cno'] == 0 && $_SESSION['name'] == 'Admin'){
	session_destroy();
	exit;
}

$cno = $_SESSION['cno'];

$dbuser="D201902721";
$dbpass="hancihu0079";
$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');

$query = "select isbn, cno, daterented, datedue from ebook where cno=${cno} and TO_CHAR(datedue,'YYMMDD') <= TO_CHAR(SYSDATE, 'YYMMDD')";
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

$rentalData = array();

//insert delete data to retalData array
while ($row = oci_fetch_assoc($stmt)){
	$data = array(
		'ISBN'=>$row['ISBN'],
		'DATERENTED' => $row['DATERENTED'],
		'DATEDUE' => $row['DATEDUE']
	);
	$rentalDate = array_push($rentalData,$data);
}

//Ebook data update
for ($i = 0; $i < count($rentalData); $i++){
	$query = "update ebook set cno='', daterented='', datedue='', exttimes='' where isbn=".$rentalData[$i]['ISBN'];
	$stmt = oci_parse($conn, $query);
	oci_execute($stmt);

	$query = "select isbn, email, datetime from reserve, customer where reserve.cno=customer.cno and isbn=".$rentalData[$i]['ISBN']." order by datetime";
	$stmt = oci_parse($conn, $query);
	oci_execute($stmt);

	$row = oci_fetch_assoc($stmt);
	$email = $row['EMAIL'];
	if ($email != ''){
		echo $email;
	}
}

//insert data to previousRental table
for ($i = 0; $i < count($rentalData); $i++){
	$query = "insert into previousrental values(".$rentalData[$i]['ISBN'].",'".$rentalData[$i]['DATERENTED']."','".$rentalData[$i]['DATEDUE']."',".$_SESSION['cno'].")";
	$stmt = oci_parse($conn, $query);
	oci_execute($stmt);	
}

session_destroy();
?>