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
 * This file should run before config.php requires '/lib/setup.php'.
 *
 * Main purpose of this file:
 * 1) Allow to 'file.php' to know where dataroot is located and serve files during a maintenance.
 * 2) Allow to 'pretend' maintenance mode for non-allowed IPs by calling 'climaintenance.php'.
 * 3) Set a flag that this file was loaded so we can warn users if this config is not working.
 *
 * @package    auth_outage
 * @author     Daniel Thee Roperto <daniel.roperto@catalyst-au.net>
 * @copyright  2016 Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @var stdClass $CFG
 */

// This file does nothing if running from CLI.
if (defined('CLI_SCRIPT') && CLI_SCRIPT) {
    return;
}

// 1) Are we fetching a file? Non-allowed IPs can still see them.
if (defined('AUTH_OUTAGE_FILE')) {
    // We are not using any external libraries or references in this file (cli maintenance is active).
    // If you change the path below maybe you need to change maintenance_static_page::get_resources_folder() as well.
    $resourcedir = $CFG->dataroot.'/auth_outage/climaintenance';

    // Protect against path traversal attacks.
    $file = $resourcedir.'/'.$_GET['file'];
    if (realpath($file) !== $file) {
        // @codingStandardsIgnoreStart
        error_log('Invalid file: '.$_GET['file']);
        // @codingStandardsIgnoreEnd
        http_response_code(404);
        die('Not found.');
    }

    readfile($file);
    exit(0);
}

// 2) Check for allowed IPs during outages.
if (file_exists($CFG->dataroot.'/climaintenance.php')) {
    $CFG->dirroot = dirname(dirname(dirname(__FILE__))); // It is not defined yet but the script below needs it.
    require($CFG->dataroot.'/climaintenance.php'); // This call may terminate the script here or not.
}

// 3) Set flag this file was loaded.
$CFG->auth_outage_check = 2;