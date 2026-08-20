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
 * POST handler for rename actions (cohort, group, batch).
 *
 * Processes the action and redirects back to the cohort detail page
 * using the Post/Redirect/Get pattern.
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
$cohortid = required_param('cohortid', PARAM_INT);
$returnurl = new moodle_url('/local/cohort_manager/view.php', ['id' => $cohortid]);

switch ($action) {
    case 'renamecohort':
        $newname = required_param('cohortname', PARAM_TEXT);
        \local_cohort_manager\manager::rename_cohort($cohortid, $newname);
        redirect($returnurl, get_string('cohortrenamed', 'local_cohort_manager'), null,
            \core\output\notification::NOTIFY_SUCCESS);
        break;

    case 'renamegroup':
        $groupid = required_param('groupid', PARAM_INT);
        $newname = required_param('groupname', PARAM_TEXT);
        \local_cohort_manager\manager::rename_group($groupid, $newname);
        redirect($returnurl, get_string('grouprenamed', 'local_cohort_manager'), null,
            \core\output\notification::NOTIFY_SUCCESS);
        break;

    case 'batchrename':
        $newname = required_param('batchgroupname', PARAM_TEXT);
        \local_cohort_manager\manager::batch_rename_groups($cohortid, $newname);
        redirect($returnurl, get_string('groupsbatchrenamed', 'local_cohort_manager'), null,
            \core\output\notification::NOTIFY_SUCCESS);
        break;

    case 'creategroup':
        $enrolid = required_param('enrolid', PARAM_INT);
        \local_cohort_manager\manager::create_group_for_enrolment($cohortid, $enrolid);
        redirect($returnurl, get_string('groupcreated', 'local_cohort_manager'), null,
            \core\output\notification::NOTIFY_SUCCESS);
        break;

    case 'deletecohort':
        $confirmname = required_param('confirmname', PARAM_TEXT);
        try {
            \local_cohort_manager\manager::delete_cohort($cohortid, $confirmname);
        } catch (\moodle_exception $e) {
            redirect($returnurl, get_string('deletenamenotmatch', 'local_cohort_manager'), null,
                \core\output\notification::NOTIFY_ERROR);
        }
        $listurl = new moodle_url('/local/cohort_manager/index.php');
        redirect($listurl, get_string('cohortdeleted', 'local_cohort_manager'), null,
            \core\output\notification::NOTIFY_SUCCESS);
        break;

    default:
        throw new moodle_exception('invalidaction', 'local_cohort_manager');
}
