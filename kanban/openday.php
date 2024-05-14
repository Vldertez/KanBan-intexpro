<?
$year=nowYear();
$date =  date("Y-m-d\TH:i", mktime(1,1,1,10,1,$year));
$result = mysqli_query($link, "SELECT `parent`, `kid`, `tel`, `age`, (SELECT `name` FROM `office` WHERE `id`=`o`.`office`) as `office`, `agegroup`, `year`,`date_create` FROM `openday` `o` WHERE `year`=$year AND `date_create` >". strtotime($date)." ORDER BY `id` DESC");
$openday = array();
while($row = mysqli_fetch_assoc($result))
$openday[] = $row;
echo "<h2>Записи на День открытых дверей</h2>

<div class='linefilter'>
	<div class='filter_collumn'>
		<lable for='year'>Учебный год</lable>
		<select name=year>";
		var_dump(printselect('openday','year' , 'DESC', 2022));
		echo "<select>
	</div>
	<div class='filter_collumn'>
		<lable for='year'>Офис</lable>
		<select name=office data='openday-office'>";
		var_dump(printselect_id('office','name' , array('id' => 'ASC'), NULL));
		echo "<select>
	</div>
</div>
<div class='linkaddelement'>
<a href='export_simple.php?table=openday' class='addelement'><i class='icon fa fa-table fa-fw'></i> Экспорт в Excel</a>";
echo "</div><table class='fullwidth'>
<tr><th>№ п/п</th><th>Датасоздания</th><th>ФИО родителя</th><th>ФИО ребёнка</th><th>Телефон</th><th>Возраст</th><th>Офис</th><th>Возрастная категория</th><th>Время</th></tr>";
$n=1;
foreach ($openday as $row) {
	if ($row['agegroup']=='age79') {
		$age = '7-9 лет';
		$time = '10:00';
	} else if ($row['agegroup']=='age10'){
		$age = '10+ лет';
		$time = '13:00';
	}else {
		$age = '12+ лет';
		$time = '15:00';
	}
	// $date =  date("Y-m-d\TH:i");
	echo $row['date_create'];
	echo "<tr><td>".$n."</td><td class='leftp'>".date("d-m-Y H:i",$row['date_create'])."</td><td class='leftp'>".$row['parent']."</td><td class='leftp'>".$row['kid']."</td><td class='leftp'>".$row['tel']."</td><td class='leftp'>".$row['age']."</td><td class='leftp'>".$row['office']."</td><td class='leftp'>".$age."</td><td class='leftp'>".$time."</td></tr>";
	$n++;
}
echo "</table>";

?>