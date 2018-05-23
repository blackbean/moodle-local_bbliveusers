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
define('AJAX_SCRIPT', true);

/**
 * 
 */
require_once(__DIR__.'/../../config.php');
require_once(__DIR__.'/locallib.php');

/**
 * 
 */
require_login();

/**
 * 
 */
$course_id = optional_param('course_id', 0, PARAM_INT);
$limit = optional_param('limit', 60, PARAM_INT);
$time = time();
$data = bbliveusers::group_liveusers($course_id, ($time - $limit), $time);
$data = json_encode(array_values($data));

/**
 * 
 */
header('HTTP/1.0 200 OK');
header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Pragma: no-cache');
header('Expires: 0');
print('{"time":'.$time.',"data":'.$data.'}');
exit(0);