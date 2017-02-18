
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="">
        <xsl:value-of select="@name"/>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
    <li>
    <a href="{@url}">
        <xsl:value-of select="@name"/>
    </a>
    </li>
        <xsl:apply-templates select="item" mode="nav"/>
    </ul>
</li>
<li>
    <xsl:apply-templates select="@name[.=$pagename]" mode="nav"/>
    <a href="{@url}">
        <xsl:value-of select="@name"/>
    </a>
</li>