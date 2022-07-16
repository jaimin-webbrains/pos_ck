<?php

class Functions {

    public static function redirect_to($url) {
        header("Location: " . $url);
        exit();
    }

    public static function output_result() {
        if (isset($_SESSION["error"])) {
            echo "<div class=\"alert alert-danger\" style=\"font-size:16px\"> <i class=\"fa fa-exclamation-circle\"></i> &nbsp; {$_SESSION["error"]} </div>";
            unset($_SESSION["error"]);
        }
        if (isset($_SESSION["message"])) {
            echo "<div class=\"alert alert-success\" style=\"font-size:16px\"> <i class=\"fa fa-check-circle\"></i>  &nbsp; {$_SESSION["message"]} </div>";
            unset($_SESSION["message"]);
        }
    }
    
    public static function custom_crypt($string, $action = 'e') {
        // you may change these values to your own
        $secret_key = $_SESSION["user"]["key"];
        $secret_iv = 'my_simple_secret_iv';

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'e') {
            $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        } else if ($action == 'd') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    public static function encrypt_string($password) {
        //2y means Bolwfish
        //10 means encryption method runs 10 times
        $hash_format = "$2y$10$";

        //salt must be 22 or more charactors
        $salt_length = 22;
        $salt = self::generate_salt($salt_length);
        $format_and_salt = $hash_format . $salt;
        $hash = crypt($password, $format_and_salt);
        return trim($hash);
    }

    public static function generate_salt($length) {
//        $unique_random_string=md5(uniqid(mt_srand(),true));
        $unique_random_string = md5("tmash14surper");
        $base64_string = base64_encode($unique_random_string);
        $modified_base64_string = str_replace('+', '.', $base64_string);
        $salt = substr($modified_base64_string, 0, $length);
        return $salt;
    }

    public static function check_password($password, $existing_hash) {
        $hash = crypt($password, $existing_hash);
        if ($hash === $existing_hash) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function check_login() {
        if (!(isset($_SESSION))) {
            session_start();
        }
        if (isset($_SESSION["user"]["id"]) && !empty($_SESSION["user"]["id"])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function attempt_login($username, $password) {
        $user = User::find_by_username($username);
        if ($user) {
            //found admin check password
            if (check_password($password, $user["hashed_password"])) {
                //password matches
                return TRUE;
            } else {
                //password does not match
                return FALSE;
            }
        } else {
            //user not found
            return FALSE;
        }
    }

    public static function confirm_logged_in() {
        if (!isset($_SESSION["user_id"])) {
            self::redirect_to("login.php");
        }
    }

    public static function logout_user() {
        $_SESSION["user_id"] = null;
        $_SESSION{"username"} = null;
        self::redirect_to("login.php");
    }

    public static function destroy_session() {
        session_start();
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        self::redirect_to("login.php");
    }

    public static function include_files($path) {
        $file_path = SITE_ROOT;
        foreach ($path as $folder) {
            $file_path .= DS . $folder;
        }
        include($file_path);
    }

//    public static function log_action($action,$message=""){
//        $logfile="../logs/log.txt";
//        $new= file_exists($logfile)?false:true;
//        if($handle= fopen($logfile, 'a')){
//            $timestamp= strtotime("%Y-%m-%d %H:%M:%S",time());
//            $content="{$timestamp} | {$action} : {$message}\n";
//            fwrite($handle, $content);
//            fclose($handle);
//            if($new){chmod($logfile, 0775);}
//        }else{
//            echo "Could not open log file for writing.";
//        }
//    }

    public static function clear_logfile($user) {
        require_once ("session.php");

        if ($session->is_logged_in()) {
            $logfile = "./../logs/log.txt";
            file_put_contents($logfile, '');
            self::log_action("Logs Cleared", "by UserID:{$session->user_id} Username:{$session->username}");
        } else {
            echo "Could not clear logs. user not logged in.";
        }
    }

    public static function print_r_value($value) {
        echo "<pre>";
        print_r($value);
        echo "</pre>";
    }

    public static function dateTimeDifference($old, $new) {
        $date1Timestamp = strtotime($old);
        $date2Timestamp = strtotime($new);
        $difference = $date2Timestamp - $date1Timestamp;
        return $difference;
    }

    public static function dateTimeDifferenceString($date_1, $date_2, $differenceFormat = '%a') {
        //////////////////////////////////////////////////////////////////////
        //PARA: Date Should In YYYY-MM-DD Format
        //RESULT FORMAT:
        // '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
        // '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
        // '%m Month %d Day'                                            =>  3 Month 14 Day
        // '%d Day %h Hours'                                            =>  14 Day 11 Hours
        // '%d Day'                                                        =>  14 Days
        // '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
        // '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
        // '%h Hours                                                    =>  11 Hours
        // '%a Days                                                        =>  468 Days
        //////////////////////////////////////////////////////////////////////

        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);
    }

    public static function get_privileges_by_module($module) {
        $user_privileges = [];
        global $session;
        if ($session->check_login()) {
            foreach ($_SESSION["user"]["privileges"] as $privilege) {
                if ($privilege["module_name"] == $module) {
                    $user_privileges[] = $privilege;
                }
            }
        }
        return $user_privileges;
    }

    public static function check_privilege_by_module_action($module, $action) {
        $result = false;   
        foreach (self::get_privileges_by_module($module) as $privilege) {
            if ($privilege["module_name"] == $module) {
                $result = $privilege[$action];
            }
        }
        return $result;
    }

    public static function check_privilege_redirect($module, $action, $path) {
        $privilege = self::check_privilege_by_module_action($module, $action);
        if ($privilege) {
            return true;
        } else {
            $_SESSION["error"] = "You have no Privileges for the operation.";
            self::redirect_to($path);
        }
    }

    public static function privilege_of_sel($module) {
        return self::check_privilege_by_module_action($module, "view");
    }

}

function __autoload($class_name) {
//    $class_name= strtolower($class_name);
    $path = "./../modal/{$class_name}.php";
    if (file_exists($path)) {
        require_once ($path);
    } else {
        die("The file {$class_name}.php could not be found.");
    }
}

$functions = new Functions();
?>