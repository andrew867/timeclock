<?php
/*
Function:  mtr_conditions($icao, $curtime, $sunrise, $sunset)

Purpose:  fetch and cache a nearby METAR to use to show a conditions icon and text based on
          the current METAR weather report and sky conditions.
		  The iconnumber (matching the Weather-Display set of icons from 0-35) is returned.
Arguments: $icao is the 4-character UPPERCASE identifier of the METAR (e.g. 'KSJC' etc.).
          $curtime is the current time in hh:mm([am|pm]) - defaults to current time
		  $sunrise is the time of local sunrise hh:mm([am|pm]) - defaults to 07:00
		  $sunset is the time of local sunset hh:mm([am|pm])   - defaults to 19:00
		  The times are used to select a day or night version for the icon
		  
Calling sequence:
          list($Currentsolardescription,$iconnumber,$icongraphic,$icontext) = 
		     mtr_conditions($icao, $curtime, $sunrise, $sunset);
where
	$Currentsolardescription will contain a string of the text representing the metar weather and sky conditions.
    $iconnumber will be a number from 0 to 35 representing the WD icon number appropriate for the METAR weather and sky
	$icongraphic will be the name of the .gif file in ./ajax-images/ which matches the iconnumber
	$icontext will contain the alternative (WD text) destription of the icon (mostly for debugging purposes).

Examples from METAR
KSJC='2011/01/22 22:53 KSJC 222253Z 28011KT 10SM FEW160 BKN180 21/05 A2996 RMK AO2 SLP145 T02110050'
Array
(
    [0] => Mostly Cloudy
    [1] => 2
    [2] => day_partly_cloudy.gif
    [3] => Cloudy
)

KCDR='2011/01/23 00:01 KCDR 230001Z AUTO 02018KT 1/4SM -SN FZFG BKN007 OVC012 M06/M07 A2986 RMK AO2 PRESRR P0000'
Array
(
    [0] => Light Snow, Freezing Fog, Overcast
    [1] => 16
    [2] => night_snow.gif
    [3] => Snow
)

WIOO='2011/01/22 23:30 WIOO 222330Z 00000KT 3000 FU FEW011CB BKN008 25/25 Q1011 TEMPO AT0000 5000 -RA'
Array
(
    [0] => Smoke, Mostly Cloudy
    [1] => 7
    [2] => haze.gif
    [3] => Haze
)

	
Author:  Ken True - webmaster@saratoga-weather.org  (with a lot of code borrowed from my own works and others :)
Referemce: METAR Coding http://www.ofcm.gov/fmh-1/pdf/L-CH12.pdf from Federal Meteorological Handbook No. 1 (FCM-H1-2005)
Also see: http://en.wikipedia.org/wiki/METAR for more descriptions.
Note: Runway conditions are not decoded by this function.

Version 1.00 - 21-Jan-2011 - initial release
Version 1.01 - 24-Mar-2011 - added optional return of large-icon .jpg image name for condition and $metar array.
Version 1.02 - 10-Aug-2011 - fixes for function name collisions with *-mesomap.php programs
Version 1.03 - 01-Oct-2011 - added support for alternative animated icon set from http://www.meteotreviglio.com/ 
Version 1.04 - 09-Oct-2011 - fixed issue with 'RA' (rain) condition non-detection
Version 1.05 - 17-Nov-2011 - added $metarGMT optional return and UOM specs
Version 1.06 - 19-Nov-2011 - fixed formatting for Wind Chill
Version 1.07 - 19-Nov-2011 - fixed runway decode for European METARs
Version 1.08 - 22-Nov-2011 - fixed Notice: type errata
Version 1.09 - 23-Nov-2011 - fix for metar reports with >1 runway reports or limited visibility reports
Version 1.10 - 24-Nov-2011 - fix for CAVOK with km/miles selection based on wind units
Version 1.11 - 29-Nov-2011 - added cloud-details return for wxmetar.php page
Version 1.12 - 04-May-2012 - added fix for variable wind decode like VRB02G03KT
Version 1.13 - 31-Aug-2012 - added fixes for incomplete visibility and multiple conditions decode
Version 1.14 - 23-May-2016 - chg source to tgftp.nws.noaa.gov/data from weather.noaa.gov/pub/data (deprecated site)

*/
global $Debug, $GMCVersion;

$GMCVersion = 'get-metar-conditions-inc.php - Version 1.14 - 23-May-2016';

if (isset($_REQUEST['sce']) && ( strtolower($_REQUEST['sce']) == 'view' or
    strtolower($_REQUEST['sce']) == 'show') ) {
   //--self downloader --
   $filenameReal = __FILE__;
   $download_size = filesize($filenameReal);
   header('Pragma: public');
   header('Cache-Control: private');
   header('Cache-Control: no-cache, must-revalidate');
   header("Content-type: text/plain");
   header("Accept-Ranges: bytes");
   header("Content-Length: $download_size");
   header('Connection: close');
   
   readfile($filenameReal);
   exit;
}
// local settings
$cacheFileDir = './';   // default cache file directory

global $cacheFileDir;
//------------ override from Settings.php --------------------
global $SITE;
if(isset($SITE['cacheFileDir']))     {$cacheFileDir = $SITE['cacheFileDir']; }
//------------ end override from Settings.php ----------------
# ------------------------------------------------------------------------------
# main function mtr_conditions
#-------------------------------------------------------------------------------

