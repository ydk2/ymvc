<?php
class MngLayout extends XSLRender {
    
    public function Init(){
        //call in __constructor
        $this->SetModel(SYS.M.'model');
        
        $this->registerPHPFunctions();
        
        $this->only_registered(FALSE);
        $this->RegisterView(SYS.V."layout".S."content");
        $this->SetView(SYS.V."layout".S."content");
        $this->RegisterView(SYS.V.'errors'.DS.'error');
        
        $this->SetAccess(self::ACCESS_EDITOR);
        //Helper::Session_Set('user_access',Helper::Get('access'));
        $this->access_groups = array('admin','editor');
        $this->current_group = Helper::Session('user_role');
        $this->AccessMode(2);
        $this->global_access = Helper::Session('user_access');
        
        $this->current_group = (Helper::Session('user_role')!="")?Helper::Session('user_role'):'any';
        
        $this->exceptions = TRUE;
        
    }
    
    public function onEnd(){
        // 		call after render view
        return TRUE;
    }
    
    public function Destruct(){
        // 		call in __destructor
        return TRUE;
    }
    
    public function Exception(){
        $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');
        $this->exception->setParameter('','inside','yes');
        $this->exception->setParameter('','show_link','yes');
        $this->exception->ViewData('title', Intl::_p('Error!!!'));
        $this->exception->ViewData('header', Intl::_p('Error!!!').' '.$this->error);
        $this->exception->ViewData('alert',Intl::_p($this->emessage).' - '.Intl::_p('Catch Error').' - ');
        $this->exception->ViewData('error', $this->error);
        return $this->exception->View();
    }

    public function Run(){

        $table='layouts';
		$gprx = 'layout';
		$this->array = $this->model->get_entries($table,$gprx);
        $this->sksort($this->array,'idx');
        $this->datalist=$this->model->searchByName($this->array,'name',$gprx);
        $content = $this->tmpform($this->manage());
        $this->ViewData('layout','' );
        $this->data->layout->addChild('views', htmlspecialchars($content));
    }

    
    protected function contents() {
        $this->SetModule(SYS.V.'layout'.S.'views',SYS.C.'layout'.S.'layout');
        $content = $this->GetModule(SYS.C.'layout'.S.'layout');
        $content = ($content)? htmlspecialchars($content->View()):"";
        $this->ViewData('content', $content);
    }
    protected function manage(){

        if(!isset($this->model->layout_data) || $this->model->layout_data==''){
          $this->model->layout_data=Config::$data['layout_data'];
        }
        $this->modules = array(
        "admin".S."menu"=>array("elements".S."nav","admin".S."account","admin".S."login"),
        "other:two"=>array("elements".S."nav","admin".S."account","admin".S."login","other:two"),
        "index"=>array("index","theme"),
        "layout"=>array("sections","views"),
        "section"=>array("sections","views"),
        "route"=>array("content","container")
        );
        
        $this->layouts = array(
        "section",
        "layout",
        "route"
        );
        
        
        $layout_items = array(
        array('id'=>999, 'pos' => 99, 'name'=>'time','module'=>'check:gettime','view'=>'check:time','class'=>'col-sm-12','attrid'=>'', 'model'=>'', 'group'=>'sec'),
        );
        
        $default_items = array(
        array('id'=>1, 'pos' => 1, 'name'=>'index','module'=>'layout','view'=>'default','class'=>'row','attrid'=>'', 'model'=>'any', 'group'=>'main'),
        );
        
        if (!isset($_GET['group'])) {
            $this->_group='main';
        } else {
            $this->_group = $_GET['group'];
        }
        if(isset($_POST['addgroup'])){
            $this->_group = ($_POST['addgroup']!="")?$_POST['addgroup']:$this->_group;  
        }
        $items = json_decode(file_get_contents(ROOT.SYS.STORE.$this->model->layout_data),true);
        //$items = $this->datalist;
        if (empty($items)){
            $items = $default_items;
        }
        
        if (!empty($items)){
            $this->sksort($items,'id');
            $this->_groups = array();
            $this->tmp = array();
            foreach ($items as $key => $value) {
                if ($value['group']==$this->_group && $value['group']!=$value['name']) {
                    $this->tmp[$key]=$value;
                }
                $this->_groups[]=$value['group'];
                $modules[$value['group']]=array("sections","views");
            }
        }
        

        if (!empty($this->tmp)){
            $this->sksort($this->tmp,'pos');
            foreach ($this->tmp as $pos => $val) {
                $i =$pos+1;
                if ($i > $val['pos']) {
                    $this->tmp[$pos]['pos'] = $i;
                }
            }
        }
        return $items;
    }

