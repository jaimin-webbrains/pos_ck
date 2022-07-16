<?php
require_once __DIR__.'/../util/initialize.php';

class ProductUnitBranch extends DatabaseObject{
    protected static $table_name="product_unit_branch";
    protected static $db_fields=array();

    protected static $db_fk=array("product_unit_id"=>"ProductUnit","branch"=>"Branch");

    public function product_unit_id()
    {
        return parent::get_fk_object("product_unit_id");
    }

    public function branch()
    {
        return parent::get_fk_object("branch");
    }

    public static function find_by_product_unit_id($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE product_unit_id = '$value' ");
        return $object_array;
    }

    public static function find_by_product_unit_branch($value1,$value2){
        global $database;
        $value1=$database->escape_value($value1);
        $value2=$database->escape_value($value2);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE branch = '$value1' AND product_unit_id='$value2' ");
        return $object_array;
    }

}

?>
