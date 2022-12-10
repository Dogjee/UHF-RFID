<?php
    require "../mohinh/mongodb.php";

    // them RFID
    if(isset($_POST['themrfid'])){
        $tableRfid = $db->rfid;

        $ms= $_POST['ms'];
        $toadoxrfid = $_POST['toadoxrfid'];
        $toadoyrfid = $_POST['toadoyrfid'];
        $insertrfid = array(
            "ms" => (int)$ms,
            "xrfid" => (int)$toadoxrfid,
            "yrfid" => (int)$toadoyrfid
        );

        $tableRfid->insertOne($insertrfid);
        // header("Location:../index3.php");
        echo "<script> 
                alert('thêm thành công');
                window.location.href = '../index3.php';
            </script>";
    }
    
    //xoa RFID
    if (isset($_GET['xoarfid'])){
        $msRFID = $_GET['xoarfid'];
        $tableRfid = $db ->rfid;
        // $xoaRFID = $tableRfid->find("ms" => $msRFID);   
        $delerfid=$tableRfid->deleteOne(["ms"=>$msRFID]);
        print($delerfid->getDeletedCount());
        // header("Location:../index3.php");
        echo "<script> 
                alert('xóa thành công');
                window.location.href = '../index3.php';
            </script>";

    }

    //cap nhat RFID
    // if (isset($_GET['capnhatrfid'])){
    //     $_SESSION['capnhatrfid']=$_GET['capnhatrfid'];
    //     // $tableRfid = $db ->rfid;
    //     // print($_SESSION['capnhatrfid']);
    //     echo "<script> 
    //     window.location.href = '../index3.php';
    //     </script>";
    // $id_capnhat=$_SESSION['capnhatrfid'];
    // // print($id_capnhat);
    // $tableRfid = $db->rfid;
    

    if (isset($_POST['capnhat'])){
        $id_capnhatrfid=$_POST['ms'];
        $xr = $_POST['toadoxrfid'];
        $yr = $_POST['toadoyrfid'];
        
        $tableRfid = $db ->rfid;
        $updaterfid = $tableRfid->updateOne(["ms"=>(int)$id_capnhatrfid], 
            ['$set'=>['ms'=>(int)$id_capnhatrfid, 'xrfid'=>(int)$xr, 'yrfid'=>(int)$yr]]);
        // printf($updaterfid->getMatchedCount());
        echo "<script> 
        alert('cập nhật thành công');
        window.location.href = '../index3.php';
        </script>";
    
    }
        
?>