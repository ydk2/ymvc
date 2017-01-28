<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:strip-space elements="*"/>
	<xsl:param name="content"/>
	<xsl:template match="/">
	<div class="row">
	<div class="col-sm-4">
	<xsl:value-of select="data/menus" disable-output-escaping="yes"/>
	</div>
	<div class="col-sm-8">
	<xsl:value-of select="data/layouts" disable-output-escaping="yes"/>
	</div>
	</div>
	</xsl:template>

	<xsl:template match="data/layouts">
        <xsl:apply-templates select="data/layouts/items" />
    </xsl:template>
    <xsl:template match="data/layouts/items">
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