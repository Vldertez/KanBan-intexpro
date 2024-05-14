<?
$month_en = ['January', 'February','March','April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$month_stydy = [9,10,11,12,1,2,3,4,5];
$now_year = mktime(1, 1, 0, 6, 1, nowYear());
// echo $now_year;
$year=nowYear();
// $req = "SELECT (SELECT `fio` FROM `users` `u` WHERE `u`.`id`=`p`.`id-user`) as `user`, (SELECT `name` FROM `groupuser` `g` WHERE `g`.`id`=`p`.`id-group`) as `group`";
$req = "SELECT `u`.`id`, `u`.`fio` FROM `users` `u`
WHERE `u`.`id` IN (SELECT `userid` 
FROM `group_members` 
WHERE `groupid` IN (
    SELECT `id`
    FROM `groupuser` 
    WHERE `year`=".$year.")
) ORDER BY `u`.`fio`";

$result = mysqli_query($link, $req);
$users = array();
while($row = mysqli_fetch_assoc($result))
$users[] = $row;


echo "<h2>Сводная оплат</h2>";
echo "<div class='linkaddelement'>";
echo "<a href='index.php?p=addpay' class='addelement'><i class='icon fa fa-plus fa-fw'></i> Добавить оплату</a>";
echo "<a href='#selectdate' class='addelement'><i class='icon fa fa-table fa-fw exportpay'></i> Экспорт в Excel</a>";
echo "</div>";
echo "<table class='fullwidth edit_table'>";
echo "<tr>
<th>№ п/п</th>
<th>ФИО</th>
<th>Группа</th>
<th>Сентябрь</th>
<th>Октябрь</th>
<th>Ноябрь</th>
<th>Декабрь</th>
<th>Январь</th>
<th>Февраль</th>
<th>Март</th>
<th>Апрель</th>
<th>Май</th>
<th>Итого</th>
</tr>";
$n = 1;
for ($i = 0; $i < count($users); $i++){
    $req = "SELECT `id`, `name` FROM `groupuser` WHERE `id` IN (SELECT `groupid` FROM `group_members` WHERE `userid` = ".$users[$i]['id'].") AND `year`=".$year;
    $result = mysqli_query($link, $req);
    $users_in_group = array();
    while($row = mysqli_fetch_assoc($result))
    $users_in_group[] = $row;
    echo "<tr>";
    for ($j = 0; $j < count($users_in_group); $j++){
    echo "<td>$n</td>";
    echo "<td class='leftp'>".$users[$i]['fio']."</td>";
    echo "<td class='leftp'>".$users_in_group[$j]['name']."</td>";
    $req = '';
   for ($k=0; $k < count($month_stydy); $k++) { 
    $year_att =  $month_stydy[$k]>8 ? $year : $year+1;
    $sql_month = ($month_stydy[$k] < 10 ? '0'.$month_stydy[$k] : $month_stydy[$k]);
$req = "SELECT SUM(`price`) AS `sum`, (SELECT `status` FROM `attendance` WHERE `iduser`=".$users[$i]['id']." AND `group_id`=".$users_in_group[$j]['id']." AND `dateat`>= '$year_att"."-".$sql_month."-01' AND `dateat`<= '$year_att"."-".$sql_month."-31' AND `status` LIKE '%+%' LIMIT 1) as `status` FROM `pay` WHERE `month` = ".$month_stydy[$k]." AND `date-create` > $now_year AND `id-user` = ".$users[$i]['id']." AND `id-group` = ".$users_in_group[$j]['id'] ;
$result = mysqli_query($link, $req);
$pay =  mysqli_fetch_assoc($result);
if ($k <= array_search(date('n'), $month_stydy) && $pay['sum'] === null && $pay['status'] !== null ){
    echo "<td class = 'debt'>".$pay['sum']."</td>";
} else {
    echo "<td>".$pay['sum']."</td>";
}

}
$req = "SELECT SUM(`price`) AS `sum` FROM `pay` WHERE `date-create` > $now_year AND `id-user` =".$users[$i]['id']." AND `id-group` =".$users_in_group[$j]['id'];
$result = mysqli_query($link, $req);
$sum =  mysqli_fetch_assoc($result);
echo "<td>".$sum['sum']."</td>";
    echo "</tr>";
  $n++;
    }
}
echo "</table>";
