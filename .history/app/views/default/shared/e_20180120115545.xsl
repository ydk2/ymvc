<xsl:stylesheet version="2.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
    xmlns:php="http://php.net/xsl">
    <xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
    <xsl:param name="controller" as="xs:string">App/controllers/shared/E</xsl:param>
    <controller xmlns="ymvc" name="login" path="App/controllers/shared/E"/>
    <xsl:param name="content"/>
    <xsl:strip-space elements="*"/>
    <xsl:template match="/">
        
        <div class="container">
        	<h1>
            <xsl:value-of select="data/error" disable-output-escaping="yes"/>
            <xsl:text> </xsl:text>
            <xsl:value-of select="data/response" disable-output-escaping="yes"/>
            </h1>
        </div>
              
        <div class="container">
            <b><a href="{data/host}">Home</a></b>
        </div>
    </xsl:template>
</xsl:stylesheet>