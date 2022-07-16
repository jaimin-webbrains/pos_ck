<?php
require_once __DIR__.'/../util/initialize.php';

class Role extends DatabaseObject{
    protected static $table_name="role";
    protected static $db_fields=array();
    protected static $db_fk=array();

//    public $id;
//    public $name;

public static function role_name($value){
    global $database;
    $value=$database->escape_value($value);
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE name LIKE '$value%' ");
    return $object_array;
}

}

?>
