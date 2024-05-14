<?
include('connect.php');

$result = mysqli_query($link, "SELECT * FROM `attendance`");
$attendance = array();
while($row = mysqli_fetch_assoc($result))
$attendance[$row['id']] = $row;



foreach ($attendance as $elatt) {
	
	$result = mysqli_query($link, "SELECT * FROM `group_members` WHERE `userid`=".$elatt['iduser']);
	$group_members = array();
	while($row = mysqli_fetch_assoc($result))
	$group_members[] = $row;
var_dump($group_members);
if (count($group_members)<2){
	$request="UPDATE `attendance` SET `group_id`='".$group_members[0]['groupid']."' WHERE `id`=".$elatt['id'];
	mysqli_query($link,$request) or die(mysqli_error($link));
}
}

?>