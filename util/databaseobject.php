<?php

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/initialize.php';

class DatabaseObject {

//    public static $called_classes=array();
//    public static $recursing=false;

    function __construct() {
        $this->set_db_fields();
    }

//    private function set_db_fields(){
//        global $database;
//        $qry="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB_NAME."' AND TABLE_NAME = '".static::$table_name."'";
//        $result=$database->query($qry);
//        $fields=array();
//        while ($row=$database->fetch_array($result)){
//            $fields[]=$row[0];
//        }
//        static::$db_fields=$fields;
//    }
//    private function set_db_fields(){
//        global $database;
//        $qry="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB_NAME."' AND TABLE_NAME = '".static::$table_name."'";
//        $result=$database->query($qry);
//        $fields=array();
//        while ($row=$database->fetch_array($result)){
//            $field=$row[0];
//            $fields[]=$field;
//            $this->$field=null;
//        }
//        static::$db_fields=$fields;
//    }

    private function set_db_fields() {
        $fields = $this->get_db_fields_on_construct();
        foreach ($fields as $field) {
            $this->$field = null;
        }
        static::$db_fields = $fields;
    }

    private function get_db_fields_on_construct() {
        global $database;
        $qry = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . DB_NAME . "' AND TABLE_NAME = '" . static::$table_name . "'";
        $result = $database->query($qry);
        $fields = array();
        while ($row = $database->fetch_array($result)) {
            $field = $row[0];
            $fields[] = $field;
        }
        return $fields;
    }

    public static function get_db_fields() {
        global $database;
        $qry = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . DB_NAME . "' AND TABLE_NAME = '" . static::$table_name . "'";
        $result = $database->query($qry);
        $fields = array();
        while ($row = $database->fetch_array($result)) {
            $field = $row[0];
            $fields[] = $field;
        }
        return $fields;
    }

    private static function instantiate($record) {
        //$class_name= get_called_class();
        //$object=new $class_name;
        $object = new static;
        foreach ($record as $attribute => $value) {
            if (array_key_exists($attribute, get_object_vars($object))) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

// <editor-fold defaultstate="collapsed" desc="instantiate">
//    public static function instantiate($record){
//        $object=new static;
//        foreach ($record as $attribute=>$value){
//            if(array_key_exists($attribute, get_object_vars($object))){
//                if(array_key_exists($attribute, static::$db_fk)){
//                    echo "called class:".get_called_class()."----------attribute:".$attribute."--------".static::$db_fk[$attribute]."----------".$value."</br>";
//                    $class=static::$db_fk[$attribute];
//                    $object->$attribute= $class::find_by_id($value);
//                }else{
//                    $object->$attribute=$value;
//                }
//            }
//        }
//        return $object;
//    }
//    public static function instantiate($record){
//        $object=new static;
//        foreach ($record as $attribute=>$value){
//            if(!static::$recursing){
//                static::$called_classes=array();
//            }
//            if(array_key_exists($attribute, get_object_vars($object))){
//                if(array_key_exists($attribute, static::$db_fk)){
//                    static::$recursing=TRUE;
////                    echo "</br>called class:".get_called_class()."----------attribute:".$attribute."--------".static::$db_fk[$attribute]."----------".$value;
//                    $class=static::$db_fk[$attribute];
//                    if(array_key_exists($class, static::$called_classes)){
//                        $object->$attribute=$value;
////                        echo '</br>---recursing stop---';
//                        static::$recursing=false;
//                        static::$called_classes=array();
//                    }else{
//                        static::$called_classes[$class]=$class;
//                        $object->$attribute= $class::find_by_id($value);
//                    }
//                }else{
//                    $object->$attribute=$value;
//                }
//            }
////            echo "</br>called classess--".join(",  ", static::$called_classes);
//        }
////        static::$called_classes=array();
//        return $object;
//    }
    // </editor-fold>

    public function get_fk_object($id_fk) {
        if (!empty($this->$id_fk)) {
            $class = static::$db_fk[$id_fk];
            $object = $class::find_by_id($this->$id_fk);
            return $object;
        } else {
            return FALSE;
        }
    }

    public static function find_by_sql($sql = "") {
        global $database;
        $result = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result)) {
            $object_array[] = static::instantiate($row);
        }
        return $object_array;
    }

//    public static function find_all(){
//        $result=static::find_by_sql("SELECT * FROM ".static::$table_name);
//        return $result;
//    }

