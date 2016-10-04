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
		<div>
			<xsl:for-each select="data">

					<h3>
						<xsl:value-of select="title"/>
					</h3>
					<div>
						<xsl:value-of select="content"  disable-output-escaping="yes"/>
					</div>
			</xsl:for-each>
		</div>
		<div>
			<xsl:value-of select="$test"/>
		</div>
		<div>
		<xsl:value-of select="$dump"  disable-output-escaping="yes"/>
		<hr/>
		<xsl:value-of select="data/error"/>
		</div>
	</body>
</html>
</xsl:template>
</xsl:stylesheet>