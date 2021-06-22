//데이터 베이스에 Ebook 추가(관리자인 경우만 가능)
function addEbook(){
	
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
function EbookSort(mode){
	$.ajax({
		url:'EbookSortMode.php',
		type:'post',
		data: {
			mode : mode
		}
	}).done(function(data) {
		location.reload();
	});
}