  <!-- javascripts -->
    <script src="../scripts/jquery.js"></script>
	<script src="../scripts/jquery-ui-1.10.4.min.js"></script>
    <script src="../scripts/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="../scripts/jquery-ui-1.9.2.custom.min.js"></script>
    <!-- bootstrap -->
    <script src="../scripts/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="../scripts/jquery.scrollTo.min.js"></script>
    <script src="../scripts/jquery.nicescroll.js" type="text/javascript"></script>
    <!-- charts scripts -->

    <script src="../scripts/jquery.sparkline.js" type="text/javascript"></script>

    <script src="../scripts/owl.carousel.js" ></script>
    <!-- jQuery full calendar -->


    <!--script for this page only-->

	<script src="../scripts/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="../scripts/jquery.customSelect.min.js" ></script>


    <!--custome script for all page-->
    <script src="../scripts/scripts.js"></script>
    <!-- custom script for this page-->

	<script src="../scripts/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="../scripts/jquery-jvectormap-world-mill-en.js"></script>

	<script src="../scripts/jquery.autosize.min.js"></script>
	<script src="../scripts/jquery.placeholder.min.js"></script>
	<script src="../scripts/gdp-data.js"></script>
	<script src="../scripts/morris.min.js"></script>
	<script src="../scripts/sparklines.js"></script>

	<script src="../scripts/jquery.slimscroll.min.js"></script>

<?php

// display 'Powered by' info in bottom right of each page //

echo "        <tr class=hide><td height=4% class=misc_items align=right valign=middle scope=row colspan=2>Powered by&nbsp;<a class=footer_links
            href='http://httpd.apache.org/'>Apache</a>&nbsp;&#177<a class=footer_links href='http://mysqli.org'>&nbsp;mysqli</a>
            &#177";

if ($email == "none") {
    echo "<a class=footer_links href='http://php.net'>&nbsp;PHP</a>";
} else {
    echo "<a class=footer_links href='http://php.net'>&nbsp;PHP</a>&nbsp;&#8226;&nbsp;<a class=footer_links href='mailto:$email'>$email</a>";
}

echo "&nbsp;&#8226;<a class=footer_links href='http://github.com/kayoti/timeclock'>&nbsp;$app_name&nbsp;$app_version</a></td></tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</body>\n";
echo "</html>\n";
?>
