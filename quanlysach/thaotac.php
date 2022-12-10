<?php
    require "../mohinh/mongodb.php";

    // them Sach
    if(isset($_POST['themsach'])){
        $tableSach = $db->sach;

        $mss= $_POST['mass'];
        $tens= $_POST['tensach'];
        $trangthais= $_POST['trangthai'];
        $motas= $_POST['mota'];
        $toadoxs = $_POST['toadoxsach'];
        $toadoys = $_POST['toadoysach'];
        $inserts = array(
            "mass" => (int)$mss,
            "tensach" => $tens,
            "trangthai" => $trangthais,
            "mota" => $motas,
            "toadox" => (int)$toadoxs,
            "toadoy" => (int)$toadoys
        );

        $tableSach->insertOne($inserts);
        // header("Location:../index3.php");
        echo "<script> 
                alert('thêm thành công');
                window.location.href = '../index5.php';
            </script>";
    }
    
    //xoa sach
    if (isset($_GET['xoasach'])){
        $mss = $_GET['xoasach'];
        $tableSach = $db ->sach;
        // $xoaRFID = $tableRfid->find("ms" => $msRFID);   
        $delesach=$tableSach->deleteOne(["mass"=>(int)$mss]);
        // print($delesach->getDeletedCount());
        // header("Location:../index3.php");
        echo "<script> 
                alert('xóa thành công');
                window.location.href = '../index5.php';
            </script>";

    }

    //cap nhat sach
    if (isset($_POST['capnhat'])){
        $id_capnhatsach=$_POST['mass'];

        $tens= $_POST['tensach'];
        $trangthais= $_POST['trangthai'];
        $motas= $_POST['mota'];
        $toadoxs = $_POST['toadoxsach'];
        $toadoys = $_POST['toadoysach'];



        $tableSach = $db ->sach;
        $updatesach = $tableSach->updateOne(["mass"=>(int)$id_capnhatsach], 
            ['$set'=>['mass'=>(int)$id_capnhatsach,'tensach'=>$tens, 'trangthai'=>$trangthais, 'mota'=>$motas, 'toadox'=>(int)$toadoxs, 'toadoy'=>(int)$toadoys]]);
        // printf($updaterfid->getMatchedCount());
        echo "<script> 
        alert('cập nhật thành công');
        window.location.href = '../index5.php';
        </script>";
    
    }
    
        
?>