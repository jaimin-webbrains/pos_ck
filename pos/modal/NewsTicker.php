<?php
require_once __DIR__.'/../util/initialize.php';

class NewsTicker extends DatabaseObject{
  protected static $table_name="news_ticker";
  protected static $db_fields=array();
  protected static $db_fk=array("");

  public static function find_last_five(){
    global $database;
    $object_array=self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY id DESC LIMIT 5");
    return $object_array;
  }


}

?>
