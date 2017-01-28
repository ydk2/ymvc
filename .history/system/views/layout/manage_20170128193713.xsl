<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:param name="content"/>
	<xsl:template match="/">
	<div class="container">
	<xsl:value-of select="data/content" disable-output-escaping="yes"/>
	</div>
	</xsl:template>

	<xsl:template match="data/layout">
        <xsl:apply-templates select="data/layout/views" />
    </xsl:template>
    <xsl:template match="data/layout/views">
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