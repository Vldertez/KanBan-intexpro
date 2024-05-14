<?
echo "<h2>Добавить объявление</h3>";
echo "<form method='POST' action='#openconfirm'>";
echo "<div class='container'>";
echo "<div class='label'>";
echo "<p>Заголовок объявления</p>";
echo "<p>Текст объявления</p>";
echo "<p>Группа получателей</p>";
echo "<p>Получатели</p>";
echo "</div>";
echo "<div class='input'>";
echo "<input type='text' name='title' required='true'>";
echo "<textarea name='text' required='true'></textarea>";
echo "<select name='recipient_group' required='true'>
			<option selected='selected'></option>
			 <option value='all'>Всем ученикам</option>
			 <option value='course'>По курсу</option>
			 <option value='group'>По группе</option>
		</select>";
		echo "<div class='recipients'></div>";
echo "</div></div><input type='submit' value='Добавить' class='btn' name='okaddads'></form>";

if($_POST['okaddads']){
	$title=$_POST['title'];
	$text=$_POST['text'];
	$recipient_group=$_POST['recipient_group'];
	$recipients=$_POST['recipients'];
	$author=intval($_COOKIE['id']);
	$date=date('d').'.'.date('m').'.'.date('y');
	$request="INSERT INTO `ads`(`title`, `text`, `recipient_group`, `recipients`, `date`, `author`) 
	VALUES ('".$title."','".$text."','".$recipient_group."','".$recipients."','".$date."','".$author."')";
	mysqli_query($link,$request) or die(mysqli_error($link));

}

?>