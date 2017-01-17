 <xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
    <xsl:param name="pageid" select="9"/>

    <xsl:template match="/data">
        <xsl:call-template name="nav"/>
    </xsl:template>

    <xsl:template name="nav">
        <ul>
            <xsl:apply-templates select="item" mode="nav"/>
        </ul>
        <!--
            <xsl:if test="@id != ''"><xsl:attribute name="id"><xsl:value-of select="@id" /></xsl:attribute></xsl:if><xsl:if test="@class != ''"><xsl:attribute name="class"><xsl:value-of select="@class" /></xsl:attribute></xsl:if><xsl:if test="@style != ''"><xsl:attribute name="style"><xsl:value-of select="@style" /></xsl:attribute></xsl:if>
        -->
    </xsl:template>

    <xsl:template match="item" mode="nav">
        <li>
            <xsl:apply-templates select="@id[.=$pageid]" mode="nav"/>
			<a href="{@url}"><xsl:value-of select="@name"/></a>
            <xsl:if test="item">
                <ul>
                    <xsl:apply-templates select="item" mode="nav"/>
                </ul>
            </xsl:if>
        </li>

    </xsl:template>

    <xsl:template match="@id" mode="nav">
        <xsl:attribute name="class">
            <xsl:value-of select="'active'"/>
        </xsl:attribute>
    </xsl:template>

</xsl:stylesheet>