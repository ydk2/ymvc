<div>
  <h3><?=$this->ViewData('title');?></h3>
  <div><b><?=$this->ViewData('header');?></b></div>
  <div>
    <?=$this->ViewData('alert');?>
  </div>
  <div><a href="<?=HOST_URL;?>">Go back</a></div>
  <div>
    <?=Intl::_('Posts Categorized:','phpcall');?>
  </div>
  <div>


    <ul>
      <?php foreach ($this->langs as $key => $value) : ?>
        <li>
          <a href="<?=HOST_URL;?>?<?=htmlentities("phpcall=phpcall&setlocale=$value");?>">
            <?=$value;?>
          </a>
        </li>
        <?php endforeach; ?>
    </ul>
  </div>
  <div>
    <?php



//global $po;
$po = parse_po_file(SYS.LANGS.basename($this->name,EXT).DS.'pl.po');
//var_dump($po);
$n = 3003;
$search = "choices: ";
$nplurals = 3;
// polski pl nplurals=3; plural=(n==1 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2);
$plural = ($n == 1) ? 0 : ((($n % 10 >= 2 && $n % 10 <=4) && ($n % 100<=10 || $n % 100 >= 20))? 1 : 2 );

echo Loader::get_module_view(APP.C.'test');
echo "<p>".$n." "._n_search($search,$po,$nplurals,$plural)."</p>";
?>
  </div>
</div>