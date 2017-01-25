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
				<style>
					<![CDATA[
html, body {
width: 100%;
height: 100%;
}
.navbar  {
background: rgb(66, 184, 221);
}
.main {
position: relative;
clear: both;
width: 100%;
min-height: 50%;
}
.footer {
position: relative;
clear: both;
width: 100%;
}
#heads {
color: #c41818;
}
.onleft {
border-left: 5px solid #c41818;
}
.onright {
border-right: 5px solid #c41818;
}
    td, th {
      padding: 0px;
      margin:0px;
    border-spacing: 0px;
    border-collapse: collapse;
    }

    .custom-restricted {
      height: 150px;
      border-radius: 0px;
	  overflow-y:scroll;
    }
    .pure-button,
    .button-success,
    .button-error,
    .button-warning,
    .button-secondary {
        color: white;
        border-radius: 0px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    }
    
    .button-success {
        background: rgb(28, 184, 65); /* this is a green */
    }
    
    .button-error {
        background: rgb(202, 60, 60); /* this is a maroon */
    }

    .button-warning {
        background: rgb(223, 117, 20); /* this is an orange */
    }

    .button-secondary {
        background: rgb(66, 184, 221); /* this is a light blue */
    }
    .pure-table-odd, .pure-table-odd input, .pure-table-odd select {
        color: white;
        background: rgb(66, 14, 100); /* this is a light blue */
    }
]]>
				</style>
			</head>
			<body>
			<div class="container">
				<xsl:value-of select='data/contents' disable-output-escaping='yes'/>
			</div>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>