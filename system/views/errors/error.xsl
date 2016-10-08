<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:param name="content"/>
	<xsl:param name="inside"/>
	<xsl:param name="show_link"/>
	<xsl:param name="call"/>
	<xsl:param name="langs">Polski</xsl:param>

<xsl:template match="/">
<xsl:choose>
<xsl:when  test="$inside = 'yes'">
	<xsl:call-template name="inside"/>
</xsl:when>
<xsl:otherwise>
	<xsl:call-template name="outside"/>
</xsl:otherwise>
</xsl:choose>
</xsl:template>

<xsl:template name="outside">

<!----><xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html&gt;
</xsl:text><!---->
<html lang="pl">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><xsl:value-of select="data/title"/></title>
</head>
	<body>
		<xsl:call-template name="inside"/>
	</body>
</html>

</xsl:template>

<xsl:template name="inside">

<div>
	<h3><xsl:value-of select="data/header"  disable-output-escaping="yes"/></h3>
		<div>
		<xsl:value-of select="data/alert"  disable-output-escaping="yes"/>
		<xsl:value-of select="data/error"/>
		</div>
		<xsl:if test="$inside != 'yes' or $show_link = 'yes'">
		<div>
		<xsl:for-each select="data/links/a">
				<p><a href="{@href}"><xsl:value-of select="node()"/></a></p>
		</xsl:for-each>
		</div>
		</xsl:if>
</div>

</xsl:template>

</xsl:stylesheet>