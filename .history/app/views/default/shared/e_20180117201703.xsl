<xsl:stylesheet version="2.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
    xmlns:php="http://php.net/xsl">
    <xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
    <xsl:param name="controller" as="xs:string">App/controllers/shared/e</xsl:param>
    <xsl:param name="content"/>
    <xsl:strip-space elements="*"/>
    <xsl:template match="/">
        
        <div class="container">
        	<h1>
            <xsl:value-of select="data/error" disable-output-escaping="yes"/>
            <xsl:value-of select="data/response" disable-output-escaping="yes"/>
            </h1>
        </div>
    </xsl:template>
</xsl:stylesheet>