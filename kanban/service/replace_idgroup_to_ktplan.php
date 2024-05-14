<?
include "../connect.php";
$req = "SELECT * FROM `ktplan`";
$result = mysqli_query($link, $req);
$ktplan = array();
while($row = mysqli_fetch_assoc($result))
$ktplan[] = $row;
for ($j=0; $j < count($ktplan); $j++) {
    if (strpos($ktplan[$j]['idgroup'], "=") !== false) {
        $id = explode("=", $ktplan[$j]['idgroup'])[1];
        $req = "UPDATE `ktplan` SET `idgroup`=$id WHERE `id`=".$ktplan[$j]['id'];
        mysqli_query($link,$req) or die(mysqli_error($link));
    }
  
}
?>