<?
include('connect.php');

	
if (isset($_POST['addles'])) {
	// var_dump($_POST);
	$type_lesson=$_POST['type-lesson'];
	$name=$_POST['name'];
	$time_begin=$_POST['time-begin'];
	$time_end=$_POST['time-end'];
	$place=$_POST['place'];
	$cabinet=$_POST['cabinet'];
	$topic=$_POST['topic'] ? "'".$_POST['topic']."'" : 'NULL';
	$hw=$_POST['hw'] ? "'".$_POST['hw']."'" : 'NULL';
	$max_points=$_POST['max-points'] ? $_POST['max-points'] : 'NULL';
	$teacher=$_POST['teacher'] ? $_POST['teacher'] : 'NULL';
	$course=$_POST['course'] ? $_POST['course'] : 'NULL';
	if(isset($_POST['repeat'])) {
		$date_start=$_POST['date-start'];
		$date_end=$_POST['date-end'];
		$days = $_POST['day'];
		$num_day_start = date("w", strtotime($date_start));
		$num_day_end = date("w", strtotime($date_end)) != 0 ? date("w", strtotime($date_end)) : 7;
		$j = 0;
		for ($i = 0; $i < count($days); $i++){
			$count_day_start = $days[$i]-$num_day_start;
			$count_day_end =$num_day_end - $days[$i];
	
			$tmp_date_time = strtotime("+$count_day_start days", strtotime($date_start));
			
			$tmp_date_time_end = strtotime("-$count_day_end days", strtotime($date_end));
	
			$tmp_date = date('Y-m-d', $tmp_date_time );
			$array_date[$j]['date'] =  $tmp_date;
			$array_date[$j]['time_begin'] =  $time_begin[$i];
			$array_date[$j]['time_end'] =  $time_end[$i];
			$count_day = 7;
			while ($tmp_date_time < $tmp_date_time_end) {
				$j++;
			$tmp_date_time = strtotime("+$count_day days", $tmp_date_time);
			$tmp_date = date('Y-m-d', $tmp_date_time );
			$array_date[$j]['date'] =  $tmp_date;
			$array_date[$j]['time_begin'] =  $time_begin[$i];
			$array_date[$j]['time_end'] =  $time_end[$i];
			}
			$j++;
		}
		$fun_sort = fn($a, $b) =>  $a['date'] > $b['date'];
		uasort($array_date, fn($a, $b) =>  strtotime($a['date']) - strtotime($b['date']));
		$query="INSERT INTO `ktplan`( `datelesson`, `namelesson`, `time_begin`, `time_end`, `type`, `cabinet`, `place`, `homework`, `max-points`, `idgroup`, `teacher`, `course`) VALUES ";
		$queries = [];
		for ($i = 0; $i < count($array_date); $i++){
			$queries[] = "('".$array_date[$i]['date']."',$topic,'".$array_date[$i]['time_begin']."','".$array_date[$i]['time_end']."','$type_lesson','$cabinet','$place',$hw,$max_points,'$name',$teacher,$course)";
		}
		$queries_str = implode(",", $queries);
		$query.=$queries_str;
		mysqli_query($link,$query) or die(mysqli_error($link));
	} else {
		$date=$_POST['date-lesson'];
	$query="INSERT INTO `ktplan`( `datelesson`, `namelesson`, `time_begin`, `time_end`, `type`, `cabinet`, `place`, `homework`, `max-points`, `idgroup`, `teacher`, `course`) VALUES ('".$date."',".$topic.",'".$time_begin."','".$time_end."','".$type_lesson."','".$cabinet."','".$place."',".$hw.",".$max_points.",'".$name."',".$teacher.",".$course.")";
	mysqli_query($link,$query) or die(mysqli_error($link));
	}
	

	$url='index.php';
	if ($_GET['p']) {
		$url.='?'.$_GET['p'];
	}
	
	header('Location: '.$url);
}
if (isset($_POST['office'])) {
	$date = json_decode($_POST['date']);
	$date_start = $date[0]->year.'-'.$date[0]->num_mounth.'-'.$date[0]->day;
	$date_end = $date[6]->year.'-'.$date[6]->num_mounth.'-'.$date[6]->day;
	$office=$_POST['office'];
	$req="SELECT * FROM `admins`";
	$result = mysqli_query($link, $req);
	$teachers = array();
	while($row = mysqli_fetch_assoc($result))
		$teachers[$row['id']] = $row;
	$req="SELECT * FROM `cabinet`";
	$result = mysqli_query($link, $req);
	$cabinet = array();
	while($row = mysqli_fetch_assoc($result))
		$cabinet[$row['id']] = $row;
	if (isset($_GET['year'])) {
		$year=$_GET['year'];
   	}else {
	   $d = getdate();
	   $m=$d['mon']; 
	   if ($m <=8) {
		   $year=$d['year']-1 ;
	   }else {
		   $year= $d['year'];
	   }
   };
	$req="SELECT * FROM `groupuser`";
	$result = mysqli_query($link, $req);
	$group = array();
	while($row = mysqli_fetch_assoc($result))
		$group[$row['id']] = $row;
	$req="SELECT * FROM `users`";
	$result = mysqli_query($link, $req);
	$users = array();
	while($row = mysqli_fetch_assoc($result))
		$users[$row['id']] = $row;
	$result = mysqli_query($link, "SELECT * FROM `ktplan` WHERE `place`=".$office." AND `datelesson`>='$date_start' AND `datelesson`<='$date_end'");
	// echo "SELECT * FROM `ktplan` WHERE `place`=".$office." AND `datelesson`>'$date_start' AND `datelesson`<'$date_end'";
	$lessons = array();
	while($row = mysqli_fetch_assoc($result))
		$lessons[$row['id']] = $row;
		//  var_dump($lessons);
	foreach ($lessons as $key => $val) {
			$tmpmas=$val['idgroup'];
			if($val['type']==1){
				$lessons[$key]['name-title']= isset($group[$tmpmas]['name']) ? $group[$tmpmas]['name'] : null;
				$lessons[$key]['teacher-title']=isset($teachers[$val['teacher']]['initials']) ? $teachers[$val['teacher']]['initials'] : null;
				$lessons[$key]['teacher-color']=isset($teachers[$val['teacher']]['color']) ? $teachers[$val['teacher']]['color'] : null;
			} else if ($val['type'] == 2) {
				$lessons[$key]['name-title']=isset($users[$tmpmas]['fio']) ? explode(' ', $users[$tmpmas]['fio'])[0]: null;
				$lessons[$key]['teacher-title']=isset($teachers[$val['teacher']]['initials']) ? $teachers[$val['teacher']]['initials'] : null;
				$lessons[$key]['teacher-color']=isset($teachers[$val['teacher']]['color']) ? $teachers[$val['teacher']]['color'] : null;
				
			} else if ($val['type'] == 5) {
				$lessons[$key]['name-title']= isset($users[$tmpmas]['fio']) ? explode(' ', $users[$tmpmas]['fio'])[0] . ' (о)' : $users[$tmpmas]['fio'];
				$lessons[$key]['teacher-title']=isset($teachers[$val['teacher']]['initials']) ? $teachers[$val['teacher']]['initials'] : null;
				$lessons[$key]['teacher-color']=isset($teachers[$val['teacher']]['color']) ? $teachers[$val['teacher']]['color'] : null;
				
			} else if ($val['type'] == 3) { 
				$lessons[$key]['name-title']=isset($lessons[$key]['idgroup']) ? $lessons[$key]['idgroup'] : null;
				$lessons[$key]['teacher-color'] = '#86065c';
			} else if ($val['type'] == 4) { 
				$lessons[$key]['name-title']=isset($lessons[$key]['idgroup']) ? $lessons[$key]['idgroup'] : null;
				$lessons[$key]['teacher-color'] = '#d355a9';
			}
			$lessons[$key]['id_cabinet'] = isset($lessons[$key]['cabinet']) ? $lessons[$key]['cabinet'] : null;
			$lessons[$key]['cabinet'] = isset($cabinet[$lessons[$key]['cabinet']]['name']) ? $cabinet[$lessons[$key]['cabinet']]['name'] : null;
	}
	 echo(json_encode($lessons, true));
}
if (isset($_POST['cont'])) {
	if($_POST['cont']=='group'){
		if (isset($_GET['year'])) {
			$year=$_GET['year'];
	   }else {
		   $d = getdate();
		   $m=$d['mon']; 
		   if ($m <=8) {
			   $year=$d['year']-1 ;
		   }else {
			   $year= $d['year'];
		   }
	   };
		$req="SELECT * FROM `groupuser` WHERE `year`=$year ORDER BY `name` ASC" ;
	$result = mysqli_query($link, $req);
	$group = array();
	while($row = mysqli_fetch_assoc($result))
	$group[] = $row;
	echo(json_encode($group, true));
} else if(isset($_POST['cont']) && $_POST['cont']=='ind'){
	$req="SELECT * FROM `users` ORDER BY `fio` ASC";
	$result = mysqli_query($link, $req);
	$users = array();
	while($row = mysqli_fetch_assoc($result))
	$users[] = $row;
	echo(json_encode($users, true));
} else if(isset($_POST['cont']) && $_POST['cont']=='less'){
$req="SELECT * FROM `ktplan` WHERE id=".$_POST['id'];
	$result = mysqli_query($link, $req);
	$less = array();
	while($row = mysqli_fetch_assoc($result))
	$less[$row['id']] = $row;
	echo(json_encode($less, true));
}
}
if (isset($_POST['editless'])) {
	$date=$_POST['date-lesson'];
	$time_begin=$_POST['time-begin'];
	$time_end=$_POST['time-end'];
	$type=$_POST['type-lesson'];
	$cabinet=$_POST['cabinet'];
	$name=$_POST['name'];
	$id=$_POST['id'];
	$place=$_POST['place'];
	$topic=$_POST['topic'] ? $_POST['topic'] : 'NULL';
	$hw=$_POST['hw'] ? $_POST['hw'] : 'NULL';
	$max_points=$_POST['max-points'] ? $_POST['max-points'] : 'NULL';
	$teacher=$_POST['teacher'] ? $_POST['teacher'] : 'NULL';
	$course=$_POST['course'] ? $_POST['course'] : 'NULL';
	$req="UPDATE `ktplan` SET `idgroup`='".$name."',`datelesson`='".$date."',`namelesson`='".$topic."',`time_begin`='".$time_begin."',`time_end`='".$time_end."',`type`='".$type."',`cabinet`='".$cabinet."',`place`='".$place ."',`homework`='".$hw."',`max-points`='".$max_points ."',`teacher`=".$teacher .",`course`=".$course ." WHERE `id`=".$id;
	echo $req;
	mysqli_query($link,$req) or die(mysqli_error($link));
	$url='index.php';
	// $_SERVER['REQUEST_URI']
	if ($_GET['p']) {
		$url.='?p='.$_GET['p'];
	}
	header('Location: '.$url);
	// sleep(5);
}
if (isset($_POST['delid'])) {
	$req="DELETE FROM `ktplan` WHERE `id`=".$_POST['delid'];
	if(mysqli_query($link,$req
	) or die(mysqli_error($link))) {
		echo 'ok';
	}
}

if (isset($_POST['teachers'])) {
	$req="SELECT * FROM `admins`";
	$result = mysqli_query($link, $req);
	$teachers = array();
	while($row = mysqli_fetch_assoc($result))
	$teachers[$row['id']] = $row;
	echo(json_encode($teachers, true));
}
if (isset($_POST['get_cabinet'])) {
	
	$office = $_POST['get_cabinet'];
	$req="SELECT * FROM `cabinet` WHERE `office` = $office ORDER BY `name`";
	$result = mysqli_query($link, $req);
	$cabinet = array();
	while($row = mysqli_fetch_assoc($result))
	$cabinet[] = $row;
	echo(json_encode($cabinet, true));
}

if (isset($_POST['teacher_id'])) {
	if ($_POST['teacher_id'] == 'curent') {
		$req="SELECT * FROM `admins` WHERE `id`=".$_COOKIE['id'];
	} else {
		$id =  $_POST['teacher_id'];
		$req="SELECT * FROM `admins` WHERE `id`=(SELECT `teachers` FROM `groupuser` WHERE `id` = $id)";
	}
	$result = mysqli_query($link, $req);
	$teacher = mysqli_fetch_assoc($result);
	echo(json_encode($teacher, true));
}
?>