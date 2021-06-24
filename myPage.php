<?php
session_start();

if ((!isset($_SESSION['cno']))){
	echo "<script>alert('잘못된 접근입니다.');</script>";
	echo "<script>location.href = './signIn.html';</script>";
}

function lendingBookList(){
	$cno = $_SESSION['cno'];
	$dbuser="D201902721";
	$dbpass="hancihu0079";
	$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');

	$query = "select * from ebook where cno=${cno} order by isbn";
	$stmt = oci_parse($conn, $query);
	oci_execute($stmt);

	while ($row = oci_fetch_assoc($stmt)){
		echo "<tr>";
		echo "<th>".$row['ISBN']."</th>";
		echo "<th>".$row['TITLE']."</th>";
		echo "<th>".$row['PUBLISHER']."</th>";
		echo "<th>".$row['YEAR']."</th>";
		echo "<th>".$row['DATERENTED']."</th>";
		echo "<th>".$row['DATEDUE']."</th>";
		echo "<th>".$row['EXTTIMES']."</th>";
		if ($row['EXTTIMES'] == 0){
			echo "<th><button class='btn btn-dark' onclick='renewEbook(".$row['ISBN'].")'>연장</button></th>";
		}
		else if ($row['EXTTIMES'] == 1){
			echo "<th><button class='btn btn-dark' disabled>연장</button></th>";
		}
		echo "</tr>";
	}
	oci_free_statement($stmt);
	oci_close($conn);
}

function reservingBookList(){
	$cno = $_SESSION['cno'];
	$dbuser="D201902721";
	$dbpass="hancihu0079";
	$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');

	$query = "select e.isbn, e.title, e.publisher, e.year, r.cno, r.datetime
	from (select isbn, cno, datetime from reserve where cno=${cno}) r
	left join ebook e on (e.isbn = r.isbn) order by e.isbn";
	$stmt = oci_parse($conn, $query);
	oci_execute($stmt);

	while ($row = oci_fetch_assoc($stmt)){
		echo "<tr>";
		echo "<th>".$row['ISBN']."</th>";
		echo "<th>".$row['TITLE']."</th>";
		echo "<th>".$row['PUBLISHER']."</th>";
		echo "<th>".$row['YEAR']."</th>";
		echo "<th>".$row['DATETIME']."</th>";
		echo "<th><button class='btn btn-dark' onclick='deleteReserve(".$row['ISBN'].")'>취소</button></th>";
		echo "</tr>";
	}
	oci_free_statement($stmt);
	oci_close($conn);
}
?>

<html>
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="board.js"></script>
    <body>
    <div class="container">
		<div class="row" id="header">
			<p>
          <!-- 이름, 마이페이지, 로그아웃-->
				<span><?php echo $_SESSION['name']."님 환영합니다."; ?></span>
          		<span><a id="myPage-btn" class="btn btn-dark" href="./board.php">도서목록</a></span>
         
				<span id="sign-btn"><a class="btn btn-dark" onclick="logout()">로그아웃</a></span>
			</p>
		</div>

		<div class="row">
			<h2>대출한 책 목록</h2>
        	<table class="table table-hover">
				<thead>
					<tr>
						<th>No.</th>
						<th>제목</th>
						<th>출판사</th>
						<th>출판연도</th>
        	 			<th>대출 날짜</th>
						<th>반납 일자</th>
						<th>반납 연장 횟수</th>
						<th>반납 연장</th>
					</tr>
				</thead>

				<tbody>
					<?php lendingBookList(); ?>
				</tbody>
		  	</table>
		</div>

		<div class="row">
			<h2>예약한 책 목록</h2>
        	<table class="table table-hover">
				<thead>
					<tr>
						<th>No.</th>
						<th>제목</th>
						<th>출판사</th>
						<th>출판연도</th>
        	 			<th>예약 날짜</th>
						<th>예약 취소</th>
					</tr>
				</thead>

				<tbody>
					<?php reservingBookList(); ?>
				</tbody>
		  	</table>
		</div>
    </body>

  </head>
</html>