<?
var_dump($_POST);
include('connect.php');
if($_POST['okexportpay']){
	$datebig=$_POST['datebig'];
	$dateend=$_POST['dateend'];
$result = mysqli_query($link, "SELECT * FROM `pay-old`");
$pay = array();
while($row = mysqli_fetch_assoc($result))
$pay[] = $row;
$result = mysqli_query($link, "SELECT * FROM `users`");
$users = array();
while($row = mysqli_fetch_assoc($result))
 $users[$row['id']] = $row;
 $result = mysqli_query($link, "SELECT * FROM `groupuser`");
$groups = array();
while($row = mysqli_fetch_assoc($result))
$groups[$row['id']] = $row;
require_once("PHPExcel/Classes/PHPExcel.php");
require_once('PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');
require_once('PHPExcel/Classes/PHPExcel/IOFactory.php');
$objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Дата платежа');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'ФИО');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Группа');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Сумма платежа');
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Стоимость занятия');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Количество занятий');
    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Тип оплаты');
    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Способ оплаты');
    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Дата периода оплаты');	
    $num=2;		
 for ($i=0; $i < count($pay); $i++) { 
 		if ($pay[$i]['datepay']>=$datebig && $pay[$i]['datepay']<=$dateend) {
 			
 		if ($pay[$i]['way']=='B'){
 			$type='Безнал';
 		}else if ($pay[$i]['way']=='Q'){
 			$type='QR';
 		} else {
 			$type='Наличные';
 		}
		if ($pay[$i]['type']=='A'){
 			$way='Абонемент';
 		} else {
 			$way='Разовое';
 		}		
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$num, $pay[$i]['datepay']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$num, $users[$pay[$i]['iduser']]['fio']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$num, $groups[$pay[$i]['namegroup']]['name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$num, $pay[$i]['sumpay']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$num, $pay[$i]['sumpayone']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$num, $pay[$i]['countless']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$num, $type);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$num, $way);
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$num, $pay[$i]['datebegin']);
        $num++;
        }
     }
     
     date_default_timezone_set('Европа/Город');
header('Content-Type: application/vnd.ms-excel');
 header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="userList.xls"');
$objWriter->save('php://output');
exit;
 }


if ($_POST) { 
    echo "3";
$data = $_POST;
    require_once("PHPExcel/Classes/PHPExcel.php");
    require_once('PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');
    require_once('PHPExcel/Classes/PHPExcel/IOFactory.php');
    $en = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $n = 0;
        foreach ($data[0] as $key => $val){
        $objPHPExcel->getActiveSheet()->SetCellValue($en[$n].'1', $key);
        $n++;
    }
               
     for ($i=0; $i < count($data); $i++) { 	
        $num=0;
        foreach ($data[$i] as $val){
            $objPHPExcel->getActiveSheet()->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($num).($i+2), $val);
            $num++;
        }
            
         }
         
         date_default_timezone_set('Европа/Город');
    header('Content-Type: application/vnd.ms-excel');
     header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="userList.xls"');
    $objWriter->save('php://output');
    exit;
     }
     

?>