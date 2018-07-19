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
defined('MOODLE_INTERNAL') || exit(0);

class bbliveusers
{
    /**
     * [store_liveuser]
     *
     * @param integer $courseid
     * @param integer $userid
     * @param integer $step
     * @return boolean
     */
    public static function store_liveuser($courseid = 0, $userid = 0, $step = 20) {
        global $DB;

        $courseid = max(0, (integer)$courseid);
        $userid = max(0, (integer)$userid);
        $step = max(20, (integer)$step);
        $usertime = time();
        $usertime = ($usertime - ($usertime % $step));

        if ($courseid == 0 or
            $courseid == 1 or
            $userid == 0) {
            return(false);
        }

        $sql = "SELECT 1 ".
                "FROM {local_bbliveusers} tb1 ".
                "WHERE tb1.courseid=? ".
                "AND tb1.userid=? ".
                "AND tb1.usertime=?";

        if ($DB->get_field_sql($sql, [$courseid, $userid, $usertime]) == false) {
            $sql = "INSERT INTO {local_bbliveusers} ".
                    "(courseid,userid,usertime) ".
                    "VALUES (?,?,?)";

            $DB->execute($sql, [$courseid, $userid, $usertime]);
        }

        return(true);
    }

    /**
     * [count_liveusers]
     *
     * @param integer $courseid
     * @param integer $start
     * @param integer $stop
     * @param integer $step
     * @return integer
     */
    public static function count_liveusers($courseid = 0, $start = 0, $stop = PHP_INT_MAX, $step = 20) {
        global $DB;

        $courseid = max(0, (integer)$courseid);
        $start = max(0, (integer)$start);
        $stop = max(0, (integer)$stop);
        $step = max(20, (integer)$step);
        $start = ($start - ($start % $step));
        $stop = ($stop - ($stop % $step));

        if ($courseid > 1) {
            $sql = "SELECT COUNT(DISTINCT tb1.userid) AS total ".
                    "FROM {local_bbliveusers} tb1 ".
                    "WHERE tb1.courseid=? ".
                    "AND tb1.usertime>=? ".
                    "AND tb1.usertime<=?";

            $params = [$courseid, $start, $stop];
        } else {
            $sql = "SELECT COUNT(DISTINCT tb1.userid) AS total ".
                    "FROM {local_bbliveusers} tb1 ".
                    "WHERE tb1.usertime>=? ".
                    "AND tb1.usertime<=?";

            $params = [$start, $stop];
        }

        if ($result = $DB->get_record_sql($sql, $params)) {
            return((integer)$result->total);
        }

        return(0);
    }

    /**
     * [fetch_liveusers]
     *
     * @param integer $courseid
     * @param integer $start
     * @param integer $stop
     * @param integer $step
     * @return array
     */
    public static function fetch_liveusers($courseid = 0, $start = 0, $stop = PHP_INT_MAX, $step = 20) {
        global $DB;

        $courseid = max(0, (integer)$courseid);
        $start = max(0, (integer)$start);
        $stop = max(0, (integer)$stop);
        $step = max(20, (integer)$step);
        $start = ($start - ($start % $step));
        $stop = ($stop - ($stop % $step));
        $users = [];

        if ($courseid > 1) {
            $sql = "SELECT tb2.id,".
                        "tb2.firstname,".
                        "tb2.lastname,".
                        "MIN(tb1.usertime) AS first,".
                        "MAX(tb1.usertime) AS last,".
                        "(MAX(tb1.usertime) - MIN(tb1.usertime)) AS total,".
                        "COUNT(DISTINCT tb1.usertime) AS count ".
                    "FROM {local_bbliveusers} tb1 ".
                    "INNER JOIN {user} tb2 ".
                    "ON tb2.id=tb1.userid ".
                    "WHERE tb1.courseid=? ".
                    "AND tb1.usertime>=? ".
                    "AND tb1.usertime<=? ".
                    "GROUP BY tb1.userid,".
                        "tb2.firstname,".
                        "tb2.lastname ".
                    "ORDER BY tb2.firstname";

            $params = [$courseid, $start, $stop];
        } else {
            $sql = "SELECT tb2.id,".
                        "tb2.firstname,".
                        "tb2.lastname,".
                        "MIN(tb1.usertime) AS first,".
                        "MAX(tb1.usertime) AS last,".
                        "(MAX(tb1.usertime) - MIN(tb1.usertime)) AS total,".
                        "COUNT(DISTINCT tb1.usertime) AS count ".
                    "FROM {local_bbliveusers} tb1 ".
                    "INNER JOIN {user} tb2 ".
                    "ON tb2.id=tb1.userid ".
                    "WHERE tb1.usertime>=? ".
                    "AND tb1.usertime<=? ".
                    "GROUP BY tb1.userid,".
                        "tb2.firstname,".
                        "tb2.lastname ".
                    "ORDER BY tb2.firstname";

            $params = [$start, $stop];
        }

        if ($results = $DB->get_records_sql($sql, $params)) {
            foreach ($results as $result) {
                $user = new stdclass();
                $user->id = (integer)$result->id;
                $user->firstname = (string)$result->firstname;
                $user->lastname = (string)$result->lastname;
                $user->first = (integer)$result->first;
                $user->last = (integer)$result->last;
                $user->total = (integer)$result->total;
                $user->count = (integer)$result->count;

                $users[$user->id] = $user;
            }
        }

        return($users);
    }

    /**
     * [group_liveusers]
     *
     * @param integer $courseid
     * @param integer $start
     * @param integer $stop
     * @param integer $step
     * @return array
     */
    public static function group_liveusers($courseid = 0, $start = 0, $stop = PHP_INT_MAX, $step = 20) {
        global $DB;

        $courseid = max(0, (integer)$courseid);
        $start = max(0, (integer)$start);
        $stop = max(0, (integer)$stop);
        $step = max(20, (integer)$step);
        $start = ($start - ($start % $step));
        $stop = ($stop - ($stop % $step));
        $stats = [];

        if ($courseid > 1) {
            $sql = "SELECT (tb1.usertime-(tb1.usertime%".$step.")) AS time,".
                        "MIN(tb1.usertime) AS first,".
                        "MAX(tb1.usertime) AS last,".
                        "COUNT(DISTINCT tb1.userid) AS total ".
                    "FROM {local_bbliveusers} tb1 ".
                    "WHERE tb1.courseid=? ".
                    "AND tb1.usertime>=? ".
                    "AND tb1.usertime<=? ".
                    "GROUP BY (tb1.usertime-(tb1.usertime%".$step."))";

            $params = [$courseid, $start, $stop];
        } else {
            $sql = "SELECT (tb1.usertime-(tb1.usertime%".$step.")) AS time,".
                        "MIN(tb1.usertime) AS first,".
                        "MAX(tb1.usertime) AS last,".
                        "COUNT(DISTINCT tb1.userid) AS total ".
                    "FROM {local_bbliveusers} tb1 ".
                    "WHERE tb1.usertime>=? ".
                    "AND tb1.usertime<=? ".
                    "GROUP BY (tb1.usertime-(tb1.usertime%".$step."))";

            $params = [$start, $stop];
        }

        if ($results = $DB->get_records_sql($sql, $params)) {
            foreach ($results as $result) {
                $stat = new stdclass();
                $stat->time = (integer)$result->time;
                $stat->first = (integer)$result->first;
                $stat->last = (integer)$result->last;
                $stat->total = (integer)$result->total;

                $stats[$stat->time] = $stat;
            }
        }

        return($stats);
    }
}