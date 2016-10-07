<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:param name="content"/>
	<xsl:param name="test"/>
	<xsl:param name="dump"/>
	<xsl:param name="call"/>
	<xsl:param name="langs">Polski</xsl:param>

<xsl:template match="/">
<!----><xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html&gt;
</xsl:text><!---->
<html lang="pl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><xsl:value-of select="data/title"/></title>
    </head>
	<body>
	<h3><xsl:value-of select="data/header"  disable-output-escaping="yes"/></h3>
		<div>
		<xsl:value-of select="data/alert"  disable-output-escaping="yes"/>
		<xsl:value-of select="data/error"/>
		</div>
		<div>
				<p><a href="{data/links/a/@href}"><xsl:value-of select="data/links/a/node()"/></a></p>
		</div>
	</body>
</html>
</xsl:template>
</xsl:stylesheet>