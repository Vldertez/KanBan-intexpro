<?
$link = mysqli_connect("localhost", "root", "", "crm");
$query = "SET NAMES 'utf8'";
if (mysqli_query($link,$query) === TRUE) {
}
$query = "SET SESSION collation_connection = 'utf8_general_ci';";
if (mysqli_query($link,$query) === TRUE) {
}
?>