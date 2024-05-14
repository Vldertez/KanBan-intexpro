<?php

include('connect.php');
$year=nowYear();
$req = "SELECT `t`.`initials`, `c`.`namecourse`, `g`.`name` as `group`, 
concat(
    IF (
        (SELECT COUNT(*) FROM `days-week` WHERE `id` = `g`.`first-day`)>0, (SELECT `name` FROM `days-week` WHERE `id` = `g`.`first-day`), ''), 
    IF (
        (SELECT COUNT(*) FROM `days-week` WHERE `id` =`g`.`second-day`)>0, concat(',', (SELECT `name` FROM `days-week` WHERE `id` =`g`.`second-day`)),''
    )) as `days`, 
    concat(`g`.`first-time-start`, '-', `g`.`first-time-end`, 
           IF(`g`.`second-time-start`, 
              concat(',',`g`.`second-time-start`, '-',`g`.`second-time-end`), '')) as `times`, 
           `o`.`name` as `office` FROM `groupuser` `g`, `admins` `t`, `courses` `c`, `cat_courses` `ct`, `office` `o` WHERE `t`.`status` = 0 AND `c`.`id` = `g`.`course` AND `g`.`year` = $year AND `g`.`address` = `o`.`id` AND `g`.`teachers` = `t`.`id` AND `c`.`categories` = `ct`.`id` ORDER BY `t`.`initials`";
$result = mysqli_query($link, $req) or die(mysqli_error($link));

$teachers = array();
while($row = mysqli_fetch_assoc($result))
$teachers[] = $row;

if ($_GET['export']){
    echo "1";
    sleep(1);
    echo curl_sql($teachers);
}


// echo "<pre>";
// var_dump($teachers);
// echo "</pre>";
echo "<h2>Сводная по преподавателям</h2>
<div class='linkaddelement'>
<a href='?p=teachers_summary&export=1' class='addelement'><i class='icon fa fa-table fa-fw'></i> Экспорт в Excel</a>
</div>
<table class='fullwidth'>
<tr>
<th>№ п/п</th>
<th>Преподаватель</th>
<th>Курс</th>
<th>Группа</th>
<th>Дни занятий</th>
<th>Время занятий</th>
<th>Место занятий</th>
</tr>";
$n=1;
foreach ($teachers as $row) {
    echo "<tr>";
    echo "<td class='td-center'>$n</td>";
    foreach ($row as $key => $td) {
        if ($key == 'initials') {
            echo "<td class='td-bold'>$td</td>";
        }
        else {
            echo "<td>$td</td>";
        }
        
    }
    echo "</tr>";
    $n++;
}
echo "</table>";
?>