<div class="row">
<?=var_dump($this->lenght)?>
<? if($this->lenght > 1){ ?>
  <div class="col-sm-12 text-center">
    <ul class="pagination">
      <li>
        <a href="#">Prev</a>
      </li>
      <li>
        <a href="#">1</a>
      </li>
      <li>
        <a href="#">2</a>
      </li>
      <li>
        <a href="#">3</a>
      </li>
      <li>
        <a href="#">4</a>
      </li>
      <li>
        <a href="#">5</a>
      </li>
      <li>
        <a href="#">Next</a>
      </li>
    </ul>
  </div>
<?php } ?>
</div>