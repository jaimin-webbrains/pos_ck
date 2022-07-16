<?php
require_once __DIR__.'/../util/initialize.php';

class ProductBranch extends DatabaseObject{
    protected static $table_name="product_branch";
    protected static $db_fields=array();

    protected static $db_fk=array("product_id"=>"Product","branch_id"=>"Branch");

    public function product_id()
    {
        return parent::get_fk_object("product_id");
    }

    public function branch_id()
    {
        return parent::get_fk_object("branch_id");
    }

    public static function find_by_product_id($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE product_id = '$value' ");
        return $object_array;
    }

    public static function find_by_product_branch($value1,$value2){
        global $database;
        $value1=$database->escape_value($value1);
        $value2=$database->escape_value($value2);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE branch_id = '$value1' AND product_id='$value2' ");
        return $object_array;
    }

}

?>
