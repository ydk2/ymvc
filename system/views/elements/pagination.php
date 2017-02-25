<? if($this->lenght > 1){ ?>
<? $array =  helper::array_url($_SERVER['QUERY_STRING']); unset($array[$this->getstr])?>
  <div class="col-sm-12 text-center">
    <ul class="pagination">
      <li>
    <? if(intval(helper::get($this->getstr)) > 1){ ?>
         <a href="<?=HOST.'?'.helper::query_url($array+array($this->getstr => intval(helper::get($this->getstr))-1))?>">
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
        <a href="<?=HOST.'?'.helper::query_url($array+array($this->getstr => $i))?>"><?=$i?></a>
      </li>
      <?php $i++; endwhile ?>
      <li>
    <? if(intval(helper::get($this->getstr)) < $this->lenght){ ?>
         <a href="<?=HOST.'?'.helper::query_url($array+array($this->getstr => intval(helper::get($this->getstr))+1))?>">
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
