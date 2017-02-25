
<?=$_SERVER['QUERY_STRING']?>
<? if($this->lenght > 1){ ?>
  <div class="col-sm-12 text-center">
    <ul class="pagination">
      <li>
        <a href="#">Prev</a>
      </li>
      <?php $i=1; while ($i <= $this->lenght): ?>
      <li>
        <a href="<?=modify_url(HOST,$_SERVER['QUERY_STRING'],array('p' => $i));?>"><?=$i?></a>
      </li>
      <?php $i++; endwhile ?>
      <li>
        <a href="#">Next</a>
      </li>
    </ul>
  </div>
<?php } ?>
