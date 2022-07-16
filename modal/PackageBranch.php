<?php
require_once __DIR__.'/../util/initialize.php';

class PackageBranch extends DatabaseObject{
    protected static $table_name="package_branch";
    protected static $db_fields=array(); 
    
    protected static $db_fk=array("package_id"=>"Package","branch_id"=>"Branch");
    
//    public $id;
//    public $name;

     public function package_id()
    {
        return parent::get_fk_object("package_id");
    }

     public function branch_id()
    {
        return parent::get_fk_object("branch_id");
    }

    public static function find_by_package_id($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE package_id = '$value' ");
        return $object_array;
    }

     public static function find_by_package_branch($value1,$value2){
        global $database;
        $value1=$database->escape_value($value1);
        $value2=$database->escape_value($value2);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE branch_id = '$value1' AND package_id='$value2' ");
        return $object_array;
    }
    
}

?>