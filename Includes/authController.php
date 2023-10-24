<?php



class AuthenticatorController
{

    public function __construct()
    {
        if(!$this->checkIsLoggedIn()){
            header('Location: Register.php');
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