function mtr_conditions ($icao,$curtime='',$sunrise='',$sunset='',$useJpgIcon=false,$UOM='&deg;F,mph,inHg,in') {
  global $lang, $Debug, $mtrInfo, $metarPtr, $group, $GMCVersion;
  global $Icons, $IconsLarge, $IconsText, $cacheFileDir;
  $metarCacheName = $cacheFileDir."metarcache-$icao.txt";
  $metarRefetchSeconds = 600;  // fetch every 10 minutes
  list($uomTemp,$uomWind,$uomBaro,$uomRain) = explode(',',$UOM.',,,,');
  global $UOMS;
  $UOMS = array(
    'TEMP' => "$uomTemp",
	'WIND' => "$uomWind",
	'BARO' => "$uomBaro",
	'RAIN' => "$uomRain"
   );
  
  if(isset($_REQUEST['cache']) and strtolower($_REQUEST['cache']) == 'refresh') {
      $metarRefetchSeconds = 0;
  }
  if(isset($_REQUEST['cache']) and strtolower($_REQUEST['cache']) == 'norefresh') {
      $metarRefetchSeconds = 9999999;
  }

  $mtrInfo = array();
  $Debug .= "<!-- $GMCVersion -->\n";
//  $Debug .= "<!-- UOMS\n".print_r($UOMS,true)."-->\n";
  if(isset($icao) and strlen($icao) == 4) {

	$Debug .= "<!-- mtr_conditions using METAR ICAO='$icao' -->\n";
	$host = 'tgftp.nws.noaa.gov';
	$path = '/data/observations/metar/stations/';
	$metarURL = 'http://' . $host . $path . $icao . '.TXT';

    $html = '';
    $raw = '';
// get the metar data from the cache or from the URL if the cache is 'stale'
  if (file_exists($metarCacheName) and filemtime($metarCacheName) + $metarRefetchSeconds > time()) {
      $WhereLoaded = "from cache $metarCacheName";
      $html = implode('', file($metarCacheName));
    } else {
      $WhereLoaded = "from URL $metarURL";
      $rawhtml = mtr_fetchUrlWithoutHanging($metarURL);
	  $i = strpos($rawhtml,"\r\n\r\n");
	  $headers = substr($rawhtml,0,$i-1);
	  $content = substr($rawhtml,$i+2);
      $RC = '';
	  if (preg_match("|^HTTP\/\S+ (.*)\r\n|",$rawhtml,$matches)) {
	    $RC = trim($matches[1]);
	  }
	  if(!preg_match('|200 |',$RC)) {
	     $t = array("unable to load $icao data RC=$RC",5,'day_partly_cloudy.gif',"unable to load $icao data RC=$RC",array(),$metarGMT);
         $Debug .= "<!-- mtr_conditions returns RC='".$RC."' for ICAO/METAR='$icao' -->\n";
        return $t;
	  }
	  if(preg_match('|Content-Encoding: gzip|Ui',$headers)) {
		  $Debug .= "<!-- Webserver returned gzipped data, dang 'em -- unzipping response -->\n";
		  // $Debug .= "<!-- content='".$content."' -->\n";
		  $err = 'None';
		  $html = trim(mtr_gzdecode($content,$err));
		  $Debug .= "<!-- mtr_gzdecode err='$err' -->\n";
		  if($err <> 'None') {
		    $Debug .= "<!-- contentX='".bin2hex($content).". -->\n";
		  }
	  } else {
	      $html = $content;
	  }
    $fp = fopen($metarCacheName, "w"); 
    if($fp) {
        $write = fputs($fp, $html); 
        fclose($fp);
	  } else {
	    $Debug .= "<!--Unable to write cache $metarCacheName -->\n";
	  }
  } // end of get the METAR from cache or URL
  $raw_metar = preg_replace("/[\n\r ]+/", ' ', trim(implode(' ', (array)$html)));
  $Debug .= "<!-- loaded $WhereLoaded -->\n";
  $Debug .= "<!-- $icao='$raw_metar' -->\n";
  $metar = trim($raw_metar);
  $metarDate = preg_replace('|/|','-',substr($metar,0,16)) . ':00 GMT';
  $metarGMT = strtotime($metarDate);
  $age = abs(time() - $metarGMT); // age in seconds
  $Debug .= "<!-- age=$age sec '$metarDate' -->\n";

  mtr_load_iconDefs();  // initialize ICON defs to use and lookup arrays

/*
  Metar formatter expects
    CYXU='2010/11/30 23:00 CYXU 302300Z 15013G18KT 5SM -RA BR OVC005 11/10 A2969 RMK SF8 SLP059'
*/

// Clean up the metar.. some are not properly formatted, human made, most likely
    $unprocMetar = $metar;
    $metar = preg_replace('|[\r\n]+|is','',$metar);  // remove internal newlines
	$metar = preg_replace('|/////KT|is','VRB00KT',$metar); // replace bogus wind report
	$metar = preg_replace('|@|is','',$metar);       // remove strange @ in metar
	$metar = preg_replace('|///|is',' ',$metar);      // remove strange standalone slashes
	$metar = preg_replace('| /|is',' ',$metar);      // remove strange standalone slashes
	$metar = preg_replace('| / |is',' ',$metar);      // remove strange standalone slashes
	$metar = preg_replace('| \s+|is',' ',$metar);    // remove multiple spaces
	$metar = preg_replace('| COR |i',' ',$metar);    // remove COR (correction) from raw metar
	$metar = preg_replace('|(\d{5}) KT|i','${1}KT',$metar);    // fix any space in wind value
	$metar = preg_replace('| 999 |',' 9999 ',$metar); // fix malformed unlimited visibility
	$metar = preg_replace('| LRA |',' -RA ',$metar); // fix malformed light rain
	$metar = preg_replace('| HRA |',' +RA ',$metar); // fix malformed light rain
	// $metar = preg_replace('| (\d)SM|i',' 0${1}SM',$metar); // fix malformed visibility to two digits
 	// $metar = preg_replace('| (\d+) (\d+)/(\d+)SM |i',' $1_$2/${3}SM ',$metar); // fix NOAA visibility

    mtr_process($metar,$icao);  // actually parse the metar for conditions.. results in $mtrInfo array

    // assemble the conditions string:
	// use conditions first
	// use sky (clouds) second
	//
	$mtrInfo['RAW-METAR'] = $unprocMetar;
    $Sky = isset($mtrInfo['CLOUDS'])?trim($mtrInfo['CLOUDS']):'';
    $Weather = isset($mtrInfo['CONDITIONS'])?trim($mtrInfo['CONDITIONS']):'';
 
    $Conds = $Weather;  // Choose any conditions report first

    if($Sky <> '' and $Conds <> '') {$Conds .= ", $Sky"; } // append a clouds descriptor if available
	if($Conds == '' and $Sky <> '') {$Conds = $Sky; }     // no weathercond .. use sky only
	
    $iconnumber = mtr_get_iconnumber('',$Conds,$sunrise,$sunset);
	if(!$useJpgIcon) {
	  $useicon = $Icons[$iconnumber];
	} else {
	  $useicon = $IconsLarge[$iconnumber];
	}
	$icondescr = $IconsText[$iconnumber];

    $t = array($Conds,$iconnumber,$useicon,$icondescr,$mtrInfo,$metarGMT);
  } else {
	$t = array("$icao not loaded",5,'day_partly_cloudy.gif',"unable to load data RC=$RC",array(),$metarGMT);
  } // end of ICAO processing
  
  $Debug .= "<!-- mtr_conditions returns '".$t[0]."' iconnumber='".$t[1]."' img='".$t[2]."' comment='".$t[3]."' -->\n";
  return $t;
}
// ------------------------------------------------------------

