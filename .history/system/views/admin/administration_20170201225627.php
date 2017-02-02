
	<div class="jumbotron">
              <h3 class="text-center text-muted">YMVC
                <small>&#160;System</small>
              </h3>
              <hr/>
              <p class="text-center text-primary"><?=$this->message;?></p>
              <ul class="nav nav-stacked nav-tabs">
                <?php foreach($this->datalist[1] as $entry):?>
                <li>
                  <a href="#"><?=$entry?></a>
                </li>

                <?php endforeach; ?>

                <!--<?=var_dump($this->datalist)?>-->
                <!--
                <li class="active">
                  <a href="#">Ustawienia Główne</a>
                </li>
                <li>
                  <a href="#">Zarządzaj Profilami</a>
                </li>
                <li>
                  <a href="#">Zarządzaj Menu</a>
                </li>
                <li>
                  <a href="#">Zarządzaj Modułami</a>
                </li>
                <li>
                  <a href="#">Zarządzaj Dostępem</a>
                </li>
                <li>
                  <a href="#">Zarządzaj Wyglądem</a>
                </li>
                -->
              </ul>
              <a class="btn btn-block btn-large btn-primary">Administracja</a>
              <a class="btn btn-block btn-large btn-primary">Użykownicy</a>
              <a class="btn btn-block btn-large btn-primary">Programy</a>
              <a href="?login-form&amp;action=logout" class="btn btn-block btn-large btn-danger">Wyloguj</a>
    </div>