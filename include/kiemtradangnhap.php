<?php 
    session_start();
    if (isset($_SESSION['dangnhap'])){

    }
    else{
        echo "
        <script> 
            alert('Vui lòng đăng nhập');
            window.location.href = 'login/login.php';
        </script>
        ";
    }

?>