// get contents from one URL and return as string 
 function mtr_fetchUrlWithoutHanging($url,$useFopen=false) {
// thanks to Tom at Carterlake.org for this script fragment
  global $Debug, $needCookie,$timeStamp,$TOTALtime;
  $overall_start = time();
  if (! $useFopen) {
   // Set maximum number of seconds (can have floating-point) to wait for feed before displaying page without feed
   $numberOfSeconds=5;   

   // Suppress error reporting so Web site visitors are unaware if the feed fails
   error_reporting(0);

   // Extract resource path and domain from URL ready for fsockopen
   $FullUrl = $url;
   $urlParts = parse_url($url);
   
   $domain = $urlParts['host'];
   if(isset($urlParts['port'])) {
      $port   = $urlParts['port'];
   } else { 
      $port   = 80;
   }
   $resourcePath = $urlParts['path'];
   $resourcePath = preg_replace('|nocache|','?'.$timeStamp,$resourcePath);
   if(isset($urlParts['query']))    {$resourcePath .= "?" . $urlParts['query']; }
   if(isset($urlParts['fragment'])) {$resourcePath .= "#" . $urlParts['fragment']; }
   $T_start = mtr_microtime_float();
   $hostIP = gethostbyname($domain);
   $T_dns = mtr_microtime_float();
   $ms_dns  = sprintf("%01.3f",round($T_dns - $T_start,3));
   
   $Debug .= "<!-- GET $resourcePath HTTP/1.1 \n      Host: $domain  Port: $port IP=$hostIP-->\n";
//   print "GET $resourcePath HTTP/1.1 \n      Host: $domain  Port: $port IP=$hostIP\n";

   // Establish a connection
   $socketConnection = fsockopen($hostIP, $port, $errno, $errstr, $numberOfSeconds);
   $T_connect = mtr_microtime_float();
   $T_puts = 0;
   $T_gets = 0;
   $T_close = 0;
   
   if (!$socketConnection)
       {
       // You may wish to remove the following debugging line on a live Web site
       $Debug .= "<!-- Network error: $errstr ($errno) -->\n";
//       print "Network error: $errstr ($errno)\n";
       }    // end if
   else    {
       $xml = '';
	   $getString = "GET $resourcePath HTTP/1.1\r\nHost: $domain\r\nConnection: Close\r\n";
	   if (isset($needCookie[$domain])) {
	     $getString .= $needCookie[$domain] . "\r\n";
		 $Debug .=  "<!-- cookie used '" . $needCookie[$domain] . "' for GET to $domain -->\n";
	   }
	   $getString .= "User-agent: Mesomap Loader\r\nAccept: text/plain,text/html\r\nAccept-Encoding: gzip;q=0,compress;q=0\r\n";
	   $getString .= "\r\n";
//	   print "Sending:\n$getString\n\n";
       fputs($socketConnection, $getString);
       $T_puts = mtr_microtime_float();
	   
       // Loop until end of file
	   $TGETstats = array();
	   $TGETcount = 0;
       while (!feof($socketConnection))
           {
		   $T_getstart = mtr_microtime_float();
           $xml .= fgets($socketConnection, 16384);
		   $T_getend = mtr_microtime_float();
		   $TGETcount++;
		   $TGETstats[$TGETcount] = sprintf("%01.3f",round($T_getend - $T_getstart,3));
           }    // end while
       $T_gets = mtr_microtime_float();
       fclose ($socketConnection);
       $T_close = mtr_microtime_float();
       }    // end else
   $ms_connect = sprintf("%01.3f",round($T_connect - $T_dns,3));

   if($T_close > 0) {
      $ms_puts = sprintf("%01.3f",round($T_puts - $T_connect,3));
	  $ms_gets = sprintf("%01.3f",round($T_gets - $T_puts,3));
	  $ms_close = sprintf("%01.3f",round($T_close - $T_gets,3));
	  $ms_total = sprintf("%01.3f",round($T_close - $T_start,3)); 
    } else {
       $ms_puts = 'n/a';
	  $ms_gets = 'n/a';
	  $ms_close = 'n/a';
	  $ms_total = sprintf("%01.3f",round($T_connect - $T_start,3)); 
   }

   $Debug .= "<!-- HTTP stats:  dns=$ms_dns conn=$ms_connect put=$ms_puts get($TGETcount blocks)=$ms_gets close=$ms_close total=$ms_total secs -->\n";
//   print  "HTTP stats: dns=$ms_dns conn=$ms_connect put=$ms_puts get($TGETcount blocks)=$ms_gets close=$ms_close total=$ms_total secs \n";
//   foreach ($TGETstats as $block => $mstimes) {
//     print "HTTP Block $block took $mstimes\n";
//   }
   $TOTALtime+= ($T_close - $T_start);
   $overall_end = time();
   $overall_elapsed =   $overall_end - $overall_start;
   $Debug .= "<!-- fetch function elapsed= $overall_elapsed secs. -->\n"; 
//   print "fetch function elapsed= $overall_elapsed secs.\n"; 
   return($xml);
 } else {
//   print "<!-- using file function -->\n";
   $T_start = mtr_microtime_float();

   $xml = implode('',file($url));
   $T_close = mtr_microtime_float();
   $ms_total = sprintf("%01.3f",round($T_close - $T_start,3)); 
   $Debug .= "<!-- file() stats: total=$ms_total secs -->\n";
//   print " file() stats: total=$ms_total secs.\n";
   $TOTALtime+= ($T_close - $T_start);
   $overall_end = time();
   $overall_elapsed =   $overall_end - $overall_start;
   $Debug .= "<!-- fetch function elapsed= $overall_elapsed secs. -->\n"; 
//   print "fetch function elapsed= $overall_elapsed secs.\n"; 
   return($xml);
 }

   }    // end mtr_fetchUrlWithoutHanging
// ------------------------------------------------------------------

