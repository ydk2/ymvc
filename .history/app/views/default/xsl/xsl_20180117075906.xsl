<xsl:stylesheet version="2.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
    <xsl:param name="controller" as="xs:string">App/controllers/XSL/Xsl</xsl:param>
	<xsl:param name="content"/>
    <xsl:strip-space elements="*"/>
	<xsl:template match="/">

	<div class="container">
	Test is loaded
	</div>
	<div class="container">
	<xsl:value-of select="data/content" disable-output-escaping="yes"/>
    <br/>
	<xsl:value-of select="$controller" disable-output-escaping="yes"/>
	</div>
	</xsl:template>
</xsl:stylesheet>