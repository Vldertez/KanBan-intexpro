<?
// $month = $json['meta_data'][2]['value'];
$month = "1, 2, 6";
$month_name = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
$direction_name = ["Первые шаги в IT", "Веб-разработчик. Создание сайтов", "Программирование. Python", "Основы работы с персональным компьютером", "Pro.Office", "Бизнес-Excel", "IT-дошкольник", "Английский язык", "Обществознание", "История", "Химия", "Биология", "Физика", "Информатика", "Математика", "Литература", "Русский язык", "Медиаредактор. Моушн-дизайн", "Медиаредактор. 3D-графика", "Медиаредактор. Векторная графика", "Медиаредактор. Растровая графика", "Дизайн интерфейсов", "Программирование. C#", "NoКодер. Разработка без кода", "Поколение Альфа", "Создание игр в Roblox", "Искусственный интеллект в Майнкрафт", "Unity.GameDev", "Поколение Z"];
if (strlen($month)>2){
$month = explode(', ', $month);
$month_title = $month_name[$month[0]-1];
for ($i=1; $i<count($month); $i++){
$month_title .= ", ".$month_name[$month[$i]-1];
}
} else {
    $month_title = $month_name[$month];  
}
echo $month_title."<br>";


$direction = "1";
if (strlen($direction)>2){
$direction = explode(', ', $direction);
$direction_title = $direction_name[$direction[0]-1];
for ($i=1; $i<count($direction); $i++){
$direction_title .= ", ".$direction_name[$direction[$i]-1];
}
} else {
    $direction_title = $direction_name[intval($direction)-1];  
}
echo $direction_title;
?>