function mtr_microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}
// ------------------------------------------------------------------
function mtr_gzdecode($rawdata,&$error='',&$filename='',$maxlength=null)
{
	//0d0a1f8b0800000000000003454d390ec3300cdbfb0aee45654a71e463ed5ef40bdd0214feff5adb49130814285122d502535082
	if(strcmp(substr($data,0,2),"\x0d\x0a")) { // got an extra \r\n in the data?
		$data = substr($rawdata,2);
	} else {
		$data = $rawdata;
	}
    $len = strlen($data);
    if ($len < 18 || strcmp(substr($data,0,2),"\x1f\x8b")) {
        $error = "Not in GZIP format.";
        return null;  // Not GZIP format (See RFC 1952)
    }
    $method = ord(substr($data,2,1));  // Compression method
    $flags  = ord(substr($data,3,1));  // Flags
    if ($flags & 31 != $flags) {
        $error = "Reserved bits not allowed.";
        return null;
    }
    // NOTE: $mtime may be negative (PHP integer limitations)
    $mtime = unpack("V", substr($data,4,4));
    $mtime = $mtime[1];
    $xfl   = substr($data,8,1);
    $os    = substr($data,8,1);
    $headerlen = 10;
    $extralen  = 0;
    $extra     = "";
    if ($flags & 4) {
        // 2-byte length prefixed EXTRA data in header
        if ($len - $headerlen - 2 < 8) {
            return false;  // invalid
        }
        $extralen = unpack("v",substr($data,8,2));
        $extralen = $extralen[1];
        if ($len - $headerlen - 2 - $extralen < 8) {
            return false;  // invalid
        }
        $extra = substr($data,10,$extralen);
        $headerlen += 2 + $extralen;
    }
    $filenamelen = 0;
    $filename = "";
    if ($flags & 8) {
        // C-style string
        if ($len - $headerlen - 1 < 8) {
            return false; // invalid
        }
        $filenamelen = strpos(substr($data,$headerlen),chr(0));
        if ($filenamelen === false || $len - $headerlen - $filenamelen - 1 < 8) {
            return false; // invalid
        }
        $filename = substr($data,$headerlen,$filenamelen);
        $headerlen += $filenamelen + 1;
    }
    $commentlen = 0;
    $comment = "";
    if ($flags & 16) {
        // C-style string COMMENT data in header
        if ($len - $headerlen - 1 < 8) {
            return false;    // invalid
        }
        $commentlen = strpos(substr($data,$headerlen),chr(0));
        if ($commentlen === false || $len - $headerlen - $commentlen - 1 < 8) {
            return false;    // Invalid header format
        }
        $comment = substr($data,$headerlen,$commentlen);
        $headerlen += $commentlen + 1;
    }
    $headercrc = "";
    if ($flags & 2) {
        // 2-bytes (lowest order) of CRC32 on header present
        if ($len - $headerlen - 2 < 8) {
            return false;    // invalid
        }
        $calccrc = crc32(substr($data,0,$headerlen)) & 0xffff;
        $headercrc = unpack("v", substr($data,$headerlen,2));
        $headercrc = $headercrc[1];
        if ($headercrc != $calccrc) {
            $error = "Header checksum failed.";
            return false;    // Bad header CRC
        }
        $headerlen += 2;
    }
    // GZIP FOOTER
    $datacrc = unpack("V",substr($data,-8,4));
    $datacrc = sprintf('%u',$datacrc[1] & 0xFFFFFFFF);
    $isize = unpack("V",substr($data,-4));
    $isize = $isize[1];
    // decompression:
    $bodylen = $len-$headerlen-8;
    if ($bodylen < 1) {
        // IMPLEMENTATION BUG!
        return null;
    }
    $body = substr($data,$headerlen,$bodylen);
    $data = "";
    if ($bodylen > 0) {
        switch ($method) {
        case 8:
            // Currently the only supported compression method:
            $data = gzinflate($body,$maxlength);
            break;
        default:
            $error = "Unknown compression method.";
            return false;
        }
    }  // zero-byte body content is allowed
    // Verifiy CRC32
    $crc   = sprintf("%u",crc32($data));
    $crcOK = $crc == $datacrc;
    $lenOK = $isize == strlen($data);
    if (!$lenOK || !$crcOK) {
        $error = ( $lenOK ? '' : 'Length check FAILED. ') . ( $crcOK ? '' : 'Checksum FAILED.');
        return false;
    }
    return $data;
}
// ------------------------------------------------------------------
function mtr_load_iconDefs () {

global $Icons, $IconsLarge, $IconsText, $Conditions, $Debug;

   // CURRENT CONDITIONS ICONS FOR clientraw.txt
   // create array for icons. There are 35 possible values in clientraw.txt
   // It would be simpler to do this with array() but to make it easier to 
   // modify each element is defined individually. Each index [#] corresponds
   // to the value provided in clientraw.txt
   $Icons[0] = "day_clear.gif";            // image sunny.visible
   $Icons[1] = "night_clear.gif";          // image clearnight.visible
   $Icons[2] = "day_partly_cloudy.gif";    // image cloudy.visible
   $Icons[3] = "day_partly_cloudy.gif";    // image cloudy2.visible
   $Icons[4] = "night_partly_cloudy.gif";  // image night cloudy.visible
   $Icons[5] = "day_clear.gif";            // image dry.visible
   $Icons[6] = "fog.gif";                  // image fog.visible
   $Icons[7] = "haze-sm.gif";                 // image haze.visible
   $Icons[8] = "day_heavy_rain.gif";       // image heavyrain.visible
   $Icons[9] = "day_mostly_sunny.gif";     // image mainlyfine.visible
   $Icons[10] = "mist-sm.gif";                // image mist.visible
   $Icons[11] = "fog.gif";                 // image night fog.visible
   $Icons[12] = "night_heavy_rain.gif";    // image night heavyrain.visible
   $Icons[13] = "night_cloudy.gif";        // image night overcast.visible
   $Icons[14] = "night_rain.gif";          // image night rain.visible
   $Icons[15] = "night_light_rain.gif";    // image night showers.visible
   $Icons[16] = "night_snow.gif";          // image night snow.visible
   $Icons[17] = "night_tstorm.gif";        // image night thunder.visible
   $Icons[18] = "day_cloudy.gif";          // image overcast.visible
   $Icons[19] = "day_partly_cloudy.gif";   // image partlycloudy.visible
   $Icons[20] = "day_rain.gif";            // image rain.visible
   $Icons[21] = "day_rain.gif";            // image rain2.visible
   $Icons[22] = "day_light_rain.gif";      // image showers2.visible
   $Icons[23] = "sleet.gif";               // image sleet.visible
   $Icons[24] = "sleet.gif";               // image sleetshowers.visible
   $Icons[25] = "day_snow.gif";            // image snow.visible
   $Icons[26] = "day_snow.gif";            // image snowmelt.visible
   $Icons[27] = "day_snow.gif";            // image snowshowers2.visible
   $Icons[28] = "day_clear.gif";           // image sunny.visible
   $Icons[29] = "day_tstorm.gif";          // image thundershowers.visible
   $Icons[30] = "day_tstorm.gif";          // image thundershowers2.visible
   $Icons[31] = "day_tstorm.gif";          // image thunderstorms.visible
   $Icons[32] = "tornado.gif";             // image tornado.visible
   $Icons[33] = "windy-sm.gif";               // image windy.visible
   $Icons[34] = "day_partly_cloudy.gif";   // stopped rainning
   $Icons[35] = "windyrain-sm.gif";   // wind + rain

   $IconsText[0] =  'Sunny';
   $IconsText[1] =  'Clear';
   $IconsText[2] =  'Cloudy';
   $IconsText[3] =  'Cloudy2';
   $IconsText[4] =  'Partly Cloudy';
   $IconsText[5] =  'Dry';
   $IconsText[6] =  'Fog';
   $IconsText[7] =  'Haze';
   $IconsText[8] =  'Heavy Rain';
   $IconsText[9] =  'Mainly Fine';
   $IconsText[10] = 'Mist';
   $IconsText[11] = 'Fog';
   $IconsText[12] = 'Heavy Rain';
   $IconsText[13] = 'Overcast';
   $IconsText[14] = 'Rain';
   $IconsText[15] = 'Showers';
   $IconsText[16] = 'Snow';
   $IconsText[17] = 'Thunder';
   $IconsText[18] = 'Overcast';
   $IconsText[19] = 'Partly Cloudy';
   $IconsText[20] = 'Rain';
   $IconsText[21] = 'Rain2';
   $IconsText[22] = 'Showers2';
   $IconsText[23] = 'Sleet';
   $IconsText[24] = 'Sleet Showers';
   $IconsText[25] = 'Snow';
   $IconsText[26] = 'Snow Melt';
   $IconsText[27] = 'Snow Showers2';
   $IconsText[28] = 'Sunny';
   $IconsText[29] = 'Thunder Showers';
   $IconsText[30] = 'Thunder Showers2';
   $IconsText[31] = 'Thunder Storms';
   $IconsText[32] = 'Tornado';
   $IconsText[33] = 'Windy';
   $IconsText[34] = 'Stopped Raining';
   $IconsText[35] = 'Wind/Rain';
   
   $IconsLarge = array(
	"skc.jpg",          //  0 imagesunny.visible
	"nskc.jpg",         //  1 imageclearnight.visible
	"bkn.jpg",          //  2 imagecloudy.visible
	"sct.jpg",          //  3 imagecloudy2.visible
	"nbkn.jpg",         //  4 imagecloudynight.visible
	"sct.jpg",          //  5 imagedry.visible
	"fg.jpg",           //  6 imagefog.visible
	"hazy.jpg",         //  7 imagehaze.visible
	"ra.jpg",           //  8 imageheavyrain.visible
	"few.jpg",          //  9 imagemainlyfine.visible
	"mist.jpg",         // 10 imagemist.visible
	"nfg.jpg",          // 11 imagenightfog.visible
	"nra.jpg",          // 12 imagenightheavyrain.visible
	"novc.jpg",         // 13 imagenightovercast.visible
	"nra.jpg",          // 14 imagenightrain.visible
	"nshra.jpg",        // 15 imagenightshowers.visible
	"nsn.jpg",          // 16 imagenightsnow.visible
	"ntsra.jpg",        // 17 imagenightthunder.visible
	"ovc.jpg",          // 18 imageovercast.visible
	"sct.jpg",          // 19 imagepartlycloudy.visible
	"ra.jpg",           // 20 imagerain.visible
	"ra.jpg",           // 21 imagerain2.visible
	"shra.jpg",         // 22 imageshowers2.visible
	"ip.jpg",           // 23 imagesleet.visible
	"ip.jpg",           // 24 imagesleetshowers.visible
	"sn.jpg",           // 25 imagesnow.visible
	"sn.jpg",           // 26 imagesnowmelt.visible
	"sn.jpg",           // 27 imagesnowshowers2.visible
	"skc.jpg",          // 28 imagesunny.visible
	"scttsra.jpg",      // 29 imagethundershowers.visible
	"hi_tsra.jpg",      // 30 imagethundershowers2.visible
	"tsra.jpg",         // 31 imagethunderstorms.visible
	"nsvrtsra.jpg",     // 32 imagetornado.visible
	"wind.jpg",         // 33 imagewindy.visible
	"ra1.jpg",          // 34 stopped rainning
	"windyrain.jpg"     // 35 windy/rain 
	);	



/* the following is a lookup table for conditions text from the metar to return
  the WD Icon number above.  It is sorted such that the most severe conditions
  are at the top of the list, with least severe at the bottom.  This is done
  so that significant weather icon will prevail when multiple conditions/sky cover
  messages are emitted by the METAR station.
  
  tornado/waterspout
  thunder (in any form)
  Ice / Snow/ Freezing / Sleet
  Rain
  Fog
  Haze/Smoke/Dust/Volcano
  cloud cover
  
*/
  
$Condstring = '
#
cond|tornado|32|32|Severe storm|
cond|thunder|31|17|Thunder storm|
cond|ice|23|23|Sleet|
cond|snow|25|16|Snow|
cond|freezing rain|23|23|FrzgRn|
cond|freezing drizzle|23|23|FrzgRn|
cond|freezing fog|6|11|FrzgFog|
cond|hail|23|23|Hail|
cond|heavy rain|8|12|Rain|
cond|light rain|22|15|Rain|
cond|showers|22|15|Showers|
cond|rain|20|14|Rain|
cond|fog|6|11|Fog|
cond|drizzle|22|15|Drizzle|
cond|mist|10|10|Mist|
cond|haze|7|7|Haze|
cond|dust|7|7|Dust|
cond|smoke|7|7|Smoke|
cond|volcanic|7|7|Volcanic Ash|
cond|sand|7|7|Sand|
cond|overcast|18|18|Overcast|
cond|mostly cloudy|2|4|Mostly Cloudy|
cond|partly cloudy|19|4|Partly Cloudy|
cond|few clouds|9|4|Few Clouds|
cond|clear|0|1|Clear|
cond|cloud|19|4|Variable Clouds|
#
';

$config = explode("\n",$Condstring);
foreach ($config as $key => $rec) { // load the parser condition strings
  $recin = trim($rec);
  if ($recin and substr($recin,0,1) <> '#') { // got a non comment record
    list($type,$keyword,$dayicon,$nighticon,$condition) = explode('|',$recin . '|||||');

        if (isset($type) and strtolower($type) == 'cond' and isset($condition)) {
          $Conditions["$keyword"] = "$dayicon\t$nighticon\t$condition";
//          $Debig .= "<!-- '$keyword'='$dayicon','$nighticon' '$condition' -->\n";
        }
  } // end if not comment or blank
} // end loading of loop over config recs



return;

}
// ------------------------------------------------------------------
function mtr_get_iconnumber ($time,$condString,$sunrise,$sunset) {
     // Many thanks to Larry at Anole Computer for the basis of
	 // this routine.
	 // adapted by Ken True to be compatible with WD icon set
     global $Icons, $IconsText, $Conditions, $Debug;
	 
	 $Debug .= "<!-- mtr_get_iconnumber begin: '$time','$condString','$sunrise','$sunset' -->\n";
	 if(!preg_match('/^\d{1,2}:\d{2}[:\d{2}]{0,1}\s*[am|pm]*$/i',$sunrise)) { $sunrise = '';  }
	 if(!preg_match('/^\d{1,2}:\d{2}[:\d{2}]{0,1}\s*[am|pm]*$/i',$sunset)) { $sunset = '';  }
 
     $sunrise2 = mtr_fixupTime(($sunrise<>'')?"$sunrise":"6:00a");
     $sunset2 = mtr_fixupTime(($sunset<>'')?"$sunset":"7:00p");
     $time2 =   mtr_fixupTime(($time<>'')?"$time":date("H:i",time()));
     if ($time2 >= $sunrise2 and $time2 <= $sunset2) {
         $daynight = 'day';
     } // end if
     else {
         $daynight = 'night';
     } // end else
	 $Debug .= "<!-- mtr_get_iconnumber using: time2='$time2' as $daynight for sunrise2='$sunrise2',sunset2='$sunset2'  -->\n";
  $condString = trim($condString);
  reset($Conditions);  // Do search in load order

  $iconnumb = 5; // default is a sunny icon
  // scan over the conditions table and see if an icon fits the description in the table
  foreach ($Conditions as $cond => $condrec) { // look for matching condition

   if(preg_match("!$cond!i",$condString,$mtemp)) {
     list($dayicon,$nighticon,$condition) = explode("\t",$condrec);
         if (preg_match('|night|i',$daynight)) {
           $iconnumb = $nighticon;
         } else {
           $iconnumb = $dayicon;
         }
         break;
   }
 } // end of conditions search
 
  return $iconnumb;
}
// ------------------------------------------------------------------
function mtr_fixupTime ($intime) {
  global $Debug;
  $tfixed = preg_replace('/\s+([AM|PM])/i',"$1",$intime);
  $tfixed = preg_replace('/^(\S+)\s+(\S+)$/is',"$2",$tfixed);
  $t = explode(':',$tfixed);
  if (preg_match('/p/i',$tfixed)) { $t[0] = $t[0] + 12; }
  if ($t[0] > 23) {$t[0] = 12; }
  if (preg_match('/^12.*a/i',$tfixed)) { $t[0] = 0; }
  if ($t[0] < '10') {$t[0] = sprintf("%02d",$t[0]); } // leading zero on hour.
  $t2 = join(':',$t); // put time back to gether;
  $t2 = preg_replace('/[^\d\:]/is','',$t2); // strip out the am/pm if any
  $Debug .= "<!-- mtr_fixupTime in='$intime' tfixed='$tfixed' out='$t2' -->\n";
  return($t2);	
	
}
   
