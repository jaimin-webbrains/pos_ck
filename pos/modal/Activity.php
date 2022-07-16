<?php

require_once __DIR__ . '/../util/initialize.php';

class Activity extends DatabaseObject {

    protected static $table_name = "activity";
    protected static $db_fields = array();
    protected static $db_fk = array("user_id" => "User");

    public function user_id() {
        return parent::get_fk_object("user_id");
    }

    public static function log_action($description) {
        if (isset($_SESSION["user"]["id"]) && !empty($_SESSION["user"]["id"])) {
            $activity = new self;
            $activity->date_time = date('Y-m-d H:i:s');
            $activity->description = $description;
            $activity->user_id = $_SESSION["user"]["id"];
            $activity->save();
        }
    }

    public static function find_all_limit_10() {
        $object_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " ORDER BY id DESC LIMIT 10");
        return $object_array;
    }

    public static function find_all_latest() {
        $object_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " ORDER BY id DESC");
        return $object_array;
    }

    public static function find_all_by_user_id($value) {
        global $database;
        $value = $database->escape_value($value);
        $object_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE user_id='$value' ORDER BY date_time DESC");
        return $object_array;
    }
    
    public static function find_all_by_limit_offset_custom($limit, $offset) {
        $object_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " ORDER BY date_time DESC LIMIT $limit OFFSET $offset");
        return $object_array;
    }

}

?>