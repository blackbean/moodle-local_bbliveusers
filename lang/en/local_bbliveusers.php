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

$string['Ymd'] = 'Y-m-d';
$string['His'] = 'H:i:s';
$string['YmdHis'] = 'Y-m-d H:i:s';
$string['pluginname'] = 'LiveUsers';
$string['bbliveusers'] = 'LiveUsers';
$string['local/bbliveusers'] = 'LiveUsers';
$string['local_bbliveusers'] = 'LiveUsers';
$string['bbliveusers:export'] = 'Export';
$string['local/bbliveusers:export'] = 'Export';
$string['local_bbliveusers:export'] = 'Export';
$string['bbliveusers:report'] = 'Report';
$string['local/bbliveusers:report'] = 'Report';
$string['local_bbliveusers:report'] = 'Report';
$string['title_settings'] = 'LiveUsers - Settings';
$string['label_timeout'] = 'Timeout';
$string['help_timeout'] = 'The amount of seconds that this plugin will track idle users. If lower than 5 minutes it\'s exactly like to OnlineUsers native plugin, if it\'s too high the user session lifetime will be perpetuated, which can be considered a security flaw.';