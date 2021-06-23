<?php
session_start();
//정렬
$_SESSION['order'] = $_POST['order'];

//검색 세션변수 초기화
$_SESSION['search_title'] = '';
$_SESSION['search_publisher'] ='';
$_SESSION['search_minYear'] = '';
$_SESSION['search_maxYear'] = '';
$_SESSION['search_author'] = '';
?>