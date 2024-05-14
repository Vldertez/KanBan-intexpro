
<?
function attendance($a){
	$idgroup=$a;
	include('connect.php');
	$result = mysqli_query($link, "SELECT * FROM `groupuser`");
	$groups = array();
	while($row = mysqli_fetch_assoc($result))
	$groups[$row['id']] = $row;
	$result = mysqli_query($link, "SELECT * FROM `attendance`");
	$attendance = array();
	while($row = mysqli_fetch_assoc($result))
	$attendance[$row['id']] = $row;
	$result = mysqli_query($link, "SELECT * FROM `pay-old`");
	$pay = array();
	while($row = mysqli_fetch_assoc($result))
	$pay[$row['id']] = $row;
	$result = mysqli_query($link, "SELECT * FROM `ktplan` WHERE idgroup='group=".$idgroup."' AND `idgroup` LIKE '%group%' ORDER BY `datelesson`");
	$ktplanm = array();
	while($row = mysqli_fetch_assoc($result))
	 $ktplanm[] = $row;
	$result = mysqli_query($link, "SELECT * FROM `users`");
	$users = array();
	while($row = mysqli_fetch_assoc($result))
	 $users[$row['id']] = $row;
	$result = mysqli_query($link, "SELECT * FROM `group_members`WHERE groupid=$idgroup");
	$group_members = array();
	while($row = mysqli_fetch_assoc($result))
	$group_members[] = $row;
	echo "<h2 id='".$idgroup."'>Посещаемость группы ".$groups[$idgroup]['name']." </h3>";
	echo "<div class='containertable'>";
	echo "<table class='fiotable'>";
	echo "<tr><th width='200px;' height='110px'>ФИО</th></tr>";
	foreach ($group_members as $us) {
        if ($users[$us['userid']]['fio']) {
		echo "<tr><td>".$users[$us['userid']]['fio']."</td></tr>";
        }
	};
	echo "</table>";
	echo "<div class='scroll mCustomScrollbar'>";
	echo "<table class='defaultwidth tablepos'><tr>";
	foreach ($ktplanm as $th) {
		$datereverse=explode("-", $th['datelesson']);
		$datereverse=$datereverse[2].'-'.$datereverse[1].'-'.$datereverse[0];
	echo "<th class='vertth'>
				<p  class='vert'>".$datereverse."</p>
		</th>";
	}
	echo "</tr>";
	foreach ($group_members as $us) {
		echo "<tr>";
		$countpayless=0;
		// $k=0; //счетчик оплаченных закрашенных дней
	foreach ($ktplanm as $td) {
		$posel='';
		//считываем статус посещения
		foreach ($attendance as $elatt) {
			if ($elatt['dateat']==$td['datelesson'] && $elatt['iduser']==$us['userid'] && $elatt['group_id']==$idgroup){
			$posel=$elatt['status'];
			break;
		}
		}
		//считали статус посещения
		if($td['datelesson']<$users[$us['userid']]['datepay']) {
			echo "<td id='".$us['userid']."s".$td['datelesson']."' class='tddate'>
					<div class='points'>
					<div class='item__points' data='status'>
						<input type='text' class='tdpos' value='".$posel."'>
						</div>
						<div>
				</td>";
		} else {
		if (floor($countpayless)>0){
			if ($posel=='-' && $type_pay=='R') {
				echo "<td id='".$us['userid']."s".$td['datelesson']."' class='tddate'>
				<div class='points'>
					<div class='item__points' data='status'><input type='text' class='tdpos' value='".$posel."'></div>
				<div>
				</td>";
			} else {
				echo "<td id='".$us['userid']."s".$td['datelesson']."' class='tddate'>
				<div class='points'>
					<div class='item__points' data='status'><input type='text' class='tdpos paid' value='".$posel."'></div>
				<div>
				</td>";
			$countpayless--;
			}
		} else{
			$flag_paid=0;
			foreach ($pay as $elpay) {//ищем взятую дату в списке оплат
				if ($td['datelesson']==$elpay['datebegin'] && $elpay['iduser']==$us['userid'] && $elpay['namegroup']==$us['groupid']){//если за эту дату оплачивали
					$type_pay=$elpay['type'];
					if ($posel=='-' && $type_pay=='R') {
						echo "<td id='".$us['userid']."s".$td['datelesson']."' class='tddate'>
						<div class='points'>
							<div class='item__points' data='status'><input type='text' class='tdpos' value='".$posel."'></div>
						<div>
				</td>";
						$countpayless+=$elpay['countless'];
					} else {
						$countpayless+=$elpay['countless']-1;//сколько занятий оплатили
						echo "<td id='".$us['userid']."s".$td['datelesson']."' class='tddate'>
						<div class='points'>
							<div class='item__points' data='status'><input type='text' class='tdpos paid' value='".$posel."'></div>
						<div>
				</td>";
					} 
					$flag_paid=1;
				} 
			}
			if($flag_paid==0 ){ 									
				if (date('Y-m-d')>=$td['datelesson'] && $posel!='-'){
					echo "<td id='".$us['userid']."s".$td['datelesson']."' class='tddate'>
					<div class='points'>
					<div class='item__points' data='status'><input type='text' class='tdpos debt' value='".$posel."'></div>
						<div>
				</td>";
				} else {
				echo "<td id='".$us['userid']."s".$td['datelesson']."' class='tddate'>
				<div class='points'>
					<div class='item__points' data='status'><input type='text' class='tdpos' value='".$posel."'></div>
				<div>
				</td>";
				}
			}
		}	
	}
		$posel='';
		$type_pay=='';					
	}
	echo "</tr>";
	}
echo "</table> </div></div>";
}
if ($_GET['idgr']){
	attendance($_GET['idgr']);
}
?>