// ---------------------------------------------------------

function mtr_process($metar,$icao) {
  global $lang,$Debug, $mtrInfo, $metarPtr, $group,$UOMS;
  $Debug .= "<!-- called mtr_process -->\n";
  $Debug .= "<!-- UOMS\n".print_r($UOMS,true)." -->\n";
	//   This function directs the examination of each group of the METAR. The problem
	// with a METAR is that not all the groups have to be there. Some groups could be
	// missing. Fortunately, the groups must be in a specific order. (This function
	// also assumes that a METAR is well-formed, that is, no typographical mistakes.)
	//   This function uses a function variable to organize the sequence in which to
	// decode each group. Each function checks to see if it can decode the current
	// METAR part. If not, then the group pointer is advanced for the next function
	// to try. If yes, the function decodes that part of the METAR and advances the
	// METAR pointer and group pointer. (If the function can be called again to
	// decode similar information, then the group pointer does not get advanced.)
	// This function was modified by Ken True - webmaster@saratoga-weather.org to
	// work with the template sets.
	$lang = 'en';
  foreach ($mtrInfo as $i => $value) { // clear out prior contents
   unset($mtrInfo[$i]);
//    $mtrInfo[$i] = '';
  }
//  $Debug .= "<!-- wxInfo cleared\n" . print_r($mtrInfo,true) . " -->\n";
  $mtrInfo['STATION'] = $icao;
  $mtrInfo['METAR'] = $metar;
	
	if ($metar != '') {
		$metarParts = explode(' ',$metar);
		$groupName = array('mtr_get_station',
                       'mtr_get_time',
                       'mtr_get_station_type',
                       'mtr_get_wind',
                       'mtr_get_var_wind',
                       'mtr_get_visibility',
                       'mtr_get_runway',
                       'mtr_get_conditions',
                       'mtr_get_cloud_cover',
                       'mtr_get_temperature',
                       'mtr_get_altimeter');
		$metarPtr = 3;  // mtr_get_station identity is ignored
		$group = 1; // start with Time
		
		while ($group < count($groupName)) {
			$part = $metarParts[$metarPtr];
			$Debug .= "<!-- calling '" . $groupName[$group] . "' part='$part' ptr=$metarPtr grp=$group -->\n";
			$groupName[$group]($part);  // $groupName is a function variable
			}
	} else {
	  $mtrInfo['ERROR'] = 'Data not available';
	}
	$Debug .= "<!-- decode for $icao in mtrInfo is\n".print_r($mtrInfo,true)." -->\n";
}

