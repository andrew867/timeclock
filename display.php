<?php

$row_count = 0;
$page_count = 0;

while ($row=mysql_fetch_array($result)) {

    $display_stamp = "".$row["timestamp"]."";
    $time = date($timefmt, $display_stamp);
    $date = date($datefmt, $display_stamp);

        if ($row_count == 0) {

            if ($page_count == 0) {

                // display sortable column headings for main page //

                echo "            <table class=misc_items width=100% border=0 cellpadding=2 cellspacing=0>\n";

                if (!isset($_GET['printer_friendly'])) {
                    echo "              <tr><td align=right colspan=7><a style='font-size:11px;color:#853d27;' 
                                          href='timeclock.php?printer_friendly=true'>printer friendly page</a></td></tr>\n";
                }

                echo "              <tr class=notprint>\n";
                echo "                <td nowrap width=20% align=left style='padding-left:10px;padding-right:10px;'>
                                    <a style='font-size:11px;color:#27408b;'
                                    href='$current_page?sortcolumn=empfullname&sortdirection=$sortnewdirection'>Name</a></td>\n";
                echo "                <td nowrap width=7% align=left style='padding-left:10px;'><a style='font-size:11px;color:#27408b;'
                                    href='$current_page?sortcolumn=inout&sortdirection=$sortnewdirection'>In/Out</a></td>\n";
                echo "                <td nowrap width=5% align=right style='padding-right:10px;'><a style='font-size:11px;color:#27408b;' 
                                    href='$current_page?sortcolumn=tstamp&sortdirection=$sortnewdirection'>Time</a></td>\n";
                echo "                <td nowrap width=5% align=right style='padding-left:10px;'><a style='font-size:11px;color:#27408b;' 
                                    href='$current_page?sortcolumn=tstamp&sortdirection=$sortnewdirection'>Date</a></td>\n";

                if ($display_office_name == "yes") {
                    echo "                <td nowrap width=10% align=left style='padding-left:10px;'><a style='font-size:11px;color:#27408b;' 
                                        href='$current_page?sortcolumn=office&sortdirection=$sortnewdirection'>Office</a></td>\n";
                }

                if ($display_group_name == "yes") {
                    echo "                <td nowrap width=10% align=left style='padding-left:10px;'><a style='font-size:11px;color:#27408b;' 
                                        href='$current_page?sortcolumn=groups&sortdirection=$sortnewdirection'>Group</a></td>\n";
                }

                echo "                <td style='padding-left:10px;'><a style='font-size:11px;color:#27408b;'
                                    href='$current_page?sortcolumn=notes&sortdirection=$sortnewdirection'><u>Notes</u></a></td>\n";
                echo "              </tr>\n";

            } else {

            // display report name and page number of printed report above the column headings of each printed page //

            $temp_page_count = $page_count + 1;
        }

        echo "              <tr class=notdisplay>\n";
        echo "                <td nowrap width=20% align=left style='padding-left:10px;padding-right:10px;font-size:11px;color:#27408b;
                            text-decoration:underline;'>Name</td>\n";
        echo "                <td nowrap width=7% align=left style='padding-left:10px;font-size:11px;color:#27408b;
                            text-decoration:underline;'>In/Out</td>\n";
        echo "                <td nowrap width=5% align=right style='padding-right:10px;font-size:11px;color:#27408b;
                            text-decoration:underline;'>Time</td>\n";
        echo "                <td nowrap width=5% align=right style='padding-left:10px;font-size:11px;color:#27408b;
                            text-decoration:underline;'>Date</td>\n";

        if ($display_office_name == "yes") {
            echo "                <td nowrap width=10% align=left style='padding-left:10px;font-size:11px;color:#27408b;
                                text-decoration:underline;'>Office</td>\n";
        }

        if ($display_group_name == "yes") {
            echo "                <td nowrap width=10% align=left style='padding-left:10px;font-size:11px;color:#27408b;
                                text-decoration:underline;'>Group</td>\n";
        }

        echo "                <td style='padding-left:10px;'><a style='font-size:11px;color:#27408b;text-decoration:underline;'>Notes</td>\n";
        echo "              </tr>\n";
    }

    // begin alternating row colors //

    $row_color = ($row_count % 2) ? $color1 : $color2;

    // display the query results //

    $display_stamp = $display_stamp + @$tzo;
    $time = date($timefmt, $display_stamp);
    $date = date($datefmt, $display_stamp);

    if ($show_display_name == "yes") {
        echo stripslashes("              <tr class=display_row><td nowrap width=20% bgcolor='$row_color' style='padding-left:10px; 
                          padding-right:10px;'>".$row["displayname"]."</td>\n");
    } elseif ($show_display_name == "no") {
        echo stripslashes("              <tr class=display_row><td nowrap width=20% bgcolor='$row_color' style='padding-left:10px;
                          padding-right:10px;'>".$row["empfullname"]."</td>\n");
    }

    echo "                <td nowrap align=left width=7% style='background-color:$row_color;color:".$row["color"].";
                        padding-left:10px;'>".$row["inout"]."</td>\n";
    echo "                <td nowrap align=right width=5% bgcolor='$row_color' style='padding-right:10px;'>".$time."</td>\n";
    echo "                <td nowrap align=right width=5% bgcolor='$row_color' style='padding-left:10px;'>".$date."</td>\n";

    if ($display_office_name == "yes") {
        echo "                <td nowrap align=left width=10% bgcolor='$row_color' style='padding-left:10px;'>".$row["office"]."</td>\n";
    }

    if ($display_group_name == "yes") {
        echo "                <td nowrap align=left width=10% bgcolor='$row_color' style='padding-left:10px;'>".$row["groups"]."</td>\n";
    }

    echo stripslashes("                <td bgcolor='$row_color' style='padding-left:10px;'>".$row["notes"]."</td>\n");
    echo "              </tr>\n";

    $row_count++;
	
    // output 40 rows per printed page //

    if ($row_count == 40) {
        echo "              <tr style=\"page-break-before:always;\"></tr>\n";
        $row_count = 0;
        $page_count++;
    }

}

echo "            </table>\n";

if (!isset($_GET['printer_friendly'])) {
    echo "          </td></tr>\n";
}

mysql_free_result($result);
?>
