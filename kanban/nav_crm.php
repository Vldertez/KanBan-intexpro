<?
include('connect.php');
include('functions.php');
include('generate_sql.php');
if(!@$_COOKIE['id']){
$new_url='login.php';
header('Location: '.$new_url);
}
$result = mysqli_query($link, "SELECT * FROM `admins`");
$admins = array();
while($row = mysqli_fetch_assoc($result))
$admins[$row['id']] = $row;
if($admins[@$_COOKIE['id']]['role']=='teacher') {
if(isset($_GET['p']) && ($_GET['p']=='addpay' || $_GET['p']=='pay' || $_GET['ideditpay'] || $_GET['p']=='teachers' || $_GET['p']=='addteacher' || $_GET['p']=='course' || $_GET['p']=='addcourse' || $_GET['p']=='summary' || $_GET['p']=='addadmins' || $_GET['p']=='admins' || $_GET['p']=='openday' || $_GET['p']=='request' || $_GET['p']=='contract' || $_GET['p']=='addcontract')){
$new_url='index.php';
header('Location: '.$new_url);
}
} 
$result = mysqli_query($link, "SELECT * FROM `groupuser` ORDER BY `name`");
$groups = array();
while($row = mysqli_fetch_assoc($result))
$groups[$row['id']] = $row;
$result = mysqli_query($link, "SELECT * FROM `group_members`");
$group_members = array();
while($row = mysqli_fetch_assoc($result))
$group_members[$row['id']] = $row;
// $result = mysqli_query($link, "SELECT * FROM `teachers` ORDER BY `initials`");
// $teachers = array();
// while($row = mysqli_fetch_assoc($result))
// $teachers[$row['id']] = $row;
$result = mysqli_query($link, "SELECT `c`.`id`, `abbreviation`, `namecourse`, `description`, `age_min`, `age_max`, `cost`, `cc`.`name` as `category` FROM `courses` `c`, `courses_categories` `cc` WHERE `c`.`id_courses_categories` = `cc`.`id`");
$courses = array();

while($row = mysqli_fetch_assoc($result))
$courses[] = $row;
$result = mysqli_query($link, "SELECT * FROM `attendance`");
$attendance = array();
while($row = mysqli_fetch_assoc($result))
$attendance[$row['id']] = $row;
$result = mysqli_query($link, "SELECT * FROM `pay-old` ORDER BY `id` DESC");
$pay = array();
while($row = mysqli_fetch_assoc($result))
$pay[$row['id']] = $row;
$result = mysqli_query($link, "SELECT * FROM `users` ORDER BY `id` DESC");
$users = array();
while($row = mysqli_fetch_assoc($result))
$users[$row['id']] = $row;


