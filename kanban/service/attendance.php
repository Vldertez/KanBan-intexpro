
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
	echo "<h2 id='".$idgroup."'>Посещаемость группы ".$groups[$idgroup]['name']." </h2>";
	echo "<a href='index.php?p=ktplan&p2=addlesson&gid=$idgroup' class='addelement'><i class='icon fa fa-plus fa-fw'></i> Добавить занятие</a>";
	echo "<div class='containertable'>";
	echo "<table class='fiotable'>";
	echo "<tr><th width='200px;' height='110px'>ФИО</th></tr>";
	foreach ($group_members as $us) {
		echo "<tr><td>".$users[$us['userid']]['fio']."</td></tr>";
	};
	echo "</table>";
	echo "<div class='scroll mCustomScrollbar'>";
	echo "<table class='defaultwidth tablepos'><tr>";
	foreach ($ktplanm as $th) {
		$datereverse=explode("-", $th['datelesson']);
		$datereverse=$datereverse[2].'-'.$datereverse[1].'-'.$datereverse[0];
	echo "<th class='vertth'>
			<div class='container-table'>
				<p  class='vert'>".$datereverse."</p>";
							if ($idgroup!=86){
								echo "
				<div class='points'>
					<div class='item__points'>Пункт.<br>(0-1)</div>
					<div class='item__points'>Пов.<br>(0-3)</div>
					<div class='item__points'>Акт.<br>(0-1)</div>
					<div class='item__points'>Зад.<br>(0-5)</div>
					<div class='item__points'>Итог<br>(0-10)</div>
					<div class='item__points'>ДЗ</div>
				</div>";
							}
							echo "</th>";
	}
	echo "</tr>";
	foreach ($group_members as $us) {
		$countpayless=0;
		// $k=0; //счетчик оплаченных закрашенных дней
	foreach ($ktplanm as $td) {
		$posel='';
			$pun='';
			$beh='';
			$act='';
			$task='';
			$hw='';
			$sum='';
		//считываем статус посещения
		foreach ($attendance as $elatt) {
			if ($elatt['dateat']==$td['datelesson'] && $elatt['iduser']==$us['userid'] && $elatt['group_id']==$idgroup){
			$posel=$elatt['status'];
			$pun=$elatt['punctuality'];
			$beh=$elatt['behaviour'];
			$act=$elatt['activity'];
			$task=$elatt['tasks'];
			$hw=$elatt['estimation_home'];
			$sum=$pun+$beh+$act+$task;
			break;
		}
		}
		// if (!isset($posel)) {
		// 	$posel='';
		// 	$pun=0;
		// 	$beh=0;
		// 	$act=0;
		// 	$task=0;
		// 	$hw=0;
		// 	$sum=0;
		// }
		//считали статус посещения
		if($td['datelesson']<$users[$us['userid']]['datepay']) {
			echo "<td id='".$us['userid']."s".$td['datelesson']."' class='tddate'>
					<div class='points'>
					<div class='item__points' data='status'>
						<input type='text' class='tdpos' value='".$posel."'></div>";
							if ($idgroup!=86){
								echo "<div class='item__points' data='pun'><input type='text' class='tdpos' value='".$pun."'></div>
								<div class='item__points' data='beh'><input type='text' class='tdpos' value='".$beh."'></div>
								<div class='item__points' data='act'><input type='text' class='tdpos' value='".$act."'></div>
								<div class='item__points' data='task'><input type='text' class='tdpos' value='".$task."'></div>
								<div class='item__points tdpos' data='asses'>$sum</div>
								<div class='item__points' data='hw'><input type='text' class='tdpos' value='".$hw."'></div>";
							}
							echo "<div>
				</td>";
		} else {
		if (floor($countpayless)>0){
			if ($posel=='-' && $type_pay=='R') {
				echo "<td id='".$us['userid']."s".$td['datelesson']."' class='tddate'>
				<div class='points'>
					<div class='item__points' data='status'><input type='text' class='tdpos' value='".$posel."'></div></div>";
					if ($idgroup!=86){
						echo "<div class='item__points' data='pun'><input type='text' class='tdpos' value='".$pun."'></div>
					<div class='item__points' data='beh'><input type='text' class='tdpos' value='".$beh."'></div>
					<div class='item__points' data='act'><input type='text' class='tdpos' value='".$act."'></div>
					<div class='item__points' data='task'><input type='text' class='tdpos' value='".$task."'></div>
					<div class='item__points' data='asses'>$sum</div>
					<div class='item__points' data='hw'><input type='text' class='tdpos' value='".$hw."'></div>";
					}
				echo "<div>
				</td>";
			} else {
				echo "<td id='".$us['userid']."s".$td['datelesson']."' class='tddate'>
				<div class='points'>
					<div class='item__points' data='status'><input type='text' class='tdpos paid' value='".$posel."'></div>";
					if ($idgroup!=86){
						echo "<div class='item__points' data='pun'><input type='text' class='tdpos' value='".$pun."'></div>
					<div class='item__points' data='beh'><input type='text' class='tdpos' value='".$beh."'></div>
					<div class='item__points' data='act'><input type='text' class='tdpos' value='".$act."'></div>
					<div class='item__points' data='task'><input type='text' class='tdpos' value='".$task."'></div>
					<div class='item__points' data='asses'>$sum</div>
					<div class='item__points' data='hw'><input type='text' class='tdpos' value='".$hw."'></div>";
					}
				echo "<div>
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
							<div class='item__points' data='status'><input type='text' class='tdpos' value='".$posel."'></div>";
							if ($idgroup!=86){
								echo "<div class='item__points' data='pun'><input type='text' class='tdpos' value='".$pun."'></div>
							<div class='item__points' data='beh'><input type='text' class='tdpos' value='".$beh."'></div>
							<div class='item__points' data='act'><input type='text' class='tdpos' value='".$act."'></div>
							<div class='item__points' data='task'><input type='text' class='tdpos' value='".$task."'></div>
							<div class='item__points' data='asses'>$sum</div>
							<div class='item__points' data='hw'><input type='text' class='tdpos' value='".$hw."'></div>";
							}
						echo "<div>
				</td>";
						$countpayless+=$elpay['countless'];
					} else {
						$countpayless+=$elpay['countless']-1;//сколько занятий оплатили
						echo "<td id='".$us['userid']."s".$td['datelesson']."' class='tddate'>
						<div class='points'>
							<div class='item__points' data='status'><input type='text' class='tdpos paid' value='".$posel."'></div>";
							if ($idgroup!=86){
								echo "
							<div class='item__points' data='pun'><input type='text' class='tdpos' value='".$pun."'></div>
							<div class='item__points' data='beh'><input type='text' class='tdpos' value='".$beh."'></div>
							<div class='item__points' data='act'><input type='text' class='tdpos' value='".$act."'></div>
							<div class='item__points' data='task'><input type='text' class='tdpos' value='".$task."'></div>
							<div class='item__points' data='asses'>$sum</div>
							<div class='item__points' data='hw'><input type='text' class='tdpos' value='".$hw."'></div>";
							}
						echo "<div>
				</td>";
					} 
					$flag_paid=1;
				} 
			}
			if($flag_paid==0 ){ 									
				if (date('Y-m-d')>=$td['datelesson'] && $posel!='-'){
					echo "<td id='".$us['userid']."s".$td['datelesson']."' class='tddate'>
					<div class='points'>
					<div class='item__points' data='status'><input type='text' class='tdpos debt' value='".$posel."'></div>";
					if ($idgroup!=86){
						echo "
						<div class='item__points' data='pun'><input type='text' class='tdpos' value='".$pun."'></div>
						<div class='item__points' data='beh'><input type='text' class='tdpos' value='".$beh."'></div>
						<div class='item__points' data='act'><input type='text' class='tdpos' value='".$act."'></div>
						<div class='item__points' data='task'><input type='text' class='tdpos' value='".$task."'></div>
						<div class='item__points' data='asses'>$sum</div>
						<div class='item__points' data='hw'><input type='text' class='tdpos' value='".$hw."'></div>";
					}
						echo "<div>
				</td>";
				} else {
				echo "<td id='".$us['userid']."s".$td['datelesson']."' class='tddate'>
				<div class='points'>
					<div class='item__points' data='status'><input type='text' class='tdpos' value='".$posel."'></div>";
					if ($idgroup!=86){
						echo "
					<div class='item__points' data='pun'><input type='text' class='tdpos' value='".$pun."'></div>
					<div class='item__points' data='beh'><input type='text' class='tdpos' value='".$beh."'></div>
					<div class='item__points' data='act'><input type='text' class='tdpos' value='".$act."'></div>
					<div class='item__points' data='task'><input type='text' class='tdpos' value='".$task."'></div>
					<div class='item__points' data='asses'>$sum</div>
					<div class='item__points' data='hw'><input type='text' class='tdpos' value='".$hw."'></div>";
					}
				echo "<div>
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
echo "<p class='attantion'> * Чтобы отменить изменения аналогично нужно нажать Esc.</p>";
}
if ($_GET['idgr']){
	attendance($_GET['idgr']);
}
?>