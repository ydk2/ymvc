 
<xsl:stylesheet 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
    <xsl:param name="pageid" select="9"/>
    <xsl:template match="/data">
        <xsl:call-template name="form"/>
    </xsl:template>
    <xsl:template name="form">
        <form>
            <xsl:for-each select="@*">
                <xsl:attribute name="{name()}">
                    <xsl:value-of select="." />
                </xsl:attribute>
            </xsl:for-each>
            <xsl:apply-templates select="item" mode="form"/>
        </form>
    </xsl:template>
    <xsl:template match="item" mode="form">
        <div>
            <input>
                <xsl:for-each select="@*">
                    <xsl:attribute name="{name()}">
                        <xsl:value-of select="." />
                    </xsl:attribute>
                </xsl:for-each>
            </input>
        </div>
    </xsl:template>
</xsl:stylesheet>