//----------------------------------------------------------------
// Ignore station code. Script assumes this matches requesting
// $station. This function is never called. It is here for
// completeness of documentation.
function mtr_get_station($part)
{ global $lang,$Debug, $mtrInfo, $metarPtr, $group;
  if (strlen($part) == 4 and $group == 0)
  {
    $group++;
    $metarPtr++;
  }
}

function mtr_get_time($part)
{ global $lang,$Debug, $mtrInfo, $metarPtr, $group;
  // Ignore observation time. This information is found in the
  // first line of the NWS file.
  // Format is ddhhmmZ where dd = day, hh = hours, mm = minutes
  // in UTC time.
  if (substr($part,-1) == 'Z') {
     $dd = substr($part,0,2);
	 $hh = substr($part,2,2);
	 $mm = substr($part,4,2);
	 
     $metarPtr++;
  }
  $group++;
}

function mtr_get_station_type($part)
{ global $lang,$Debug, $mtrInfo, $metarPtr, $group;
  // Ignore station type if present.
  if ($part == 'AUTO' || $part == 'COR')
    $metarPtr++;
  $group++;
}

  function mtr_speed($part, $unit)
  {
    global $lang,$Debug, $mtrInfo, $metarPtr, $group, $UOMS;
    // Convert wind speed into miles per hour.
    // Some other common conversion factors (to 6 significant digits):
    //   1 mi/hr = 1.15080 knots  = 0.621371 km/hr = 2.23694 m/s
    //   1 ft/s  = 1.68781 knots  = 0.911344 km/hr = 3.28084 m/s
    //   1 knot  = 0.539957 km/hr = 1.94384 m/s
    //   1 km/hr = 1.852 knots  = 3.6 m/s
    //   1 m/s   = 0.514444 knots = 0.277778 km/s
    if ($unit == 'KT') 
      $speed = 1.1508 * $part;    // from knots
    elseif ($unit == 'MPS')
      $speed = 2.23694 * $part;   // from meters per second
    else
      $speed = 0.621371 * $part;  // from km per hour
    $speedkph = $speed / 0.621371;
    if (preg_match('|mph|i',$UOMS['WIND']))
      $speed ="" . round($speed) . " mph (". round($speedkph) . " km/h)";
    else
      $speed = "" . round($speedkph) . " km/h";
	return $speed;
  }

//-------------------------------------------------------------------------
// Decodes wind direction and speed information.
// Format is dddssKT where ddd = degrees from North, ss = speed,
// KT for knots  or dddssGggKT where G stands for gust and gg = gust
// speed. (ss or gg can be a 3-digit number.)
// KT can be replaced with MPH for meters per second or KMH for
//kilometers per hour.
function mtr_get_wind($part)
{ global $lang,$Debug, $mtrInfo, $metarPtr, $group;
  
  
  if (preg_match('/^([0-9G]{5,10}|VRB[0-9G]{2,7})(KT|MPS|KMH)$/',$part,$pieces))
  {
    $part = $pieces[1];
    $unit = $pieces[2];
    if ($part == '00000')
    {
      $mtrInfo['WIND'] = 'calm';  // no wind
    }
    else
    {
      preg_match('/([0-9]{3}|VRB)([0-9]{2,3})G?([0-9]{2,3})?/',$part,$pieces);
      if ($pieces[1] == 'VRB')
        $direction = 'varies';
      else
      {
        $angle = (integer) $pieces[1];
        $compass = array('N','NNE','NE','ENE','E','ESE','SE','SSE',
                         'S','SSW','SW','WSW','W','WNW','NW','NNW');
        $direction = $compass[round($angle / 22.5) % 16];
      }
      if (!isset($pieces[3]) or (isset($pieces[3]) and $pieces[3] == 0 ) ) {
        $gust = '';
	   } else {
        $gust = ', gusting to ' . mtr_speed($pieces[3], $unit);
	   }
	  if ($unit == 'KT') {
        $speed = 1.1508 * $pieces[2];    // from knots
	  } elseif ($unit == 'MPS') {
        $speed = 2.23694 * $pieces[2];   // from meters per second
	  } else {
        $speed = 0.621371 * $pieces[2];  // from km per hour
	  }

	  $mtrInfo['WINDMPH'] = $direction . ' at ' . round($speed) . ' mph';
      $mtrInfo['WIND'] = $direction . ' at ' . mtr_speed($pieces[2], $unit) . $gust;
    }
    $metarPtr++;
  }
  $group++;
}

function mtr_get_var_wind($part)
{ global $lang,$Debug, $mtrInfo, $metarPtr, $group;
  // Ignore variable wind direction information if present.
  // Format is fffVttt where V stands for varies from fff
  // degrees to ttt degrees.
  if (preg_match('/([0-9]{3})V([0-9]{3})/',$part,$pieces))
    $metarPtr++;
  $group++;
}


//------------------------------------------------------------------
// Decodes visibility information. This function will be called a
// second time if visibility is limited to an integer mile plus a
// fraction part.
// Format is mmSM for mm = statute miles, or m n/dSM for m = mile
// and n/d = fraction of a mile, or just a 4-digit number nnnn (with
// leading zeros) for nnnn = meters.

function mtr_get_visibility($part) {

  global $lang,$Debug, $mtrInfo, $metarPtr, $group, $UOMS;
  static $integerMile = '';
  if (strlen($part) == 1)
  {
    // visibility is limited to a whole mile plus a fraction part
    $integerMile = $part . ' ';
    $metarPtr++;
  }
  elseif (preg_match('|^\d{4}$|',$part)) { 
  // international code for meters of visibility
     $kmVis = round($part/1000);
	 $miVis = round($part/1609);
     if ($miVis > 1) {$unit = ' miles';} else {$unit = ' mile';}
     if (preg_match('|mph|i',$UOMS['WIND'])) {
       $mtrInfo['VISIBILITY'] = " $miVis $unit ($kmVis km)";
	 } else {
      $mtrInfo['VISIBILITY'] = "$kmVis km";
	 }
	$integerMile = ''; 
    $metarPtr++;
    $group++;
  }
  elseif (substr($part,-2) == 'SM')
  {
    // visibility is in miles
    $part = substr($part,0,strlen($part)-2);
    if (substr($part,0,1) == 'M')
    {
      $prefix = 'less than ';
      $part = substr($part, 1);
    }
    else
      $prefix = '';

    if (preg_match('|mph|i',$UOMS['WIND']))
    {
      if (($integerMile == '' && preg_match('![/]!',$part,$pieces)) || $part == '1')
        $unit = ' mile';
      else
        $unit = ' miles';
    }
    $kmVis = round( $part * 1.6 );
    if (preg_match('|mph|i',$UOMS['WIND']))
      $mtrInfo['VISIBILITY'] = $prefix . $integerMile . 
                              " $part $unit ($kmVis km)";
    else
      $mtrInfo['VISIBILITY'] = "$kmVis km";
	$integerMile = '';
    $metarPtr++;
    $group++;
  }
  elseif (substr($part,-2) == 'KM')
  {
    // unknown (Reported by NFFN in Fiji)
	$integerMile = '';
    $metarPtr++;
    $group++;
  }
  elseif (preg_match('/^([0-9]{4})/',$part,$pieces))
  {
    // visibility is in meters
    $distance = round($part/ 621.4, 1);      // convert to miles
    if ($distance > 5)
      $distance = round($distance);
    if ($distance <= 1)
      $unit = ' mile';
    else
      $unit = ' miles';
    $mtrInfo['VISIBILITY'] = $distance . $unit;
	$integerMile = '';
    $metarPtr++;
    $group++;
  }
  elseif ($part == 'CAVOK')
  {
    // good weather
	if (preg_match('|mph|i',$UOMS['WIND'])) {
	   $mtrInfo['VISIBILITY'] = 'greater than 7 miles (10 km)';  // or 10 km
	} else {
	   $mtrInfo['VISIBILITY'] = 'greater than 10 km';  // or 10 km
	}
    $mtrInfo['CONDITIONS'] = 'Clear';
//    $mtrInfo['CLOUDS'] = 'clear skies';
    $metarPtr++;
    $group += 4;  // can skip the next 3 groups
  }
  else
  {
    $group++;
  }
}

