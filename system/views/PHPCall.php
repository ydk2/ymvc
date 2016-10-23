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
$lang = Helper::Session('locale');
$n = 30030;
$searcho = "choice: ";
$searchp = "choices: ";
//$searchp = NULL;Helper::Session('locale')
//Intl::po_locale_plural(SYS.LANGS.basename($this->name,EXT).DS.'pl.po','plurals');
Intl::po_locale_plural($lang,'plurals');
//Intl::set_lang($lang);
//global $po;
//$po = parse_po_file(SYS.LANGS.basename($this->name,EXT).DS.'pl.po');
//var_dump(Intl::$lang);
$plural = 3;
$nplurals = 2;

$module = Loader::get_module(APP.C.'test');
//echo Loader::get_module_view($module);
//echo "<p>".$n." "._n_search_plural($searcho,$searchp,$n,$po,$plural['nplurals'],$plural['plural'])."</p>";
echo "<p>".$n." ".Intl::_n($searcho,$searchp,$n,'plurals')."</p>";
echo "<p>".$n." ".Intl::_p($searchp,'plurals',array('plural'=>$plural,'nplurals'=>$nplurals))."</p>";
echo "<p>1. ".Intl::_p($searcho,'plurals',1)."</p>";
?>
  </div>
</div>