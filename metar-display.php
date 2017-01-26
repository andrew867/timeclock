<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Local Weather</title>
<style type="text/css">
.ajaxDashboard {
    font-size: 96%;
        font-family: Verdana, Arial, Helvetica, sans-serif;
}
.ajaxDashboard .datahead {
        font-size: 100%;
        font-weight: bold;
        color:  white;
        background-color: #3173B1;
        text-align: center;
}
.ajaxDashboard .datahead2 {
        font-size: 100%;
        font-weight: bold;
		border-bottom: 1px solid #CCCCCC;
        color:  white;
        background-color: #3173B1;
        text-align: center;
}
.ajaxDashboard .data1 {
         color: black;
         font-size: 100%;
         border-bottom: 1px solid #CCCCCC;
         background-color: white;
         text-align: left;
}
.ajaxDashboard .data2 {
         color: black;
         font-size: 100%;
         background-color: white;
         text-align: left;
}
.ajaxDashboard td {
         border: none;
         background-color: white;
}
</style>
</head>
<body style="width: 200px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color: black; background-color: white;">

	

<?php
$SITE = array();  // required for non-Saratoga template use
global $SITE;

// Customize this list with your nearby METARs by
// using http://saratoga-weather.org/wxtemplates/find-metar.php to create the list below

$MetarList = array( // set this list to your local METARs 
// Metar(ICAO) | Name of station | dist-mi | dist-km | direction |
  'KTOP|Topeka, Kansas|4|7|NE|');
$maxAge = 75*60; // max age for metar in seconds = 75 minutes
#
$SITE['cacheFileDir']   =  './cache/';   // directory to use for scripts cache files .. use './' for doc.root.dir
$SITE['tz'] 			= 'America/Chicago'; //NOTE: this *MUST* be set correctly to
// translate UTC times to your LOCAL time for the displays.
//  http://us.php.net/manual/en/timezones.php  has the list of timezone names
//  pick the one that is closest to your location and put in $SITE['tz'] like:
//    $SITE['tz'] = 'America/Los_Angeles';  // or
//    $SITE['tz'] = 'Europe/Brussels';
$SITE['timeFormat'] = 'D, d-M-Y g:ia T';  // Day, 31-Mar-2006 6:35pm Tz  (USA Style)
$SITE['latitude']		= '39.027153397';    //North=positive, South=negative decimal degrees
$SITE['longitude']		= '-95.62274323';  //East=positive, West=negative decimal degrees

$condIconDir = './metar-images/';  // directory for metar-images with trailing slash
$SITE['fcsticonstype'] = '.jpg'; // default type='.jpg' 
#                                // use '.gif' for animated icons from # http://www.meteotreviglio.com/
$SITE['uomTemp'] = '&deg;F';  // ='&deg;C', ='&deg;F'
$SITE['uomBaro'] = ' inHg';   // =' hPa', =' inHg'
$SITE['uomWind'] = ' mph';    // =' km/h', =' mph'
$SITE['uomRain'] = ' in';     // =' mm', =' in'
$SITE['uomDistance'] = ' mi'; // =' mi' or =' km'
// end of customizations
#
# utility functions .. you don't need to change these
// Wind Rose graphic in ajaxwindiconwr as wrName . winddir . wrType
$wrName   = 'wr-';       // first part of the graphic filename (followed by winddir to complete it)
$wrType   = '.png';      // extension of the graphic filename
$wrHeight = '58';        // windrose graphic height=
$wrWidth  = '58';        // windrose graphic width=
$wrCalm   = 'wr-calm.png';  // set to full name of graphic for calm display ('wr-calm.gif')
$Lang = 'en'; // default language used (for Windrose display)
$SITE['lang'] = $Lang;
if (!function_exists('date_default_timezone_set')) {
   putenv("TZ=" . $SITE['tz']);
  } else {
   date_default_timezone_set($SITE['tz']);
 }
function langtrans ( $str ) { echo $str; return; }
function langtransstr ($str) { return($str); }
$time = date('H:i');
//$sunrise = date_sunrise(time(), SUNFUNCS_RET_STRING, $SITE['latitude'], $SITE['longitude']);
//$sunset  = date_sunset(time(), SUNFUNCS_RET_STRING, $SITE['latitude'], $SITE['longitude']);
$sun_info = date_sun_info(time(),$SITE['latitude'], $SITE['longitude']);
$sunrise = date('H:i',$sun_info['sunrise']);
$sunset  = date('H:i',$sun_info['sunset']);
print "<!-- time='$time' sunrise='$sunrise' sunset='$sunset' latitude='".$SITE['latitude']."' longitude='".$SITE['longitude']."' -->\n";
# end of utility functions
?>

<?php
  if(file_exists("include-metar-display.php")) {
	  include_once("include-metar-display.php");
      print "<p><small>Metar display script from <a href=\"http://saratoga-weather.org/scripts-metar.php#metar\">Saratoga-Weather.org</a></small></p>\n";
  } else {
	  print "<p>Sorry.. include-metar-display.php not found</p>\n";
  }
?>

</body>
</html>