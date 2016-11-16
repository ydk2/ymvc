<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:param name="content"/>
	<xsl:param name="fixie"/>
	<xsl:template match="/">
		<xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html&gt;</xsl:text>
		<html lang="{data/lang}">
			<head>
				<meta charset="utf-8"/>
				<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
				<meta name="viewport" content="width=device-width, initial-scale=1"/>
				<title>
					<xsl:value-of select="data/title"/>
				</title>
				<!-- Bootstrap CSS -->
				<link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet"/>
				<!--
	<xsl:value-of select="php:function ('htmlentities','')" xmlns:php="http://php.net/xsl" disable-output-escaping="yes"/>
-->
				<xsl:value-of select='$fixie' disable-output-escaping='yes'/>
				<xsl:text disable-output-escaping='yes'></xsl:text>
				<script src="https://cdn.polyfill.io/v1/polyfill.min.js"></script>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
				<!-- Bootstrap JavaScript -->
				<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
				<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
				<style>
					<![CDATA[
html, body {
width: 100%;
height: 100%;
}
.main {
position: relative;
clear: both;
width: 100%;
min-height: 50%;
}
.footer {
position: relative;
clear: both;
width: 100%;
}
#heads {
color: #c41818;
}
.onleft {
border-left: 5px solid #c41818;
}
.onright {
border-right: 5px solid #c41818;
}
]]>
				</style>
			</head>
			<body>
				<nav class="navbar navbar-default">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="#">
								<span>
									<xsl:value-of select="data/maintitle"/>
								</span>
							</a>
						</div>
						<div class="collapse navbar-collapse" id="navbar-ex-collapse">
							<ul class="nav navbar-nav navbar-right">
								<xsl:for-each select="data/links/items">
									<li>
										<a href="{@href}" hreflang="{@hreflang}">
											<xsl:value-of select="node()"/>
										</a>
									</li>
								</xsl:for-each>
							</ul>
						</div>
					</div>
				</nav>
				<header class="section">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="page-header">
									<h1>
										<xsl:value-of select="data/header"/>
										<small>
											<xsl:text></xsl:text>
											<xsl:value-of select="data/smallheader"/>
										</small>
									</h1>
								</div>
							</div>
						</div>
					</div>
				</header>
				<main class="main">
					<section class="section">
						<div class="container">
							<div class="row">
								<div class="col-md-2">
									<ul class="list-group">
										<xsl:for-each select="data/list/items">
											<li class="list-group-item">
												<a href="{@href}">
													<xsl:value-of select="node()"/>
												</a>
											</li>
										</xsl:for-each>
									</ul>
								</div>
								<div class="col-md-10">
									<div class="well">
										<h2>
											<xsl:value-of select="data/subheader"/>
										</h2>
										<p>
											<xsl:value-of select="data/content"/>
										</p>
									</div>
								</div>
							</div>
						</div>
					</section>
				</main>
				<!-- main -->
				<footer class="section footer">
					<div class="container">
						<div class="row">
							<div class="col-sm-6">
								<h3>
									<xsl:value-of select="data/footerheader"/>
								</h3>
								<p>
									<xsl:value-of select="data/footercontent"/>
								</p>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-md-12 text-right">
										<a href="#">
											<i class="fa fa-3x fa-fw fa-instagram text-inverse"></i>
										</a>
										<a href="#">
											<i class="fa fa-3x fa-fw fa-twitter text-inverse"></i>
										</a>
										<a href="#">
											<i class="fa fa-3x fa-fw fa-facebook text-inverse"></i>
										</a>
										<a href="#">
											<i class="fa fa-3x fa-fw fa-github text-inverse"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</footer>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>