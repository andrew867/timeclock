<?php

////////////////////////////////////////////
/* Copied from PHP Weather version 1.62.  */
/* Line 109 was added for php timeclock.  */
/* Line 110 was edited for php timeclock. */
////////////////////////////////////////////

/* Unsets old language variables and loads new ones. */

if (isset($strings)) {
  /* The strings array is loaded - assume the same for the rest. */
  unset($strings);
  unset($wind_dir_text_short_array);
  unset($wind_dir_text_array);
  unset($weather_array);
  unset($cloud_condition_array);
}

/* Load the new strings */

$wind_dir_text_short_array = array(
  'N',
  'N/NE',
  'NE',
  'E/NE',
  'E',
  'E/SE',
  'SE',
  'S/SE',
  'S',
  'S/SW',
  'SW',
  'W/SW',
  'W',
  'W/NW',
  'NW',
  'N/NW',
  'N');

$cloud_condition_array = array(
  'SKC' => 'Clear',
  'CLR' => 'Clear',
  'VV'  => 'Vertical Visibility',
  'FEW' => 'Partly Cloudy',
  'SCT' => 'Scattered Clouds',
  'BKN' => 'Partly Cloudy',
  'OVC' => 'Overcast');

/* Offset in hours to add to the time of a report. If all your times
 * are 2 hours off, then set this to -2.  */
$weather_offset = 0;

  /* Make a connection to the MySQL database: */
  if (mysql_pconnect($db_hostname, $db_username, $db_password)) {
    mysql_select_db($db_name);
  } else {
    echo "<p>Unable to connect to MySQL database!</p>";
  }

function store_speed($value, $windunit, &$meterspersec, &$knots, &$milesperhour) {
  /*
   * Helper function to convert and store speed based on unit.
   * &$meterspersec, &$knots and &$milesperhour are passed on
   * reference
   */
  if ($windunit == 'KT') {
    /* The windspeed measured in knots: */
    $knots = number_format($value);
    /* The windspeed measured in meters per second, rounded to one
     * decimal place: */
    $meterspersec = number_format($value * 0.51444, 1);
    /* The windspeed measured in miles per hour, rounded to one
     * decimal place: */
    $milesperhour = number_format($value * 1.1507695060844667, 1);
  } elseif ($windunit == 'MPS') {
    /* The windspeed measured in meters per second: */
    $meterspersec = number_format($value);
    /* The windspeed measured in knots, rounded to one decimal
     * place: */
    $knots = number_format($value / 0.51444, 1);
    /* The windspeed measured in miles per hour, rounded to one
     * decimal place: */
    $milesperhour = number_format($value / 0.51444 * 1.1507695060844667, 1);
  } elseif ($windunit == 'KMH') {
    /* The windspeed measured in kilometers per hour: */
    $meterspersec = number_format($value * 1000 / 3600, 1);
    $knots = number_format($value * 1000 / 3600 / 0.51444, 1);
    /* The windspeed measured in miles per hour, rounded to one
     * decimal place: */
    $milesperhour = number_format($knots * 1.1507695060844667, 1);
  }
}

function get_metar($station, $always_use_cache = 0) {
  /*
   * Looks in the database, and fetches a new metar is nesceary. If
   * $always_use_cache is true, then it ignores the timestamp of the
   * METAR and just returns it.
   * 
   * You should pass a ICAO station identifier, eg. 'EKYT' for
   * Aalborg, Denmark.
   */

  global $conn, $dbmMetar, $dbmTimestamp;

    $query = "SELECT metar, UNIX_TIMESTAMP(timestamp) FROM ".$db_prefix."metars WHERE station = '$station'";
    $result = mysql_query($query);
    @$metar_rows = mysql_num_rows($result); /* this suppresses a php error message if the metars db has not yet been created. */ 
    if (isset($metar_rows)) { /* found station */
      list($metar, $timestamp) = mysql_fetch_row($result);
    }

  if (isset($metar)) { /* found station */
    if ($always_use_cache || $timestamp > time() - 3600) {
      /* We have asked explicit for a cached metar, or the metar is
       * still fresh. */
      return $metar;
    } else {
      /* We looked in the cache, but the metar was too old. */
      return fetch_metar($station, 0);
    }
  } else {
    /* The station is new - we fetch a new METAR */
    return fetch_metar($station, 1);
  }
}

