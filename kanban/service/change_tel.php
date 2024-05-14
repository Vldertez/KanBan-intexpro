<?
include "../connect.php";
$result = mysqli_query($link, "SELECT * FROM `individual`");
$users = array();
while($row = mysqli_fetch_assoc($result))
$users[] = $row;
for ($i=0; $i < count($users); $i++) { 
	echo strpos($users[$i]['phone'], '+')."<br>";
	if ($users[$i]['phone']) {
		echo $users[$i]['phone']."<br>";
		$users[$i]['phone'] = str_replace('-', '', $users[$i]['phone']);
		$users[$i]['phone'] = str_replace(" ", '', $users[$i]['phone']);
		$users[$i]['phone'] = str_replace('+7', '8', $users[$i]['phone']);
		$users[$i]['phone'] = str_replace('(', '', $users[$i]['phone']);
		$users[$i]['phone'] = str_replace(')', '', $users[$i]['phone']);
		echo $users[$i]['phone']."<br>";
		$req = "UPDATE `individual` SET `phone`='".$users[$i]['phone']."' WHERE `id`=".$users[$i]['id'];
		mysqli_query($link,$req) or die(mysqli_error($link));
	}
	// if ($users[$i]['telStudent']) {
	// 	echo $users[$i]['telStudent']."<br>";
	// 	$users[$i]['telStudent'] = str_replace('-', '', $users[$i]['telStudent']);
	// 	$users[$i]['telStudent'] = str_replace(" ", '', $users[$i]['telStudent']);
	// 	$users[$i]['telStudent'] = str_replace('+7', '8', $users[$i]['telStudent']);
	// 	$users[$i]['telStudent'] = str_replace('(', '', $users[$i]['telStudent']);
	// 	$users[$i]['telStudent'] = str_replace(')', '', $users[$i]['telStudent']);
	// 	echo $users[$i]['telStudent']."<br>";
	// 	$req = "UPDATE `users` SET `telStudent`='".$users[$i]['telStudent']."' WHERE `id`=".$users[$i]['id'];
	// 	mysqli_query($link,$req) or die(mysqli_error($link));
	// }
}
?>