<?
include "../connect.php";
$result = mysqli_query($link, "SELECT * FROM `individual`");
$individual = array();
while($row = mysqli_fetch_assoc($result))
$individual[] = $row;
for ($i=0; $i < count($individual); $i++) {
	if ($individual[$i]['phone']) {
	if($individual[$i]['phone'][0] ==="8") {
		$tel = substr($individual[$i]['phone'], 1);
	} else {
		$tel = substr($individual[$i]['phone'], 0);
	}
	 $fio = (strpos($individual[$i]['fio'], ' ') !== false) ? "OR `fio` LIKE '%".$individual[$i]['fio']."%'" : '';
	 $result = mysqli_query($link, "SELECT * FROM `users` WHERE `telParents` LIKE '%$tel%' OR `telStudent` LIKE '%$tel%' $fio");
	$users = array();
	while($row = mysqli_fetch_assoc($result))
	$users[] = $row;
	
	$needadd = false;
	if (count($users) == 1) {
		 if ($users[0]['fio'] !== $individual[$i]['fio'] && strpos($individual[$i]['fio'], ' ') !== false && strpos($users[0]['fio'], ' ') !== false) { 
			$needadd = true;
		 } else {
			echo $individual[$i]['fio']."<br><b>НЕ добавлять в БД</b><br><br>"; 
			$id = $users[0]['id'];
		 }
	} else if (count($users) > 1) {
		echo "В таблице users дубль записи: ". $users[0]['fio']."<br><br>";
		if ($users[0]['fio'] !== $individual[$i]['fio']) {
			$needadd = true;; 
		 } else {
			echo $individual[$i]['fio']."<br><b>НЕ добавлять в БД</b><br><br>"; 
			$id = $users[0]['id'];
		 }
		
	} else {
		$needadd = true;
	}
} else if (strpos($individual[$i]['fio'], ' ') !== false) {
	$result = mysqli_query($link, "SELECT * FROM `users` WHERE `fio` LIKE '%".$individual[$i]['fio']."%'");
	$users = array();
	while($row = mysqli_fetch_assoc($result))
	$users[] = $row;
	if (count($users) == 1) {
		   echo $individual[$i]['fio']." - нет телефона <br><b>НЕ добавлять в БД</b><br><br>"; 
		   $id = $users[0]['id'];
   } else if (count($users) > 1) {
	   echo "В таблице users дубль записи: ". $users[0]['fio']."<br><br>";
		echo "<b> - нет телефона, НЕ добавлять в БД</b><br><br>";
		$id = $users[0]['id'];

   } else {
	$needadd = true; 
   }
} else {
	$needadd = true; 
}
if ($needadd) {
	$datebirth = ($individual[$i]['datebirth'] !='') ? "'".$individual[$i]['datebirth']."'" : 'NULL';
	$phone = ($individual[$i]['phone'] !='') ? "'".$individual[$i]['phone']."'" : 'NULL';
	$req = "INSERT INTO `users`(`fio`, `datepay`, `telStudent`, `dateBirth`, `parent`, `tg_id`) VALUES ('".$individual[$i]['fio']."',NULL,".$phone.",".$datebirth.",NULL,NULL)";
	mysqli_query($link,$req) or die(mysqli_error($link));
	$req = "SELECT max(`id`) as `id` FROM `users`";
	$result = mysqli_query($link,$req);
	$id = mysqli_fetch_assoc($result);
	$id = $id['id'];
}
$req = "SELECT * FROM `ktplan` WHERE `type`=2 AND `idgroup`=".$individual[$i]['id'];
$result = mysqli_query($link, $req);
$ktplan = array();
while($row = mysqli_fetch_assoc($result))
$ktplan[] = $row;
for ($j=0; $j < count($ktplan); $j++) {
	$req = "UPDATE `ktplan` SET `teacher`=".$individual[$i]['teacher'].", `course`=".$individual[$i]['course'].", `idgroup`=".$id." WHERE `id`=".$ktplan[$j]['id'];
	mysqli_query($link,$req) or die(mysqli_error($link));
}

	
}
?>