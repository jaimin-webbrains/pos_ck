<?php
session_start();
$message;

if (isset($_POST["submit"])) {

    if (!empty($_POST["username"]) && !empty($_POST["password"])) {

        $username = $_POST["username"];
        $password = $_POST["password"];
        
        if ($username=="admin" && $password=="123"){
            $_SESSION["userid"] = $row["id"];
//                $_SESSION["message"]="Successfully Logged In";
            header("Location:index.php");
        } else {
            $_SESSION["error"]="Username password does not match !";
            header("Location:login.php");
        }
    } else {
        $_SESSION["error"]="Username or password empty !";
        header("Location:login.php");
    }
} else {
    $_SESSION["error"]="Submission not ok !";
    header("Location:login.php");
}
?>


