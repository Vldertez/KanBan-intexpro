<?
$month_name = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
$result = mysqli_query($link, "SELECT `id`, (SELECT `fio` FROM `users` `u` WHERE `u`.`id`=`p`.`id-user`) as `user`, (SELECT `name` FROM `groupuser` `g` WHERE `g`.`id`=`p`.`id-group`) as `group`, `price`, (SELECT `id` FROM `pay-type` `pt` WHERE `pt`.`id`=`p`.`type`) as `id-type`, (SELECT `name` FROM `pay-type` `pt` WHERE `pt`.`id`=`p`.`type`) as `type`, (SELECT `id` FROM `pay-way` `pw` WHERE `pw`.`id`=`p`.`way`) as `id-way`, (SELECT `name` FROM `pay-way` `pw` WHERE `pw`.`id`=`p`.`way`) as `way`, `date-create`, `date_change`, `month` FROM `pay` `p` ORDER BY `id` DESC");
$pay = array();
while($row = mysqli_fetch_assoc($result))
$pay[] = $row;

$req = "SELECT SUM(`price`) AS `sum`, COUNT(`price`) AS `count` FROM `pay` WHERE `date-create` BETWEEN ". mktime(0, 0, 0, date('m'), 1, date('Y')). " AND ". mktime(0, 0, 0, date('m'), 31, date('Y'));
$result = mysqli_query($link, $req);
$sum_pay_mounth = mysqli_fetch_assoc($result);
$req =  "SELECT (SELECT COUNT(`price`) FROM `pay` WHERE `date-create` BETWEEN ". mktime(0, 0, 0, date('m'), 1, date('Y')). " AND ". mktime(0, 0, 0, date('m'), 31, date('Y'))." AND `way` = 1) AS `BN`, (SELECT COUNT(`price`) FROM `pay` WHERE `date-create` BETWEEN ". mktime(0, 0, 0, date('m'), 1, date('Y')). " AND ". mktime(0, 0, 0, date('m'), 31, date('Y'))." AND `way` = 2) AS `QR`, (SELECT COUNT(`price`) FROM `pay` WHERE `date-create` BETWEEN ". mktime(0, 0, 0, date('m'), 1, date('Y')). " AND ". mktime(0, 0, 0, date('m'), 31, date('Y'))." AND `way` = 3) AS `N`, (SELECT COUNT(`price`) FROM `pay` WHERE `date-create` BETWEEN ". mktime(0, 0, 0, date('m'), 1, date('Y')). " AND ". mktime(0, 0, 0, date('m'), 31, date('Y'))." AND `way` = 4) AS `site` FROM `pay`";
$result = mysqli_query($link, $req);
$count_pay_way = mysqli_fetch_assoc($result);
?>
<div class="sammaryCards">
	<div class="sammaryCards-item block-shadow">
		<div class="sammaryCards-header block-shadow-header">
			<div class="sammaryCards-nameTable">Сумма оплат</div>
			<div class="sammaryCards-filter">
				<input type="date" name="date-from" id="date-from" value="<?echo date ("Y-m-01")?>">
				<span> - </span>
				<input type="date" name="date-to" id="date-to" value="<?echo date ("Y-m-31")?>">
			</div>
		</div>
		<div class="sammaryCards-content">
			<div class="sammaryCards-value"><img src="assets/img/Icon - Wallet.png" alt="Сумма оплат"> ₽<span id="totalPaySum"><?echo $sum_pay_mounth['sum'] ? $sum_pay_mounth['sum'] : 0?></span></div>
			<div class="sammaryCards-explanation">Сумма оплат с <span class="sammaryCards-explanation__from"><?echo date ("Y-m-01")?></span> по  <span class="sammaryCards-explanation__to"><?echo date ("Y-m-31")?></span></div>
		</div>
		
	</div>
	<div class="sammaryCards-item block-shadow">
		<div class="sammaryCards-header block-shadow-header">
			<div class="sammaryCards-nameTable">Количество всех оплат</div>
		</div>
		<div class="sammaryCards-content">
			<div class="sammaryCards-value"><img src="assets/img/Icon - Wallet.png" alt="Сумма оплат"><span id="countSum"> <?echo $sum_pay_mounth['sum'] ? $sum_pay_mounth['count'] : 0?></span></div>
			<div class="sammaryCards-explanation">Количество всех оплат с <span class="sammaryCards-explanation__from"><?echo date ("Y-m-01")?></span> по  <span class="sammaryCards-explanation__to"><?echo date ("Y-m-31")?></span></div>
		</div>
		
	</div>
	<div class="sammaryCards-item block-shadow">
		<div class="sammaryCards-header block-shadow-header">
			<div class="sammaryCards-nameTable">Количество оплат по типу платежа</div>
		</div>
		<div class="sammaryCards-content">
			<div class="sammary_values" id="countByWay">
				<div class="item">
					<div class="sammaryCards-value"><?echo $count_pay_way['BN'] ?></div>
					<div class="sammaryCards-explanation">Безнал</div>
				</div>
				<div class="item">
					<div class="sammaryCards-value"><?echo $count_pay_way['N'] ?></div>
					<div class="sammaryCards-explanation">Нал</div>
				</div>
				<div class="item">
					<div class="sammaryCards-value"><?echo $count_pay_way['QR'] ?></div>
					<div class="sammaryCards-explanation">QR</div>
				</div>
				<div class="item">
					<div class="sammaryCards-value"><?echo $count_pay_way['site'] ?></div>
					<div class="sammaryCards-explanation">Сайт</div>
				</div>
			</div>
		</div>
		
	</div>
