<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:param name="content"/>
	<xsl:template match="/">
	<xsl:value-of select="data/layout/content" disable-output-escaping="yes"/>
	</xsl:template>
</xsl:stylesheet>