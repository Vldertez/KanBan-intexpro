<?
include('connect.php');
// if($_POST['page']=='users'){ //Удаление пользователя
// 	$usid=$_POST['elid'];
// 	$request="DELETE FROM `users` WHERE id=$usid";
// 	mysqli_query($link,$request) or die(mysqli_error($link));
// 	echo "ok";
// }
// if($_POST['page']=='group'){ //Удаление группы
// 	$iddelgroup=$_POST['elid'];
// 	$request="DELETE FROM `groupuser` WHERE id=$iddelgroup";
// 	mysqli_query($link,$request) or die(mysqli_error($link));
// 	echo "ok";
// }
// if($_POST['page']=='ktplan'){ //Удаление группы
// 	$iddelktp=$_POST['elid'];
// 	$request="DELETE FROM `ktplan` WHERE id=$iddelktp";
// 	mysqli_query($link,$request) or die(mysqli_error($link));
// 	echo "ok";
// }
// if($_POST['page']=='pay'){ //Удаление оплаты
// 	$iddelpay=$_POST['elid'];
// 	$request="DELETE FROM `pay` WHERE id=$iddelpay";
// 	mysqli_query($link,$request) or die(mysqli_error($link));
// 		echo "ok";
// }
// if($_POST['page']=='individual'){ //Удаление индивидуальника
// 	$iddelind=$_POST['elid'];
// 	$request="DELETE FROM `individual` WHERE id=$iddelind";
// 	mysqli_query($link,$request) or die(mysqli_error($link));
// 		echo "ok";
// }
if (isset($_POST['delusgr'])){
	$delusgr=$_POST['delusgr'];
	$groupid=$_POST['groupid'];
	$request="DELETE FROM `group_members` WHERE userid=$delusgr AND `groupid`=$groupid";
	mysqli_query($link,$request) or die(mysqli_error($link));
		echo "ok";
}
if (isset($_POST['event']) && $_POST['event']=='del'){
	$id=$_POST['elid'];
	$page=$_POST['page'];
	$request="DELETE FROM `".$page."` WHERE id=$id";
	mysqli_query($link,$request) or die(mysqli_error($link));
		echo "ok";
}
if (isset($_POST['event']) && $_POST['event']=='delall'){
	$id=$_POST['elid'];
	$page=$_POST['page'];
	$request="DELETE FROM `".$page."` WHERE `idgroup`='group=".$id."'";
	mysqli_query($link,$request) or die(mysqli_error($link));
		echo "ok";
}

?>