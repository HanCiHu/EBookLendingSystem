//데이터 베이스에 Ebook 추가(관리자인 경우만 가능)
function addEbook(){
	window.open('addEbook.html', '_blank', 'width=400px,height=500px, toolbars=no');
}

//도서 검색 팝업창
function searchEbook(){
	window.open('searchEbook.html', '_blank', 'width=500px,height=300px, toolbars=no');
}

//도서 대출
function lendingEbook(isbn){
	$.ajax({
		url:'lendingEbook.php',
		type: 'post',
		data:{
			mode : 1
		}
	}).done(function(data){
		if (data == "OK"){
			var flag = confirm("현재 대출이 가능합니다.\n대출하시겠습니까?");
			if (flag){
				$.ajax({
					url:'lendingEbook.php',
					type: 'post',
					data : {
						mode : 2,
						isbn : isbn
					}
				}).done(function(data){
					if (data == "OK"){
						alert("대출이 완료되었습니다.");
						location.reload();
					}
					else{
						alert("Error");
					}
				});
			}
			else{
				alert("취소하셨습니다.");
			}
		}
		else if (data == "NO"){
			alert("최대 3권까지 대출이 가능합니다.");
		}
	});
}

//책 예약
function reservingEbook(ISBN){
	$.ajax({
		url:'reservingEbook.php',
		type: 'post',
		data : {
			mode : 1
		}
	}).done(function(data){
		if (data == "OK"){
			var flag = confirm("예약이 가능합니다.\n예약하시겠습니까?");
			if (flag){
				$.ajax({
					url : 'reservingEbook.php',
					type:'post',
					data:{
						mode : 2,
						ISBN : ISBN
					}
				}).done(function(data){
					if (data == "OK"){
						alert("예약이 완료되었습니다.");
					}
					else{
						alert("Error");
					}
				});
			}
			else{
				alert("취소하셨습니다.");
			}
		}
		else if(data == "NO"){
			alert("최대 3권까지 예약 가능합니다.");
		}
	});
}

//상세정보를 보려고 하는 도서의 isbn 세션에 저장
function setISBN(isbn){
	$.ajax({
		url : 'setEbookInfo.php',
		type: 'post',
		data :{
			isbn :isbn
		}
	}).done(function(){
		window.open('EbookInfo.php', '_blank', 'width=400px,height=500px, toolbars=no');
	});
}

function logout(){
	$.ajax({
		url:'logout.php',
		type:'post',
		
	}).done(function(data) {
		location.href = './signIn.html';
	});
}

//mode에 따라 Ebook리스트를 정렬
function EbookSort(order){
	$.ajax({
		url:'EbookSortMode.php',
		type:'post',
		data: {
			order : order
		}
	}).done(function(data) {
		location.reload();
	});
}

//반납 기간 연장
function renewEbook(){

}

//예약 취소
function deleteReserve(){

}

//통계
function setStatisticsMode(mode){
	$.ajax({
		url : 'setStatisticsMode.php',
		type : 'post',
		data:{
			mode : mode
		}
	}).done(function(data){
		location.reload();
	});
}