function fetch_metar($station, $new) {
  /*
   * Fetches a new METER from weather.noaa.gov. If the $new variable
   * is true, the metar is inserted, else it will replace the old
   * metar. The new METAR is returned.
   */
  global $conn, $dbmMetar, $dbmTimestamp;

  $metar = '';
  $station = strtoupper($station);
  
  /* We use the @ notation, because it might fail. */
  $file  = @file('http://weather.noaa.gov/pub/data/' .
                   "observations/metar/stations/$station.TXT");

  /* Here we test to see if we actually got a METAR. */
  if (is_array($file)) {
    $date = trim($file[0]);
    $metar = trim($file[1]);
    for ($i = 2; $i < count($file); $i++) {
      $metar .= ' ' . trim($file[i]);
    }
    
    /* The date is in the form 2000/10/09 14:50 UTC. This seperates
       the different parts. */
    $date_parts = explode(':', strtr($date, '/ ', '::'));
    $date_unixtime = gmmktime($date_parts[3], $date_parts[4],
                              0, $date_parts[1], $date_parts[2],
                              $date_parts[0]);
   
    if (!ereg('[0-9]{6}Z', $metar)) {
      /* Some reports dont even have a time-part, so we insert the
       * current time. This might not be the time of the report, but
       * it was broken anyway :-) */
      $metar = gmdate('dHi', $date_unixtime) . 'Z ' . $metar;
    }
    
    if ($date_unixtime < (time() - 3300)) {
      /* The timestamp in the metar is more than 55 minutes old. We
       * adjust the timestamp, so that we won't try to fetch a new
       * METAR within the next 5 minutes. After 5 minutes, the
       * timestamp will again be more than 1 hour old. */
      $date_unixtime = time() - 3300;
    }

  } else {
    /* If we end up here, it means that there was no file, we then set
     * the metar to and empty string. We set the date to time() - 3000
     * to give the server 10 minutes of peace. If the file is
     * unavailable, we don't want to stress the server. */
    $metar = '';
    $date_unixtime = time() - 3000;
  }
  
  /* It might seam strange, that we make a local date, but MySQL
   * expects a local when we insert the METAR. */
  $date = date('Y/m/d H:i', $date_unixtime);

    if ($new) {
      /* Insert the new record */
      $query = "INSERT INTO ".$db_prefix."metars SET station = '$station', " .
        "metar = '$metar', timestamp = '$date'";
    } else {
      /* Update the old record */
      $query = "UPDATE ".$db_prefix."metars SET metar = '$metar', " .
        "timestamp = '$date' WHERE station = '$station'";
    }
    mysql_query($query);

  return $metar;
}

