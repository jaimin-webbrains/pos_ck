
<div class="col-sm-4">
  <a href="index.php" class="btn btn-info" role="button"> <span class="fa fa-home"></span> </a>
  <a href="logout.php" class="btn btn-info" role="button"> <span class="fa fa-sign-out"></span> </a>

  <a href="index.php" class="btn btn-info" role="button" ><span class="fa fa-file-text"></span> PENDING <?php $pendig_inv = Invoice::find_all_pending($user->branch_id); echo count($pendig_inv); ?> </a>
</div>