function mtr_get_runway($part)
{ global $lang,$Debug, $mtrInfo, $metarPtr, $group;
  // Ignore runway information if present. Maybe called a second time.
  // Format is Rrrr/vvvvFT where rrr = runway number and
  // vvvv = visibility in feet.
//  if (substr($part,0,1) == 'R')
  if(preg_match('|^\d{4}[NESW]+$|',$part)) {
	  // WMO formatted limited visibility
	  $metarPtr++;
	  return;
  }
  if(preg_match('|^R\d\d|',$part)) {
    $metarPtr++;
  } else {
    $group++;
  }
}



function mtr_get_conditions($part) {
global $lang,$Debug, $mtrInfo, $metarPtr, $group;
	// Decodes current weather conditions. This function maybe called several times
	// to decode all conditions. To learn more about weather condition codes, visit section
	// 12.6.8 - Present Weather Group of the Federal Meteorological Handbook No. 1 at
	// www.nws.noaa.gov/oso/oso1/oso12/fmh1/fmh1ch12.htm
  if(preg_match('|^R\d\d|',$part)) { // more than one runway conditions report?
    $metarPtr++;
  }
	static $conditions = '';
        $Debug .= "<!-- conditions='$conditions' on entry -->\n";
	static $wxCode = array(
		'VC' => 'Nearby ',
		'MI' => 'Shallow ',
		'PR' => 'Partial ',
		'BC' => 'Patches of ',
		'DR' => 'Low Drifting ',
		'BL' => 'Blowing ',
		'SH' => 'Showers',
		'TS' => 'Thunderstorm',
		'FZ' => 'Freezing ',
		'DZ' => 'Drizzle',
		'RA' => 'Rain',
		'SN' => 'Snow',
		'SG' => 'Snow Grains',
		'IC' => 'Ice Crystals',
		'PE' => 'Ice Pellets',
		'GR' => 'Hail',
		'GS' => 'Small Hail',  // and/or snow pellets
		'UP' => '',   // leave 'Unknown' out of the conditions .. reads better :)
		'BR' => 'Mist',
		'FG' => 'Fog',
		'FU' => 'Smoke',
		'VA' => 'Volcanic Ash',
		'DU' => 'Widespread Dust',
		'SA' => 'Sand',
		'HZ' => 'Haze',
		'PY' => 'Spray',
		'PO' => 'Well-developed Dust/Sand Whirls',
		'SQ' => 'Squalls',
		'FC' => 'Funnel Cloud, Tornado, or Waterspout',
		'SS' => 'Sandstorm/Duststorm');
	if (preg_match('/^(-|\+|VC)?(TS|SH|FZ|BL|DR|MI|BC|PR|RA|DZ|SN|SG|GR|GS|PE|IC|UP|BR|FG|FU|VA|DU|SA|HZ|PY|PO|SQ|FC|SS|DS)+$/',$part,$pieces)) {
	    $Debug .= "<!-- mtr_get_conditions part='$part' -->\n";
		$join = (strlen($conditions) == 0)?'':', '; // append conditions with a ', ' between
		if (substr($part,0,1) == '-') {
			$prefix = 'Light ';
			$part = substr($part,1);
			}
		elseif (substr($part,0,1) == '+') {
			$prefix = 'Heavy ';
			$part = substr($part,1);
			}
		elseif (substr($part,0,2) == 'VC') {
			$prefix = 'Nearby ';
			$part = substr($part,2);
			}
		else $prefix = '';  // moderate conditions have no descriptor
		$conditions .= $join . $prefix;
		// The 'showers' code 'SH' is moved behind the next 2-letter code to make the English translation read better.
		if (substr($part,0,2) == 'SH') $part = substr($part,2,2) . substr($part,0,2). substr($part, 4);
		while ($code = substr($part,0,2)) {
			$join = (strlen($conditions) < 1)?' ':', ';
			$conditions .= $wxCode[$code]. $join;
			$part = substr($part,2);
			}
		$conditions = preg_replace('|, $|','',$conditions);  // remove trailing comma if any
		$conditions = preg_replace('| , |is',', ',$conditions); // replace space before comma
		$conditions = preg_replace('|\s+|is',' ',$conditions);  // remove multiple spaces
		$mtrInfo['CONDITIONS'] = $conditions;
//        $Debug .= "<!-- conditions='$conditions' metarPtr incr -->\n";
		$metarPtr++;
		}
	else {
		$mtrInfo['CONDITIONS'] = $conditions;
		$group++;
//        $Debug .= "<!-- conditions='$conditions' group incr -->\n";
		$conditions = '';
//        $Debug .= "<!-- conditions='$conditions' reset -->\n";
		}
}

