<xsl:stylesheet version="2.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
    <ymvc:controller xmlns:ymvc="https://ydk2.tk/ymvc" name="xsl" path="app/controllers/json/xsl"/>
    <xsl:param name="content"/>
    <xsl:strip-space elements="*"/>
    <xsl:template match="/">
        
        <div class="container">
        	<br/>
            <xsl:value-of select="data/error" disable-output-escaping="yes"/>
            <br/>
            <xsl:value-of select="$self" disable-output-escaping="yes"/>
            <br/>
            <xsl:value-of xmlns:php="http://php.net/xsl" as="xs:string" select="php:function($self,'test',$self)"/>
        </div>
    </xsl:template>
</xsl:stylesheet>