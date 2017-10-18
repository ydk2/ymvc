 
<xsl:stylesheet 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
    <xsl:param name="pagename" select="start"/>
    <xsl:template match="/data">
        <xsl:call-template name="nav"/>
    </xsl:template>
    <xsl:template name="nav">
        <ul class="nav nav-tabs">
            <xsl:apply-templates select="item" mode="nav"/>
        </ul>
    </xsl:template>
    <xsl:template match="item" mode="nav">
        <xsl:choose>
            <xsl:when test="item">
                <li class="dropdown">
                    <xsl:apply-templates select="@name[.=$pagename]" mode="nav"/>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="{@url}">
                        <xsl:value-of select="@name"/>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                    <li>
                    <xsl:apply-templates select="@name[.=$pagename]" mode="nav"/>
                    <a href="{@url}">
                        <xsl:value-of select="@name"/>
                    </a>
                    </li>
                        <xsl:apply-templates select="item" mode="nav"/>
                    </ul>
                </li>
            </xsl:when>
            <xsl:otherwise>
                <li>
                    <xsl:apply-templates select="@name[.=$pagename]" mode="nav"/>
                    <a href="{@url}">
                        <xsl:value-of select="@name"/>
                    </a>
                </li>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="@name" mode="nav">
        <xsl:attribute name="class">
            <xsl:value-of select="'active'"/>
        </xsl:attribute>
    </xsl:template>
</xsl:stylesheet>