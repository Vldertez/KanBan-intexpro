
<?
function attendance($a){
	$idgroup=$a;
	include('connect.php');
	$result = mysqli_query($link, "SELECT `id`, `name`, (SELECT `namecourse` FROM `courses` `c` WHERE `gr`.`course`=`c`.`id`) AS `course`, (SELECT `name` FROM `office` `o` WHERE `gr`.`address`=`o`.`id`) AS `address`, (SELECT `initials` FROM `admins` `t` WHERE `gr`.`teachers`=`t`.`id`) AS `teacher`, (SELECT `name` FROM `days-week` `d` WHERE `gr`.`first-day`=`d`.`id`) AS `first-day`, (SELECT `name` FROM `days-week` `d` WHERE `gr`.`second-day`=`d`.`id`) AS `second-day`, `first-time-start`, `second-time-start`, `first-time-end`, `second-time-end` FROM `groupuser` `gr` WHERE `id` =$idgroup");
	$groups =  mysqli_fetch_assoc($result);
	$result = mysqli_query($link, "SELECT * FROM `attendance`");
	$attendance = array();
	while($row = mysqli_fetch_assoc($result))
	$attendance[] = $row;
	$result = mysqli_query($link, "SELECT * FROM `ktplan` WHERE idgroup=".$idgroup." ORDER BY `datelesson`");
	$ktplanm = array();
	while($row = mysqli_fetch_assoc($result))
	 $ktplanm[] = $row;
	$result = mysqli_query($link, "SELECT * FROM `users` WHERE `id` IN (SELECT `userid` FROM `group_members`WHERE `groupid`=".$idgroup.")");
	$users = array();
	while($row = mysqli_fetch_assoc($result))
	 $users[$row['id']] = $row;
	echo "<h2 id='".$idgroup."' class='att-h2'>Посещаемость группы ".$groups['name']." </h2>
	<p class='att-info'><b>Курс:</b> ".$groups['course'].". <br><b>Офис: </b>".$groups['address'].". <b>Преподаватель: </b>".$groups['teacher']." <br><b>Время занятий: </b>".$groups['first-day']." ".$groups['first-time-start']."-".$groups['first-time-end'];
	echo ($groups['second-day'])? ", ".$groups['second-day']." ".$groups['second-time-start']."-".$groups['second-time-end']:'';
	// echo "</p><a href='index.php?p=ktplan&p2=addlesson&gid=$idgroup' class='addelement'><i class='icon fa fa-plus fa-fw'></i> Добавить занятие</a>";
	echo "<div class='containertable'>";
	echo "<table class='fiotable'>";
	echo "<tr><th>№ п/п</th><th width='200px;' height='110px'>ФИО</th></tr>";
	$n = 1;
	foreach ($users as $us) {
		
		echo "<tr><td>$n</td><td>".$us['fio']."</td></tr>";
		$n++;
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
							if ($idgroup!=86 && $idgroup!=164){
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
	echo "<th class='vertth'>
	<div class='container-table'>
	<div class='points'>
	<div class='item__points'><p class='vert'>Макс. баллов,<br>занятия</p></div>
	<div class='item__points'><p class='vert'>За занятия, <br>балл</p></div>
	<div class='item__points'><p class='vert'>За занятия, %</p></div>
	<div class='item__points'><p class='vert'>За ДЗ, макс. <br>балл</p></div>
	<div class='item__points'><p class='vert'>За ДЗ, балл</p></div>
	<div class='item__points'><p class='vert'>За ДЗ, %</p></div>
	<div class='item__points'><p class='vert'>Итого макс. <br>балл</p></div>
	<div class='item__points'><p class='vert'>Итого, балл</p></div>
	<div class='item__points'><p class='vert'>Итого, %</p></div>
	</div>
	</div></th>";
	echo "</tr>";
	foreach ($users as $us) {
		
		$sum_total = 0;
		$sum_max = 0;
		$sum_hw = 0;
		$max_hw = 0;
		foreach ($ktplanm as $td) {
			$posel='';
				$pun='';
				$beh='';
				$act='';
				$task='';
				$hw='';
				$sum='';
				$max_hw += $td['max-points'] ? $td['max-points'] : 0;
			//считываем статус посещения
			foreach ($attendance as $elatt) {
				$sum=0;
				if ($elatt['dateat']==$td['datelesson'] && $elatt['iduser']==$us['id'] && $elatt['group_id']==$idgroup){
					
				$posel=$elatt['status'];
				$pun=$elatt['punctuality']; 
				$beh=$elatt['behaviour'];
				$act=$elatt['activity'];
				$task=$elatt['tasks'];
				$hw=$elatt['estimation_home'];
				$sum=$pun+$beh+$act+$task;
				$sum_total += $sum;
				$sum_max +=10;
				$sum_hw +=$hw;
				break;
			}
			}
			//считали статус посещения
				echo "<td id='".$us['id']."s".$td['datelesson']."' class='tddate'>
						<div class='points'>
						<div class='item__points' data='status'>
							<input type='text' class='tdpos' value='".$posel."'></div>";
							if ($idgroup!=86 && $idgroup!=164){
									echo "<div class='item__points' data='pun'><input type='text' class='tdpos' value='".$pun."'></div>
									<div class='item__points' data='beh'><input type='text' class='tdpos' value='".$beh."'></div>
									<div class='item__points' data='act'><input type='text' class='tdpos' value='".$act."'></div>
									<div class='item__points' data='task'><input type='text' class='tdpos' value='".$task."'></div>
									<div class='item__points tdpos' data='asses'>$sum</div>
									<div class='item__points' data='hw'><input type='text' class='tdpos' value='".$hw."'></div>";
							}
								echo "<div>
					</td>";
			$posel='';			
		}
		
		$sum_percent = isset($sum_total) && $sum_max != 0 ? round($sum_total * 100 / $sum_max, 2) : "";
		$hw_percent = isset($sum_hw) && $max_hw != 0 ? round($sum_hw * 100 / $max_hw, 2) : "";
		$less_total = isset($sum_total) && isset($sum_hw) ? $sum_total + $sum_hw : "";
		$max_total =isset($sum_max) && isset($max_hw) ? $sum_max + $max_hw : "";
		$total_percent = $max_total != 0 ? round($less_total * 100 / $max_total, 2) : "";
		
		echo "<td>
		<div class='points'>
			<div class='item__points'>$sum_max</div>
			<div class='item__points'>$sum_total</div>
			<div class='item__points'>$sum_percent%</div>
			<div class='item__points'>$max_hw </div>
			<div class='item__points'>$sum_hw</div>
			<div class='item__points'>$hw_percent</div>
			<div class='item__points'>$max_total</div>
			<div class='item__points'>$less_total</div>
			<div class='item__points'>$total_percent%</div>
			</div>
		</td>";
		echo "</tr>";
	}
echo "</table> </div></div>";
echo "<p class='attantion'> * Чтобы отменить изменения аналогично нужно нажать Esc.</p>";
}
if (isset($_GET['idgr'])){
	attendance($_GET['idgr']);
}
?>