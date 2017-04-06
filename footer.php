<?php

// display 'Powered by' info in bottom right of each page //

echo "        <tr class=hide><td height=4% class=misc_items align=right valign=middle scope=row colspan=2>";

if ($email != "none") {
    echo "<a class=footer_links href='mailto:$email'>$email</a>&nbsp;&#8226;&nbsp;";
}

echo "<a class=footer_links href='https://github.com/BoatrightTBC/timeclock'>$app_name&nbsp;$app_version</a></td></tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</body>\n";
echo "</html>\n";
?>
