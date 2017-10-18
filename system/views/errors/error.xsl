<xsl:stylesheet version="1.0" 
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
<xsl:param name="content"/>
<xsl:param name="inside"/>
<xsl:param name="show_link"/>
<xsl:param name="fixie"/>

<xsl:template match="/">
<xsl:choose>
<xsl:when test="$inside = 'yes'">
<xsl:call-template name="inside"/>
</xsl:when>
<xsl:otherwise>
<xsl:call-template name="outside"/>
</xsl:otherwise>
</xsl:choose>
</xsl:template>

<xsl:template name="outside">
<xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html&gt;
</xsl:text>
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
	<xsl:value-of select="php:function ('htmlentities','')"  xmlns:php="http://php.net/xsl" disable-output-escaping="yes"/>
-->
<xsl:value-of select='$fixie' disable-output-escaping='yes'/>
<xsl:text disable-output-escaping='yes'></xsl:text>
<script src="https://cdn.polyfill.io/v1/polyfill.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<style><![CDATA[
html, body {
width: 100%;
height: 100%;
}
.main {
padding-top: 10%;
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
			<body class="bg-danger">
				<main class="main">
					<div class="section">
						<div class="container">
							<div class="col-md-12">
								<div class="jumbotron">
									<h1 id="heads" class="text-danger">
										<span class="fa fa-3x fa-fw fa-exclamation-circle"></span>
										<xsl:text> </xsl:text>
										<xsl:value-of select="data/header" disable-output-escaping="yes"/>
									</h1>
									<p class="lead text-danger">
										<b>
											<xsl:value-of select="data/alert" disable-output-escaping="yes"/>
										</b>
										<xsl:text> </xsl:text>
										<span class="label label-danger">
											<xsl:value-of select="data/error"/>
										</span>
									</p>
									<xsl:if test="$inside != 'yes' or $show_link = 'yes'">
										<xsl:for-each select="data/links/a">
											<a class="btn btn-large btn-danger" href="{@href}">
												<xsl:value-of select="node()"/>
											</a>
										</xsl:for-each>
									</xsl:if>
								</div>
							</div>
						</div>
					</div>
				</main>
			</body>
		</html>
	</xsl:template>
	<xsl:template name="inside">
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-dismissable alert-danger lead">
					<button contenteditable="false" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<strong>
						<span class="fa fa-3x fa-fw fa-exclamation-circle"></span>
						<xsl:text> </xsl:text>
						<xsl:value-of select="data/title" disable-output-escaping="yes"/>
					</strong>
					<xsl:text> </xsl:text>
					<xsl:value-of select="data/alert" disable-output-escaping="yes"/>
					<xsl:text> </xsl:text>
					<xsl:value-of select="data/error"/>
				</div>
			</div>
		</div>
	</xsl:template>
</xsl:stylesheet>