
	<div class="jumbotron">
              <h3 class="text-center text-muted">YMVC
                <small>&#160;System</small>
              </h3>
              <hr/>
              <p class="text-center text-primary"><?=$this->message;?></p>
              <ul class="nav nav-stacked nav-tabs">
                <?php foreach($this->subitems as $entry):?>
                <li>
                  <a href="<?=$entry['link']?>"><?=$entry['title']?></a>
                </li>

                <?php endforeach; ?>

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
              <?php foreach($this->mainitems as $modules):?>
                <a href="<?=$modules['link']?>" class="btn btn-block btn-large btn-primary"><?=$modules['title']?></a>
              <?php endforeach; ?>
              <a href="?login-form&amp;action=logout" class="btn btn-block btn-large btn-danger">Wyloguj</a>
    </div>