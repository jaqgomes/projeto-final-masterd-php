<?php
class SessionService
{
    public static function logoutUser()
    {
        $_SESSION = [];
        session_destroy();
        header('Location: /projeto-final/index.php');
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public static function isRequireLogin()
    {
        if (!self::isLoggedIn()) {
            header('Location: /projeto-final/security/login.php');
            exit;
        }
    }
    
}
?>