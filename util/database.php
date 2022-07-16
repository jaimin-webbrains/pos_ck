<?php

require_once __DIR__ . "/config.php";

//    defined("DB_SERVER")? null : define("DB_SERVER", "localhost");
//    defined("DB_USER")? null : define("DB_USER", "root");
//    defined("DB_PASS")? null : define("DB_PASS", "mahesh");
//    defined("DB_NAME")? null : define("DB_NAME", "backend");

class MySQLDatabase {

    private $connection;
    public $last_query;

    function __construct() {
        $this->open_connection();
    }

    public function open_connection() {
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if (!$this->connection) {
            die("Database connection failed: " . mysqli_error($this->connection));
        }
    }

    public function close_connection() {
        if (isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    public function escape_value($string) {
        $prepairedString = mysqli_real_escape_string($this->connection, $string);
        return $prepairedString;
    }

//        public function query($sql){
//            $this->last_query=$sql;
//            $result= mysqli_query($this->connection, $sql);
//            $this->confirm_query($result);
//            return $result;
//        }
    public function query($sql) {
        $this->last_query = $sql;
        $result = mysqli_query($this->connection, $sql);

        if ($result) {
            return $result;
        } else {
            throw new Exception('Database query failed: "' . $this->last_query . '" (' . mysqli_error($this->connection) . ')');
        }
    }

//    public static function doQuery($sql) {
//        $result = $this->query($sql);
//        $result_array = array();
//        while ($row = $this->fetch_array($result)) {
//            $result_array[] = $row;
//        }
//        return $result_array;
//    }

    public static function doQuery($sql, $fetch = null) {
        global $database;
        $result = $database->query($sql);
        $result_array = array();

////        while($row=$database->fetch_array($result)){
//        while($row=$database->fetch_object($result)){
////            $result_array[$row[0]]=$row[1];
//            $result_array[]=$row;
//        }

        if ($fetch === "fetch_array") {
            while ($row = $database->fetch_array($result)) {
                $result_array[] = $row;
            }
        } else if ($fetch === "fetch_assoc") {
            while ($row = $database->fetch_assoc($result)) {
                $result_array[] = $row;
            }
        } else if ($fetch === "fetch_object") {
            while ($row = $database->fetch_object($result)) {
                $result_array[] = $row;
            }
        } else {
            while ($row = $database->fetch_array($result)) {
                $result_array[] = $row;
            }
        }

        return $result_array;
    }

    public function fetch_assoc($result) {
        return mysqli_fetch_assoc($result);
    }

    public function fetch_array($result) {
        return mysqli_fetch_array($result);
    }

    public function fetch_object($result) {
        return mysqli_fetch_object($result);
    }



    public function num_rows($result) {
        return mysqli_num_rows($result);
    }

    public function insert_id() {
        return mysqli_insert_id($this->connection);
    }

    public function affected_rows() {
        return mysqli_affected_rows($this->connection);
    }

    private function confirm_query($result) {
        if (!$result) {
            $output = "Database query failed: " . mysqli_error($this->connection);
//                $output.="<br/>Last query: ". $this->last_query;
            die($output);
        }
    }

    public function last_insert_id($table) {
        $result = $this->query("SELECT LAST_INSERT_ID(id) From " . $table . " ORDER BY id DESC LIMIT 1");
        $row = $this->fetch_array($result);
        return $row[0];
    }

    public function start_transaction() {
        $result = $this->query("START TRANSACTION");
    }

    public function rollback() {
        $result = $this->query("ROLLBACK");
    }

    public function commit() {
        $result = $this->query("COMMIT");
    }

}

$database = new MySQLDatabase();
$db = & $database;
?>