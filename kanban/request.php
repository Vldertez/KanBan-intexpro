 <?
include('connect.php');
include('generate_sql.php');

if (isset($_POST['idgr'])){
	$idgr=$_POST['idgr'];
	$result = mysqli_query($link, "SELECT * FROM `group_members` WHERE groupid='$idgr'");
$group_members = array();
while($row = mysqli_fetch_assoc($result))
 $group_members[] = $row;
$mas = array();
foreach ($group_members as $value) {
	$result = mysqli_query($link, "SELECT * FROM `users` WHERE id='".$value['userid']."'");
		if (mysqli_num_rows($result)!=0){
			$row = mysqli_fetch_assoc($result);
			$mas[] = $row;
		} else {
			$mas[] = array('id'=>$value['userid'], 'fio'=>'Не найдено');
		}
}
echo(Json_encode($mas, JSON_UNESCAPED_UNICODE));
}

if (isset($_POST['nameuser'])) {
	$result = mysqli_query($link, "SELECT * FROM `users` WHERE fio LIKE '%".$_POST['nameuser']."%'");
$mas = array();
while($row = mysqli_fetch_assoc($result))
 $mas[$row['id']] = $row;
echo(Json_encode($mas, JSON_UNESCAPED_UNICODE));
}

if (isset($_POST['idsaddgroup'])) {
$result = mysqli_query($link, "SELECT * FROM `group_members`");
$group_members = array();
while($row = mysqli_fetch_assoc($result))
 $group_members[$row['id']] = $row;
$idsaddgroup=$_POST['idsaddgroup'];
$idsaddgroup=explode(',', $idsaddgroup);
$idaddedgroup=$_POST['idaddedgroup'];
for ($i=0; $i < count($idsaddgroup); $i++) { 
	$flag=0;
	foreach ($group_members as $value) {
		if ($value['groupid']==$idaddedgroup && $value['userid']==$idsaddgroup[$i]) {
			$flag=1;
		}
	}
	if (!$flag) {
		 $request="INSERT INTO `group_members`(`groupid`, `userid`) VALUES ('".$idaddedgroup."','".$idsaddgroup[$i]."')";
            if(mysqli_query($link,$request)){
				echo "ok";
            } else {
            	echo "error";
            }
}
}
}

if (isset($_POST['unknown'])) {
	$unknown = $_POST['unknown'];
	$table = $_POST['table'];
	$field = $_POST['field'];
$result = mysqli_query($link, "SELECT `".$field."`,`id` FROM `".$table."` WHERE fio LIKE '%".$unknown."%'");
$mas = array();
while($row = mysqli_fetch_assoc($result))
 $mas[] = $row;
echo(Json_encode($mas, JSON_UNESCAPED_UNICODE));
}

if (isset($_POST['type']) && $_POST['type'] == 'tdedit') {
	$table = $_POST['table'];
	$title = $_POST['title'];
	$id = $_POST['id'];
	$val = $_POST['val'];
	$date =  date("d.m.Y H:i");
	echo $title;
	echo $table;
	$req = "UPDATE `$table` SET `$title`='$val', `date_change` = '".strtotime($date)."' WHERE `id`=".$id;
mysqli_query($link,$req) or die(mysqli_error($link));
echo 'ok';
}

if (isset($_POST['type']) && $_POST['get'] === 'cabinet') {
    $result = mysqli_query($link, "SELECT * FROM `cabinet` WHERE `office` = ". $_POST['office']);
    $cabinet = array();
    while($row = mysqli_fetch_assoc($result))
    $cabinet[] = $row;
    echo(json_encode($cabinet, true));
}

