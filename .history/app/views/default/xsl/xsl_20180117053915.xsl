<xsl:stylesheet version="1.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
    <xsl:param name="controller" select="App\controllers\XSL\Xsl"/>
	<xsl:param name="content"/>
    <xsl:strip-space elements="*"/>
	<xsl:template match="/">
	<div class="container">
	<xsl:value-of select="data/content" disable-output-escaping="yes"/>
	</div>
	</xsl:template>
</xsl:stylesheet>