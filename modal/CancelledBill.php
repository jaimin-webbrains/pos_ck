<?php
require_once __DIR__.'/../util/initialize.php';

class CancelledBill extends DatabaseObject{
    protected static $table_name = "deleted_invoices";    
    protected static $db_fields = array();
    protected static $db_fk = array();
}

?>
