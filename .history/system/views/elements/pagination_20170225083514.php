<? if($this->lenght > 1){ ?>
  <div class="col-sm-12 text-center">
    <ul class="pagination">
      <li>
        <a href="#">Prev</a>
      </li>
      <?php $i=1; while ($i <= $this->lenght): ?>
      <li>
      <?php $a = explode("&", $_SERVER['QUERY_STRING'])+array('p'=>$i)?>
        <a href="<?=HOST.modify_url($a)?>"><?=$i?></a>
      </li>
      <?php $i++; endwhile ?>
      <li>
        <a href="#">Next</a>
      </li>
    </ul>
  </div>
<?php } ?>
