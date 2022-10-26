<?php

class DbOperation
{
    private $conn;

    function __construct()
    {
        require_once dirname(__FILE__) . '/Constants.php';
        require_once dirname(__FILE__) . '/DbConnect.php';
        // 打開資料庫連接
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    /*
     * 增加了這個方法
     * 我們正在使用用戶名和密碼
     * 然後從數據庫中驗證它
     * */

    public function userLogin($username, $pass)
    {
        $password = md5($pass);
        $stmt = $this->conn->prepare("SELECT users_ID FROM users WHERE users_name = ? AND users_password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    /*
     * 登錄成功後我們會調用這個方法
     * 此方法將返回數組中的用戶數據
     */
    
    public function getUserByUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT users_ID, users_name, users_email, users_phone, users_chineseName FROM users WHERE users_name = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $name, $email, $phone, $chineseName);
        $stmt->fetch();
        $user = array();
        $user['users_ID'] = $id;
        $user['users_name'] = $name;
        $user['users_email'] = $email;
        $user['users_phone'] = $phone;
        $user['users_chineseName'] = $chineseName;
        
        return $user;
    }

    // 新增使用者
    public function createUser($username, $pass, $email, $name, $phone)
    {
        if (!$this->isUserExist($username, $email, $phone)) {
            $password = md5($pass);
            $stmt = $this->conn->prepare("INSERT INTO users (users_name, users_password, users_email, users_chineseName, users_phone) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $password, $email, $name, $phone);
            if ($stmt->execute()) {
                return USER_CREATED;
            } else {
                return USER_NOT_CREATED;
            }
        } else {
            return USER_ALREADY_EXIST;
        }
    }


    private function isUserExist($username, $email, $phone)
    {
        $stmt = $this->conn->prepare("SELECT users_ID FROM users WHERE users_name = ? OR users_email = ? OR users_phone = ?");
        $stmt->bind_param("sss", $username, $email, $phone);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
}

?>