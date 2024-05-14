<?
include('connect.php');
$result = mysqli_query($link, "SELECT * FROM `attendance`");
$attendance = array();
while($row = mysqli_fetch_assoc($result))
 $attendance[] = $row;
if ($_GET['id']) {
  $idid= filter_input(INPUT_GET ,  'id' , FILTER_SANITIZE_STRING );
  $idid=explode('s', $idid);
  $userid=$idid[0];
  $userdate=$idid[1];
  $content = $_GET['content']; //get posted data
  $idgr=$_GET['idgroup'];
  $data=$_GET['data'];
 	$criteria=['pun'=>'punctuality','beh'=>'behaviour', 'act'=>'activity', 'task'=>'tasks', 'hw'=>'estimation_home', 'status'=>'status'];
 	$data=$criteria[$data];
        print $content;
       
     $flag=false; 
     //После отметки посещаемости (поставили + в клетку)
     if (count($attendance)!=0) {  //если таблица не пустая
foreach ($attendance as $th) {
//проверяем во всей таблице посещаемости были ли отметки для этой клетки
	if ($th['dateat']==$userdate && $th['iduser']==$userid && $th['group_id']==$idgr){ 
	//Если уже есть такая дата и одновременно для такого пользователя и такой даты
		if ($data=='status'){
			$content="'".$content."'";
		}
		$req="UPDATE `attendance` SET `".$data."`=$content WHERE id=".$th['id'];
			mysqli_query($link,$req) or die(mysqli_error($link)); //Обновить

			$flag=false;
			break;
	} else{ // если такой даты и пользователя одновременно нет
	$flag=true; //вставить
}
}
} else{
	$flag=true;
}
if ($flag) {
	$str="'".$userdate."',".$userid.",".$idgr.",";
	$data=='status' ? $str.= "'".$content."'," : $str.= "NULL,";
	$data=='punctuality' ? $str.= $content."," : $str.= "NULL,";
	$data=='behaviour' ? $str.= $content."," : $str.= "NULL,";
	$data=='activity' ? $str.= $content."," : $str.= "NULL,";
	$data=='tasks' ? $str.= $content."," : $str.= "NULL,";
	$data=='hw' ? $str.= $content : $str.= "NULL";
	$req="INSERT INTO `attendance`( `dateat`, `iduser`, `group_id`, `status`, `punctuality`, `behaviour`, `activity`, `tasks`, `estimation_home`) VALUES ($str)";
				mysqli_query($link,$req) or die(mysqli_error($link));
}
}
?>