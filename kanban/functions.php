<?
include "connect.php";
function nowYear()
{
    if (isset($_GET['year'])) {
        $year=$_GET['year'];
   }else {
       $d = getdate();
       $m=$d['mon']; 
       if ($m <=7) {
           $year=$d['year']-1 ;
       }else {
           $year= $d['year'];
       }
   };
   return $year;
}

function printselect($table, $field, $order, $selected) {
    include "connect.php";
    $result = mysqli_query($link, getRecords($table, array("DISTINCT ". $field), NULL, NULL, array($field => $order),$table,NULL));
    $html = '<option></option>';
    while($row = mysqli_fetch_assoc($result)) {
        if ($selected != NULL && $row[$field] ==$selected ){
        $html.= '<option selected>'.$row[$field].'</option>';
        } else {
            $html.= '<option>'.$row[$field].'</option>';
        }
    }
    
    return $html;
}
function printselect_id($table, $field, $order, $selected) {
    include "connect.php";
     getRecords($table, array('id', $field), NULL, NULL, array($field => $order),$table,NULL);
    $result = mysqli_query($link, getRecords($table, array('id', $field), NULL, NULL, $order, $table, NULL));
    $html = '<option></option>';
    while($row = mysqli_fetch_assoc($result)) {
        // var_dump(mysqli_fetch_assoc($result));
        if ($selected != NULL && $row[$selected[0]] == $selected[1] ){
            $html.= '<option value='.$row['id'].' selected>'.$row[$field].'</option>';
        } else {
            $html.= '<option value='.$row['id'].'>'.$row[$field].'</option>';
        }
    }
    return $html;
}


function curl_sql($array) {
    $array = json_encode($array);
    echo "2";
    $c = curl_init ('export.php');
    curl_setopt ($c, CURLOPT_POST, true);
    curl_setopt ($c, CURLOPT_POSTFIELDS, $array);
    curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4); 
    $page = curl_exec ($c);
    $error = curl_error($c);
    curl_close ($c);
 
    // $res = json_encode($res, JSON_UNESCAPED_UNICODE);
    var_dump($page);
    var_dump($error);
    // return $page;
}

?>