    public static function find_all($limit=0,$offset=0) {
        global $database;
        $limit = $database->escape_value($limit);
        $offset = $database->escape_value($offset);
        if($limit && $offset) {
            return $result = self::find_by_sql("SELECT * FROM " . static::$table_name . " LIMIT $limit OFFSET $offset");
        } else {
            return $result = static::find_by_sql("SELECT * FROM " . static::$table_name);
        }
    }

    public static function find_by_id($id = 0) {
//        $object_array=static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id={$id}");
//        return array_shift($object_array);

        $fields = static::get_db_fields();
        if (in_array("id", $fields)) {
            $object_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id={$id}");
            return array_shift($object_array);
        } else {
//            return new static;
            return false;
        }
    }

    private function has_attribute($attribute) {
        $object_vars = $this->attributes();
        return array_key_exists($attribute, $object_vars);
    }

    protected function attributes() {
        $class_name = get_called_class();
        $object = new $class_name();

//        return get_object_vars($object);

        $attributes = array();
        foreach (static::$db_fields as $field) {
            if (property_exists($object, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    protected function sanitized_attributes($attributes) {
        global $database;
        $clean_attibutes = array();
        foreach ($attributes as $key => $value) {
            $clean_attibutes[$key] = $database->escape_value($value);
        }
        return $clean_attibutes;
    }

    function only_available_attributes($attributes) {
        $available_attributes = array();
        foreach ($attributes as $key => $value) {
            ////0 or false values  are considerd as empty 
            ////https://stackoverflow.com/questions/2220519/in-php-is-0-treated-as-empty   
            ////https://stackoverflow.com/questions/4139301/php-0-as-a-string-with-empty
            ////            if(!empty($value)){
            ////               $available_attributes[$key]=$value;
            ////            }
            //            if(!empty($value) && ($value===0 || $value===FALSE)){
            //                $available_attributes[$key]=$value;
            //            }
            if (isset($value)) {
                $available_attributes[$key] = $value;
            }
        }
        return $available_attributes;
    }

    public function save() {
        return empty($this->id) ? $this->create() : $this->update();
    }

    private function set_fk($value) {
        global $database;
        if (is_object($value)) {
            if (isset($value->id)) {
                return $value->id;
            } else {
                try {
                    $value->save();
                    $last_insert_id = $database->last_insert_id($value::$table_name);
                    return $last_insert_id;
                } catch (Exception $exc) {
                    $ok = FALSE;
                    return FALSE;
                }
            }
        } else {
            return $value;
        }
    }

    // <editor-fold defaultstate="collapsed" desc="create">


    /*    private function create(){
      global $database;


      $attributes= $this->sanitized_attributes();
      $available_attributes= $this->only_available_attributes($attributes);


      $sql="INSERT INTO ".static::$table_name
      ." (". join(", ", array_keys($available_attributes)).")"
      ." VALUES"
      ." ('".join("', '", array_values($available_attributes))."')";




      if($database->query($sql)){
      $this->id=$database->insert_id();
      return TRUE;
      }else{
      return FALSE;
      }
      } */
//    private function create(){
//        global $database;
//        
//        $attributes= $this->sanitized_attributes();
//        $available_attributes= $this->only_available_attributes($attributes);
//        
//        $sql="INSERT INTO ".static::$table_name
//        ." (". join(", ", array_keys($available_attributes)).")"
//        ." VALUES"
//        ." ('".join("', '", array_values($available_attributes))."')";
//        
//        try {
//            $database->query($sql);
//            $this->id=$database->insert_id();
//        } catch (Exception $exc) {
//            throw new Exception($exc->getMessage());
//        }
//    }
    // </editor-fold>

    private function create() {
        global $database;

        $attributes = $this->attributes();
        $available_attributes = $this->only_available_attributes($attributes);

        $ok = TRUE;
        $temp_attributes = array();
        foreach ($available_attributes as $attribute => $value) {
            if (array_key_exists($attribute, static::$db_fk)) {
                $temp_attributes[$attribute] = self::set_fk($value);
            } else {
                $temp_attributes[$attribute] = $value;
            }
        }

        $final_attributes = $this->sanitized_attributes($temp_attributes);

        $sql = "INSERT INTO " . static::$table_name
                . " (" . join(", ", array_keys($final_attributes)) . ")"
                . " VALUES"
                . " ('" . join("', '", array_values($final_attributes)) . "')";

        try {
            $database->query($sql);
            $this->id = $database->insert_id();
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }

// <editor-fold defaultstate="collapsed" desc="update">


    /*    private function update(){
      global $database;


      $attributes= $this->sanitized_attributes();
      $available_attributes= $this->only_available_attributes($attributes);


      $attribute_pairs=array();
      foreach($available_attributes as $key=>$value){
      if($key!="id"){
      $attribute_pairs[]="{$key}='{$value}'";
      }
      }


      $sql="UPDATE ".static::$table_name." SET"
      . join(", ", $attribute_pairs)
      ." WHERE id={$id}";


      $database->query($sql);
      return ($database->affected_rows()==1)? true : false ;
      } */
//    private function update(){
//        global $database;
//        
//        $attributes= $this->sanitized_attributes();
//        $available_attributes= $this->only_available_attributes($attributes);
//        
//        
//        $attribute_pairs=array();
//        foreach($available_attributes as $key=>$value){
//            if($key!="id"){
//                $attribute_pairs[]="{$key}='{$value}'";
//            }
//        }
//        
//        $sql="UPDATE ".static::$table_name
//        ." SET "
//        . join(", ", $attribute_pairs)
//        ." WHERE id={$this->id}";
//        
//        try {
//            $database->query($sql);
//            return ($database->affected_rows()==1)? true : false ;
//        } catch (Exception $exc) {
//            throw new Exception($exc->getMessage());
//        }
//    }
    // </editor-fold>

    private function update() {
        global $database;

        $attributes = $this->attributes();
        $available_attributes = $this->only_available_attributes($attributes);

        $ok = TRUE;
        $temp_attributes = array();
        foreach ($available_attributes as $attribute => $value) {
            if (array_key_exists($attribute, static::$db_fk)) {
                $temp_attributes[$attribute] = self::set_fk($value);
            } else {
                $temp_attributes[$attribute] = $value;
            }
        }

        $final_attributes = $this->sanitized_attributes($temp_attributes);

        $attribute_pairs = array();
        foreach ($final_attributes as $key => $value) {
            if ($key != "id") {
                $attribute_pairs[] = "{$key}='{$value}'";
            }
        }

        $sql = "UPDATE " . static::$table_name
                . " SET "
                . join(", ", $attribute_pairs)
                . " WHERE id={$this->id}";

        try {
            $database->query($sql);
            return ($database->affected_rows() == 1) ? true : false;
        } catch (Exception $exc) {
            throw new Exception($exc->getMessage());
        }
    }

    /*    public function delete(){
      if(!empty($this->id)){
      global $database;

      $id=$database->escape_value($this->id);

      $sql="DELETE FROM ".static::$table_name
      ." WHERE id={$id}"
      ." LIMIT 1";
      $database->query($sql);
      return ($database->affected_rows()==1)? true : false ;

      }else{
      throw Exception("Could not delete, attribute 'id' is empty");
      }

      } */

    public function delete() {
        if (!empty($this->id)) {
            global $database;

            $id = $database->escape_value($this->id);

            $sql = "DELETE FROM " . static::$table_name
                    . " WHERE id={$id}"
                    . " LIMIT 1";

            try {
                $database->query($sql);
                return ($database->affected_rows() == 1) ? true : false;
            } catch (Exception $exc) {
                throw new Exception($exc->getMessage());
            }
        } else {
            throw new Exception("Could not delete...! object attribute: 'id' is empty or not valid");
        }
    }

    public function to_array() {
        $array = array();
        $attributes = $this->attributes();
        foreach ($attributes as $key => $value) {
            $array[$key] = $value;
        }
        return $array;
    }

    public function to_array_all() {
        $array = array();
        $attributes = get_object_vars($this);
        foreach ($attributes as $key => $value) {
            $array[$key] = $value;
        }
        return $array;
    }

    // public static function getAutoIncrement() {
    //     global $database;
    //     $sql = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . DB_NAME . "' AND   TABLE_NAME   = '" . static::$table_name . "'";
    //     $result = $database->query($sql);
    //     $result_array = array();
    //     while ($row = $database->fetch_array($result)) {
    //         $result_array[] = $row["AUTO_INCREMENT"];
    //     }
    //     return !empty($result_array) ? array_shift($result_array) : false;
    // }

    public static function getVoucherAutoIncrement() {
        global $database;
        $sql = "SELECT id FROM  voucher order by id DESC LIMIT 1";
        $result = $database->query($sql);
        $result_array = array();
        while ($row = $database->fetch_array($result)) {
            $result_array[] = $row["id"];
        }
        return !empty($result_array) ? array_shift($result_array) : 0;
    }

    public static function last_insert_id() {
        global $database;
        $result = $database->query("SELECT * From " . static::$table_name . " ORDER BY id DESC LIMIT 1");
        $row = $database->fetch_array($result);
        return !empty($row[0]) ? $row[0] : false;
    }

    public static function last_insert_object() {
        $object_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " ORDER BY id DESC LIMIT 1");
        return array_shift($object_array);
    }

    public static function doQuery($sql, $fetch_type) {
        global $database;
        return $database->doQuery($sql, $fetch_type);
    }

    public static function foreignKeys() {
        global $database;
        $sql = "SELECT concat(column_name) AS 'foreign key', concat(referenced_column_name) AS 'references' FROM information_schema.key_column_usage WHERE referenced_table_name IS NOT NULL AND table_schema = '" . DB_NAME . "' AND table_name = '" . static::$table_name . "'";
        $result = $database->query($sql);
        $result_array = array();
        while ($row = $database->fetch_array($result)) {
            $result_array[] = $row[0];
        }
        return $result_array;
    }

//    public static function primaryKeys(){
//        global $database;
//        $sql="SELECT k.COLUMN_NAME FROM information_schema.table_constraints t LEFT JOIN information_schema.key_column_usage k USING(constraint_name,table_schema,table_name) WHERE t.constraint_type='PRIMARY KEY' AND t.table_schema='".DB_NAME."' AND t.table_name='".static::$table_name."';";
//        $result=$database->query($sql);
//        $result_array=array();
//        while($row=$database->fetch_array($result)){
//            $result_array[]= $row[0];
//        }
//        return $result_array;
//    }

    public static function primaryKeys() {
        global $database;
        $sql = "SELECT `COLUMN_NAME` FROM `information_schema`.`COLUMNS` WHERE (`TABLE_SCHEMA` = '" . DB_NAME . "') AND (`TABLE_NAME` = '" . static::$table_name . "') AND (`COLUMN_KEY` = 'PRI')";
        $result = $database->query($sql);
        $result_array = array();
        while ($row = $database->fetch_array($result)) {
            $result_array[] = $row[0];
        }
        return $result_array;
    }

    public static function table_name() {
        return static::$table_name;
    }

    public static function row_count() {
        global $database;
        $res = $database->doQuery("SELECT COUNT(*) FROM " . static::$table_name);
        $count = $res[0][0];
        return $count;
    }

    public static function find_all_by_limit_offset($limit, $offset) {
        $object_array = self::find_by_sql("SELECT * FROM " . static::$table_name . " LIMIT $limit OFFSET $offset");
        return $object_array;
    }

}
