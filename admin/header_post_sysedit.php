<?php
include "header.admin.inc.php";

echo "<link rel='stylesheet' type='text/css' media='screen' href='../css/default.css' />\n";
echo "<link rel='stylesheet' type='text/css' media='print' href='../css/print.css' />\n";
echo "<script type=\"text/javascript\" src=\"../scripts/CalendarPopup.js\"></script>\n";
echo "<script language=\"javascript\">document.write(getCalendarStyles());</script>\n";
echo "<script language=\"javascript\" src=\"../scripts/pnguin.js\"></script>\n";
include '../scripts/dropdown_post_sysedit.php';
echo "</head>\n";

setTimeZone();

echo "<body onload='office_names();'>\n";
?>
