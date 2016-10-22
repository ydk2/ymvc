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
function parse_po($path){
    $oarray = array();
    if(is_file($path)){
        $file = file_get_contents($path);
        $file =  preg_replace(array("/\t+\n/"), "\n", $file);
        $file =  preg_replace(array("/\s+\n/"), "\n", $file);
        $file = str_replace(array("msgid \"\"\nmsgstr","\"\n\""),array("msgid \"_PO_HEADER_\"\nmsgstr",''),$file);
        $narray = explode("\n",$file);
        $ikey = 0; $pkey = 0;$skey = 0; $ckey = 0;$sikey = 0;$cmkey = 0;$cikey = 0;
        $n = 0;
        for ($i=0; $i < count($narray); $i++) {
            $cmsgid = preg_match("/^msgid \"(.*)\"/",$narray[$i],$msgid);
            $cmsgidp = preg_match("/^msgid_plural \"(.*)\"/",$narray[$i],$msgidp);
            $cmsgstr = preg_match("/^msgstr \"(.*)\"/",$narray[$i],$msgstr);
            $cmsgstri = preg_match("/^msgstr\[([0-9]+)\] \"(.*)\"/",$narray[$i],$msgstri);
            //$cstr = preg_match("/^\"(.*)\"/",$narray[$i],$str);
            if($cmsgid){
                $ikey = $i;
                $n++;
            }
            if($cmsgidp){
                $pkey = $i;
            }
            if($cmsgstr){
                $skey = $i;
            }
            if($cmsgstri){
                $sikey = $i;
            }
            
            if($ikey <= $i){
                if($ikey == $i){
                    if($n == 1){
                        $oarray[$n]['HEADER']=$msgid[1];
                    } else {
                        $oarray[$n]['msgid']=$msgid[1];
                    }
                }
                if($ikey < $pkey && $pkey == $i){
                    $oarray[$n]['msgid_plural']=$msgidp[1];
                }
                if($ikey < $skey && $skey == $i){
                    if($n == 1){
                        $oarray[$n]['HEADER_STR']=explode('\n',$msgstr[1]);
                    } else {
                        $oarray[$n]['msgstr']=$msgstr[1];
                    }
                }
                if($ikey < $sikey && $sikey == $i){
                    $oarray[$n]['msgstr'][$msgstri[1]]=$msgstri[2];
                }
            }
        }
    }
    return $oarray;
}

function _n($msgid, $n = 1 , $nplurals = 2, $plural = NULL){
	global $po;
    $retstr = $msgid;
    foreach ($po as  $value) {
        if(isset($value['msgid']) && isset($value['msgstr']) && !isset($value['msgid_plural']) && !is_array($value['msgstr']))
        	if($value['msgid']==$msgid)
        		$retstr = $value['msgstr'];
        		if(isset($value['msgid']) && isset($value['msgid_plural']) && is_array($value['msgstr']))
        			foreach($value['msgstr'] as $i=>$values):
       					if($i == 0)
        					if($value['msgid']==$msgid)
        						$retstr = $value['msgstr'][0];
        				else
            				if($value['msgid_plural']==$msgid)
        						$retstr = $value['msgstr'][$plural];
    				endforeach;
    }
	return $retstr;
}

global $po;
$po = parse_po(SYS.LANGS.basename($this->name,EXT).DS.'pl.po');
//var_dump($po);
$n = 3002;
$search = "choices: ";
$nplurals = 3;
// polski pl nplurals=3; plural=(n==1 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2);
$plural = ($n == 1) ? 0 : ((($n % 10 >= 2 && $n % 10 <=4) && ($n % 100<=10 || $n % 100 >= 20))? 1 : 2 );

echo Loader::get_module_view(APP.C.'test');
echo "<p>".$n." "._n($search,$n,3,$plural)."</p>";
?>
  </div>
</div>