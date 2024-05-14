<?
include('connect.php');
if(!@$_COOKIE['id']){
$new_url='../login.php';
header('Location: '.$new_url);
}
$result = mysqli_query($link, "SELECT * FROM `admins`");
$admins = array();
while($row = mysqli_fetch_assoc($result))
$admins[$row['id']] = $row;
if($admins[@$_COOKIE['id']]['role']!='admin') {
if($_GET['p']=='addpay' || $_GET['p']=='pay' || $_GET['ideditpay'] || $_GET['p']=='teachers' || $_GET['p']=='addteacher' || $_GET['p']=='course' || $_GET['p']=='addcourse' || $_GET['p']=='summary' || $_GET['p']=='addadmins' || $_GET['p']=='admins'){
$new_url='index.php';
header('Location: '.$new_url);
}
}
$query = "SET NAMES 'utf8'";
if (mysqli_query($link,$query) === TRUE) {
}
$query = "SET SESSION collation_connection = 'utf8_general_ci';";
if (mysqli_query($link,$query) === TRUE) {
}
$result = mysqli_query($link, "SELECT * FROM `archive_groupuser`");
$groups = array();
while($row = mysqli_fetch_assoc($result))
$groups[$row['id']] = $row;
$result = mysqli_query($link, "SELECT * FROM `teachers` ORDER BY `initials`");
$teachers = array();
while($row = mysqli_fetch_assoc($result))
$teachers[$row['id']] = $row;
$result = mysqli_query($link, "SELECT * FROM `courses`");
$courses = array();
while($row = mysqli_fetch_assoc($result))
$courses[$row['id']] = $row;
$result = mysqli_query($link, "SELECT * FROM `archive_attendance`");
$attendance = array();
while($row = mysqli_fetch_assoc($result))
$attendance[$row['id']] = $row;
$result = mysqli_query($link, "SELECT * FROM `pay` ORDER BY `id` DESC");
$pay = array();
while($row = mysqli_fetch_assoc($result))
$pay[$row['id']] = $row;
$result = mysqli_query($link, "SELECT * FROM `users` ORDER BY `id` DESC");
$users = array();
while($row = mysqli_fetch_assoc($result))
$users[$row['id']] = $row;
?>