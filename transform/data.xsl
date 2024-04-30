<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html"/>
    <xsl:template match="dato">
        <tr>
            <td><xsl:value-of select="nombre"/></td>
            <td><xsl:value-of select="apellido"/></td>
            <td><xsl:value-of select="edad"/></td>
            <td><xsl:value-of select="correo"/></td>
        </tr>
    </xsl:template>
    <xsl:template match="/">
        <html>
            <table>
                <thead>
                    <tr>
                        <td>Nombre</td>
                        <td>Apellido</td>
                        <td>Edad</td>
                        <td>Correo</td>
                    </tr>
                </thead>
                <tbody>
                    <xsl:apply-templates select="//datos"/>
                </tbody>
            </table>
            
        </html>
    </xsl:template>
</xsl:stylesheet>
