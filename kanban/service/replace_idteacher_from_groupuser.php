<?
include "../connect.php";
$req = "SELECT * FROM `groupuser`";
$result = mysqli_query($link, $req);
$group = array();
while($row = mysqli_fetch_assoc($result))
$group[] = $row;
for ($j=0; $j < count($group); $j++) {
    $req = "UPDATE `ktplan` SET `teacher`=".intval($group[$j]['teachers']).",`course`=".intval($group[$j]['course'])." WHERE `type`=1 AND `idgroup`='".$group[$j]['id']."'";
    echo $req."<br>";
    mysqli_query($link,$req) or die(mysqli_error($link));
}
?>