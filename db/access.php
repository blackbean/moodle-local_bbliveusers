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

/**
 *
 */
$capabilities = array(
    'local/bbliveusers:export' => array(
        'riskbitmask' => RISK_CONFIG,
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'student' => CAP_DENY,
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_DENY,
            'teacher' => CAP_DENY)
    ),
    'local/bbliveusers:report' => array(
        'riskbitmask' => RISK_CONFIG,
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'student' => CAP_DENY,
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_DENY,
            'teacher' => CAP_DENY)
    )
);