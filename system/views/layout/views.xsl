<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
 <xsl:output omit-xml-declaration="yes" indent="yes"/>
 <xsl:strip-space elements="*"/>
    <xsl:template match="/">
        <xsl:apply-templates select="data/layout/views" />
    </xsl:template>
   <xsl:template match="data/layout/views">
        <xsl:if test="node() != ''">
        <div>
            <xsl:if test="@id != ''">
                <xsl:attribute name="id">
                    <xsl:value-of select="@id" />
                </xsl:attribute>
            </xsl:if>
            <xsl:if test="@class != ''">
                <xsl:attribute name="class">
                    <xsl:value-of select="@class" />
                </xsl:attribute>
            </xsl:if>
            <xsl:if test="@style != ''">
                <xsl:attribute name="style">
                    <xsl:value-of select="@style" />
                </xsl:attribute>
            </xsl:if>
            <xsl:value-of select="node()" disable-output-escaping="yes"/>
        </div>
        </xsl:if>
    </xsl:template>
</xsl:stylesheet>