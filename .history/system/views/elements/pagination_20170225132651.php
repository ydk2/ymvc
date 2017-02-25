<? if($this->lenght > 1){ ?>
<? $array =  helper::array_url($_SERVER['QUERY_STRING']); unset($array['p'])?>
  <div class="col-sm-12 text-center">
    <ul class="pagination">
      <li>
    <? if(intval(helper::get('p')) > 1){ ?>
         <a href="<?=HOST.'?'.helper::query_url($array+array('p' => intval(helper::get('p'))-1))?>">
         <?=intl::_('poprzednia')?>
         </a>
    <? } else { ?>
         <a>
         <?=intl::_('poprzednia')?>
         </a>
    <? } ?>
      </li>
      <?php $i=1; while ($i <= $this->lenght): ?>
      <li>
        <a href="<?=HOST.'?'.helper::query_url($array+array('p' => $i))?>"><?=$i?></a>
      </li>
      <?php $i++; endwhile ?>
      <li>
    <? if(intval(helper::get('p')) < $this->lenght){ ?>
         <a href="<?=HOST.'?'.helper::query_url($array+array('p' => intval(helper::get('p'))+1))?>">
         <?=intl::_('następna')?>
         </a>
    <? } else { ?>
         <a>
         <?=intl::_('następna')?>
         </a>
    <? } ?>
      </li>
    </ul>
  </div>
<?php } ?>