function exceltomysql($par, $file, $data){
include('connect.php');
$result = mysqli_query($link, "SELECT * FROM `groupuser`");
$groups = array();
while($row = mysqli_fetch_assoc($result))
$groups[$row['id']] = $row;
$result = mysqli_query($link, "SELECT * FROM `courses`");
$courses = array();
while($row = mysqli_fetch_assoc($result))
$courses[$row['id']] = $row;
  foreach ($file->getWorksheetIterator() as $worksheet) {
  $rows_count = $worksheet->getHighestRow();
  // $columns_count = PHPExcel_Cell::columnIndexFromString($worksheet->getHighestColumn());
  if ($par['p']=='users'){
            $columns_count =8;
        } else if ($par['p']=='group'){
            $columns_count =6;
        }else if ($par['p']=='ktplan'){
            $columns_count =4;
			$req = "SELECT `teachers` FROM `groupuser` WHERE `id`=".$par['gid'];
			$result = mysqli_query($link, $req);
			$teacher = mysqli_fetch_assoc($result)['teachers'];
        }else if ($par['p']=='individual'){
            $columns_count =8;
        }
  // echo "$rows_count $columns_count";
// Перебираем строки листа Excel
for ($row = 1; $row <= $rows_count; $row++) {
    // Строка со значениями всех столбцов в строке листа Excel
    $value_str = [];
    // Перебираем столбцы листа Excel
    for ($column = 0; $column < $columns_count; $column++) {
        // Строка со значением объединенных ячеек листа Excel
        // Ячейка листа Excel
        $cell = $worksheet->getCellByColumnAndRow($column, $row);
		
        if (PHPExcel_Shared_Date::isDateTime($cell) && $cell!='' && $column==0) { 
 	$unixTimeStamp = PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()); 
$value_str[]= "'" . date('Y-m-d', $unixTimeStamp) . "'";
 } else if($column==1 && $par['p']=='group' && $cell!=''){
				for ($i=0; $i <= count($courses); $i++) { 
					if($courses[$i]['namecourse']==$cell){
							$cell1=$i;
						break;
					} else {
					    $cell1= '';
					}
			}
			$value_str[]= "'" . $cell1. "'";
		} else if($column==3 && $par['p']=='group' && $cell!='') {

				for ($i=0; $i <= count($teachers); $i++) { 
					if($teachers[$i]['initials']==$cell){
							$cell1=$i;
						break;
					} else {
					    $cell1= '';
					}
			}
			$value_str[]= "'" . $cell1. "',";
			}else if($column==3 && $par['p']=='individual' && $cell!=''){
				for ($i=0; $i <= count($courses); $i++) {
					if($courses[$i]['namecourse']==$cell){
						$cell1=$i;
						break;
					} else {
					    $cell1= '';
					}
			}
			$value_str[]= "'" . $cell1. "'";
		} else if($column==4 && $par['p']=='individual' && $cell!=''){
					for ($i=0; $i <= count($teachers); $i++) { 
					if($teachers[$i]['initials']==$cell){
							$cell1=$i;
						break;
					} else {
					    $cell1= '';
					}
			}
			$value_str[]= "'" . $cell1. "'";
		} 
		else{
			$value_str[]= "'" . $cell . "'";
 	}
 //echo $value_str."<br>";
}
if ($par['p']=='ktplan') {
	$value_str[] = 1;
	$value_str[] = $data['cabinet'];
	$value_str[] = $data['office'];
	
	$cell = $worksheet->getCellByColumnAndRow(4, $row);
	$value_str[]= "'" . $cell. "'";
	$cell = $worksheet->getCellByColumnAndRow(5, $row);
	$value_str[]= "'" . $cell. "'";
}
   $value_str = implode(',', $value_str);
    // Добавляем строку в таблицу MySQL
   //echo $value_str."<br>";
   // var_dump($par);
   		
        if ($par['p']=='users'){
            if (strlen($value_str)>40){
				$request="INSERT INTO `users`(`contract`, `datacontract`,`fio`, `datepay`, `parents`, `telParents`, `telStudent`, `dateBirth`) VALUES (".$value_str.")";
				mysqli_query($link,$request) or die(mysqli_error($link));
          	  }  
            } else if ($par['p']=='group'){
                if (strlen($value_str)>40){
            $request="INSERT INTO `groupuser`(`name`, `course`, `address`, `teachers`, `days`, `times`) VALUES (".$value_str.")";
            mysqli_query($link,$request) or die(mysqli_error($link));
                }
            }else if ($par['p']=='ktplan'){
                if (strlen($value_str)>14){
            $request="INSERT INTO  `ktplan`(`datelesson`, `namelesson`, `time_begin`, `time_end`, `type`, `cabinet`, `place`, `homework`, `max-points`, `idgroup`, `teacher`) VALUES (".$value_str.",".$par['gid'].", $teacher)";
            mysqli_query($link,$request) or die(mysqli_error($link));
                }
       			
    		} else if ($par['p']=='individual'){
            if (strlen($value_str)>30){
            $request="INSERT INTO `individual`(`contract`, `datecontract`, `fio`, `course`, `teacher`, `datepay`, `phone`, `datebirth`) VALUES (".$value_str.")";
            //echo $request."<br><br>";
            mysqli_query($link,$request) or die(mysqli_error($link));
            }  
            }

}
}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT" />
 <meta http-equiv="Pragma" content="no-cache" />
	<title>CRM</title>
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="assets/style.css?<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="assets/crm.css?<?php echo time(); ?>">
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	
	<?
	 if(!isset($_GET['p'])){
		echo '<link rel="stylesheet" type="text/css" href="assets/modalless.css?'.time().'">';
	 }
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="assets/jquery-3.6.0.min.js"></script>


</head>
<body>
<?
$user_id = $_COOKIE['id'];
$result = mysqli_query($link, "SELECT * FROM `admins` WHERE `id`=$user_id");
$user = mysqli_fetch_assoc($result);
?>
<header class="user-info">
	<div class="user-info-line user-info-line--name">
        <div class="search">
            <i class="fa fa-search fa-lg"></i>
            <input type="text" id="search_for_table" class="field_multiselect" placeholder='Быстрый поиск'>
        </div>
		<div class="user-name">
			<div class="user-name__container">
		<?	
		echo ($user['avatar']) ? "<img src='assets/img/avatars/".$user['avatar']."' class='curent_user_avatar'>" : "<img src='assets/img/avatars/some_user.jpg' class='curent_user_avatar'>";
		echo "</div><div class='curent_user_name'>".$user['fio']."</div>";
		?>
		</div>
	</div>
	<div class="user-info-line user-info-line--notifications">
		<div class="user-notifications">
		<?	
			echo "<i class='fa fa-bell-o fa-lg'></i>";
		?>
		</div>
	</div>
	<div class="user-info-line user-info-line--logout">
		<div class="user-logout">
		<?	
			echo "<a href='login.php?logout'><img src='assets/img/logout.png'></a>";
		?>
		</div>
	</div>
</header>

