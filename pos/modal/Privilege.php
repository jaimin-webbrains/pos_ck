<?php
require_once __DIR__.'/../util/initialize.php';

class Privilege extends DatabaseObject{
    protected static $table_name="privilege";
    protected static $db_fields=array(); 
    protected static $db_fk=array("role_id"=>"Role","module_id"=>"Module");
    
//    public $id;
//    public $role_id;
//    public $module_id;
//    public $sel;
//    public $ins;
//    public $upd;
//    public $del;
    
    public function role_id(){
        return parent::get_fk_object("role_id");
    }
    
    public function module_id(){
        return parent::get_fk_object("module_id");
    }
    
    public static function find_all_by_role_module($role,$module){
        global $database;
        $role=$database->escape_value($role);
        $module=$database->escape_value($module);
        $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE role_id='$role' AND module_id='$module'");
        return $object_array;
    }
    
    public static function find_all_by_user_id($value){
        global $database;
        $value=$database->escape_value($value);
        $object_array=self::find_by_sql("SELECT privilege.* FROM ".self::$table_name." INNER JOIN role ON role.id=privilege.role_id INNER JOIN user_role ON user_role.role_id=role.id WHERE user_role.user_id='$value'");
        return $object_array;
    }
    
}

?>