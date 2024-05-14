<!DOCTYPE html>
<html>
<head>
	<title>CRM</title>
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="../assets/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script  charset="utf-8" type="text/javascript" src="../assets/js.js"></script>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link rel="stylesheet" href="../assets/form.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<body>
	
	<div class="header">
		<img src="../assets/img/logo.svg" class="logo">
		<div class="blockMenu">
			<ul class="mainMenu">
				<li><a href="index.php">ГЛАВНАЯ</a></li>
				<li><a href="index.php?p=users">УЧЕНИКИ <i class="fa fa-angle-down fa-lg"></i></a>
					<ul class="submenu">
						<li><a href="../index.php?p=individual">ИНДИВИДУАЛЬНЫЕ</a></li>
						<li><a href="../index.php?p=group">ГРУППЫ</a></li>
					</ul>
				</li>
				<li><a href="">ЗАНЯТИЯ <i class="fa fa-angle-down fa-lg"></i> </a>
					<ul class="submenu">
						<li><a href="../index.php?p=ktplan">КТП</a></li>
						<li><a href="../index.php?p=attendance">ПОСЕЩАЕМОСТЬ</a></li>
					</ul>
				</li>
				<? if($admins[@$_COOKIE['id']]['role']=='admin') {
					echo  '<li><a href="../index.php?p=pay">ОПЛАТА <i class="fa fa-angle-down fa-lg"></i></a>
				<ul class="submenu">
						<li><a href="../index.php?p=summary">СВОДНАЯ</a></li>
					</ul>
				</li>
				<li><a href="">УПРАВЛЕНИЕ <i class="fa fa-angle-down fa-lg"></i> </a>
					<ul class="submenu">
						<li><a href="index.php?p=teachers">ПРЕПОДАВАТЕЛИ</a></li>
						<li><a href="../index.php?p=admins">ПОЛЬЗОВАТЕЛИ CRM</a></li>
						<li><a href="../index.php?p=course">КУРСЫ</a></li>
					</ul>
				</li>';
			}
			if(@$_COOKIE['id']){
				echo '<li><a href="../login.php?logout">ВЫХОД <i class="fa fa-angle-down fa-lg"></i> </a></li>';
			}
			?>
			</ul>
		</div>
	</div>
	<?
	// if(!$_GET['p']){
	// 	include '../calendar.php';
	// 	echo '<script  charset="utf-8" type="text/javascript" src="../assets/calendar.js"></script>';
	// 	echo '<script  charset="utf-8" type="text/javascript" src="../assets/eventless.js"></script>';
	// } else {
	echo '<div class="main">
		<div class="content">';
		// }

		?>