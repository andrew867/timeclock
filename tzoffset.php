<script language="JavaScript">

  var time = new Date()
  var cookieexpire = new Date(time.getTime() + 90 * 24 * 60 * 60 * 1000); //cookie expires in 90 days
  var timeclock = document.cookie;
  var timezone = (-(time.getTimezoneOffset()))

  function getthecookie(name) { 
    var index = timeclock.indexOf(name + "=");
    if (index == -1) return null;
    index = timeclock.indexOf("=", index) + 1;
    var endstr = timeclock.indexOf(";", index);
    if (endstr == -1) endstr = timeclock.length;
    return unescape(timeclock.substring(index, endstr));
  }

  function setthecookie(timeclock, value) { 
    if (value != null && value != "")
      document.cookie=timeclock + "=" + escape(value) + "; expires=" + cookieexpire.toGMTString();
    timeclock = document.cookie; 
  }

  var tzoffset = getthecookie("tzoffset") || timezone;
  if (tzoffset == null || tzoffset == "")
    tzoffset="0";
  setthecookie("tzoffset", tzoffset);
</script>



