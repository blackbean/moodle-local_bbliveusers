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

// Loading all the required objects.
global $ADMIN, $CFG;

// Verifying if we are within the site administration section
// and, if true, registering this plug-in configuration page.
if ($hassiteconfig) {

    // Creating this plug-in configuration page.
    $settings = new admin_settingpage('local_bbliveusers_settings',
                                      get_string('title_settings', 'block_bbliveusers'));

    // Creating this plug-in parameter input.
    $settings->add(new admin_setting_configduration(
        // Registering this parameter key.
        'local_bbliveusers/timeout',
        // Registering this parameter name.
        get_string('label_timeout', 'block_bbliveusers'),
        // Registering this parameter help.
        get_string('help_timeout', 'block_bbliveusers'),
        // Registering this parameter value.
        $CFG->sessiontimeout,
        // Registering this parameter unit.
        1
    ));

    // Registering this plug-in configuration page.
    $ADMIN->add('localplugins', $settings);
}