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
$lang = 'csb';
$n = 3003;
$searcho = "choice: ";
$searchp = "choices: ";
//$searchp = NULL;

//global $po;
$po = parse_po_file(SYS.LANGS.basename($this->name,EXT).DS.'pl.po');
//var_dump($po);
$plural = get_plural_by_lang($n,$lang);

$module = Loader::get_module(APP.C.'test');
echo Loader::get_module_view($module);
echo "<p>".$n." "._n_search_plural($searcho,$searchp,$n,$po,$plural['nplurals'],$plural['plural'])."</p>";
?>
  </div>
</div>