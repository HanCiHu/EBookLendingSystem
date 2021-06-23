<?php
session_start();

$_SESSION['search_title'] = trim($_POST['title']);
$_SESSION['search_publisher'] = trim($_POST['publisher']);
$_SESSION['search_minYear'] = $_POST['minYear'];
$_SESSION['search_maxYear'] = $_POST['maxYear'];
$_SESSION['search_author'] = trim($_POST['author']);

?>