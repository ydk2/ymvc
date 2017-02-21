<div class="row">
  <div class="col-sm-12">
    <?php if(!empty($this->userdetails)){ ?>
      <?php foreach($this->userdetails as $ukey=>$uvalues) { ?>
        <p><b><?=$ukey?></b> "<?=$uvalues?>"</p>
      <?php } ?>
	  <a href="?accounts-users=accounts-list" class="btn btn-primary btn-large">Wróć</a>
    <?php } else { ?>
    <div class="well">
      <h1>Oj! coś tu nie tak</h1>
      <p>Nic nie znaleziono</p>
      <a href="?accounts-users=accounts-list" class="btn btn-primary btn-large">Wróć</a>
    </div>
    <?php } ?>
  </div>
</div>