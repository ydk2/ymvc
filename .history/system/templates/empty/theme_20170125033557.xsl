<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:param name="content"/>
	<xsl:param name="fixie"/>
	<xsl:template match="/">
		<xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html&gt;</xsl:text>
		<html lang="{data/lang}">
			<head>
				<xsl:value-of select='data/header' disable-output-escaping='yes'/>
				<xsl:value-of select='$fixie' disable-output-escaping='yes'/>
			</head>
			<body>
				<xsl:value-of select='data/contents' disable-output-escaping='yes'/>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>