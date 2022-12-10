<?php 
    session_start();
    require "../mohinh/mongodb.php";
    $username = $_POST['username'];
    $password = $_POST['password'];

    $tableAccount = $db->account;
    $cursor1 = $tableAccount->find(); 
    $user = $db->account->findOne(array('username'=> $username, 'password'=> $password));
    if ($user){
        $_SESSION['dangnhap'] = 1;
        echo "
            <script>
                alert('Dang nhap thanh cong');
                window.location.href = '../index3.php';
            </script>
        ";
    }
    else{
        echo "
            <script>
                alert('Sai tai khoan hoac mat khau');
                window.location.href = '../login.php';
            </script>
        ";
    }
    // unset($_SESSION);
    // session_destroy();
    
?>