if (isset($_POST['type']) && $_POST['type'] === 'select-get') {
	$table = $_POST['table'];
	$title = $_POST['title'];
	$id = $_POST['id'];
	$result = mysqli_query($link, "SELECT `id`, `$title` FROM `$table`");
    $content = array();
    while($row = mysqli_fetch_assoc($result))
    $content[] = $row;
	echo(Json_encode($content, JSON_UNESCAPED_UNICODE));
}
if (!count($_POST)){
	$data = json_decode(file_get_contents('php://input'));
}
if (isset($data -> type) && $data -> type === 'filter') {
	$table =$data-> table;
	unset($data -> type);
	unset($data -> table);
	$mas = [];
	
	foreach ($data as $key => $value) {
		$mas[$key] = array('IN', $value);
	}

	// $req = getRecords($table,array('*'),$mas, NULL, NULL, NULL, false);
	// e
	$req = "SELECT * FROM `".$table."` WHERE ";
	$mas = [];
	foreach ($data as $key => $value) {
		if ($value != ''){
			if (strpos($value, ',')){
				$val = explode(',', $value);
				echo $val;
		}
		$mas[]="`$key` = $value";
		}
	
	}
	$req.= implode(' AND ', $mas);
	echo $req;
	 $result = mysqli_query($link, $req);
$pay = array();
while($row = mysqli_fetch_assoc($result))
$pay[] = $row;
echo(Json_encode($pay, JSON_UNESCAPED_UNICODE));
}
// if ($_POST['type'] == 'filter') {
// 	$data = $_POST;
// 	$page =$data['table'];
// 	// if ($page == 'work_performed') {
// 	// 	$req = "SELECT `w`.`id`,`w`.`date_of_completion`, concat(`e`.`lastname`, ' ', `e`.`firstname`, ' ', `e`.`patronymic`) as 'name_eployees', `e`.`id` as `id_employees`, `w`.`volume`, `s`.`name` as `shift`, `w`.`shift` as `id_shift`, `t`.`name`, `t`.`id` as `id_type_of_work`, `hours` FROM `work_performed` `w`, `employees` `e`, `types_of_work` `t`, `shift` `s` WHERE `w`.`id_employees`=`e`.`id` AND `t`.`id`=`w`.`id_types_of_work` AND `s`.`id` = `w`.`shift` ";
// 	// 	if($data['project']) {
// 	// 		if (count(explode(",", $data['project'])) > 1) {
// 	// 			$req_str .= " IN ({$data['project']}) ";
// 	// 		} else {
// 	// 			$req_str .= "={$data['project']}";
// 	// 		}
// 	// 	}
// 	// 	$req .= " AND `t`.`id_section` IN (SELECT `id` FROM `sections` WHERE `id_project` $req_str)";
// 	// 	unset($data['project']);
// 	// }
	
	
// 	unset($data['type']);
// 	unset($data['page']);
// 	$mas = [];
// 	foreach ($data as $key => $value) {
// 		if ($value) {
// 			$req .= " AND ";
// 			$key = str_replace('-', '.', $key);
// 				if (count(explode(",", $value)) > 1) {
// 					$req .= "{$key} IN ($value)";
// 				} else if (strpos($key, "date") !== false && strpos($key, "from") !== false) {
// 					$keys = explode('.', $key);
// 					$req .= "{$keys[0]} >=  ". strtotime($value);
// 				} else if (strpos($key, "date") !== false && strpos($key, "to") !== false) {
// 					$keys = explode('.', $key);
// 					// echo strtotime($value);
// 					$req .= "{$keys[0]} <=  ". strtotime($value);
// 				}
				
// 				else {
// 					$req .= "{$key}=$value";
// 				}
// 		}
		
// 	}
// 	// $req = substr($req, 0, -5);
// 	$result = mysqli_query($link, $req);
//     $content = array();
//     while($row = mysqli_fetch_assoc($result))
//     $content[] = $row;
// 	echo(Json_encode($content, JSON_UNESCAPED_UNICODE));
// }
// if ($_POST['type'] === 'sammary-pay') {
// 	$date1= explode('-', $_POST['date1']);
// 	$date2= explode('-', $_POST['date2']);
// 	$req = "SELECT `id`, (SELECT `fio` FROM `users` `u` WHERE `u`.`id`=`p`.`id-user`) as `user`, (SELECT `name` FROM `groupuser` `g` WHERE `g`.`id`=`p`.`id-group`) as `group`, `price`, (SELECT `id` FROM `pay-type` `pt` WHERE `pt`.`id`=`p`.`type`) as `id-type`, (SELECT `name` FROM `pay-type` `pt` WHERE `pt`.`id`=`p`.`type`) as `type`, (SELECT `id` FROM `pay-way` `pw` WHERE `pw`.`id`=`p`.`way`) as `id-way`, (SELECT `name` FROM `pay-way` `pw` WHERE `pw`.`id`=`p`.`way`) as `way`, `date-create`, `date_change`, `month` FROM `pay` `p`  WHERE `date-create` BETWEEN ".  mktime(0, 0, 0, $date1[1], $date1[2], $date1[0]). " AND ". mktime(0, 0, 0, $date2[1], $date2[2], $date2[0])." ORDER BY `id` DESC";
// 	// $req = "SELECT * FROM `pay` WHERE `date-create` BETWEEN ".  mktime(0, 0, 0, $date1[1], $date1[2], $date1[0]). " AND ". mktime(0, 0, 0, $date2[1], $date2[2], $date2[0]);
// $result = mysqli_query($link, $req);
// $pay = array();
// while($row = mysqli_fetch_assoc($result))
// $pay[] = $row;
// echo(Json_encode($pay, JSON_UNESCAPED_UNICODE));
// }

if (isset($_POST['type']) && $_POST['type'] === 'getWay') {
	$result = mysqli_query($link, "SELECT * FROM `pay-way`");
    $way = array();
    while($row = mysqli_fetch_assoc($result))
    $way[] = $row;
    echo(json_encode($way, true));
}
if (isset($_POST['type']) && $_POST['type'] === 'addtag') {
	$tag = $_POST['val'];
	$result = mysqli_query($link, "INSERT INTO `tags`(`name_tags`) VALUES ('$tag')") or die(mysqli_error($link));
	$req = "SELECT MAX(`id`) as `max` FROM `tags`";
	$res = mysqli_query($link,$req);
	$max = mysqli_fetch_assoc($res)['max'];
	echo $max;
}
if (isset($_POST['type']) && $_POST['type'] === 'addtagforcourse') {
	$id_tag = $_POST['id_tag'];
	$ischecked = $_POST['ischecked'];
	$id_course = $_POST['id_course'];
	if ($ischecked === 'true') {
		$req = "INSERT INTO `id_tags`(`id_courses`, `id_tags`) VALUES ($id_course,$id_tag)";
	} else {
		$req = "DELETE FROM `id_tags` WHERE `id_courses` = $id_course AND `id_tags` = $id_tag";
	}
	$result = mysqli_query($link, $req) or die(mysqli_error($link));
	echo "ok";
}
?>