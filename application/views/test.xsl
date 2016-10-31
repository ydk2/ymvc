<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
 <xsl:output omit-xml-declaration="yes" indent="yes"/>
 <xsl:strip-space elements="*"/>

 <xsl:template match="/">
 <div>
  <xsl:copy-of select="/data/items/section/*/."/>
  </div>
 </xsl:template>
</xsl:stylesheet>