    <div class="section">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<form class="form-horizontal" method="post" action="<?=HOST_URL?>?admin:mngaccount&action=register" role="form">
					<div class="form-group">
						<div class="col-sm-2">
							<label for="name" class="control-label">Name</label>
						</div>
						<div class="col-sm-10">
							<input type="text" required="required" name="name"  value="<?=$this->name?>" class="form-control" id="name" placeholder="Name">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-2">
							<label for="Email" class="control-label">Email</label>
						</div>
						<div class="col-sm-10">
							<input type="email" required="required" name="email" value="<?=$this->email?>" class="form-control" id="Email" placeholder="Email">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-2">
							<label for="Password" class="control-label">Password</label>
						</div>
						<div class="col-sm-10">
							<input type="password"  required="required" name="password"  value="<?=$this->pass?>" class="form-control" id="Password" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-2">
							<label for="Password" class="control-label">Password</label>
						</div>
						<div class="col-sm-10">
							<input type="password"  required="required" name="password2"  value="<?=$this->pass2?>" class="form-control" id="Password2" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="hidden" name="from" value="register"/>
							<input type="submit" class="btn btn-primary" value="Register"/>
							<a class="btn btn-primary" href="<?=HOST_URL?>?admin:mngaccount&action=login">Login</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	</div>
