<?
// echo "<link href='https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.1/slimselect.min.css' rel='stylesheet'></link>";
if(isset($_GET['p']) && $_GET['p']=='addpay'){
    echo "<h2>Внести оплату</h3>";
    echo "<div class='filters'>";
    echo "<div class='input'><input type='text' id='input-filter' name='filter_users-fio' placeholder='ФИО ученика'>
        <div class='listfind find_filter'><ul>";	
    echo "</ul></div></div></div>";
    echo "<div id='content-addpay'>";
    if (isset($_GET['user'])){
        $userid=$_GET['user'];
        echo "<form method='POST' style='display:flex;justify-content: center; width:100%;flex-direction:column'>";
        echo "<div class='container'>
        <div class='label'>
        <p>Группа</p>
        <p>ФИО ученика</p>
        <p>ФАКТИЧЕСКАЯ дата платежа</p>
        <p>Сумма</p>
        <p>Месяц</p>
        <p>Способ оплаты</p>
        <p>Тип оплаты</p>
        </div>
        <div class='input'>";
        echo "<input type='hidden' name='p' value='addpay'>";
        echo "<select name='group' style='width:40%' id='select-group' required>";
        $year=nowYear();
        $result = mysqli_query($link, "SELECT `name`,`id` FROM `groupuser` WHERE `id` IN (SELECT `groupid` FROM `group_members` WHERE `userid`=$userid) AND `year`=$year");
        $groups = array();
        while($row = mysqli_fetch_assoc($result))
        $groups[] = $row;

        foreach ($groups as $td) {
        echo "<option value=".$td['id'].">".$td['name']."</option>";
        }	
        echo "</select>";
        $date =  date("Y-m-d H:i");
        // $date=$date['year'].'-'.$date['mounth'].'-'.$date['mday'];
        
    
        $result = mysqli_query($link, "SELECT `fio` FROM `users` WHERE `id` =".$userid);
        $user = mysqli_fetch_assoc($result);
        // var_dump($user);
        echo "<input type='hidden' name='user' value='".$userid."'> 
        <input type='text' name='name' disabled value='".$user['fio']."'>
        <input type='datetime-local' name='date-create' value='".$date."' required>
        <input type='number' name='price' id='sumpay' required>
        <select name='month'>
                <option></option>
                <option value=1>Январь</option>
                <option value=2>Февраль</option>
                <option value=3>Март</option>
                <option value=4>Апрель</option>
                <option value=5>Май</option>
                <option value=6>Июнь</option>
                <option value=7>Июль</option>
                <option value=8>Август</option>
                <option value=9>Сентябрь</option>
                <option value=10>Октябрь</option>
                <option value=11>Ноябрь</option>
                <option value=12>Декабрь</option>
        </select>
        <select name='way' required>
        <option></option>";
       

        $result = mysqli_query($link, "SELECT `name`,`id` FROM `pay-way`");
        $pay_way = array();
        while($row = mysqli_fetch_assoc($result))
        $pay_way[] = $row;
        foreach ($pay_way as $td) {
            echo "<option value=".$td['id'].">".$td['name']."</option>";
            }	
        echo "</select>
        <select name='type' required>
        <option></option>";
        $result = mysqli_query($link, "SELECT `name`,`id` FROM `pay-type`");
        $pay_type = array();
        while($row = mysqli_fetch_assoc($result))
        $pay_type[] = $row;
        foreach ($pay_type as $td) {
            echo "<option value=".$td['id'].">".$td['name']."</option>";
            }	
        echo "</select>
        <input style='opacity:0' type='datetime-local' name='date_change' value='".$date."' readonly>
        </div></div>
        <input type='submit' value='Добавить' class='btn' name='okaddpay'></form>";
        
        
        
    echo "</div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.1/slimselect.min.js'></script>
    <script>
    new SlimSelect({
        select: '#single'
      })
    </script>
    ";

    $month_en = ['January', 'February','March','April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $month_stydy = [9,10,11,12,1,2,3,4,5];
    $now_year = mktime(1, 1, 0, 6, 1, nowYear());
$req = "SELECT  `u`.`fio`, `g`.`id`, `g`.`name` FROM `groupuser` `g`, `users` `u` WHERE `g`.`id` IN (SELECT `groupid` FROM `group_members` WHERE `userid` = $userid) AND `year`=$year AND `u`.`id`=$userid";
$result = mysqli_query($link, $req);
$users_in_group = array();
while($row = mysqli_fetch_assoc($result))
$users_in_group[] = $row;
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

    for ($j = 0; $j < count($users_in_group); $j++){
        echo "<tr>";
    echo "<td>$n</td>";
    echo "<td class='leftp'>".$users_in_group[$j]['fio']."</td>";
    echo "<td class='leftp'>".$users_in_group[$j]['name']."</td>";
$req = '';
for ($k=0; $k < count($month_stydy); $k++) { 
 $year_att =  $month_stydy[$k]>8 ? $year : $year+1;
$req = "SELECT SUM(`price`) AS `sum`, (SELECT `status` FROM `attendance` WHERE `iduser`=$userid AND `group_id`=".$users_in_group[$j]['id']." AND `dateat`>= '$year_att"."-".$month_stydy[$k]."-1' AND `dateat`<= '$year_att"."-".$month_stydy[$k]."-31' AND `status`= '+' LIMIT 1) as `status` FROM `pay` WHERE `month` = ".$month_stydy[$k]." AND `date-create` > $now_year AND `id-user` = $userid AND `id-group` = ".$users_in_group[$j]['id'] ;
$result = mysqli_query($link, $req);
$pay =  mysqli_fetch_assoc($result);
if ($k <= array_search(date('n'), $month_stydy) && $pay['sum'] === null && $pay['status'] !== null ){
 echo "<td class = 'debt'>".$pay['sum']."</td>";
} else {
 echo "<td>".$pay['sum']."</td>";
}

}
$req = "SELECT SUM(`price`) AS `sum` FROM `pay` WHERE `date-create` > $now_year AND `id-user` =$userid AND `id-group` =".$users_in_group[$j]['id'];
$result = mysqli_query($link, $req);
$sum =  mysqli_fetch_assoc($result);
echo "<td>".$sum['sum']."</td>";
 echo "</tr>";
$n++;
 }
 }
    }
    if(isset($_POST['okaddpay'])){
    $request="INSERT INTO `pay`(`id-user`, `id-group`, `price`, `type`, `way`, `date-create`, `date_change`, `month`) 
        VALUES (".$_POST['user'].",".$_POST['group'].",".$_POST['price'].",'".$_POST['type']."','".$_POST['way']."','".strtotime($_POST['date-create'])."','".strtotime($_POST['date_change'])."','".$_POST['month']."')";
    mysqli_query($link,$request) or die(mysqli_error($link));
    echo "<script>window.location = 'index.php?p=addpay&user=".$_POST['user']."'</script>";	
}
?>