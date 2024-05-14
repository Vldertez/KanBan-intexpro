<?
include "../connect.php";
$req = "SELECT * FROM `users` WHERE `groupuser` IS NOT NULL";
$result = mysqli_query($link, $req);
$users = array();
while($row = mysqli_fetch_assoc($result))
$users[] = $row;
for ($j=0; $j < count($users); $j++) {
    if ($users[$j]['groupuser'] !== "") {
       $idgroup = $users[$j]['groupuser'];
       $iduser = $users[$j]['id'];
        $req = "INSERT INTO `group_members`(`groupid`, `userid`) VALUES ($idgroup,$iduser)";
        mysqli_query($link,$req) or die(mysqli_error($link));
    }
  
}
?>