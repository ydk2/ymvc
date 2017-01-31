<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:strip-space elements="*"/>
	<xsl:param name="current"/>
	<xsl:param name="action"/>
	<xsl:param name="addgroup"/>
	<xsl:param name="addgrouphidden"/>
	<xsl:template match="/">
	<div class="row">
	<div class="col-sm-12">
	<strong class="lead">
	<xsl:value-of select="data/header"/>
	</strong>
	<div class="row">
	<ul class="breadcrumb">
    <li><strong>Pokaż w kolumnach</strong></li>
		<xsl:for-each select="data/columns/list">
			<li><a href="{./@link}">
			<xsl:value-of select="=./title" />
			</a></li>
		</xsl:for-each>
	</ul>
	</div>
	</div>
	<div class="col-sm-4">
	<div class="row">
	<h2>Dodaj nową grupę</h2>
	<form role="form" method="get" action="{$addgroup}">
    <div class="form-group">
        <div class="input-group">
        <input type="text" class="form-control" name="group" placeholder="Wpisz nazwę nowej grupy"/>

        <span class="input-group-btn">
    	<button class="btn btn-success" name="{$addgrouphidden}" value="add" type="submit">Dodaj</button>
        </span>
        </div>
    </div>
    </form>
	</div>
	<div class="row">
	<xsl:value-of select="data/addnewitem" disable-output-escaping="yes"/>
	</div>
	<div class="row">
	<xsl:value-of select="data/menus" disable-output-escaping="yes"/>
	</div>
	</div>
	<div class="col-sm-8">
	<xsl:choose>
	  <xsl:when test="data/message !='' ">
	  	<xsl:call-template name="msg"/>
	  </xsl:when>
	  <xsl:otherwise>
		  <xsl:call-template name="items"/>
	  </xsl:otherwise>
	</xsl:choose>

	</div>
	</div>
	</xsl:template>

	<xsl:template match="data/message" name="msg">
        <div class="row">
          <div class="col-md-12">
            <div class="jumbotron">
              <h2 class="text-primary"><xsl:value-of select="data/message/header" /></h2>
              <p class="text-primary"><xsl:value-of select="data/message/text"  disable-output-escaping="yes"/></p>
              <a href="{data/message/link}" class="btn btn-info btn-large">OK</a>
            </div>
          </div>
        </div>
	</xsl:template>

	<xsl:template match="data/layouts" name="items">
	<!--
	<xsl:value-of select="$action"/>
	-->
	<h2><xsl:text>Edytowany Layout: </xsl:text><xsl:value-of select="$current"/></h2>
	<xsl:choose>
    <xsl:when test="data/layouts/items != ''">
	<form action="{$action}&amp;action=update" method="post">
		<div class="form-group">
        <xsl:apply-templates select="data/layouts/items" />
		</div>
		<div class="form-group">
        <div class="col-sm-offset-2 col-sm-8">
        <button type="submit" name="update" class="btn btn-primary btn-block">Update</button>
        </div>
        </div>
	</form>
    </xsl:when>
    <xsl:otherwise>
		<h2 class="text-primary">Empty group</h2>
    </xsl:otherwise>
	</xsl:choose>
	<div class="col-sm-12">
		<xsl:value-of select="data/dump"  disable-output-escaping="yes"/>
	</div>
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