<?php $data = $this->Page("/App/Controllers/Theme/Footer",$this->model);?>
  <footer class="section section-primary">
    <div class="container">
      <div class="row">
        <div class="col-sm-6">
          <h1><?=$data['header']?></h1>
          <p>
             <strong>Powered by <?=$data['powered']?></strong><br> author <a class="text-inverse" href="<?=$data['link']?>"><?=$data['author']?></a>
          </p>
        </div>
        <div class="col-sm-6">
          <div class="text-info text-right">
            <br>
            <br>
          </div>
          <div class="row">
            <div class="col-md-12 text-right">
              <a href="<?=$data['github']?>"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  </body>

</html>