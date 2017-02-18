<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:param name="content"/>
	<xsl:param name="inside"/>
	<xsl:param name="fixie"/>
	<!-- -->
	<xsl:template match="/">
		<xsl:choose>
			<xsl:when test="$inside = 'yes'">
				<xsl:call-template name="inside"/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:call-template name="page"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<!-- -->
	<!-- head -->
	<xsl:template name="head">
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
	</xsl:template>
	<!-- nav -->
	<xsl:template name="nav">
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
								<a href="{@href}">
									<xsl:value-of select="node()"/>
								</a>
							</li>
						</xsl:for-each>
					</ul>
				</div>
			</div>
		</nav>
	</xsl:template>
	<!-- header -->
	<xsl:template name="headers">
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
	</xsl:template>
	<!-- main -->
	<xsl:template name="main">
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
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title">
										<xsl:value-of select="data/subheader"/>
									</h3>
								</div>
								<div class="panel-body">
									<xsl:value-of select="data/content" disable-output-escaping="yes"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>
	</xsl:template>
	<!-- footer -->
	<xsl:template name="footer">
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
						<p>
							<xsl:call-template name="languages"/>
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
	</xsl:template>
	<!-- langs -->
	<xsl:template name="languages">
		<div class="row">
			<div class="col-md-12">
				<div class="btn-toolbar" role="toolbar">
					<div class="btn-group">
						<xsl:for-each select="data/links/langs">
							<a href="{@href}" hreflang="{@hreflang}" type="button" class="btn btn-link">
								<i class="fa fa-fw fa-globe"></i>
								<xsl:value-of select="node()"/>
							</a>
						</xsl:for-each>
					</div>
				</div>
			</div>
		</div>
	</xsl:template>
	<!-- page -->
	<xsl:template name="page">
		<xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html&gt;</xsl:text>
		<html lang="{data/lang}">
			<xsl:call-template name="head"/>
			<body>
				<!-- content -->
				<xsl:call-template name="nav"/>
				<xsl:call-template name="headers"/>
				<xsl:call-template name="main"/>
				<xsl:call-template name="footer"/>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>