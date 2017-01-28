<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:strip-space elements="*"/>
	<xsl:param name="content"/>
	<xsl:param name="action"/>
	<xsl:template match="/">
	<div class="row">
	<div class="col-sm-12">
	<xsl:value-of select="data/header" disable-output-escaping="yes"/>
	</div>
	<div class="col-sm-4">
	<xsl:value-of select="data/menus" disable-output-escaping="yes"/>
	</div>
	<div class="col-sm-8">
	<xsl:call-template name="items"/>
	</div>
	</div>
	</xsl:template>

	<xsl:template match="data/layouts" name="items">
	<form action="{$action}">
        <xsl:apply-templates select="data/layouts/items" />
	</form>
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