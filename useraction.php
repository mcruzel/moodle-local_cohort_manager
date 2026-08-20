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
 * POST handler for user cohort management actions (add/remove).
 *
 * @package    local_cohort_manager
 * @copyright  2026 Maxime Cruzel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

require_login();
require_capability('local/cohort_manager:manage', context_system::instance());
require_sesskey();

$action   = required_param('action', PARAM_ALPHA);
$userid   = required_param('userid', PARAM_INT);
$cohortid = required_param('cohortid', PARAM_INT);
$returnurl = new moodle_url('/local/cohort_manager/user.php', ['userid' => $userid]);

switch ($action) {
    case 'addcohort':
        \local_cohort_manager\manager::add_user_to_cohort($cohortid, $userid);
        redirect($returnurl, get_string('useraddedtocohort', 'local_cohort_manager'), null,
            \core\output\notification::NOTIFY_SUCCESS);
        break;

    case 'removecohort':
        \local_cohort_manager\manager::remove_user_from_cohort($cohortid, $userid);
        redirect($returnurl, get_string('userremovedfromcohort', 'local_cohort_manager'), null,
            \core\output\notification::NOTIFY_SUCCESS);
        break;

    default:
        throw new moodle_exception('invalidaction', 'local_cohort_manager');
}
