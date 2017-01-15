 
<xsl:stylesheet 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
    <xsl:param name="title"/>
    <xsl:template match="/data">
        <xsl:call-template name="form"/>
    </xsl:template>
    <xsl:template name="form">
        <div class="col-sm-offset-2 col-sm-8">
            <xsl:if test="($title != '')">
                <h2><xsl:value-of select="$title" /></h2>
            </xsl:if>
        <form>
            <xsl:for-each select="@*">
                <xsl:attribute name="{name()}">
                    <xsl:value-of select="." />
                </xsl:attribute>
            </xsl:for-each>
            <xsl:apply-templates select="item" mode="form"/>
        </form>
        </div>
    </xsl:template>
    <xsl:template match="item" mode="form">
        <xsl:choose>
            <xsl:when test="(@type != 'submit') and (@type != 'button') and (@type != 'reset') and (@type != 'radio') and (@type != 'checkbox')">
                <xsl:call-template name="input"/>
            </xsl:when>
            <xsl:when test="(@type = 'submit') or (@type = 'button') or (@type = 'reset')">
                <xsl:call-template name="button"/>
            </xsl:when>
            <xsl:when test="(@type = 'checkbox') or (@type = 'radio')">
                <xsl:call-template name="checkbox"/>
            </xsl:when>
            <xsl:otherwise></xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template name="input">
        <div class="form-group">
            <div class="col-sm-12">
                <div class="input-group">
                    <input class="form-control">
                        <xsl:for-each select="@*">
                            <xsl:if test="(name() != 'label') and (name() != 'error')">
                                <xsl:attribute name="{name()}">
                                    <xsl:value-of select="." />
                                </xsl:attribute>
                            </xsl:if>
                        </xsl:for-each>
                    </input>
                    <span class="input-group-addon">
                        <i class="fa fa-lg fa-asterisk {@error}"></i>&#160;                                                                        
                        <xsl:value-of select="@label" />
                    </span>
                </div>
            </div>
        </div>
    </xsl:template>
    <xsl:template name="button">
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <input type="submit" class="btn btn-block btn-primary">
                    <xsl:for-each select="@*">
                        <xsl:if test="(name() != 'label') and (name() != 'error')">
                            <xsl:attribute name="{name()}">
                                <xsl:value-of select="." />
                            </xsl:attribute>
                        </xsl:if>
                    </xsl:for-each>
                </input>
            </div>
        </div>
    </xsl:template>
    <xsl:template name="checkbox">
        <div class="form-group">
            <div class="col-sm-12">
                <label class="checkbox-inline">
                    <input data-toggle="toggle" data-on="Tak" data-off="Nie" data-onstyle="success" data-offstyle="danger">
                        <xsl:for-each select="@*">
                            <xsl:if test="(name() != 'label') and (name() != 'error')">
                                <xsl:attribute name="{name()}">
                                    <xsl:value-of select="." />
                                </xsl:attribute>
                            </xsl:if>
                        </xsl:for-each>
                    </input>
                    <i class="fa fa-lg fa-send"></i>&#160;                                    
                    <xsl:value-of select="@label" />
                </label>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>