function process_metar($metar) {
  /* This function decodes a raw METAR. The result is an associative
   * array with entries like 'temp_c', 'visibility_miles' etc.  */

  global $strings, $wind_dir_text_short_array, $wind_dir_text_array,
    $cloud_condition_array, $weather_array, $weather_offset;

  $temp_visibility_miles = '';
  $cloud_layers = 0;
  $decoded_metar['remarks'] = '';
  $decoded_metar['weather'] = '';
  
  $cloud_coverage = array('SKC' => '0',
        'CLR' => '0',
        'VV'  => '8/8',
        'FEW' => '1/8 - 2/8',
        'SCT' => '3/8 - 4/8',
        'BKN' => '5/8 - 7/8',
        'OVC' => '8/8');
  
  $decoded_metar['metar'] = $metar;
  $parts = split('[ ]+', $metar);
  $num_parts = count($parts);
  for ($i = 0; $i < $num_parts; $i++) {
    $part = $parts[$i];

    if (ereg('RMK|TEMPO|BECMG', $part)) {
      /* The rest of the METAR is either a remark or temporary
       * information. We skip the rest of the METAR. */
      $decoded_metar['remarks'] .= ' ' . $part;
      break;
    } elseif ($part == 'METAR') {
      /*
       * Type of Report: METAR
       */
      $decoded_metar['type'] = 'METAR';
    } elseif ($part == 'SPECI') {
      /*
       * Type of Report: SPECI
       */
      $decoded_metar['type'] = 'SPECI';
    } elseif (ereg('^[A-Z]{4}$', $part) && ! isset($decoded_metar['station']))  {
      /*
       * Station Identifier
       */
      $decoded_metar['station'] = $part;
    } elseif (ereg('([0-9]{2})([0-9]{2})([0-9]{2})Z', $part, $regs)) {
      /*
       * Date and Time of Report
       * We return a standard Unix UTC/GMT timestamp suitable for
       * gmdate()
       */
      $decoded_metar['time'] = gmmktime($regs[2] + $weather_offset, $regs[3], 0,
                                        gmdate('m'), $regs[1], gmdate('Y'));
    } elseif (ereg('(AUTO|COR|RTD|CC[A-Z]|RR[A-Z])', $part, $regs)) {
      /*
       * Report Modifier: AUTO, COR, CCx or RRx
       */
      $decoded_metar['report_mod'] = $regs[1];
    } elseif (ereg('([0-9]{3}|VRB)([0-9]{2,3}).*(KT|MPS|KMH)', $part, $regs)) {
      /* Wind Group */
      $windunit = $regs[3];  /* do ereg in two parts to retrieve unit first */
      /* now do ereg to get the actual values */
      ereg("([0-9]{3}|VRB)([0-9]{2,3})(G([0-9]{2,3})?$windunit)", $part, $regs);
      if ($regs[1] == 'VRB') {
        $decoded_metar['wind_deg'] = $strings['wind_vrb_long'];
        $decoded_metar['wind_dir_text'] = $strings['wind_vrb_long'];
        $decoded_metar['wind_dir_text_short'] = $strings['wind_vrb_short'];
      } else {
        $decoded_metar['wind_deg'] = $regs[1];
        $decoded_metar['wind_dir_text'] =
          $wind_dir_text_array[intval(round($regs[1]/22.5))];
        $decoded_metar['wind_dir_text_short'] =
          $wind_dir_text_short_array[intval(round($regs[1]/22.5))];
      }
      store_speed($regs[2],
                  $windunit,
                  $decoded_metar['wind_meters_per_second'],
                  $decoded_metar['wind_knots'],
                  $decoded_metar['wind_miles_per_hour']);

      if (isset($regs[4])) {
        /* We have a report with information about the gust. First we
           have the gust measured in knots: */
        store_speed($regs[4],$windunit,
          $decoded_metar['wind_gust_meters_per_second'],
          $decoded_metar['wind_gust_knots'],
          $decoded_metar['wind_gust_miles_per_hour']);
      }
    } elseif (ereg('^([0-9]{3})V([0-9]{3})$', $part, $regs)) {
      /*
       * Variable wind-direction
       */
      $decoded_metar['wind_var_beg'] = $regs[1];
      $decoded_metar['wind_var_end'] = $regs[2];
    } elseif ($part == 9999) {
      /* A strange value. When you look at other pages you see it
         interpreted like this (where I use > to signify 'Greater
         than'): */
      $decoded_metar['visibility_miles'] = '>6.2';
      $decoded_metar['visibility_km']    = '>10';
    } elseif(ereg('^([0-9]{4})$', $part, $regs)) {
      /* 
       * Visibility in meters (4 digits only)
       */
      $decoded_metar['visibility_km'] = number_format($regs[1]/1000, 1);
      $decoded_metar['visibility_miles'] =
        number_format( ($regs[1]/1000) / 1.609344, 1);
    } elseif (ereg('^[0-9]$', $part)) {
      /*
       * Temp Visibility Group, single digit followed by space
       */
      $temp_visibility_miles = $part;
    } elseif (ereg('^M?(([0-9]?)[ ]?([0-9])(/?)([0-9]*))SM$',
                   $temp_visibility_miles . ' ' .
                   $parts[$i], $regs)) {
      /*
       * Visibility Group
       */
      if ($regs[4] == '/') {
        $vis_miles = $regs[2] + $regs[3]/$regs[5];
      } else {
        $vis_miles = $regs[1];
      }
      if ($regs[0][0] == 'M') {
        /* The visibility measured in miles, prefixed with < to
           indicate 'Less than' */
        $decoded_metar['visibility_miles'] =
          '<' . number_format($vis_miles, 1);
        /* The visibility measured in kilometers. The value is rounded
           to one decimal place, prefixed with < to indicate 'Less
           than' */
        $decoded_metar['visibility_km']    =
          '<' . number_format($vis_miles * 1.609344, 1);
      } else {
        /* The visibility measured in mile.s */
        $decoded_metar['visibility_miles'] = number_format($vis_miles, 1);
        /* The visibility measured in kilometers, rounded to one
           decimal place. */
        $decoded_metar['visibility_km'] =
          number_format($vis_miles * 1.609344, 1);
      }
    } elseif ($part == 'CAVOK') {
      /* CAVOK: Used when the visibility is greather than 10
         kilometers, the lowest cloud-base is at 5000 feet and there
         is no significant weather. */
      $decoded_metar['visibility_km']    = '>10';
      $decoded_metar['visibility_miles'] = '>6.2';
      $decoded_metar['cloud_layer1_condition'] = 'CAVOK';
    } elseif (ereg('^R([0-9][0-9][RLC]?)/([MP]?[0-9]{4})V?(P?[0-9]{4})?F?T?$', $part, $regs)) {
      $decoded_metar['runway_nr'] = $regs[1];
      if ($regs[3]) {
  /* We have both min and max visibility. */
  $prefix = '';
  if ($regs[2][0] == 'M') {
    /* Less than. */
    $prefix = '<';
    $regs[2] = substr($regs[2], 1);
  }
  $decoded_metar['runway_vis_min_ft']    = $prefix . number_format($regs[2]);
  $decoded_metar['runway_vis_min_meter'] = $prefix . number_format($regs[2] * 0.3048);

  $prefix = '';
  if ($regs[3][0] == 'P') {
    /* Greather than. */
    $prefix = '>';
    $regs[3] = substr($regs[3], 1);
  }
  $decoded_metar['runway_vis_max_ft']    = $prefix . number_format($regs[3]);
  $decoded_metar['runway_vis_max_meter'] = $prefix . number_format($regs[3] * 0.3048);
    
      } else {
  /* We only have a single visibility. */
  $prefix = '';
  if ($regs[2][0] == 'M') {
    $prefix = '<';
    $regs[2] = substr($regs[2], 1);
  } elseif ($regs[2][0] == 'P') {
    $prefix = '>';
    $regs[2] = substr($regs[2], 1);
  }
  $decoded_metar['runway_vis_ft']    = $prefix . number_format($regs[2]);
  $decoded_metar['runway_vis_meter'] = $prefix . number_format($regs[2] * 0.3048);
      }
    } elseif (ereg('^(-|\+|VC)?(TS|SH|FZ|BL|DR|MI|BC|PR|RA|DZ|SN|SG|GR|' .
                   'GS|PE|IC|UP|BR|FG|FU|VA|DU|SA|HZ|PY|PO|SQ|FC|SS|DS)+$',
                   $part)) {
      /*
       * Current weather-group
       */ 
      if ($part[0] == '-') {
        /* A light phenomenon */
        $decoded_metar['weather'] .= $strings['light'];
        $part = substr($part, 1);
      } elseif ($part[0] == '+') {
        /* A heavy phenomenon */
        $decoded_metar['weather'] .= $strings['heavy'];
        $part = substr($part, 1);
      } elseif ($part[0].$part[1] == 'VC') {
        /* Proximity Qualifier */
        $decoded_metar['weather'] .= $strings['nearby'];
        $part = substr($part, 2);
      } else {
        /* no intensity code => moderate phenomenon */
        $decoded_metar['weather'] .= $strings['moderate'];
      }
      
      while ($bite = substr($part, 0, 2)) {
        /* Now we take the first two letters and determine what they
           mean. We append this to the variable so that we gradually
           build up a phrase. */
        $decoded_metar['weather'] .= $weather_array[$bite];
        /* Here we chop off the two first letters, so that we can take
           a new bite at top of the while-loop. */
        $part = substr($part, 2);
      }
    } elseif (ereg('(SKC|CLR)', $part, $regs)) {
      /*
       * Cloud-layer-group.
       * There can be up to three of these groups, so we store them as
       * cloud_layer1, cloud_layer2 and cloud_layer3.
       */
      $cloud_layers++;
      /* Again we have to translate the code-characters to a
         meaningful string. */
      $decoded_metar['cloud_layer'. $cloud_layers.'_condition'] =
        $cloud_condition_array[$regs[1]];
      $decoded_metar['cloud_layer'.$cloud_layers.'_coverage'] =
        $cloud_coverage[$regs[1]];
    } elseif (ereg('^(VV|FEW|SCT|BKN|OVC)([0-9]{3})(CB|TCU)?$',
                   $part, $regs)) {
      /* We have found (another) a cloud-layer-group. There can be up
         to three of these groups, so we store them as cloud_layer1,
         cloud_layer2 and cloud_layer3. */
      $cloud_layers++;
      /* Again we have to translate the code-characters to a
         meaningful string. */
      if ($regs[1] == 'OVC') {
        $clouds_str_temp = '';
      } else {
        $clouds_str_temp = $strings['clouds'];
      }
      if ($regs[3] == 'CB') {
        /* cumulonimbus (CB) clouds were observed. */
        $decoded_metar['cloud_layer'.$cloud_layers.'_condition'] =
          $cloud_condition_array[$regs[1]] . $strings['clouds_cb'];
      } elseif ($regs[3] == 'TCU') {
        /* towering cumulus (TCU) clouds were observed. */
        $decoded_metar['cloud_layer'.$cloud_layers.'_condition'] =
          $cloud_condition_array[$regs[1]] . $strings['clouds_tcu'];
      } else {
        $decoded_metar['cloud_layer'.$cloud_layers.'_condition'] =
          $cloud_condition_array[$regs[1]] . $clouds_str_temp;
      }
      $decoded_metar['cloud_layer'.$cloud_layers.'_coverage'] =
        $cloud_coverage[$regs[1]];
      $decoded_metar['cloud_layer'.$cloud_layers.'_altitude_ft'] =
        $regs[2] *100;
      $decoded_metar['cloud_layer'.$cloud_layers.'_altitude_m'] =
        round($regs[2] * 30.48);
    } elseif (ereg('^(M?[0-9]{2})/(M?[0-9]{2})?$', $part, $regs)) {
      /*
       * Temperature/Dew Point Group
       * The temperature and dew-point measured in Celsius.
       */
      $decoded_metar['temp_c'] = number_format(strtr($regs[1], 'M', '-'));
      $decoded_metar['dew_c']  = number_format(strtr($regs[2], 'M', '-'));
      /* The temperature and dew-point measured in Fahrenheit, rounded
         to the nearest degree. */
      $decoded_metar['temp_f'] = round(strtr($regs[1], 'M', '-') * (9/5) + 32);
      $decoded_metar['dew_f']  = round(strtr($regs[2], 'M', '-') * (9/5) + 32);
    } elseif(ereg('A([0-9]{4})', $part, $regs)) {
      /*
       * Altimeter
       * The pressure measured in inHg
       */
      $decoded_metar['altimeter_inhg'] = number_format($regs[1]/100, 2);
      /* The pressure measured in mmHg, hPa and atm */
      $decoded_metar['altimeter_mmhg'] = number_format($regs[1] * 0.254, 1);
      $decoded_metar['altimeter_hpa']  = number_format($regs[1] * 0.33863881578947);
      $decoded_metar['altimeter_atm']  = number_format($regs[1] * 3.3421052631579e-4, 3);
    } elseif(ereg('Q([0-9]{4})', $part, $regs)) {
      /*
       * Altimeter
       * This is strange, the specification doesnt say anything about
       * the Qxxxx-form, but it's in the METARs.
       */
      /* The pressure measured in hPa */
      $decoded_metar['altimeter_hpa']  = number_format($regs[1]);
      /* The pressure measured in mmHg, inHg and atm */
      $decoded_metar['altimeter_mmhg'] = number_format($regs[1] * 0.7500616827, 1);
      $decoded_metar['altimeter_inhg'] = number_format($regs[1] * 0.0295299875, 2);
      $decoded_metar['altimeter_atm']  = number_format($regs[1] * 9.869232667e-4, 3);
    } elseif (ereg('^T([0-9]{4})([0-9]{4})', $part, $regs)) {
      /*
       * Temperature/Dew Point Group, coded to tenth of degree.
       * The temperature and dew-point measured in Celsius.
       */
      store_temp($regs[1],$decoded_metar,'temp_c','temp_f');
      store_temp($regs[2],$decoded_metar,'dew_c','dew_f');
    } elseif (ereg('^T([0-9]{4}$)', $part, $regs)) {
      store_temp($regs[1],$decoded_metar,'temp_c','temp_f');
    } elseif (ereg('^1([0-9]{4}$)', $part, $regs)) {
      /*
       * 6 hour maximum temperature Celsius, coded to tenth of degree
       */
      store_temp($regs[1],$decoded_metar,'temp_max6h_c','temp_max6h_f');
    } elseif (ereg('^2([0-9]{4}$)', $part, $regs)) {
      /*
       * 6 hour minimum temperature Celsius, coded to tenth of degree
       */
      store_temp($regs[1],$decoded_metar,'temp_min6h_c','temp_min6h_f');
    } elseif (ereg('^4([0-9]{4})([0-9]{4})$', $part, $regs)) {
      /*
       * 24 hour maximum and minimum temperature Celsius, coded to
       * tenth of degree
       */
      store_temp($regs[1],$decoded_metar,'temp_max24h_c','temp_max24h_f');
      store_temp($regs[2],$decoded_metar,'temp_min24h_c','temp_min24h_f');
    } elseif(ereg('^P([0-9]{4})', $part, $regs)) {
      /*
       * Precipitation during last hour in hundredths of an inch
       * (store as inches)
       */
      $decoded_metar['precip_in'] = number_format($regs[1]/100, 2);
      $decoded_metar['precip_mm'] = number_format($regs[1]*0.254, 2);
    } elseif(ereg('^6([0-9]{4})', $part, $regs)) {
      /*
       * Precipitation during last 3 or 6 hours in hundredths of an
       * inch  (store as inches)
       */
      $decoded_metar['precip_6h_in'] = number_format($regs[1]/100, 2);
      $decoded_metar['precip_6h_mm'] = number_format($regs[1]*0.254, 2);
    } elseif(ereg('^7([0-9]{4})', $part, $regs)) {
      /*
       * Precipitation during last 24 hours in hundredths of an inch
       * (store as inches)
       */
      $decoded_metar['precip_24h_in'] = number_format($regs[1]/100, 2);
      $decoded_metar['precip_24h_mm'] = number_format($regs[1]*0.254, 2);
    } elseif(ereg('^4/([0-9]{3})', $part, $regs)) {
      /*
       * Snow depth in inches
       */
      $decoded_metar['snow_in'] = number_format($regs[1]);
      $decoded_metar['snow_mm'] = number_format($regs[1] * 25.4);
    } else {
      /*
       * If we couldn't match the group, we assume that it was a
       * remark.
       */
      $decoded_metar['remarks'] .= ' ' . $part;
    }
  }
  /*
   * Relative humidity
   */
  $decoded_metar['rel_humidity'] = number_format(pow(10, 
    (1779.75 * ($decoded_metar['dew_c'] - $decoded_metar['temp_c'])/
    ((237.3 + $decoded_metar['dew_c']) * (237.3 + $decoded_metar['temp_c']))
    + 2)), 1);

  /*
   * Humidity index
   */
  $e = 6.112 * pow(10, 7.5 * $decoded_metar['temp_c']
       / (237.7 + $decoded_metar['temp_c']))
       * $decoded_metar['rel_humidity']/100;
  $decoded_metar['humidex_c'] =
    number_format($decoded_metar['temp_c'] + 5/9 * ($e - 10),1);
  $decoded_metar['humidex_f'] =
    number_format($decoded_metar['humidex_c'] * 9/5 + 32, 1);
  
  /*
   * Windchill.
   * 
   * This is only appropriate if temp < 40f and windspeed > 3 mph
   */
  if ($decoded_metar['temp_f'] <= '40' &&
      $decoded_metar['wind_miles_per_hour'] > '3'){
    $decoded_metar['windchill_f'] =
      number_format(35.74 + 0.6215 * $decoded_metar['temp_f'] -
                    35.75 * pow((float)$decoded_metar['wind_miles_per_hour'], 0.16) +
                    0.4275 * $decoded_metar['temp_f'] *
                    pow((float)$decoded_metar['wind_miles_per_hour'],0.16));
    $decoded_metar['windchill_c'] =
      number_format(13.112 + 0.6215 * $decoded_metar['temp_c'] -
                    13.37 * pow(($decoded_metar['wind_miles_per_hour']/1.609), 0.16) +
                    0.3965 * $decoded_metar['temp_c'] * 
                    pow(($decoded_metar['wind_miles_per_hour']/1.609),0.16));
  }

  return $decoded_metar;
}
 
?>
