<xsl:stylesheet version="1.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output omit-xml-declaration="yes" indent="yes"/>
    <xsl:strip-space elements="*"/>
    <xsl:template match="/">
        <xsl:apply-templates select="data/layout/sections" />
    </xsl:template>
    <xsl:template match="data/layout/sections">
        <xsl:if test="node() != ''">
        <section>
                <xsl:for-each select="@*">
                    <xsl:attribute name="{name()}">
                        <xsl:value-of select="." />
                    </xsl:attribute>
                </xsl:for-each>
            <xsl:value-of select="node()" disable-output-escaping="yes"/>
        </section>
        </xsl:if>
    </xsl:template>
</xsl:stylesheet>