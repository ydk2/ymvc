<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:param name="content"/>
	<xsl:param name="show_link"/>
	<xsl:param name="langs">Polski</xsl:param>

<xsl:template match="/">
<div>
	<xsl:for-each select="data/item">
		<p><a href="{@href}"><xsl:value-of select="node()"/></a></p>
	</xsl:for-each>
</div>
</xsl:template>
</xsl:stylesheet>