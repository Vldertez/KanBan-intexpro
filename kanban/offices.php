<?
$result = mysqli_query($link, "SELECT * FROM `office` ORDER BY `id` DESC");
$office = array();
while($row = mysqli_fetch_assoc($result))
$office[] = $row;

$result = mysqli_query($link, "SELECT * FROM `cabinet` ORDER BY `id` DESC");
$cabinet = array();
while($row = mysqli_fetch_assoc($result))
$cabinet[] = $row;

?>

<div class="block">
    
</div>