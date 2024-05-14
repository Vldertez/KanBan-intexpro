<?
if ($_POST['ok']) {
	$name_company=$_POST['name_company'];
	$fio=$_POST['fio'];
	$address=$_POST['address'];
	$comment=$_POST['comment'];
	require_once 'phpoffice/index.php';
$phpWord = new \PhpOffice\PhpWord\PhpWord();
 // $document = $phpWord->loadTemplate('tamplate.docx'); 
$phpWord1 = new \PhpOffice\PhpWord\TemplateProcessor('tamplate.docx');
$phpWord1->setValue('name_company', $name_company); 
// $document->setValue('d_date', '04.10.2014'); 
$phpWord1->setValue('fio', $fio); 
$phpWord1->setValue('address', $address);
$phpWord1->setValue('comment', $comment);
$phpWord1->saveAs('dogovor.docx');
$new_url='?stepTwo';
header('Location: '.$new_url);


}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Форма заполнения</title>
</head>
<body>
	<?
	if(!$_GET){
echo '<h3>Заполните форму для договора</h3>';
echo '<form method="POST">';
	echo '<p>Название организации: <input type="text" name="name_company" placeholder="ООО `Компания`"></p>';
	echo '<p>ФИО: <input type="text" name="fio" placeholder="Иванов Иван Иванович"></p>';
	echo '<p>Адрес: <input type="text" name="address" placeholder="г. Омск, ул. Ленина 20"></p>';
	echo '<p>Помещение будет использоваться под: <textarea name="comment"></textarea></p>';
		echo '<input type="submit" name="ok" value="Сохранить">';
	}
	echo '</form>';


if (isset($_GET['stepTwo'])) {
	echo "<a href='dogovor.docx'>Скачать заполненный договор</a>";
echo '<h3>Подпишите договор загрузите ниже</h3>';
echo '<form method="POST">';
echo '<p><input type="file" name="file" placeholder="ООО `Компания`"></p>';
		echo '<input type="submit" name="okfile" value="Отправить">';
echo '</form>';
}
if ($_POST['okfile']) {
	echo "Договор успешно отправлен!";
}
?>
</body>
</html>