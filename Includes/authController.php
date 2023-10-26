<?php



class AuthenticatorController
{

    public function __construct($redirect)
    {
        if(!$this->checkIsLoggedIn()){
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
}

?>