<?php

class RegisterController 
{
    public function __construct()
    {
        $db = new DatabaseConnection;
        $this->conn = $db->conn;
    }

    public function registration($name, $email, $password, $regDate)
{
    $register_query = "INSERT INTO users (UserEmail, UserName, UserPassword, UserType, RegDate) VALUES (?, ?, ?, 'User', ?)";
    $stmt = $this->conn->prepare($register_query);
    $stmt->bind_param("ssss",$email,$name, $password, $regDate);
    $result = $stmt->execute();
    return $result;
}

public function isEmailExist($email)
{
    $checkEmail = "SELECT UserEmail FROM users WHERE UserEmail = ? LIMIT 1";
    $stmt = $this->conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

public function isUsernameExist($name)
{
    $checkName = "SELECT UserName FROM users WHERE UserName = ? LIMIT 1";
    $stmt = $this->conn->prepare($checkName);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}  

public function isMaxChar15($name){
    return strlen($name) >15;
}
}

class LoginController   
{
    public function __construct()
    {
        $db = new DatabaseConnection;
        $this->conn = $db->conn;
    }

    public function login($email, $password)
{
    $login_query = "SELECT UserID, UserEmail, UserName, UserPassword, UserType FROM users WHERE UserEmail = ? LIMIT 1";
    $stmt = $this->conn->prepare($login_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        if (password_verify($password, $data['UserPassword'])) {
            $this->userAuthentication($data);
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

    private function userAuthentication($data)
    {
        $_SESSION['authenticated'] = true;
        $_SESSION['auth_user'] = [
            'user_id' => $data['UserID'],
            'user_name' => $data['UserName'],
            'user_email' => $data['UserEmail'],
            'user_type' => $data['UserType']
        ];
    }

    public function logout()
{
    if ($_SESSION['authenticated']) {
        session_unset();
        session_destroy(); 
        return true;
    } else {
        return false;
    }
}

public function editUserType($userID, $typeChange){
    $edit_query = "UPDATE users
        SET UserType = ?
        WHERE UserID = ?";

    $stmt = $this->conn->prepare($edit_query);
    $stmt->bind_param("ss", $typeChange, $userID);

    $result = $stmt->execute();
    $stmt->close();

    return $result;
}
}
