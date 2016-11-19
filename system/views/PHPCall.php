<div>
  <h3><?=$this->ViewData('title');?></h3>
  <div><b><?=$this->ViewData('header');?></b></div>
  <div>
    <?=$this->ViewData('alert');?>
  </div>
  <div>
<?php
$searchone = "choice: "; // one
$searchplural = "choices: "; // many

        $a = 0;
        while ($a <= 40) {
          echo "<p>".$a." ".Intl::_n($searchone,$searchplural,$a,'phpcall')."</p>\n"; // return transladed string with given number of choises
          $a += 3;
        }
?>
  </div>
</div>