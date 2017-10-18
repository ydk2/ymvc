<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:param name="content"/>
	<xsl:param name="test"/>
	<xsl:param name="dump"/>
	<xsl:param name="call"/>
	<xsl:param name="langs">Polski</xsl:param>

<xsl:template match="/">
<div>
		<h3>
		<xsl:value-of select="php:function('Intl::_', 'Used resources', 'time')"  xmlns:php="http://php.net/xsl" />
		</h3>
		<div>
		<xsl:value-of select="data/message"/>
		<xsl:value-of select="data/time"/>
		</div>
		<div>
		<xsl:value-of select="data/cpu"/>
		</div>
		<div>
		<xsl:value-of select="data/memory"/>
		</div>
</div>
</xsl:template>
</xsl:stylesheet>