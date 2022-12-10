<?php
include "../mongodb.php";

$bookName = '';
if (isset($_GET['bookName'])){
    $bookName = $_GET['bookName'];
}

$tableSach = $db->sach;
$a = $tableSach->find(['tensach'=>$bookName]);
$arrResult = $a->toArray();
$result =[];
if(count($arrResult)>0){
    $result=[
        "toaDoX"=>$arrResult[0]->toadox,
        "toaDoY"=>$arrResult[0]->toadoy,
    ];
}
// chổ này trả ra bên ajax là data nè
echo json_encode($result);
?>