<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package local_bbliveusers
 * @author Bruno Magalhães <brunomagalhaes@blackbean.com.br>
 * @copyright BlackBean Technologies Ltda <https://www.blackbean.com.br>
 * @license http://www.gnu.org/copyleft/gpl.html
 */
function local_bbliveusers_extend_navigation_course()
{
    /**
     * 
     */
    global $COURSE, $USER, $PAGE, $CFG;

    /**
     * 
     */
    if(isset($PAGE))
    {
        /**
         * 
         */
        $courseid = isset($COURSE->id) ? max(0, (integer)$COURSE->id) : 0;
        $userid = isset($USER->id) ? max(0, (integer)$USER->id) : 0;
        $limit = intval(time() + $CFG->sessiontimeout);

        /**
         * 
         */
        echo("\n\n");
        echo('<script>
var bbliveusers_limit='.$limit.';
window.setInterval(function(){
    var bbliveusers_time=((Date.now() % 1000) / 1000);
    if(bbliveusers_time<=bbliveusers_limit){
        if(window.XMLHttpRequest){
            request = new XMLHttpRequest();
        }else{
            request = new ActiveXObject("Microsoft.XMLHTTP");
        }
        request.open("GET","/local/bbliveusers/ping.php?courseid='.$courseid.'&userid='.$userid.'",true);
        request.send();
    }
},10000);
</script>');
        echo("\n\n");
    }
}