    public function save($items='') {
        $msg = "";
        $tosave = $items;

        $_delete = (isset($_GET['delete']))?$_GET['delete']:"";
        if ($_delete!="") {
            foreach ($tosave as $key => $value) {
                if ($value['id']==$_delete) {
                    unset($tosave[$key]);
                    if(!isset($tosave[$key])) $msg = "<h3>Item deleted</h3>";
                }
            }
        }

        if(isset($_POST['item'])){
            $save = (isset($_POST['item']))?$_POST['item']:array();
            foreach ($tosave as $key => $value) {
                $tosave[$key]['id'] = intval($tosave[$key]['id']);
                $tosave[$key]['pos'] = intval($tosave[$key]['pos']);
                foreach ($save as $changed) {
                  if ($value['id']==$changed['id']) {
                        $tosave[$key]=$changed;
                        break;
                  }
                }
            }
            $msg = "<h3>Changes saved</h3>";
        }  

        if(isset($_POST['addgroup']) && $_POST['addgroup']==$this->_group){
            $msg = "<h3>Successed</h3>";
            $msg .= "<p class=\"lead\">Now add new item to ”".$this->_group."”</p>";
        }

    if(isset($_POST['add'])){

      $t = count($tosave)+1;
      foreach ($tosave as $pos => $val) {
        $i =$pos+1;
        if ($i < $val['id']) {
                $t = $i;
                break;
        }
      }
      $add = $_POST['add'];
      $add['id'] = intval($t);
      $add['pos'] = intval($add['pos']);
      array_push($tosave, $add);
      $msg = "<h3>New item saved</h3>";
    }

if(isset($_POST['item']) || isset($_GET['delete']) || isset($_POST['add'])){
    if (!empty($tosave)) {
    $rev=$this->model->reverseNoId($tosave,'layout');
		foreach ($rev as $items) {
			$this->model->update_item('layouts',$items['name'],$items['value'],$items['idx'],'layout');
		}
        if(@file_put_contents(ROOT.SYS.STORE.$this->model->layout_data, json_encode($tosave))){
            $msg .= "<h3>successed</h3>";
            $msg .= "<a class=\"btn-success btn\" href=\"?admin".S."mnglayout=layout".S."manage&group=".$this->_group."\">OK</a>";
        } else {
            $msg .= "<h3>failure</h3>";
            $msg .= "<a class=\"button-error btn\" href=\"?admin".S."mnglayout=layout".S."manage&group=".$this->_group."\">OK</a>";
        }
    }
}
return $msg;

}

public function tmpform($items){
    ob_start();
    if(isset($_POST['item']) || isset($_GET['delete']) || isset($_POST['add']) || isset($_POST['addgroup'])):
    ?>
  <div class="row">
    <?php
    echo $this->save($items);
    ?>
  </div>
  <?php endif;?>

    <!-- /save msg -->

    <?php if(!isset($_POST['item']) && !isset($_GET['delete']) && !isset($_POST['add'])): ?>
      <!-- add layout & list -->
      <div class="row">
        <!-- add layout -->
        <div class="col-sm-6">
          <h3>Dodaj nowy layout</h3>
          <form class="form" action="?admin<?=S;?>mnglayout=layout<?=S;?>manage" method="post">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Nazwa</th>
                  <th>Akcja</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <input value="<?=$this->_group;?>" class="form-control" type="text" name="addgroup">
                  </td>
                  <td>
                    <input value="Dodaj" class="btn btn-primary" type="submit">
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <a class="btn btn-primary" href="?admin<?=S;?>mnglayout=layout<?=S;?>manage&group=<?=$this->_group;?>">Reflesh</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </form>
        </div>
        <!-- /add layout -->

        <!-- group list -->
        <div class="col-sm-4">
        <h3>Groups list</h3>
          <div class="custom-restricted">
            <?php $sections = array_unique($this->_groups); ?>
              <ul class="list-group">
                <?php foreach ($sections as $value) : ?>
                  <li class="list-group-item">
                    <a  href="?admin<?=S;?>mnglayout=layout<?=S;?>manage&group=<?=$value;?>">
                      <?=$value;?>
                    </a>
                  </li>
                  <?php endforeach; ?>
              </ul>
          </div>
        </div>
        <!-- /group list -->
      </div>
      <!-- /add layout & list -->

      <!-- add -->
      <div class="row">

        <h3 class="">Dodaj wpis do <?=$this->_group;?></h3>
        <form class="form" action="?admin<?=S;?>mnglayout=layout<?=S;?>manage&group=<?=$this->_group;?>" method="post">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>name</th>
                <th>module</th>
                <th>view</th>
                <th>class</th>
                <th>id</th>
                <th>mode</th>
                <th>action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <select class="form-control" name="add[pos]">
                    <?php for ($i=1; $i<=count($this->tmp)+1; $i++) {
        if (isset($this->tmp[0]) && $this->tmp[0]['group']==$this->_group) {
            $sel = ($i==count($this->tmp)+1)?" selected='selected'":"";
            echo "<option value='".trim($i)."'".$sel.">".trim($i)."</option>";
        } else { echo "<option value='1'>1</option>"; }} ?>
                  </select>
                </td>
                <td>
                  <input class="form-control" type="text" name="add[name]">
                </td>
                <td>
                  <input list="add-module" class="form-control" type="text" autocomplete="off" name="add[module]">
                  <datalist id="add-module" class="">
                    <?php $views = array(); foreach ($this->modules as $name => $view): ?>
                      <?php foreach ($view as $b) { $views[]=$b; }
        $views = array_unique($views); ?>
                        <option value="<?=trim($name);?>">
                          <?=trim($name);?>
                        </option>
                        <?php endforeach; ?>
                  </datalist>
                </td>
                <td>
                  <input list="add-view" class="form-control" autocomplete="off" type="text" name="add[view]">
                  <datalist id="add-view" class="">
                    <?php foreach ($views as $view): ?>
                      <option value="<?=trim($view);?>">
                        <?=trim($view);?>
                      </option>
                      <?php endforeach; ?>
                  </datalist>
                </td>
                <td>
                  <input class="form-control" type="text" name="add[class]">
                </td>
                <td>
                  <input class="form-control" type="text" name="add[attrid]">
                </td>
                <td>
                  <input class="form-control" type="text" name="add[mode]" value="sys">
                  <input value="<?=$this->_group;?>" type="hidden" name="add[group]">
                </td>
                <td>
                  <input class="btn btn-success" type="submit" value="Dodaj">
                </td>
              </tr>

            </tbody>
          </table>
        </form>
      </div>
      <!-- /add -->

      <!-- edit -->
      <?php if (!empty($this->tmp)): ?>
        <div class="row">

          <h3 class="">Edytuj layout <?=$this->_group;?></h3>
          <form class="form" action="?admin<?=S;?>mnglayout=layout<?=S;?>manage&group=<?=$this->_group;?>" method="post">
            <table class="table table-horizontal">
              <thead>
                <tr>
                  <th>#</th>
                  <th>name</th>
                  <th>module</th>
                  <th>view or data</th>
                  <th>class</th>
                  <th>id</th>
                  <th>mode</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $j=0;  foreach ($this->tmp as $key => $item): ?>
                  <?php if ($item['group']==$this->_group):
            $nth_child = (($j%2))?" class='pure-table-odd'":"";
        $j++;
        ?>
                    <tr<?=$nth_child;?>>
                      <td>
                        <select name="item[<?=$key;?>][pos]" class="form-control">
                          <?php for ($i=1; $i<=count($this->tmp); $i++) {
            if ($this->tmp[$i-1]['group']==$this->_group) { $sel = ($item['pos'] == $this->tmp[$i-1]['pos'])?" selected='selected'":"";
            echo "<option value='".trim($i)."'".$sel.">".trim($i)."</option>";}} ?>
                        </select>
                      </td>
                      <td>
                        <input value="<?=trim($item['name']);?>" class="form-control" type="text" name="item[<?=$key;?>][name]">
                      </td>
                      <td>
                        <input list="item-<?=$key;?>-module" value="<?=$item['module'];?>" class="form-control" type="text" name="item[<?=$key;?>][module]" autocomplete="off">
                        <datalist id="item-<?=$key;?>-module" class="" name="item[<?=$key;?>][module]">
                          <?php $views = array(); foreach ($this->modules as $name => $view): ?>
                            <?php $used=($name==$item['module'])?" selected='selected'":"";?>
                              <option value="<?=trim($name);?>" <?=$used;?>>
                                <?=trim($name);?>
                              </option>
                              <?php foreach ($view as $b) { if ($name==$item['module']) { $views[]=$b; }}
            $views = array_unique($views);?>
                                <?php endforeach; ?>
                        </datalist>
                      </td>
                      <td>
                        <?php if (in_array($item['module'],$this->layouts) && $item['module']!="route") : ?>
                          <input value="<?=$item['view'];?>" type="hidden" name="item[<?=$key;?>][view]">
                          <a class="btn btn-success" href="?admin<?=S;?>mnglayout=layout<?=S;?>manage&group=<?=$item['name'];?>">edit</a>
                          <?php elseif ($item['module']=="route") : ?>
                          <input value="<?=$item['view'];?>" type="hidden" name="item[<?=$key;?>][view]">
                          <a class="btn btn-success" href="?admin<?=S;?>mnglayout=layout<?=S;?>manage&group=<?=$item['name'];?>">edit</a>
                          <?php else: ?>
                            <input list="item-<?=$key;?>-view" value="<?=$item['view'];?>" class="form-control" type="text" name="item[<?=$key;?>][view]" autocomplete="off">
                            <datalist id="item-<?=$key;?>-view" class="" name="item[<?=$key;?>][view]">
                              <?php foreach ($views as $view): ?>
                                <?php $used=($view==$item['view'])?" selected='selected'":"";?>
                                  <option value="<?=trim($view);?>" <?=$used;?>>
                                    <?=trim($view);?>
                                  </option>
                                  <?php endforeach; ?>
                            </datalist>

                            <?php endif; ?>
                      </td>
                      <td>
                        <input value="<?=$item['class'];?>" class="form-control" type="text" name="item[<?=$key;?>][class]">
                      </td>
                      <td>
                        <input value="<?=$item['attrid'];?>" class="form-control" type="text" name="item[<?=$key;?>][attrid]">
                      </td>
                      <td>
                        <input value="<?=$item['mode'];?>" class="form-control" type="text" name="item[<?=$key;?>][mode]">
                        <input value="<?=$item['group'];?>" type="hidden" name="item[<?=$key;?>][group]">
                        <input value="<?=$item['id'];?>" type="hidden" name="item[<?=$key;?>][id]">
                      </td>
                      <td>
                        <a class="btn btn-danger" href="?admin<?=S;?>mnglayout=layout<?=S;?>manage&group=<?=$item['group'];?>&delete=<?=$item['id'];?>">delete</a>
                      </td>

                      </tr>
                      <?php endif; ?>
                        <?php endforeach; ?>
                          <tr>
                            <td colspan="6"></td>
                            <td colspan="1">
                              <input class="btn btn-primary pure-input-1" type="submit" value="Zapisz">
                            </td>
                          </tr>

              </tbody>
            </table>
          </form>
        </div>
        <?php endif; ?>
<!-- /edit -->
          <?php endif; ?>
            <?php
            $out = ob_get_clean();
            return $out;
        }

    }
    ?>