<aside class="panel">
	<header class="panel__header">
			<a href="#"><img src="assets/img/logo.svg" alt="ИНТЕКСПРО"></a>
			<div class="name_user"><?echo $admins[@$_COOKIE['id']]['fio']?></div>
		</header>
		<nav class="panel__nav">
			<ul>
				<li>
					<!-- <svg width='25px' version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 46.177 46.177" style="enable-background:new 0 0 46.177 46.177;" xml:space="preserve"><path style="fill: rgb(194, 207, 224);" d="M23.856,1.451l10.984,10.222l10.984,10.222c0.444,0.429,0.476,1.127,0.063,1.587 c-0.222,0.238-0.524,0.349-0.825,0.349v0.016h-5.555V43.91c0,0.619-0.508,1.127-1.127,1.127h-8.746 c-0.619,0-1.111-0.508-1.111-1.127V28.482H17.666V43.91c0,0.619-0.508,1.127-1.127,1.127H7.793c-0.619,0-1.111-0.508-1.111-1.127 V23.847H1.111C0.492,23.847,0,23.34,0,22.721c0-0.349,0.159-0.667,0.413-0.873l10.936-10.174L22.332,1.435 C22.761,1.039,23.427,1.039,23.856,1.451L23.856,1.451z M33.316,13.308L23.094,3.785l-10.222,9.524l-8.904,8.286h3.825 c0.619,0,1.127,0.508,1.127,1.127v20.063h6.508V27.371c0-0.619,0.492-1.127,1.111-1.127h13.095c0.619,0,1.127,0.508,1.127,1.127 v15.412h6.508V22.721c0-0.619,0.492-1.127,1.111-1.127h3.841L33.316,13.308z" fill="#1E201D"></path></svg> -->
					<a href="index.php" class="title-one">главная</a></li>
				<? if($admins[@$_COOKIE['id']]['role']=='admin' || $admins[@$_COOKIE['id']]['role']=='manager') {
					echo  '	<li class="cat-menu">';
					// echo '<svg  width="25px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 512 512" id="Layer_1" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve"><g><line fill="none" stroke="rgb(194, 207, 224)" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="10" x1="342.4" x2="342.4" y1="213.4" y2="267.9"/><line fill="none" stroke="rgb(194, 207, 224)" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="10" x1="369.6" x2="315.2" y1="240.6" y2="240.6"/><circle cx="256" cy="213.4" fill="none" r="34.5" stroke="rgb(194, 207, 224)" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="10"/><path d="   M318.4,331.7c0-34.5-27.9-62.4-62.4-62.4s-62.4,27.9-62.4,62.4H318.4z" fill="none" stroke="rgb(194, 207, 224)" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="10"/></g></svg>';
					echo '<span class="title-menu">первичный клиент </span>
					<ul class="submenu">
						<li><a href="index.php?p=openday">день открытых дверей</a>
						<li><a href="index.php?p=application_training">заявки на обучение</a></li>
						<li><a href="index.php?p=summer">заявки на лето</a></li>
					</ul>
				</li>';}?>
				<li class="cat-menu"><span class="title-menu">ученики </span>
					<ul class="submenu">
						<li><a href="index.php?p=users">ученики</a>
						<li><a href="index.php?p=group">группы</a></li>
					</ul>
				</li>
				<li class="cat-menu"><span class="title-menu">занятия </span>
					<ul class="submenu">
						<li><a href="index.php?p=ktplan">список занятий</a></li>
						<li><a href="index.php?p=attendance">посещаемость</a></li>
						<li><a href="index.php?p=ads">объявления</a></li>
					</ul>
				</li>

				<a href="crm.php" class="title-one">Планировщик задач</a></li>

				

				<? if($admins[@$_COOKIE['id']]['role']=='admin' || $admins[@$_COOKIE['id']]['role']=='manager') {
					echo  '<li class="cat-menu"><span class="title-menu">финансы </span>
								<ul class="submenu">
									<li><a href="index.php?p=pay">оплаты </a></li>
									<li><a href="index.php?p=summary">сводная</a></li>
									<li><a href="index.php?p=payold">старые оплаты </a></li>
									<li><a href="index.php?p=dept">Долги</a></li>
								</ul>
							</li>
				<li class="cat-menu"><span class="title-menu">управление </span>
					<ul class="submenu">
						<li><a href="index.php?p=management">офисы</a></li>
						<li><a href="index.php?p=admins">сотрудники</a></li>
						<li><a href="index.php?p=teachers_summary">сводная по преподавателям</a></li>
						<li><a href="index.php?p=course">курсы</a></li>
					</ul>
				</li>';
			}
			if(@$_COOKIE['id']){
				echo '<li><a href="login.php?logout"  class="title-one">выход</a></li>';
			}
			?>
			</ul>
		</nav>
		<div class="btn_nav"><i class="fa fa-angle-double-right" aria-hidden="true"></i></div>
	</aside>
	
	
	