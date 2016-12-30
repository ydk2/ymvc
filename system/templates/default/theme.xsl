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

			<section class="section">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
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
				<!-- main -->

			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>