<?php
/**
 * This file is part of BlackBean Live Users <https://github.com/blackbean/BBLiveUsers>, a plugin
 * for the Moodle LMS Platform <https://www.moodle.org> that monitors the exact number of online
 * users per course in realtime, even if they spend hours watching a single video, for example,
 * without ever refreshing a single page. Copyright (C) 2018 by BlackBean Technologies Ltda.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, either version
 * 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU
 * General Public License along with this program.
 * If not, see https://www.gnu.org/licenses/
 */

/**
 * @package local_bbliveusers
 * @author Bruno Magalhães <brunomagalhaes@blackbean.com.br>
 * @copyright 2018 by BlackBean Technologies Ltda <https://www.blackbean.com.br>
 * @license http://www.gnu.org/copyleft/gpl.html
 */
define('AJAX_SCRIPT', true);

/**
 * 
 */
require_once(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');

/**
 * 
 */
require_login();

/**
 * 
 */
$course_id = optional_param('course_id', 0, PARAM_INT);
$user_id = optional_param('user_id', 0, PARAM_INT);

/**
 * 
 */
if(bbliveusers::store_liveuser($course_id, $user_id))
{
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
	print('{"result":true}');
	exit(0);
}

/**
 * 
 */
header('HTTP/1.0 503 Service Unavailable');
header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Pragma: no-cache');
header('Expires: 0');
print('{"result":false}');
exit(0);