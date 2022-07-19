<?php
require_once __DIR__.'/../util/initialize.php';

class DeletedInvoiceItems extends DatabaseObject{
    protected static $table_name = "deleted_invoices_items";    
    protected static $db_fields = array();
    protected static $db_fk = array();
}

?>
