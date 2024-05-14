<?
include('connect.php');
$office = $_POST['office'];
// echo(json_encode($office));
	$req="SELECT * FROM `cabinet` WHERE `office` = $office ORDER BY `name`";
	echo $req;
	$result = mysqli_query($link, $req);
	$cabinet = array();
	while($row = mysqli_fetch_assoc($result))
	$cabinet[] = $row;
	echo(json_encode($cabinet, true));
    ?>