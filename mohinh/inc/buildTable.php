
<?php
    include "mohinh/mongodb.php";
    include "mohinh/inc/doiTuong.php";
    define("MAX_ROW", 39);
    define("MAX_COL", 85);


    $dbVatCan = $tableVatCan->find();
    foreach ($dbVatCan as $dataVatCan) {
        $Ctoadox= $dataVatCan["toadox"];
        $Ctoadoy= $dataVatCan["toadoy"]; 
        $vatCan[] = new vatCan($Ctoadox,$Ctoadoy);
    }
    
    // $dbSach = $tableSach->find();
    // foreach ($dbSach as $dataSach) {
    //     $mass= $dataSach["mass"];
    //     $Stoadox= $dataSach["toadox"];
    //     $Stoadoy= $dataSach["toadoy"];
    //     $trangthai= $dataSach["trangthai"]; 
    //     $sach[] = new sach($mass,$Stoadox,$Stoadoy,$trangthai);
    // }
    // $colors = array("red", "green", "blue", "yellow");
    // tim trong csdl ra duoc toa do x,y
    function constructTable(){
        $table= [[]];
        for($row=0; $row< MAX_ROW; $row++){
            for($col=0; $col < MAX_COL; $col++){
                $table[$row][$col]= 0;
            }
        }
        
        $a = new matPhang($table);
        foreach ($GLOBALS['vatCan'] as $value){
            $a->themVatCan($value);
        }

        // foreach ($GLOBALS['sach'] as $value){
        //     $a->themSach($value);
        // }
        return $a;
    }





    function showTable(matPhang $mult){
        $a = $mult->getMp();
        for($row=0; $row< MAX_ROW; $row++){
            echo "<tr>";
            for($col=0; $col < MAX_COL; $col++){
                if ($a[$row][$col]==-1)
                    echo "<td id='$row-$col' class='duongDi'>"."</td>";
                        // lấy từ get a = id;
                        // lấy x lấy y từ đối tượng sách mà id = a
                        // $a[$x][$y] gắn class vào
                elseif ($a[$row][$col] == 1)
                    echo "<td id='$row-$col' class='vatCan'>"."</td>";
                elseif ($a[$row][$col] == 0)
                    echo "<td id='$row-$col'>"."</td>";
                // else 
                //     echo "<td id='td_$row-$col'>"."</td>";

            }
            echo "</tr>";
        }
    }
    // cong việc
    // tao csdl search = id (1) 
    // đọc từ csdl add sách lên như bình thường (2)
    // 

    function buildTable(){
        for($row=1; $row<= MAX_ROW; $row++){
            echo "<tr>";
            for($col=1; $col <= MAX_COL; $col++){
                echo "<td>" . ($col * $row) . "</td>";
            }
            echo "</tr>";
        }
    }

    function createFile(matPhang $a){
        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        foreach ($a->getMp() as $values){
            $temp = '';
            foreach ($values as $value){
                if ($value == 0 || $value == 1)
                    $temp = $temp.$value;
                else
                $temp = $temp.'0';

            }
            $temp = $temp."\n" ;
            // if ($values === array_key_first($array)) {
            //     echo 'FIRST ELEMENT!';
            // }
            fwrite($myfile, $temp);
        }
        fclose($myfile);
    }
    function inMang($a){
        foreach ($a as $values){
            foreach ($values as $value){
                echo $value;
            }
            echo "<br>";
        }
    }

    function bodoi(string $x, string $y){
        $doge = ghiFileKQ($x,$y);
        $myfile = fopen("ketqua.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $doge);   
        $array = explode("\n", file_get_contents('ketqua.txt'));
        $tong = [];
        foreach ($array as $values){
            $test = str_split($values,1);
            array_push($tong,$test);
        }
        $canLay = array();
        for ($i = 0 ; $i<count($tong) ; $i++){
            for ($j = 0; $j<count($tong[$i]); $j++){
                if ($tong[$i][$j] == '.'){
                    // echo $i."+".$j;
                    // echo "<br>";
                    $temp = array($i,$j);
                    array_push($canLay,$temp);
                }
            }
        }
        return $canLay;
    }

    function addST($x, $y,$a, $b){
        $array = explode("\n", file_get_contents('newfile.txt'));
        $tong = [];
        foreach ($array as $values){
            $test = str_split($values,1);
            array_push($tong,$test);
        }
        $tong[$a][$b] = 'T';
        $tong[$x][$y] = 'S';
        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        foreach ($tong as $values){
            $temp = '';
            foreach ($values as $value){
                $temp = $temp.$value;
            }
            $temp = $temp."\n" ;
            fwrite($myfile, $temp);

        }
        fclose($myfile);
    }
    //tìm vi tri sách thay đổi theo thời gian
    //R1(x1,y1,r1)
    function trackPhone($x1,$y1,$r1,$x2,$y2,$r2,$x3,$y3,$r3){
        // $r1=$r2=$r3 = 1;
        $A = 2*$x2 - 2*$x1;
        $B = 2*$y2 - 2*$y1;
        $C = $r1**2 - $r2**2 - $x1**2 + $x2**2 - $y1**2 + $y2**2;
        $D = 2*$x3 - 2*$x2;
        $E = 2*$y3 - 2*$y2;
        $F = $r2**2 - $r3**2 - $x2**2 + $x3**2 - $y2**2 + $y3**2;
        $x = ($C*$E - $F*$B) / ($E*$A - $B*$D);
        $y = ($C*$D - $A*$F) / ($B*$D - $A*$E);
        // giao điểm 3 đường tròn
        // echo($x);
        // echo($y);
    }
        
?>