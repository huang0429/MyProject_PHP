<?php


class DbConnect
{
    private $conn;
    
    function __construct()
    {
    }

    //資料庫連結
    function connect()
    {
        require_once 'Constants.php';

        // 連結mysql資料庫
        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // 連結有錯誤時
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // 返回連接 resource
        return $this->conn;
    }
}

?>