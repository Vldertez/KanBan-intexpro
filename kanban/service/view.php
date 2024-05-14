<?
include('connect.php');

$result = mysqli_query($link, "SELECT * FROM `attendance` WHERE `group_id`=0");
$attendance = array();
while($row = mysqli_fetch_assoc($result))
$attendance[$row['id']] = $row;
$result = mysqli_query($link, "SELECT * FROM `groupuser`");
$groups = array();
while($row = mysqli_fetch_assoc($result))
$groups[$row['id']] = $row;

echo "<table border=1><tr><td>id ученика</td><td>ФИО</td><td>Дата</td><td>Статус посещения</td></tr>";
foreach ($attendance as $elatt) {
	echo "<tr>";
	$result = mysqli_query($link, "SELECT * FROM `users`  WHERE `id`=".$elatt['iduser']);
	$group_members = array();
	while($row = mysqli_fetch_assoc($result))
	$group_members[] = $row;
var_dump($group_members);
echo "<td>".$group_members[0]['id']."</td><td>".$group_members[0]['fio']."</td><td>".$elatt['dateat']."</td><td>".$elatt['status']."</td>";
echo "</tr>";
}
echo "</table>";
?>