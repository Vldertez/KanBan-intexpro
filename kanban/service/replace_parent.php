<?
include "../connect.php";
$result = mysqli_query($link, "SELECT * FROM `users`");
$users = array();
while($row = mysqli_fetch_assoc($result))
$users[] = $row;
for ($i=0; $i < count($users); $i++) { 
	$req='INSERT INTO `parents`(`name1`, `phone1`, `name2`, `phone2`, `login`, `password`, `email`, `child`) VALUES ("'.$users[$i]['parents'].'","'.$users[$i]['telParents'].'",null,null,null,null,null,"'.$users[$i]['id'].'")';
	 mysqli_query($link,$req) or die(mysqli_error($link));
}
?>