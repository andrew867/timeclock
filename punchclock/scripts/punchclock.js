/*
 * Punchclock scripts
 */

var display = {
    locked: false,
    lock: function () {
        display.locked = true;
    },
    unlock: function () {
        display.locked = false;
    },
    is_locked: function () {
        return display.locked;
    },

    timer: null,
    refresh: function () {
        if (display.is_locked()) {
            display.schedule_refresh(20);
        } else {
            location.reload();
        }
    },
    schedule_refresh: function (seconds) {
        clearTimeout(display.timer);
        display.timer = setTimeout(display.refresh, seconds * 1000);
    },
};

// Keyboard event handler to scroll display and to go to the line beginning with the typed character.
var keyboard = {
    scroll_speed: 850,
    scroll_bottom: 0,	// needs to be set to height of scroll area

    locked: false,
    lock: function () {
        keyboard.locked = true;
    },
    unlock: function () {
        keyboard.locked = false;
    },
    is_locked: function () {
        return keyboard.locked;
    },

    bind_handler: function () {
        $(document).bind('keydown', keyboard.handler)
    },
    unbind_handler: function () {
        $(document).unbind('keydown', keyboard.handler)
    },

    set_scroll_body_height: function (h) {
        this.scroll_bottom = h;
    },

    handler: function (event) {
        if (event.altKey || event.ctrlKey) return true;		// pass on control characters
        if (keyboard.is_locked()) return false;
        keyboard.lock();

        var code = event.which;

        // Process special characters
        switch (code) {
            case 13:	// Return
                // Open form for first item displayed in list.
                var index = Math.floor(($('.emp_list tbody').scrollTop() / $('.emp_list tbody tr').height()) + .66);	// custom rounding
                $('.emp_list tbody tr:eq(' + index + ')').click();
                keyboard.unlock();
                return false;
            case 33:	// PgUp
                $('.emp_list tbody').scrollTo(Math.max(0, $('.emp_list tbody').attr('scrollTop') - $('.emp_list tbody').height()), keyboard.scroll_speed, {onAfter: keyboard.unlock});
                return false;
            case 34:	// PgDn
                $('.emp_list tbody').scrollTo($('.emp_list tbody').attr('scrollTop') + $('.emp_list tbody').height(), keyboard.scroll_speed, {onAfter: keyboard.unlock});
                return false;
            case 35:	// End
                $('.emp_list tbody').scrollTo(keyboard.scroll_bottom, keyboard.scroll_speed, {onAfter: keyboard.unlock});
                return false;
            case 36:	// Home
                $('.emp_list tbody').scrollTo(0, keyboard.scroll_speed, {onAfter: keyboard.unlock});
                return false;
            case 37:	// Left
            case 38:	// Up
                $('.emp_list tbody').scrollTop(Math.max(0, $('.emp_list tbody').attr('scrollTop') - $('.emp_list tbody tr').height()));
                keyboard.unlock();
                return false;
            case 39:	// Right
            case 40:	// Down
                $('.emp_list tbody').scrollTop($('.emp_list tbody').attr('scrollTop') + $('.emp_list tbody tr').height());
                keyboard.unlock();
                return false;
        }

        // Restrict characters checked to 0-9 and A-Z.
        if (!((code >= 48 && code <= 57) || (code >= 65 && code <= 90))) {
            keyboard.unlock();
            return;
        }

        // Search first column of employee table for match.
        var ch, keych = String.fromCharCode(code);
        var found = false;
        $('.emp_list tbody tr td:nth-child(1)').each(function () {
            ch = $(this).text().charAt(0).toUpperCase();
            if (ch >= keych) {
                $('.emp_list tbody').scrollTo(this, keyboard.scroll_speed, {onAfter: keyboard.unlock});
                found = true;
                return false;
            }
        });
        if (!found) {
            // key character is greater than any found in list
            $('.emp_list tbody').scrollTo(keyboard.scroll_bottom, keyboard.scroll_speed);
        }

        keyboard.unlock();
        return true;
    },
};
