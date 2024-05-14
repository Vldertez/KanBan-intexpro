<?
$month_name = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
$result = mysqli_query($link, "SELECT `date`,`parent`, `child`, `phone`, `email`, `month`, `price`, `quantity`,  `direction`, `course`, `n-group` FROM `pay-temp`");
$pay = array();
while($row = mysqli_fetch_assoc($result))
$pay[] = $row;
echo "<h2>Реестр оплат</h2>";
echo "<div class='linkaddelement'>";
echo "<a href='#selectdate' class='addelement'><i class='icon fa fa-table fa-fw exportpay'></i> Экспорт в Excel</a>";
echo "</div>";
echo "<table class='fullwidth edit_table'>";
echo "<tr>
<th>№ п/п</th>
<th>Дата создания</th>
<th>Договор</th>
<th>Ребенок</th>
<th>Телефон</th>
<th>E-mail</th>
<th>Месяц</th>
<th>Сумма</th>
<th>Количество</th>
<th>Направление</th>
<th>Год обучения</th>
<th>группа</th>
</tr>";
$n=1;
foreach ($pay as $td) {
    echo "<tr>";
    echo "<td>$n</td>";
        echo "<td>".date("d-m-Y H:i",$td['date'])."</td>";
        echo "<td>".$td['parent']."</td>";
        echo "<td>".$td['child']."</td>";
        echo "<td>".$td['phone']."</td>";
        echo "<td>".$td['email']."</td>";
        echo "<td>".$td['month']."</td>";
        echo "<td>".$td['price']."</td>";
        echo "<td>".$td['quantity']."</td>";
        echo "<td>".$td['direction']."</td>";
        echo "<td>".$td['course']."</td>";
        echo "<td>".$td['n-group']."</td>";

    echo "</tr>";
    $n++;
}
?>