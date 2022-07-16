<?php
require_once __DIR__.'/../util/initialize.php';

class ColourBranch extends DatabaseObject{
    protected static $table_name="colour_branch";
    protected static $db_fields=array();

    protected static $db_fk=array("colour_id"=>"Colour","branch_id"=>"Branch");

    public function colour_id()
    {
        return parent::get_fk_object("colour_id");
    }

    public function branch_id()
    {
        return parent::get_fk_object("branch_id");
    }

    public static function find_by_colour_id($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE colour_id = '$value' ");
        return $object_array;
    }

    public static function find_by_colour_branch($value1,$value2){
        global $database;
        $value1=$database->escape_value($value1);
        $value2=$database->escape_value($value2);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE branch_id = '$value1' AND colour_id='$value2' ");
        return $object_array;
    }

}

?>
