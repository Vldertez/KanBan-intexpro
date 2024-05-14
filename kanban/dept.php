<?
include('connect.php');
include('attendance_pay.php');
echo '<div class="main">
		<div class="content">';
        $year=nowYear();
        $result = mysqli_query($link, "SELECT * FROM `groupuser` WHERE `year`=". $year);
	$groups = array();
	while($row = mysqli_fetch_assoc($result))
	$groups[] = $row;
    for ($k=0; $k < count($groups); $k++) {
        attendance($groups[$k]['id']);
     }

?>