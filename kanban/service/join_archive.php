<?
$link = mysqli_connect("localhost", "root", "", "crm");
$result = mysqli_query($link, "SELECT * FROM `archive_attendance` WHERE `id`>4208");
$ktplan = array();
while($row = mysqli_fetch_assoc($result))
$ktplan[] = $row;
for ($i=0; $i < count($ktplan); $i++) { 
	$req="INSERT INTO `attendance`(`id`, `dateat`, `status`, `iduser`, `group_id`) VALUES ('".$ktplan[$i]['id']."','".$ktplan[$i]['dateat']."','".$ktplan[$i]['status']."','".$ktplan[$i]['iduser']."',".$ktplan[$i]['group_id'].")";
	 mysqli_query($link,$req) or die(mysqli_error($link));
}
?>