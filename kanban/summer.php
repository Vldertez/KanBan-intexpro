<?
if (isset($_GET['year'])) {
	$year = $_GET['year'];
	$date_time_start =  mktime(0, 0, 0, 2, 1, $_GET['year'] );
	$date_time_end =  mktime(0, 0, 0, 9, 31, $_GET['year'] );
} else {
	$date_time_start =  mktime(0, 0, 0, 2, 1, date('Y') );
	$date_time_end =  mktime(0, 0, 0, 9, 31, date('Y') );
	$year = date('Y');
}

$req = "SELECT * FROM `summer` WHERE `date_time` > $date_time_start AND `date_time` < $date_time_end ORDER BY `id` DESC";
$result = mysqli_query($link, $req);
$summer = array();
while($row = mysqli_fetch_assoc($result))
$summer[] = $row;

$result = mysqli_query($link, "SELECT `date_time` FROM `summer` ORDER BY `date_time` DESC");
$date_time = array();
while($row = mysqli_fetch_assoc($result)) {
	$date_time[] =date("Y", strtotime($row['date_time']));
}
$date_time = array_unique($date_time);
if(!in_array(date('Y'), $date_time)) {
	$date_time[] = date('Y');
}
 rsort($date_time);

 $req = "SELECT * FROM `office`";
$result = mysqli_query($link, $req);
$office = array();
while($row = mysqli_fetch_assoc($result))
$office[$row['id']] = $row;

// echo "<link rel='stylesheet' type='text/css' href='assets/summer.css'>

echo "<h2>Записи на Лето</h2>";
echo "<div class='filters'> 
		<div class='inputs'>
		<input type='text' class='input-filter' name='filter_group-year' placeholder='Лето' value='".$year."'>
		<div class='listfind find_filter'>
		<ul>";
			for ($i=0; $i < count($date_time); $i++) { 
				echo "<li id=".$date_time[$i]."><a href='?p=summer&year=".$date_time[$i]."'>".$date_time[$i]."</a></li>";
			}
echo "</ul></div></div></div>";
echo "<div class='linkaddelement'>";
echo "<a href='index.php?p=addsummer' class='addelement'><i class='icon fa fa-plus fa-fw'></i> Добавить заявку</a>";
// echo "<a href='index.php?p=users#openimport' class='addelement'><i class='icon fa fa-file-excel-o fa-fw'></i> Импорт из Excel</a>";
echo "</div>";
echo "<table class='fullwidth edit_table' data-table='summer'>";
echo "<tr><th>№ п/п</th>";
echo "<th>ФИО родителя</th>";
echo "<th>ФИО ребёнка</th>";
echo "<th>Телефон</th>";
echo "<th>Тип связи</th>";
echo "<th>Возраст</th>";
echo "<th>Тип</th>";
echo "<th>Офис</th>";
echo "<th>Смены</th>";
echo "<th>Дата заявки</th>";
echo "<th>Статус</th>";
echo "<th>Комментарий</th>";
// echo "<th>Дата последнего изменения</th>";
// echo "<th>Источник заявки/перехода</th>";
echo "<th>Действие</th>
</tr>";
$n = count($summer);
foreach ($summer as $row) {
	$explode_offices = explode(';', $row['office']);
	
	$offices = [];
	foreach ($explode_offices as $of) {
		$offices[] = $office[$of]['name'];
	}
	$office = implode(',', $offices);
	echo "<br>";
	echo "<tr data-id=".$row['id']."><td style='cursor:pointer'>".$n."</td>";
	echo "<td class='leftp'><input type='text' name='parent' class='tdedit' value='".$row['parent']."'></td>";
	echo "<td class='leftp'><input type='text' name='kid' class='tdedit' value='".$row['kid']."'></td>";
	echo "<td class='leftp'><input type='text' style='width:120px' name='tel' class='tdedit' value='".$row['tel']."'></td>";
	echo "<td class='leftp'><input type='text' style='width:100px' name='call_type' class='tdedit' value='".$row['call_type']."'></td>";
	echo "<td class='leftp'><input type='text' style='width:70px' name='age' class='tdedit' value='".$row['age']."'></td>";
	echo "<td class='leftp'><input type='text' style='width:70px' name='type' class='tdedit' value='".$row['type']."'></td>";
	echo "<td class='leftp'>".$office."</td>";
	echo "<td class='leftp'><textarea name='camp_change' class='tdedit'>".$row['camp_change']."</textarea></td>";
	echo "<td class='leftp'>".date("d-m-Y H:i",$row['date_time'])."</td>";
	echo "<td class='leftp'>".$row['status']."</td>";
	echo "<td class='leftp'><input type='text' name='comment' class='tdedit' value='".$row['comment']."'></td>";
	// echo "<td class='leftp'><input type='text' data-table='summer' name='date_change' class='tdedit' value='".$row['date_change']."'></td>";
	// echo "<td class='leftp'><input type='text' data-table='summer' name='utm_source' class='tdedit' value='".$row['utm_source']."'></td>";
	echo "<td><i class='fa fa-trash fa-lg delete' id=summer-".$row['id']."></i></td>
	</tr>";
	$n--;
}
echo "</table>";
?>
<!-- <aside class="client_card">
	<header class="card_header">
		<div class="number_request">Заявка №</div>
		<div class="status">Первичный контакт</div>
	</header>
	<div class="block_edit">
		<div class="line_input">
			<label for="parent">Имя родителя</label>
			<input type="text" name="parent" id="parent">
		</div>
		<div class="line_input">
			<label for="parent">Имя родителя</label>
			<input type="text" name="parent" id="parent">
		</div>
		<div class="line_input">
			<label for="parent">Имя родителя</label>
			<input type="text" name="parent" id="parent">
		</div>
		<div class="line_input">
			<label for="parent">Имя родителя</label>
			<input type="text" name="parent" id="parent">
		</div>
		<div class="line_input">
			<label for="parent">Имя родителя</label>
			<input type="text" name="parent" id="parent">
		</div>
	</div>
</aside> -->