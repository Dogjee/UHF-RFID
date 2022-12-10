<?php
    require_once __DIR__.'\vendor\autoload.php'; 
    $connection = new MongoDB\Client("mongodb://localhost:27017");
    $db = $connection->mohinh;
    $tableSach = $db->sach;
    $tableVatCan = $db->vatcan;

?>