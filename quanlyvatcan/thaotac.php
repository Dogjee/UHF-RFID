<?php
    require "../mohinh/mongodb.php";
    session_start();    // them Vatcan
    if(isset($_POST['themvatcan'])){
        $tableVatCan = $db->vatcan;
        $toadoxvatcan = $_POST['toadoxvatcan'];
        $toadoyvatcan = $_POST['toadoyvatcan'];
        $insertvatcan = array(
            "toadox" => (int)$toadoxvatcan,
            "toadoy" => (int)$toadoyvatcan
        );

        $tableVatCan->insertOne($insertvatcan);
        echo "<script> 
                alert('thêm thành công');
                window.location.href = '../index4.php';
            </script>";
    }
    
    //xoa VatCan
    // if (isset($_GET['xoavatcan'])){
    //     $idvatcan = $_GET['xoavatcan'];
    //     $tableVatCan = $db ->vatcan;
    //     // $xoaRFID = $tableRfid->find("ms" => $msRFID);   
    //     $delerfid=$tableRfid->deleteOne(['_id'=>new MongoDB\BSON\ObjectID($idvatcan)]);
    //     print($delerfid->getDeletedCount());
    //     // header("Location:../index4.php");
    //     // echo "<script> 
    //     //         alert('xóa thành công');
    //     //         window.location.href = '../index4.php';
    //     //     </script>";

    // }
        if (isset($_GET['xoa'])){
            $toadox = $_GET['toadox'];
            $toadoy = $_GET['toadoy'];
            // echo $toadox;
            // echo "<br>";
            // echo $toadoy;
            $tableVatCan = $db->vatcan;
            $deleteResult = $tableVatCan->deleteOne(['toadox' => (int)$toadox, 'toadoy' => (int)$toadoy]);
            // printf("Deleted %d document(s)\n", $deleteResult->getDeletedCount()); 
            echo "<script> 
                alert('Xóa thành công');
                window.location.href = '../index4.php';
                </script>";
        }

        


    //cap nhat vatcan
    if (isset($_POST['capnhat'])){
        // // unset($_SESSION);
        $xvatcancu = $_SESSION['vatcanx'];
        $yvatcancu = $_SESSION['vatcany'];

        // $id_capnhatrfid=$_POST['ms'];
        $xvatcan = $_POST['toadoxvatcan'];
        $yvatcan = $_POST['toadoyvatcan'];
        

        $tableVatcan = $db ->vatcan;
        $updateVatcan = $tableVatcan->updateOne(["toadox"=>(int)$xvatcancu, "toadoy" => (int)$yvatcancu], 
            ['$set'=>['toadox'=>(int)$xvatcan, 'toadoy'=>(int)$yvatcan]]);
        // printf($updateVatcan->getMatchedCount());
        unset($_SESSION);
        echo "<script> 
        alert('cập nhật thành công');
        window.location.href = '../index4.php';
        </script>";
    
    }
?>