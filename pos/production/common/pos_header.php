<?php
require_once __DIR__ . '/../../util/validate_login.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> KTC POS </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/pos/bootstrap.min.css">
  <link href="./css/pagination.css" rel="stylesheet">
  <script src="css/pos/jquery.min.js"></script>
  <script src="css/pos/bootstrap.min.js"></script>
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <style media="screen">
    body{
      font-weight:700;
      background-color: #ecf0f1;

    }
    #product-section{
      background-color: #34495e;
      box-shadow: 5px 5px 10px #888888;
      text-align:center;
      color:white;
      text-transform: uppercase;
      min-height:500px;
    }
    #info-bar{
      background-color: #34495e;
      box-shadow: 5px 5px 10px #888888;
      color:white;
      text-transform: uppercase;
      padding-top:10px;
      margin-bottom: 10px;
      margin-top:20px;
    }
    #grid-section{
      background-color: #34495e;
      box-shadow: 5px 5px 10px #888888;
      color:white;
      padding-top:20px;
      padding-bottom:20px;
      min-height:500px;
      overflow: auto;
    }
    #bottom-section{
      background-color: #34495e;
      box-shadow: 5px 5px 10px #888888;
      color:white;
      padding-top:20px;
      padding-bottom:20px;
      margin-top:20px;
    }
    .grid-table{
      background-color: #ecf0f1;
      color:black;
    }
    .touch-button{
      padding-top:30px;
      padding-bottom:30px;
    }
    .modal-content{
      color:black;
    }
    .select-section{
      padding:5px;
    }
  </style>
 <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
  <script src="./js/select/jquery.min.js"></script>
  <script src="./js/select/bootstrap-select.min.js"></script>
  <link href="./js/select/bootstrap-select.min.css" rel="stylesheet" />
  
</head>
<?php date_default_timezone_set("Asia/Singapore"); ?>
