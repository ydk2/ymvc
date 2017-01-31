<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" indent="yes"/>
	<xsl:param name="content"/>
	<xsl:template match="/">
	<div class="jumbotron">
              <h3 class="text-center text-muted">YMVC
                <small>&#160;System</small>
              </h3>
              <hr/>
              <p class="text-center text-primary">Magazyn 11</p>
              <ul class="nav nav-stacked nav-tabs">
                <li class="active">
                  <a href="#">Ustawienia Główne</a>
                </li>
                <li>
                  <a href="#">Zarządzaj Profilami</a>
                </li>
                <li>
                  <a href="#">Zarządzaj Menu</a>
                </li>
                <li>
                  <a href="#">Zarządzaj Modułami</a>
                </li>
                <li>
                  <a href="#">Zarządzaj Dostępem</a>
                </li>
                <li>
                  <a href="#">Zarządzaj Wyglądem</a>
                </li>
              </ul>
              <a class="btn btn-block btn-large btn-primary">Administracja</a>
              <a class="btn btn-block btn-large btn-primary">Użykownicy</a>
              <a class="btn btn-block btn-large btn-primary">Programy</a>
    </div>
	</xsl:template>
</xsl:stylesheet>