<?php
    include "mohinh/inc/buildTable.php";
    require "mohinh/so/index.php";
    $mult = constructTable();       
    createFile($mult);

$tensach = '';
if(isset($_POST['timduongdingannhat'])){
    $idS=$_POST['idsach'];
    if(is_numeric($idS)){
        // tim đường đi ngắn nhất bằng mã số sách 
        $tableSach = $db->sach;
        $a = $tableSach->find(['mass' => (int)$idS]);
        $toadox ='';
        $toadoy ='';
        foreach ($a as $mss){
            $toadox=$mss['toadox'];
            $toadoy=$mss['toadoy'];
        }
        // var_dump($toadox);
        addST(4,71,$toadox,$toadoy);
        $duongDi = bodoi('S','T');
        foreach ($duongDi as $values){
            $a = new duongDi($values[0],$values[1]);
            $mult->themDuongDi($a);
        }
    }
    if(is_string($idS)){
        // tim đường đi ngắn nhất bằng tên sách
        $tableSach = $db->sach;
        // $a = $tableSach->find(['tensach' => $idS]);
        $a = $tableSach->find(['tensach'=> new MongoDB\BSON\Regex($idS, 'i')]);
        $toadox ='';
        $toadoy ='';
        foreach ($a as $mss){
            $toadox=$mss['toadox'];
            $toadoy=$mss['toadoy'];
        }
        addST(4,71,$toadox,$toadoy);
        $duongDi = bodoi('S','T');
        foreach ($duongDi as $values){
            $a = new duongDi($values[0],$values[1]);
            $mult->themDuongDi($a);
        }
    }
    
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="mohinh/jQuery/jquery-3.5.1.min.js"> </script> 
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <title>multiplcation table</title>
    <style>
        .test{
            /* background-color: red; */
        }
        /* doi code nay */
        table {
            /* background-color: black; */
            border: 1px solid red;
            background-image: url("mohinh/thuvien.png"); 
            background-repeat: no-repeat;
            background-size: auto;
            border-collapse: unset !important;
        }
        td{
            /* background-color: white; */
            padding: 0px;
            width: 10px;
            height: 15px;
            text-align: center;
        }
        /* .colortd{
            background-color: blue;
        } */
        
        .btn{
            background-color: #E5E5E5; 
            border: none;
            color: red;
            /* padding: 15px 32px; */
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 1,5rem;
            margin-left: 120px;

        }
        .rowbtn{
            align-items: center;
            justify-content: center;
        }
        .colortd{
            background-image: url("mohinh/colorcell.png");
            background-repeat: no-repeat; 
            animation: mymove 0.5s infinite;
            position: relative;
        }
        .cirle {
            width: 35px;
            height: 31px;
            border-radius: 50%;
            border: 1px solid black;
            position: absolute;
            top: 1px;
            left: 1px;
            transform: translate(-40%, -40%);
        }
        .cirle1{
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 1px solid red;
            position: absolute;
            top: 0;
            left: 0;
            transform: translate(-45%, -45%);
        }
        .cirle2{
            /* width: 80px; */
            /* height: 80px;
             */
            width: 62px;
            height: 68px;
            border-radius: 50%;
            border: 1px solid blue;
            position: absolute;
            top: 0;
            left: 0;
            transform: translate(-42%, -42%);
        }

        @keyframes mymove {
            from {background-image: url("mohinh/duongdi.png");}
            to {background-image: url("mohinh/colorcell.png");}
        }
        .vatCan{
            /* background-color: darkgray; */
        }
        /* doi code nay */
        .duongDi{
            /* background-color: black; */
            background-image: url("mohinh/duongdi.png");
            background-repeat: no-repeat;
            /* background-position: right top;
            background-repeat: no-repeat;
            background-size: auto; */
        }
        .br{
            /* background-image: url("thuvien.png");  */
            /* width: auto;
            height:auto; */
        }
    </style>
</head>

<body>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h4>Tìm vị trí </h4>
                <form action="" method="post">
                    <input type="text" name='tensach' id='tensach' placeholder="Tên sách" required>
                    <input type="submit"  value="Tìm" name='search'>
                    <input type="button" id="btnTalk" value="Voice">
                </form>
            </div>
        
            <div class="col-md-6">
                <h4>Tìm đường đi </h4>
                <form action="" method="post">
                    <input type="text" name='idsach' id="duongdingannhat" placeholder="Tên sách" required>
                    <input type="submit" name="timduongdingannhat" value="Tìm">
                    <div onClick='reloadPage()' class='btn'>Tìm lại</div>
                </form>
            </div>
        </div>
    </div>
    
    <br>
    <div class='br '>
        <table id="map" class="col-sm-12" style="min-height:665px; width: 1023px" >
            <?php
                showTable($mult);
                //tìm giao điểm 3 đường tròn
                trackPhone(0,0,3.5,10,10,3.5,0,5,3.5);
            ?>
            
        </table>
        <input type="hidden" id="currentBook" value="">
        <input type="hidden" id="currentBook1" value="">
        <input type="hidden" id="currentBook2" value="">
        <br>
    </div>
    
</body>
</html>
<script>

    // tạo mới trang
    function reloadPage(){
        window.location.href = 'index.php';
    }
    //css vi tri sach khi có 3 hoac lon hon 3 rfid bat duoc
    function cssCell(x, y) {
        $('td').each(function () {
            $(this).removeClass('colortd');
            $(this).html('')
        });
        // var a= document.getElementById(x+'-'+y);
        // console.log(a);
        let positionResponse = $('#'+x+'-'+y);
        positionResponse.addClass('colortd');
        positionResponse.append('<div class="cirle"></div>')
        // var a = document.getElementById('td_'+x+'-'+y);
        // a.classList.add('colortd');        
        // $(this).css("position", "relative");
        // alert(''#td_'+x+'-'+y');
    };
    //  hàm gọi mỗi phut 1 lần để lấy vitri của sách hien tại
    const intervalID = setInterval(function () 
    {
        if($('#currentBook').val()){
            $.ajax({
            url: 'http://localhost/MoHinhThuVien/mohinh/book/getCurrentPosition.php?bookName='+$('#currentBook').val(),
           
            success: function (data, status, xhr) {
                var position = JSON.parse(data);
                cssCell(position.toaDoX,position.toaDoY);
            }
        });
        }

    }, 5000);
    // css vi tri sach khi co 1 rfid bat duoc
    function cssCell1(x, y) {
        $('td').each(function () {
            $(this).removeClass('colortd');
            $(this).html('')
        });
        let positionResponse = $('#'+x+'-'+y);
        positionResponse.addClass('colortd');
        positionResponse.append('<div class="cirle1"></div>');
    };
    const intervalID1 = setInterval(function () 
    {
        if($('#currentBook1').val()){
            $.ajax({
            url: 'http://localhost/MoHinhThuVien/mohinh/book/getCurrentPosition.php?bookName='+$('#currentBook1').val(),
           
            success: function (data, status, xhr) {
                var position = JSON.parse(data);
                cssCell1(position.toaDoX,position.toaDoY);
            }
        });
        }

    }, 5000);
    // css vi tri sach khi co 2 rfid bat duoc
    function cssCell2(x, y) {
        $('td').each(function () {
            $(this).removeClass('colortd');
            $(this).html('')
        });
        let positionResponse = $('#'+x+'-'+y);
        positionResponse.addClass('colortd');
        positionResponse.append('<div class="cirle2"></div>')
    };
    const intervalID2 = setInterval(function () 
    {
        if($('#currentBook2').val()){
            $.ajax({
            url: 'http://localhost/MoHinhThuVien/mohinh/book/getCurrentPosition.php?bookName='+$('#currentBook2').val(),
           
            success: function (data, status, xhr) {
                var position = JSON.parse(data);
                cssCell2(position.toaDoX,position.toaDoY);
            }
        });
        }

    }, 5000);

</script>

<?php
    
    // tìm sách bằng tên sách
    if(isset($_POST['search'])){
        $tensach=$_POST['tensach'];
        $tableSach = $db->sach;
        $dbSach = $tableSach->find(['tensach'=> new MongoDB\BSON\Regex($tensach, 'i')]);
        // print_r($dbSach);
        $cor = 0;
        foreach ($dbSach as $ten){
            $toadoxS=$ten['toadox'];
            $toadoyS=$ten['toadoy'];
            $sofrfid=$ten['sorfid'];
            $cor = 1;
            if($sofrfid==1){
                // co 1 thang rfid bat
                echo "
                <script>
                    cssCell1($toadoxS,$toadoyS);
                    $('#currentBook1').val('".$tensach."');
                </script>
                ";
            }elseif($sofrfid==2){
                // co 2 thang rfid bat
                echo "
                <script>
                    cssCell2($toadoxS,$toadoyS);
                    $('#currentBook2').val('".$tensach."');
                </script>
                ";
            }else{
                // co 3 hoac lon hon 3 thang rfid bat
                echo "
                <script>
                    cssCell($toadoxS,$toadoyS);
                    $('#currentBook').val('".$tensach."');
                </script>
                ";
            }
            
        }
        if ($cor==0){
            echo "
            <script>
                alert('Không tìm thấy sách yêu cầu');
            </script>
            ";
        }
    }
    // tìm sách bằng mã số sách
    // if(isset($_POST['search'])){
    //     $mass=$_POST['tensach'];
    //     $tableSach = $db->sach;
    //     $dbSach = $tableSach->find(['mass'=>(int)$mass]);
    //     // echo $dbSach;
    //     foreach ($dbSach as $ten){
    //         $toadoxS=$ten['toadox'];
    //         $toadoyS=$ten['toadoy'];
    //         echo "
    //         <script>
    //             cssCell($toadoxS,$toadoyS);
    //             // alert('hello');
    //         </script>
    //         ";
    //     }

    // }
    
?>
    <!-- update csdl  -->
<?php
    $tensach = '';
    if(isset($_POST['timduongdingannhat'])){
        $idS=$_POST['idsach'];
        if(is_numeric($idS)){
            // tim đường đi ngắn nhất bằng mã số sách 
            $tableSach = $db->sach;
            $a = $tableSach->find(['mass' => (int)$idS]);
            $toadox ='';
            $toadoy ='';
            foreach ($a as $mss){
                $toadox=$mss['toadox'];
                $toadoy=$mss['toadoy'];
            }
            // var_dump($toadox);
            addST(4,71,$toadox,$toadoy);
            $duongDi = bodoi('S','T');
            foreach ($duongDi as $values){
                $a = new duongDi($values[0],$values[1]);
                $mult->themDuongDi($a);
            }
        }
        if(is_string($idS)){
            // tim đường đi ngắn nhất bằng tên sách
            $tableSach = $db->sach;
            // $a = $tableSach->find(['tensach' => $idS]);
            $a = $tableSach->find(['tensach'=> new MongoDB\BSON\Regex($idS, 'i')]);
            $toadox ='';
            $toadoy ='';
            foreach ($a as $mss){
                $toadox=$mss['toadox'];
                $toadoy=$mss['toadoy'];
                $sofrfid=$mss['sorfid'];
                if($sofrfid==1){
                    // co 1 thang rfid bat
                    echo "
                    <script>
                        cssCell1($toadox,$toadoy);
                        $('#currentBook1').val('".$idS."');
                    </script>
                    ";
                }elseif($sofrfid==2){
                    // co 2 thang rfid bat
                    echo "
                    <script>
                        cssCell2($toadox,$toadoy);
                        $('#currentBook2').val('".$idS."');
                    </script>
                    ";
                }else{
                    // co 3 hoac lon hon 3 thang rfid bat
                    echo "
                    <script>
                        cssCell($toadox,$toadoy);
                        $('#currentBook').val('".$idS."');
                    </script>
                    ";
                }
        }
    }
    }
?>

<!-- Giong noi -->
<script>
        var message = document.querySelector('#tensach');
        var message2 = document.querySelector('#duongdingannhat');
        var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
        var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList;

        var grammar = '#JSGF V1.0;'

        var recognition = new SpeechRecognition();
        var speechRecognitionList = new SpeechGrammarList();
        speechRecognitionList.addFromString(grammar, 1);
        recognition.grammars = speechRecognitionList;
        recognition.lang = 'vi-VN';
        recognition.interimResults = false;

        recognition.onresult = function(event) {
            var lastResult = event.results.length - 1;
            var content = event.results[lastResult][0].transcript;
            message.value = content.slice(0,content.length-1);
            message2.value = content.slice(0,content.length-1);
        };

        recognition.onspeechend = function() {
            recognition.stop();
        };

        recognition.onerror = function(event) {
            message.value = 'Có lỗi về nhận dạng giọng nói ' + event.error;
            message2.value = 'Có lỗi về nhận dạng giọng nói ' + event.error;
        }

        document.querySelector('#btnTalk').addEventListener('click', function(){
            recognition.start();
        });
</script>