<?php



class AuthenticatorController
{

    public function __construct($redirect)
    {
        if(!$this->checkIsLoggedIn()){
            header("Location: Register.php?redirect=$redirect");
        }
    }

    public function AdminPanel($redirect){
        if(!$this->isAdmin()){
            header("Location: Register.php?redirect=$redirect");
        }
    }

    private function checkIsLoggedIn()
    {
        if(!isset($_SESSION['authenticated']))
        {
            return false;
        }else{
            return true;
        }
    }

    private function isAdmin()
    {
        if(isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == true && $_SESSION['auth_user']['user_type'] == "Admin")
        {
            return true;
        }else{
            return false;
        }
    }
}

?>