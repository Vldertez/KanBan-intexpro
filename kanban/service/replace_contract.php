<?
include('../connect.php');
$req ="SELECT * FROM `users` WHERE `contract` <> ''";
$result = mysqli_query($link, $req) or die(mysqli_error($link));
$users = array();
while($tr = mysqli_fetch_assoc($result))
$users[] = $tr;
// echo "<pre>";
// var_dump($users);
// echo "</pre>"; 

foreach ($users as $row) {
$contracts = explode(' ', $row['contract']);
if (count($contracts)>1){
$contracts[1]=substr($contracts[1], 1, strlen($contracts[1])-2);
}
$date = explode(' ', $row['datacontract']);
if (count($date)>1){
$date[1]=substr($date[1], 1, strlen($date[1])-2);
}
$req ="SELECT * FROM `parents` WHERE `id`=".$row['parent'];
$result = mysqli_query($link, $req) or die(mysqli_error($link));
$parents = array();
while($tr = mysqli_fetch_assoc($result))
$parents[] = $tr;

for ($i=count($contracts)-1; $i >=0 ; $i--) { 
    $sql = "INSERT INTO `contracts`(`number`, `date`, `name`, `date_birth_parent`, `child`, `date_birth`, `passport`, `issued`, `phone`, `residency`, `id_user`) VALUES ('" . $contracts[$i] . "', '" . $date[$i] . "', '" . $parents['name1'] . "', ' ', '" . $row['fio'] . "','" . $row['dateBirth'] . "', ' ', ' ', '" . $parents['phone1'] . "', ' ', " . $row['id'] . ")";
    mysqli_query($link,$sql) or die(mysqli_error($link));
}
}

?>