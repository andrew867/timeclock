<?php
/**
 * Display time and day.
 *
 * Part of punchclock.php program.
 */

/* TODO: Text substitutions on the Javascript Date.toLocaleString() method is used to display
 * the time on the browser. The Date.toLocaleString() does not return the same string in all
 * browders. Safari and Chrome should have times adjusted to 12hr format if specified by $timefmt.
 *	Firefox:	Monday, March 08, 2010 3:22:01 PM
 *	IE8:		Monday, March 08, 2010 3:22:01 PM
 *	Safari:		Monday, March 08, 2010 15:22:01
 *	Chrome:		Mon Mar 08 2010 15:22:01 GMT-0700 (Mountain Standard Time)
 *	Opera:		3/8/10  3:22:01 PM
 */

require_once "lib.common.php";

$timestamp = utm_timestamp() + timezone_offset();
$timeclock = date('l F j, Y H:i', $timestamp); // initial display

// Define javascript replacement function for changing Date.toLocaleString() text according to $timefmt config option.
switch ($timefmt) {
    case 'G:i':
        // 24 hour w/o leading 0
        $replace_func = "function(p0,p1,p2,p3,p4,p5) { return timer.time.getHours().toString().replace(/^0(!:0)/,'')+':'+p2+':'+p3; }";
        break;
    case 'H:i':
        // 24 hour
        $replace_func = "function(p0,p1,p2,p3,p4,p5) { return ((timer.time.getHours() < 10) ? '0' : '')+timer.time.getHours()+':'+p2+':'+p3; }";
        break;
    case 'g:i A':
        // 12 hour AM/PM
        $replace_func = "function(p0,p1,p2,p3,p4,p5) { return p1+':'+p2+':'+p3+p4+p5; }";
        break;
    case 'g:i a':
        // 12 hour am/pm
        $replace_func = "function(p0,p1,p2,p3,p4,p5) { return p1+':'+p2+':'+p3+p4+p5.toLowerCase(); }";
        break;
    case 'g:iA':
        // 12 hour AM/PM
        $replace_func = "function(p0,p1,p2,p3,p4,p5) { return p1+':'+p2+':'+p3+p5; }";
        break;
    case 'g:ia':
        // 12 hour am/pm
        $replace_func = "function(p0,p1,p2,p3,p4,p5) { return p1+':'+p2+':'+p3+p5.toLowerCase(); }";
        break;
}


print <<<End_Of_HTML
<div id="timeclock">$timeclock</div>
<script type="text/javascript">
//<![CDATA[
timer.start_time = timer.time = new Date('$timeclock');	// server time
timer.frequency = 1000;		// milliseconds
function timer(id) {
	var e = typeof id == 'string' ? document.getElementById(id) : id;	// id or object
	if (! e) { return; }

	var ticktock = function() {
		timer.time.setTime(timer.time.getTime() + timer.frequency);
		e.innerHTML = timer.time.toLocaleString().replace(/ GMT.*/,'').replace(/0(\d,)/,'$1').replace(/(\d{1,2}):(\d{2}):(\d{2})( )([AP]M)/,$replace_func);
		setTimeout(arguments.callee,timer.frequency);
	};

	ticktock();		// start ticking
}
timer('timeclock');
//]]>
</script>
End_Of_HTML;
?>
