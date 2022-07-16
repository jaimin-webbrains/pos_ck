<?php
require_once __DIR__.'/../util/initialize.php';

class UserRole extends DatabaseObject{
    protected static $table_name="user_role";
    public static $db_fields=array(); 
    protected static $db_fk=array("role_id"=>"Role","user_id"=>"User");
    
//    public $id;
//    public $role_id;
//    public $user_id;

    
    public function role_id(){
        return parent::get_fk_object("role_id");
    }
    
    public function user_id(){
        return parent::get_fk_object("user_id");
    }
    
    public static function find_all_by_user_id($value){
        global $database;
        $user_id=$database->escape_value(trim($value));
        $object_array=parent::find_by_sql("SELECT * FROM user_role WHERE user_id='$user_id'");
        return $object_array;
    }

}

?>