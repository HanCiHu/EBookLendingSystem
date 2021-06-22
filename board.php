<html>
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="board.js">
    <body>
    <div class="container">
			<div class="row" id="header">
				<p>
          <!-- 이름, 마이페이지, 로그아웃-->
					<span><?php session_start(); echo $_SESSION['name']."님 환영합니다."; ?></span>
          <span id="myPage-btn"><a class="btn btn-dark" href="./signIn.html">마이 페이지</a></span>
					<span id="sign-btn"><a class="btn btn-dark" href="./signIn.html">로그아웃</a></span>
         
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
                  <a class="dropdown-item">ISBN</a><br>
                  <a class="dropdown-item">책 제목</a><br>
                  <a class="dropdown-item">출판사</a><br>
                  <a class="dropdown-item">출판 연도</a>
                </div>
              </div>
              </th>
              <!-- 관리자인 경우 활성화--> 
              <th><button class="btn btn-default" onclick="addBook()" disabled>+</button></th>
						</tr>
					</thead>

				  <tbody id="EbookList">
            
			  	</tbody>
		  	</table>
			</div>
    </body>

  </head>
</html>