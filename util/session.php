<?php

//require_once 'database.php';
//require_once 'functions.php';
require_once __DIR__ . '/initialize.php';

class Session {

    function __construct() {
        session_start();
    }

    public function check_login() {
        if (isset($_SESSION["user"]["id"]) && !empty($_SESSION["user"]["id"])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

//    public function attempt_login($username, $password){
//        global $database;
//        $username=$database->escape_value($username);
//        $password=$database->escape_value($password);
//        $enc_password= Functions::encrypt_string($password);
//        $found_user= User::authenticate($username, $enc_password);
//
//        if($found_user){
////            unset($_SESSION);
//            session_destroy();
//            session_start();
//            $this->login($found_user);
//            return TRUE;
//        }else{
//            //user not found
//            return FALSE;
//        }
//    }
    public static function check_password($password, $existing_hash) {
        $hash = crypt($password, $existing_hash);
        if ($hash === $existing_hash) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function attempt_login($username, $password) {
        $errors = array();
        $user = User::find_by_username($username);

        if ($user) {
            //found user check password
            if (self::check_password($password, $user->password)) {
                //return TRUE;
                self::login($user);
            } else {
                //return FALSE;
                //$errors[] = "Password does not match...!";
                $errors[] = "Username Password does not match...!";
            }
        } else {
            //return FALSE;
            //$errors[] = "User not found...";
            $errors[] = "Username Password does not match...!";
        }

        return $errors;
    }

    private static function login($user) {
        if ($user) {
            $_SESSION = "";
            session_destroy();
            unset($_SESSION);
            session_start();

            $sess_user = array();
            $sess_user["id"] = $user->id;
            $sess_user["username"] = $user->username;
            $sess_user["name"] = $user->name;
			$sess_user["email"] = $user->email;
            $sess_user["designation"] = $user->designation_id;
            $sess_user["time"] = date('Y-m-d H:i:s');
            $sess_user["privileges"] = self::get_privileges_by_user_id($user->id);

            $unique_random_string = md5(uniqid(mt_srand(), true));
            $base64_string = base64_encode($unique_random_string);
            $sess_user["key"] = $base64_string;

            $_SESSION["user"]=$sess_user;
            Activity::log_action("Login - '" . $user->username . "'");
        }
    }

    public static function set_privileges_by_user_id($user_id) {
        $_SESSION["user"]["privileges"]=self::get_privileges_by_user_id($user_id);
    }

    public static function get_privileges_by_user_id($user_id) {
        $user_privileges = array();
        if ($user_id) {
            $db_privileges = Privilege::find_all_by_user_id($user_id);
            foreach ($db_privileges as $privilege) {
                $privilege->module_name = $privilege->module_id()->name;
                $privilege->role_name = $privilege->role_id()->name;
               
                $user_privileges[] = $privilege->to_array_all();
            }
        }
        return $user_privileges;
    }

    public static function logout() {
        if (isset($_SESSION["user"]["id"]) && !empty($_SESSION["user"]["id"])) {
            Activity::log_action("Logout - '" . $_SESSION["user"]["username"] . "'");
        }

        self::unset_session();
    }

    public static function logout_and_redirect($error = "") {
        if (isset($_SESSION["user"]["id"]) && !empty($_SESSION["user"]["id"])) {
            Activity::log_action("Logout - '" . $_SESSION["user"]["username"] . "'");
        }

        self::unset_session();

        session_start();
        if (!empty($error)) {
            $_SESSION["error"] = $error;
        }
        Functions::redirect_to("login.php");
    }

    public static function authenticate_password($password) {
        $result = FALSE;

        if (isset($_SESSION["user"]["id"])) {
            $user = User::find_by_id($_SESSION["user"]["id"]);
            $enc_password = Functions::encrypt_string($password);
            if ($enc_password == $user->password) {
                $result = TRUE;
            }
        }

        return $result;
    }

//    public static function get_session() {
//        session_start();
//        $_SESSION[PROJECT_NAME]["user"]["id"] = "skdmnskmdksmd";
//        $session = &$_SESSION[PROJECT_NAME];
//        return $session;
//    }

    public static function unset_session() {
        $_SESSION = "";
        session_destroy();
        unset($_SESSION);
    }

}

$session = new Session();
?>
