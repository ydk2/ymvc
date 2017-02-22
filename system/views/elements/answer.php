<div class="row">
  <div class="col-sm-offset-2 col-sm-8">
      <div class="well">
        <h2 class="text-primary"><?=$this->ViewData('header')?></h2>
        <p class="text-primary"><?=$this->ViewData('text')?></p>
        <a href="<?=$this->data->link_yes?>" class="btn btn-info btn-large btn-success"><?=Intl::_('Tak')?></a>
        <a href="<?=$this->data->link_no?>" class="btn btn-info btn-large btn-danger"><?=Intl::_('Nie')?></a>
      </div>
  </div>
</div>