</div>

<h2>Реестр оплат</h2>



<div class='linkaddelement'>
<a href='index.php?p=pay_tmp' class='addelement'><i class='icon fa fa-plus fa-fw'></i> Оплаты с сайта</a>
<a href='index.php?p=addpay' class='addelement'><i class='icon fa fa-plus fa-fw'></i> Добавить оплату</a>
<a href='#selectdate' class='addelement'><i class='icon fa fa-table fa-fw exportpay'></i> Экспорт в Excel</a>
</div>
<!-- <p class='attantion'> * Изменение данных происходит как в Excel. Для активации поля нужно нажать на ячейку двойным кликом и чуть чуть подождать. Но работает пока не во всех ячейках</p> -->
<div class='scrol-container'>
<table class='fullwidth edit_table' data-table='pay'>
<thead><tr>
<th>№ п/п</th>
<th>Дата платежа</th>
<th>ФИО</th>
<th>Группа</th>
<th>Сумма</th>
<th>Месяц</th>
<th>Тип оплаты</th>
<th>Способ оплаты</th>
<th>Дата <br> последнего <br> изменения</th>
<th>Действие</th></thead></tr><tbody>

<?
$n = 1;
foreach ($pay as $row) {
	// switch ($row['way']) {
	// 	case 'B':
	// 		$type='Безнал';
	// 		break;
	// 	case 'Q':
	// 		$type='QR';
	// 		break;
	// 	case 'N':
	// 		$type='Наличные';
	// 		break;
	// 	default:
	// 	$type='Не указано';
	// 	break;		
	// }
    echo "<tr data-id=".$row['id']."><td style='cursor:pointer'>".$n."</td>
	<td class='leftp'><input type='date' style='width:150px' name='date-create' class='tdedit' value='".date("Y-m-d",$row['date-create'])."'></td>
	<td class='leftp'>".$row['user']."</td>
	<td class='leftp'>".$row['group']."</td>
	<td class='leftp'><input type='text' style='width:120px' name='price' class='tdedit' value='".$row['price']."'></td>
    <td class='leftp select-edit for_search'  data-table='month' data-title='name' data-id=".$row['month']." data-name='month'>".$month_name[$row['month']-1]."</td>
	<td class='leftp select-edit' data-table='pay-type' data-title='name' data-id=".$row['id-type']." data-name='type'>".$row['type']."</td>
	<td class='leftp select-edit' data-table='pay-way' data-title='name' data-id=".$row['id-way']." data-name='way'>".$row['way']."</td>
	<td class='leftp'>".date("d-m-Y H:i",$row['date_change'])."</td>
	<td><i class='fa fa-trash fa-lg delete' id=pay-".$row['id']."></i></td>
	</tr>";
    $n++;
}
echo "</tbody></table></div>";
?>