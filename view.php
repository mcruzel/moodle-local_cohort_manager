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
 * Cohort detail page: shows enrolled courses and groups with rename forms.
 *
 * @package    local_cohort_manager
 * @copyright  2026 Maxime Cruzel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

require_login();
$context = context_system::instance();
require_capability('local/cohort_manager:manage', $context);

$cohortid = required_param('id', PARAM_INT);

$PAGE->set_url(new moodle_url('/local/cohort_manager/view.php', ['id' => $cohortid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');

$cohort = \local_cohort_manager\manager::get_cohort($cohortid);
$enrolments = \local_cohort_manager\manager::get_cohort_enrolments($cohortid);

// Escaped variant for page chrome (title, heading, navbar) which is output raw,
// unescaped variant for the template where Mustache escapes {{ }} itself.
$cohortname = format_string($cohort->name, true, ['context' => $context]);
$cohortnameplain = format_string($cohort->name, true, ['context' => $context, 'escape' => false]);

$PAGE->set_title($cohortname . ' - ' . get_string('pluginname', 'local_cohort_manager'));
$PAGE->set_heading($cohortname);
$PAGE->navbar->add(
    get_string('pluginname', 'local_cohort_manager'),
    new moodle_url('/local/cohort_manager/index.php')
);
$PAGE->navbar->add($cohortname);

$actionurl = (new moodle_url('/local/cohort_manager/action.php'))->out(false);

$data = [
    'cohort_id'       => $cohort->id,
    'cohort_name'     => $cohortnameplain,
    'cohort_name_raw' => $cohort->name,
    'is_component_managed' => !empty($cohort->component),
    'backurl'        => (new moodle_url('/local/cohort_manager/index.php'))->out(false),
    'action_url'     => $actionurl,
    'sesskey'        => sesskey(),
    'has_enrolments' => !empty($enrolments),
    'enrolments'     => array_values(array_map(function($row) use ($actionurl, $cohort) {
        return [
            'enrolid'          => $row->enrolid,
            'courseid'         => $row->courseid,
            'course_fullname'  => $row->fullname,
            'course_shortname' => $row->shortname,
            'enrolurl'         => (new moodle_url('/enrol/instances.php', ['id' => $row->courseid]))->out(false),
            'groupid'          => $row->groupid ?? 0,
            'groupname'        => $row->groupname ?? '',
            'has_group'        => !empty($row->groupid),
        ];
    }, $enrolments)),
];

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_cohort_manager/cohort_detail', $data);
echo $OUTPUT->footer();
