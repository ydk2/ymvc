 
<xsl:stylesheet 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:param name="title"/>
	<xsl:param name="host" select="data/host"/>
	<xsl:param name="token" select="data/token"/>
	<xsl:param name="post" select="data/post"/>
	<xsl:template match="/data">
		<xsl:call-template name="form"/>
	</xsl:template>
	<xsl:template name="form">
		<div class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<form class="form-horizontal" action="?path=/login" method="post">
							<div class="form-group has-success has-feedback">
								<div class="col-sm-2">
									<label for="name" class="control-label">Login</label>
								</div>
								<div class="col-sm-10">
									<input value="" type="text" class="form-control" name="login" id="name" placeholder="Email"/>
									<span class="fa fa-check form-control-feedback"></span>
								</div>
								<div class="col-sm-offset-2 col-sm-10">
									<p class="help-block">Example block-level help text here.</p>
								</div>
							</div>
							<div class="form-group has-error has-feedback">
								<div class="col-sm-2">
									<label for="pass" class="control-label">Password</label>
								</div>
								<div class="col-sm-10">
									<input value="" type="password" class="form-control" name="pass" id="pass" placeholder="Password"/>
									<span class="fa form-control-feedback fa-exclamation"></span>
								</div>
							</div>
							<div class="form-group has-warning has-feedback">
								<div class="col-sm-2">
									<label for="tel" class="control-label">Phone</label>
								</div>
								<div class="col-sm-10">
									<input value="" type="tel" class="form-control" name="phone" id="tel" placeholder="Phone"/>
									<span class="fa form-control-feedback fa-asterisk"></span>
								</div>
							</div>
							<div class="form-group has-feedback">
								<div class="col-sm-2">
									<label for="email" class="control-label">Email</label>
								</div>
								<div class="col-sm-10">
									<input value="" type="email" class="form-control" name="email" id="email" placeholder="Email"/>
									<span class="fa form-control-feedback fa-none"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<div class="checkbox">
										<label>
											<input type="checkbox"/>Remember me                                                                                                                                                                    											
										</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-block btn-success">Sign in</button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-md-12">
						<div class="well">
							<h1></h1>
							<a href="{$host}">home</a>
							<a href="{host}?access_token=">account</a>
							<a href="?path=login&amp;authorize=true">authorize app</a>
							<a href="?path=login&amp;authorize=false">deauthorize app</a>
							<a href="?path=login&amp;access_token={access_token}">on login</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</xsl:template>
</xsl:stylesheet>