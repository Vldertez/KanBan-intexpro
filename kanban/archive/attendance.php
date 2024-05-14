<?
function attendance($a){
$idgroup=$a;
include('connect.php');
$result = mysqli_query($link, "SELECT * FROM `archive_groupuser`");
$groups = array();
while($row = mysqli_fetch_assoc($result))
$groups[$row['id']] = $row;
$result = mysqli_query($link, "SELECT * FROM `archive_attendance`");
$attendance = array();
while($row = mysqli_fetch_assoc($result))
$attendance[$row['id']] = $row;
$result = mysqli_query($link, "SELECT * FROM `pay`");
$pay = array();
while($row = mysqli_fetch_assoc($result))
$pay[$row['id']] = $row;
$result = mysqli_query($link, "SELECT * FROM `archive_ktplan` WHERE `idgroup`=".$idgroup);
$ktplanm = array();
while($row = mysqli_fetch_assoc($result))
 $ktplanm[] = $row;
$result = mysqli_query($link, "SELECT * FROM `users` WHERE groupuser=$idgroup");
$users = array();
while($row = mysqli_fetch_assoc($result))
 $users[] = $row;
echo "<h2>Посещаемость группы ".$groups[$idgroup]['name']." </h3>";
echo "<div class='containertable'>";
echo "<table class='fiotable'>";
echo "<tr><th width='200px;' height='110px'>ФИО</th></tr>";
foreach ($users as $us) {
	echo "<tr><td>".$us['fio']."</td></tr>";
};
echo "</table>";
echo "<div class='scroll mCustomScrollbar'>";
echo "<table class='defaultwidth tablepos'><tr>";
foreach ($ktplanm as $th) {
	$datereverse=explode("-", $th['datelesson']);
	$datereverse=$datereverse[2].'-'.$datereverse[1].'-'.$datereverse[0];
echo "<th class='vertth'><p  class='vert'>".$datereverse."</p></th>";
}
echo "</tr>";
foreach ($users as $us) {
	$countpayless=0;
	// $k=0; //счетчик оплаченных закрашенных дней
foreach ($ktplanm as $td) {
	
	//считываем статус посещения
	foreach ($attendance as $elatt) {
		if ($elatt['dateat']==$td['datelesson'] && $elatt['iduser']==$us['id']){
		$posel=$elatt['status'];
	}
	}
	//считали статус посещения
	
	if($td['datelesson']<$us['datepay']) {
		echo "<td><input type='text' id='".$us['id']."s".$td['datelesson']."' class='tdpos' value='".$posel."'></td>";
	} else {
	if (floor($countpayless)>0){
		if ($posel=='-' && $type_pay=='R') {
			echo "<td><input type='text' id='".$us['id']."s".$td['datelesson']."' class='tdpos' value='".$posel."'></td>";
		} else {
			echo "<td><input type='text' id='".$us['id']."s".$td['datelesson']."' class='tdpos paid' value='".$posel."'></td>";
		$countpayless--;
		}
	} else{
		$flag_paid=0;
		foreach ($pay as $elpay) {//ищем взятую дату в списке оплат
			if ($td['datelesson']==$elpay['datebegin'] && $elpay['iduser']==$us['id'] && $elpay['namegroup']==$us['groupuser']){//если за эту дату оплачивали
				$type_pay=$elpay['type'];
				if ($posel=='-' && $type_pay=='R') {
					echo "<td><input type='text' id='".$us['id']."s".$td['datelesson']."' class='tdpos' value='".$posel."'></td>";
					$countpayless+=$elpay['countless'];
				} else {
					$countpayless+=$elpay['countless']-1;//сколько занятий оплатили
					echo "<td><input type='text' id='".$us['id']."s".$td['datelesson']."' class='tdpos paid' value='".$posel."'></td>";
				} 
				$flag_paid=1;
			} 
		}
		if($flag_paid==0 ){ 									
			if (date('Y-m-d')>=$td['datelesson'] && $posel!='-'){
				echo "<td><input type='text' id='".$us['id']."s".$td['datelesson']."' class='tdpos debt' value='".$posel."'></td>";
			} else {
			echo "<td><input type='text' id='".$us['id']."s".$td['datelesson']."' class='tdpos' value='".$posel."'></td>";
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