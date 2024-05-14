<?php
include "../connect.php";

$req = "SELECT * FROM `summer`";
$result = mysqli_query($link, $req);
	$summer = array();
	while($row = mysqli_fetch_assoc($result))
	$summer[] = $row;
    for ($i = 0; $i < count($summer); $i++) {
        $date_time = strtotime($summer[$i]['date_time']);
        $date_change = strtotime($summer[$i]['date_change']);
        $id = $summer[$i]['id'];
        $req = "UPDATE `summer` SET `date_time`=$date_time, `date_change`=$date_change WHERE `id` = $id";
        mysqli_query($link,$req) or die(mysqli_error($link));
    }
?>