function mtr_get_cloud_cover($part) {
global $lang,$Debug, $mtrInfo, $metarPtr, $group, $UOMS;
	// Decodes cloud cover information. This function maybe called several times
	// to decode all cloud layer observations. Only the last layer is saved.
	// Format is SKC or CLR for clear skies, or cccnnn where ccc = 3-letter code and
	// nnn = altitude of cloud layer in hundreds of feet. 'VV' seems to be used for
	// very low cloud layers. (Other conversion factor: 1 m = 3.28084 ft)
	$doMetric = preg_match('|C|',$UOMS['TEMP']);
	static $cloudCode = array(
		'SKC' => 'Clear',
		'CLR' => 'Clear',
		'FEW' => 'Few Clouds',
		'FW'  => 'Few Clouds',
		'SCT' => 'Partly Cloudy',
		'BKN' => 'Mostly Cloudy',
		'BK'  => 'Mostly Cloudy',
		'OVC' => 'Overcast',
//		'NSC' => 'No significant clouds', // official designation.. we map to Partly Cloudy
		'NSC' => 'Partly Cloudy',
//        'NCD' => 'No cloud detected',  // official designation .. we map to Clear
        'NCD' => 'Clear',
//		'TCU' => 'Towering Cumulus',     // official designation .. we map to Thunder Storm
		'TCU' => 'Thunderstorm',
//		'CB'  => 'Cumulonimbus',         // official designation .. we map to Thunder Storm
		'CB'  => 'Thunderstorm',
		'VV'  => 'Overcast');
	$Debug .= "<!-- get cloud cover '$part' -->\n";
	if ($part == 'VV') {
		$metarPtr++;
		}
	   
	if ($part == 'SKC' || $part == 'CLR' || $part == 'NSC' || $part == 'NCD'|| $part == 'TCU'|| $part == 'CB') {
		$mtrInfo['CLOUDS'] = $cloudCode[$part];
		$metarPtr++;
		$group++;
		}
	else {
		if (preg_match('/^([A-Z]{2,3})([0-9]{3})/',$part,$pieces)) {  // codes for CB and TCU are ignored
			$mtrInfo['CLOUDS'] = $cloudCode[$pieces[1]];
			$altitude = (integer) 100 * $pieces[2];  // units are feet
			$altitudeM = round($altitude/3.28084);
			if(!isset($mtrInfo['CLOUD-DETAILS'])) {$mtrInfo['CLOUD-DETAILS'] = '';}
			if($doMetric) {
			   $mtrInfo['CLOUD-DETAILS'] .= $cloudCode[$pieces[1]]." ${altitudeM} m\t";
			} else {
			   $mtrInfo['CLOUD-DETAILS'] .= $cloudCode[$pieces[1]]." ${altitude} ft\t";
			}
			if ($pieces[1] == 'VV') {
				$mtrInfo['CLOUDS'] = "Overcast";
			} else {
				
			}
			$metarPtr++;
		}
		else {
			$group++;
			}
		}
}

  function mtr_get_heat_index($tempF, $rh)
  { global $lang,$Debug, $mtrInfo, $metarPtr, $group, $UOMS;
    // Calculate Heat Index based on temperature in F and relative
    //humidity (65 = 65%)
    if ($tempF > 79 && $rh > 39)
    {
      $hiF = -42.379 + 2.04901523 * $tempF + 10.14333127 * 
             $rh - 0.22475541 * $tempF * $rh;
      $hiF += -0.00683783 * pow($tempF, 2) - 0.05481717 * pow($rh, 2);
      $hiF += 0.00122874 * pow($tempF, 2) * $rh + 0.00085282 * $tempF 
             * pow($rh, 2);
      $hiF += -0.00000199 * pow($tempF, 2) * pow($rh, 2);
      $hiF = round($hiF);
      $hiC = round(($hiF - 32) / 1.8);
	  if(preg_match('|C|',$UOMS['TEMP'])) {
        $mtrInfo['HEAT INDEX'] = "$hiC&deg;C";
	  } else {
        $mtrInfo['HEAT INDEX'] = "$hiF&deg;F ($hiC&deg;C)";
	  }
    }
  }

  function mtr_get_wind_chill($tempF)
  {
    global $lang,$Debug, $mtrInfo, $metarPtr, $group,$UOMS;

    // Calculate Wind Chill Temperature based on temperature in F and
    // wind speed in miles per hour
    if (isset($mtrInfo['WINDMPH']) and $tempF < 51 && $mtrInfo['WINDMPH'] !== 'calm')
    {
      $pieces = explode(' ', $mtrInfo['WINDMPH']);
      $windspeed = (integer) $pieces[2]; // wind speed must be in mph
      if ($windspeed > 3)
      {
        $chillF = 35.74 + 0.6215 * $tempF - 35.75 * pow($windspeed, 0.16) + 
                  0.4275 * $tempF * pow($windspeed, 0.16);
        $chillF = round($chillF);
        $chillC = round(($chillF - 32) / 1.8);
		if(preg_match('|C|',$UOMS['TEMP'])) {
          $mtrInfo['WIND CHILL'] = "$chillC&deg;C";
		} else {
          $mtrInfo['WIND CHILL'] = "$chillF&deg;F ($chillC&deg;C)";
		}
      }
    }
  }

//-------------------------------------------------------------------------
// Decodes temperature and dew point information. Relative humidity is
// calculated. Also, depending on the temperature, Heat Index or Wind
// Chill Temperature is calculated.
// Format is tt/dd where tt = temperature and dd = dew point temperature.
// All units are in Celsius. A 'M' preceeding the tt or dd indicates a
// negative temperature. Some stations do not report dew point, so the
// format is tt/ or tt/XX.
function mtr_get_temperature($part)
{
  global $lang, $Debug, $mtrInfo, $metarPtr, $group, $UOMS;

  if (preg_match('/^(M?[0-9]{2})\/(M?[0-9]{2}|[X]{2})?$/',$part,$pieces))
  {
	$doMetric = preg_match('|C|',$UOMS['TEMP']);
	
    $tempC = (integer) strtr($pieces[1], 'M', '-');
    $tempF = round(1.8 * $tempC + 32);
    if (!$doMetric) {
        $mtrInfo['TEMP'] = $tempF . "&deg;F (" . $tempC . "&deg;C)";
	} else {
        $mtrInfo['TEMP'] = $tempC . "&deg;C";
    }
    mtr_get_wind_chill($tempF);
    if (isset($pieces[2]) and strlen($pieces[2]) != 0 && $pieces[2] != 'XX')
    {
      $dewC = (integer) strtr($pieces[2], 'M', '-');
      $dewF = round(1.8 * $dewC + 32);
      if (!$doMetric) {
          $mtrInfo['DEWPT'] = $dewF . "&deg;F (" . $dewC . "&deg;C)";
	  } else {
          $mtrInfo['DEWPT'] = $dewC . "&deg;C";
	  }
      $rh = round(100 * pow((112 - (0.1 * $tempC) + $dewC) / 
                                                (112 + (0.9 * $tempC)), 8));
      $mtrInfo['HUMIDITY'] = $rh . '%';
      mtr_get_heat_index($tempF, $rh);
    }
    $metarPtr++;
    $group++;
  }
  else
  {
    $group++;
  }
}


//-----------------------------------------------------------------------
// Decodes altimeter or barometer information.
// Format is Annnn where nnnn represents a real number as nn.nn in
// inches of Hg,
// or Qpppp where pppp = hectoPascals.
// Some other common conversion factors:
//   1 millibar = 1 hPa
//   1 in Hg = 0.02953 hPa
//   1 mm Hg = 25.4 in Hg = 0.750062 hPa
//   1 lb/sq in = 0.491154 in Hg = 0.014504 hPa
//   1 atm = 0.33421 in Hg = 0.0009869 hPa

function mtr_get_altimeter($part)
{  global $Debug, $mtrInfo, $metarPtr, $group, $UOMS;
  if (preg_match('/^(A|Q)([0-9]{4})/',$part,$pieces))
  {
    if ($pieces[1] == 'A')
    {
      $pressureIN = substr($pieces[2],0,2) . '.' . substr($pieces[2],2);
      // units are inches Hg, converts to hectoPascals
      $pressureHPA = round($pressureIN / 0.02953,1);
    }
    else
    {
      $pressureHPA = (integer) $pieces[2];        // units are hectoPascals
      $pressureIN = round(0.02953 * $pressureHPA,2);  // convert to inches Hg
    }
	if(preg_match('|inhg|i',$UOMS['BARO'])) {
      $mtrInfo['BAROMETER'] = "$pressureIN inHg ($pressureHPA hPa)";
	} else {
      $mtrInfo['BAROMETER'] = "$pressureHPA hPa";
	}
    $metarPtr++;
    $group++;
  }
  else
  {
    $group++;
  }
}


// end of the mtr_process function set
//----------------------------------------------
  
?>