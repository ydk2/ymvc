<xsl:stylesheet version="2.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
    xmlns:php="http://php.net/xsl">
    <xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
    <xsl:param name="controller" as="xs:string">App/controllers/Main</xsl:param>
    <xsl:param name="content"/>
    <xsl:strip-space elements="*"/>
    <xsl:template match="/">
        
        <div class="container">
        	<br/>
            <xsl:value-of select="data/error" disable-output-escaping="yes"/>
            <br/>
            <xsl:value-of select="$self" disable-output-escaping="yes"/>
            <br/>
            <xsl:value-of as="xs:string" select="php:function($self,'test',$parent)"/>
        </div>
    </xsl:template>
</xsl:stylesheet>