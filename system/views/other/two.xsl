<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:param name="content"/>
	<xsl:param name="show_link"/>
	<xsl:param name="langs">, Second argument from XSLT param</xsl:param>

<xsl:template match="/">
<div class="row">
	<!--<xsl:variable name="hyperlink"><xsl:value-of select="@href" /></xsl:variable>-->
		<h3><xsl:value-of select="data/title"/></h3>
		<xsl:if test="$show_link = 'yes'">
		<div>
		<xsl:for-each select="data/links/a">
				<p><a href="{@href}"><xsl:value-of select="node()"/></a></p>
		</xsl:for-each>
		</div>
		</xsl:if>
		<div>
		<!---->
		<xsl:value-of select="php:function ($self, 'test', 'called function of this class controller from XSLT',$langs)"  xmlns:php="http://php.net/xsl" disable-output-escaping="yes"/>
		<!---->
		<xsl:value-of select="data/message"/>
		</div>
</div>
        <div class="row">
          <div class="col-md-12">
            <div class="embed-responsive embed-responsive-4by3">
              <iframe class="embed-responsive-item" src="http://localhost/phpinfo.php"
              allowfullscreen=""></iframe>
            </div>
          </div>
        </div>
</xsl:template>
</xsl:stylesheet>