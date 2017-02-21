<div class="row">
  <div class="col-sm-12">
    <form role="form">
      <div class="form-group">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Wpisz zapytanie">
          <span class="input-group-btn">
			<a class="btn btn-success" type="submit">Szukaj</a>
		</span>
        </div>
      </div>
    </form>
  </div>
  <div class="col-sm-12">
    <ul class="media-list">
      <?php foreach ($this->usersList as $entry) { ?>
        <li class="media">
          <a class="pull-left" href="#"><img class="media-object" src="https://ununsplash.imgix.net/photo-1423753623104-718aaace6772?w=1024&amp;q=50&amp;fm=jpg&amp;s=1ffa61419561b5c796bca3158e7c704c" height="64" width="64"></a>
          <div class="media-body">
            <h4 class="media-heading"><?=$entry['account_name']?> </h4>
            <p>Login "
              <?=$entry['account_login']?>"</p>
            <p>Rola w aplikacji "
              <?=$entry['account_role']?>"</p>
            <a href="?accounts-users=accounts-detail&user=<?=$entry['id']?>" class="btn btn-block btn-primary btn-xs">edytuj</a>
          </div>
          <hr>
        </li>
        <? } ?>
    </ul>
  </div>
</div>