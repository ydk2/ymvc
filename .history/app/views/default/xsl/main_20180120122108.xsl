<xsl:stylesheet version="2.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
    xmlns:php="http://php.net/xsl"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
     xmlns:ymvc="https://ydk2.tk/ymvc"
    >
    <ymvc:controller name="main" path="app/controllers/json/main"/>
    <xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
    <xsl:param name="controller" as="xs:string">app/controllers/json/main</xsl:param>
    <xsl:param name="content"/>
    <xsl:strip-space elements="*"/>
    <xsl:template match="/">
        <div class="container">
            <h1>
                <xsl:value-of select="data/header" disable-output-escaping="yes"/>
            </h1>
            <p>
                <xsl:value-of select="data/error" disable-output-escaping="yes"/>
            </p>
        </div>
        <div class="container">
            <a href="{data/host}">Home</a>
            <br/>
            <a href="{data/host}?path=test">Test</a>
        </div>
    </xsl:template>
</xsl:stylesheet>