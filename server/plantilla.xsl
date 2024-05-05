<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	
	<xsl:output method="html" omit-xml-declaration="yes" indent="yes"/>
	<xsl:template match="/carrera">
		<xsl:value-of select="nombre"/>
		<ul><xsl:apply-templates select="alumnos/alumno"/></ul>
	</xsl:template>
	
	<xsl:template match="alumno">
		<li><xsl:value-of select="."/></li>
	</xsl:template>
	
</xsl:stylesheet>