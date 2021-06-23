<?php
session_start();
if ($_SESSION['cno'] != 0 || $_SESSION['name'] != 'Admin'){
	echo "<script>alert('권한이 없습니다.');</script>";
	echo "<script>window.history.back();</script>";
}

function makestatistics(){
	$dbuser="D201902721";
	$dbpass="hancihu0079";
	$conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');
	$query = "";
	$columnName = array();
	if (!isset($_SESSION['statistics'])){
		return ;
	}
	if ($_SESSION['statistics'] == 1){
		$query = "SELECT E.ISBN, E.TITLE, C.NAME, C.EMAIL FROM EBOOK E, CUSTOMER C WHERE E.CNO IS NOT NULL AND E.CNO = C.CNO ORDER BY ISBN";
		echo "<thread><tr><th>ISBN</th><th>제목</th><th>이름</th><th>이메일</th></tr></thread>";
		array_push($columnName,"ISBN","TITLE","NAME","EMAIL");
	}
	else if ($_SESSION['statistics'] == 2){
		$query = "SELECT P.C, E.* FROM EBOOK E, (SELECT ISBN, COUNT(*) C FROM PREVIOUSRENTAL GROUP BY ISBN) P WHERE P.ISBN = E.ISBN ORDER BY 1 DESC";
		echo "<thread><tr><th>ISBN</th><th>제목</th><th>출판사</th><th>출판연도</th><th>대출횟수</th></tr></thread>";
		array_push($columnName,"ISBN","TITLE","PUBLISHER","YEAR","C");
	}
	else if ($_SESSION['statistics'] == 3){
		$query = "SELECT CNO, ISBN, TITLE, COUNT(*) OVER (PARTITION BY CNO) AS TOTAL_COUNT FROM EBOOK ORDER BY (CASE WHEN CNO IS NULL THEN 0 ELSE TOTAL_COUNT END) DESC";
		echo "<thread><tr><th>CNO</th><th>ISBN</th><th>도서제목</th><th>대여권수</th></tr></thread>";
		array_push($columnName,"CNO","ISBN","TITLE","TOTAL_COUNT");
	}
	echo "<tbody>";
	$stmt = oci_parse($conn, $query);
	$stmt = oci_parse($conn,$query);
	oci_execute($stmt);
	while ($row = oci_fetch_assoc($stmt)){
		echo "<tr>";
		for ($i = 0; $i < count($columnName); $i++){
			echo "<td>".$row[$columnName[$i]]."</td>";
		}
		echo "</tr>";
	}
	echo "</tbody>";
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
			<h3>통계 선택</h3>
        	<table class="table table-hover">
				<thead>
					<tr>
						<th><a href="" onclick="setStatisticsMode(1)">현재 대출중인 도서 정보</a></th>
						<th><a href="" onclick="setStatisticsMode(2)">도서별 대출 횟수 통계</a></th>
						<th><a href="" onclick="setStatisticsMode(3)">회원별 대출 도서 확인</a></th>
					</tr>
				</thead>
		  	</table>
		</div>

		<div class="row">
			<h2></h2>
        	<table class="table table-hover">
				<?php makestatistics(); ?>
		  	</table>
		</div>

    </body>

  </head>
</html>