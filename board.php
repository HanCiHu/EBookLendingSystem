<?php
session_start();

if ((!isset($_SESSION['cno'])) || ($_SESSION['cno'] == -1)){
  echo "<script>alert('잘못된 접근입니다.');</script>";
  echo "<script>location.href = './signIn.html';</script>";
}

function EbookList($mode){
  $dbuser="D201902721";
  $dbpass="hancihu0079";
  $conn = oci_connect($dbuser,$dbpass,'localhost/XE','AL32UTF8');
  $query = '';
  if ($mode == 1){
    $query = 'select isbn, title, publisher, year, cno from EBOOK order by ISBN';
  }
  else if ($mode == 2){
    $query = 'select isbn, title, publisher, year, cno from EBOOK order by TITLE';
  }
  else if ($mode == 3){
    $query = 'select isbn, title, publisher, year, cno from EBOOK order by PUBLISHER';
  }
  else if ($mode == 4){
    $query = 'select isbn, title, publisher, year, cno from EBOOK order by YEAR';
  }
  else if ($mode == 5){
    $query = 'select isbn, title, publisher, year, cno from EBOOK order by CNO desc, ISBN';
  }
  
  $stmt = oci_parse($conn,$query);
  oci_execute($stmt);

  while ($row = oci_fetch_assoc($stmt)){
    echo "<tr>";
    echo "<th>".$row['ISBN']."</th>";
    echo "<th>".$row['TITLE']."</th>";
    echo "<th>".$row['PUBLISHER']."</th>";
    echo "<th>".$row['YEAR']."</th>";
    echo "<th><a href='EbookInfo.php'>상세정보</a></th>";
    if ($row['CNO'] == Null){
      echo "<th><button class='btn btn-dark' onclick='lendingEbook(".$row['ISBN'].")'>대출</button></th>";
    }
    else{
      echo "<th><button class='btn btn-dark' disabled>대출</button></th>";
    }
    echo "<th><button class='btn btn-dark' onclick='reservingEbook(".$row['ISBN'].")'>예약</button></th>";
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
          <span id="myPage-btn"><a class="btn btn-dark" href="./signIn.html">마이 페이지</a></span>
					<span id="sign-btn"><a class="btn btn-dark" onclick="logout()">로그아웃</a></span>
         
				</p>
			</div>

			<div class="row">
        <table class="table table-hover">
				  <thead>
						<tr>
							<th>No.</th>
							<th>제목</th>
							<th>출판사</th>
							<th>출판연도</th>
              <th colspan='2'>
              <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">정렬 ▼</button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" onclick="EbookSort(1)">ISBN</a><br>
                  <a class="dropdown-item" onclick="EbookSort(2)">책 제목</a><br>
                  <a class="dropdown-item" onclick="EbookSort(3)">출판사</a><br>
                  <a class="dropdown-item" onclick="EbookSort(4)">출판 연도</a><br>
                  <a class="dropdown-item" onclick="EbookSort(5)">대출 가능</a>
                </div>
              </div>
              </th>
              <!-- 관리자인 경우 활성화--> 
              <th><button id="addButton" class="btn btn-default" onclick="addEbook()" disabled>+</button></th>
              <?php if ($_SESSION['cno'] == 0 && $_SESSION['name'] == 'Admin'){
                echo "<script>$('#addButton').prop('disabled', false);</script>";
              }
              ?>
						</tr>
					</thead>

				  <tbody id="EbookList">
            <?php EbookList($_SESSION['mode']); ?>
			  	</tbody>
		  	</table>
			</div>
    </body>

  </head>
</html>