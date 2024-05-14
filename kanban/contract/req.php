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
$phpWord1->saveAs('dogovor.pdf');


}
?>