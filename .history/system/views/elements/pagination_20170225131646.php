<? if($this->lenght > 1){ ?>
  <div class="col-sm-12 text-center">
    <ul class="pagination">
    <? if(helper::get('p') > 2){ ?>
      <li>
         <a href="<?=HOST.'?'.helper::query_url(helper::array_url($_SERVER['QUERY_STRING'])+array('p' => intval(helper::get('p'))-1))?>">
         <?=intl::_('poprzednia')?>
         </a>
      </li>
    <? } ?>
      <?php $i=1; while ($i <= $this->lenght): ?>
      <li>
        <a href="<?=HOST.'?'.helper::query_url(helper::array_url($_SERVER['QUERY_STRING'])+array('p' => $i))?>"><?=$i?></a>
      </li>
      <?php $i++; endwhile ?>
    <? if($i <= $this->lenght){ ?>
      <li>
         <a href="<?=HOST.'?'.helper::query_url(helper::array_url($_SERVER['QUERY_STRING'])+array('p' => intval(helper::get('p'))+1))?>">
         <?=intl::_('następna')?>
         </a>
      </li>
    <? } ?>
    </ul>
  </div>
<?php } ?>
