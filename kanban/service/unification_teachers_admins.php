<?
$link = mysqli_connect("localhost", "root", "", "crm");
$req = "SELECT * FROM `teachers`";
$result = mysqli_query($link, $req);
$teachers = array();
while($row = mysqli_fetch_assoc($result))
$teachers[] = $row;
for ($j=0; $j < count($teachers); $j++) {
    $req = "UPDATE `admins` SET `initials`='".$teachers[$j]['initials']."',`avatar`='".$teachers[$j]['avatar']."',`color`='".$teachers[$j]['color']."',`status`=".$teachers[$j]['status']." WHERE `id`=".$teachers[$j]['id'];
    echo $req."<br>";
    mysqli_query($link,$req) or die(mysqli_error($link));
}
?>