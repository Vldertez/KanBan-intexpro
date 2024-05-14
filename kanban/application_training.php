<?
$year=nowYear();
$result = mysqli_query($link, "SELECT `id`, `date`, (SELECT `fio` FROM `admins` WHERE `id`=`p`.`id_admin`) as `admin`, `name_child`, `age_child`, `name_parent`, `phone`, (SELECT `name` FROM `type_of_training` WHERE `id`=`type_of_training`) as `type_of_training`, `courses`, `comment`, (SELECT `ru` FROM `utm_source` WHERE `id`=`p`.`id_channel`) as `channel` FROM `application_traning` `p` WHERE `year`=$year ORDER BY `id` DESC");
$probes = array();
while($row = mysqli_fetch_assoc($result))
$probes[] = $row;
echo "<h2>Заявки</h2>
<div class='linkaddelement'>";
// <a href='index.php?p=add_application_traning' class='addelement'><i class='icon fa fa-plus fa-fw'></i> Добавить заявку</a>
// <a href='export_simple.php?table=probes' class='addelement'><i class='icon fa fa-table fa-fw'></i> Экспорт в Excel</a>";
echo "</div><table class='fullwidth' data-table='application_traning'>
			<tr>
	<th>№ п/п</th>
	<th>Дата заявки</th>
	<th>Менеджер</th>
	<th>Ребенок</th>
	<th>Возраст</th>
	<th>Родитель</th>
	<th>Телефон</th>
	<th>Тип обучения</th>
	<th>Курс</th>
	<th>Комментарий</th>
	<th>Источник</th>
	</tr>";
$n=1;
foreach ($probes as $row) {
	echo "<tr data-id=".$row['id'].">
		<td>".$n."</td>
		<td class='leftp'>".date("d-m-Y H:i",$row['date'])."</td>
		<td class='leftp'>".$row['admin']."</td>
		<td class='leftp'>".$row['name_child']."</td>
		<td class='leftp'><input type='text' style='width:120px' name='age_child' class='tdedit' value='".$row['age_child']."'></td>
		<td class='leftp'>".$row['name_parent']."</td>
		<td class='leftp'>".$row['phone']."</td>
		<td class='leftp'>".$row['type_of_training']."</td>
		<td class='leftp'><input type='text' style='width:120px' name='courses' class='tdedit' value='".$row['courses']."'></td>
		<td class='leftp'><input type='text' style='width:120px' name='comment' class='tdedit' value='".$row['comment']."'></td>
		<td class='leftp'>".$row['channel']."</td>
	</tr>";
	$n++;
}
echo "</table>";

?>