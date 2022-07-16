<?php
require_once __DIR__.'/../util/initialize.php';

class InvoiceDelete extends DatabaseObject{
  protected static $table_name="deleted_invoices";
  protected static $db_fields=array();
  protected static $db_fk=array("customer_id"=>"Customer","invoice_branch"=>"Branch","invoiced_by"=>"User", "epayment_operator"=>"EpaymentOperator");

  public function customer_id()
  {
    return parent::get_fk_object("customer_id");
  }

  public function invoice_branch()
  {
    return parent::get_fk_object("invoice_branch");
  }

  public function invoiced_by()
  {
    return parent::get_fk_object("invoiced_by");
  }

  public function epayment_operator()
  {
    return parent::get_fk_object("epayment_operator");
  }

}

?>

