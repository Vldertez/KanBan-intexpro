<?
include('connect.php');
if($_GET){
    if (count($_GET)>1){
    $where = [];
    foreach ($_GET as $key => $val) {
        if ($key !== 'table'){
            $where[$key][]='=';  
            $where[$key][]=$val;  
        }
    }
} else {
    $where = NULL;
}

    include "generate_sql.php";
$req = getRecords($_GET['table'], $what=array('*'),$where, $limit=NULL, $order=NULL,$join=NULL,$debug=false);
$result = mysqli_query($link, $req);
$data = array();
while($row = mysqli_fetch_assoc($result))
$data[] = $row;

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