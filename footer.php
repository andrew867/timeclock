<?php

// display 'Powered by' info in bottom right of each page //

echo "        <tr class=hide><td height=4% class=misc_items align=right valign=middle scope=row colspan=2>Powered by&nbsp;<a class=footer_links 
            href='http://httpd.apache.org/'>Apache</a>&nbsp;&#177<a class=footer_links href='http://mysql.org'>&nbsp;MySql</a> 
            &#177";

if ($email == "none") {
    echo "<a class=footer_links href='http://php.net'>&nbsp;PHP</a>";
} else {
    echo "<a class=footer_links href='http://php.net'>&nbsp;PHP</a>&nbsp;&#8226;&nbsp;<a class=footer_links href='mailto:$email'>$email</a>";
}

echo "&nbsp;&#8226;<a class=footer_links href='http://timeclock.sourceforge.net'>&nbsp;$app_name&nbsp;$app_version</a></td></tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</body>\n";
echo "</html>\n";
?>
