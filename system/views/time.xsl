<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:param name="content"/>
	<xsl:param name="test"/>
	<xsl:param name="dump"/>
	<xsl:param name="call"/>
	<xsl:param name="langs">Polski</xsl:param>

<xsl:template match="/">
		<div>
		<xsl:value-of select="data/message"/>
		<xsl:value-of select="data/time"/>
		</div>
</xsl:template>
</xsl:stylesheet>