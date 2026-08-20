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
 * User cohort management page: search a user and manage their cohort memberships.
 *
 * @package    local_cohort_manager
 * @copyright  2026 Maxime Cruzel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

require_login();
$context = context_system::instance();
require_capability('local/cohort_manager:manage', $context);

$usersearch = optional_param('usersearch', '', PARAM_TEXT);
$userid     = optional_param('userid', 0, PARAM_INT);

$PAGE->set_url(new moodle_url('/local/cohort_manager/user.php', ['usersearch' => $usersearch, 'userid' => $userid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('usercohorts', 'local_cohort_manager') . ' - ' . get_string('pluginname', 'local_cohort_manager'));
$PAGE->set_heading(get_string('usercohorts', 'local_cohort_manager'));
$PAGE->navbar->add(
    get_string('pluginname', 'local_cohort_manager'),
    new moodle_url('/local/cohort_manager/index.php')
);
$PAGE->navbar->add(get_string('usercohorts', 'local_cohort_manager'));

// Search users.
$users = [];
if ($usersearch !== '') {
    $users = \local_cohort_manager\manager::search_users($usersearch);
}

// If a user is selected, get their cohorts.
$selecteduser = null;
$usercohorts = [];
if ($userid > 0) {
    // Include all name fields so fullname() can honour the site's fullname display settings.
    $namefields = \core_user\fields::for_name()->get_required_fields();
    $userfields = implode(', ', array_unique(array_merge(['id', 'email', 'username'], $namefields)));
    $selecteduser = $DB->get_record('user', ['id' => $userid, 'deleted' => 0], $userfields);
    if ($selecteduser) {
        $usercohorts = \local_cohort_manager\manager::get_user_cohorts($userid);
    }
}

$actionurl = (new moodle_url('/local/cohort_manager/useraction.php'))->out(false);

$data = [
    'searchurl'    => (new moodle_url('/local/cohort_manager/user.php'))->out(false),
    'searchvalue'  => $usersearch,
    'has_users'    => !empty($users),
    'users'        => array_values(array_map(function($u) use ($userid) {
        return [
            'id'        => $u->id,
            'fullname'  => fullname($u),
            'email'     => $u->email,
            'username'  => $u->username,
            'selecturl' => (new moodle_url('/local/cohort_manager/user.php', ['userid' => $u->id]))->out(false),
            'selected'  => ($u->id == $userid),
        ];
    }, $users)),
    'has_selected_user'  => !empty($selecteduser),
    'selected_user_id'   => $selecteduser ? $selecteduser->id : 0,
    'selected_user_name' => $selecteduser ? fullname($selecteduser) : '',
    'selected_user_email' => $selecteduser ? $selecteduser->email : '',
    'action_url'         => $actionurl,
    'sesskey'            => sesskey(),
    'has_user_cohorts'   => !empty($usercohorts),
    'user_cohorts'       => array_values(array_map(function($c) {
        return [
            'id'       => $c->id,
            'name'     => $c->name,
            'idnumber' => $c->idnumber,
        ];
    }, $usercohorts)),
];

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_cohort_manager/user_cohorts', $data);
echo $OUTPUT->footer();
