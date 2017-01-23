<xsl:stylesheet version="1.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output omit-xml-declaration="yes" indent="yes"/>
    <xsl:strip-space elements="*"/>
    <xsl:template match="/">
        <xsl:apply-templates select="data/views" />
    </xsl:template>
    <xsl:template match="data/views">
        <xsl:if test="node() != ''">
            <div>
                <xsl:for-each select="@*">
                    <xsl:attribute name="{name()}">
                        <xsl:value-of select="." />
                    </xsl:attribute>
                </xsl:for-each>
                <xsl:value-of select="node()" disable-output-escaping="yes"/>
            </div>
        </xsl:if>
    </xsl:template>
</xsl:stylesheet>