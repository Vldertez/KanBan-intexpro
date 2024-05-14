<?
require('connect.php');
require('header.php');
		echo "<div class='linegroup'>";
		foreach ($groups as $td) {
		echo "<a href='view_attendance.php?idgr=".$td['id']."'><div class='groupteg'>".$td['name']."</div></a>";
		}
		echo "</div>";
		require_once('attendance.php');
?>