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
 * Main page: searchable list of cohorts.
 *
 * @package    local_cohort_manager
 * @copyright  2026 Maxime Cruzel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

require_login();
$context = context_system::instance();
require_capability('local/cohort_manager:manage', $context);

$search  = optional_param('search', '', PARAM_TEXT);
$page    = optional_param('page', 0, PARAM_INT);
$sort    = optional_param('sort', 'name', PARAM_ALPHA);
$dir     = optional_param('dir', 'ASC', PARAM_ALPHA);
$perpage = \local_cohort_manager\manager::COHORTS_PER_PAGE;

$baseurl = new moodle_url('/local/cohort_manager/index.php', ['search' => $search, 'sort' => $sort, 'dir' => $dir]);

$PAGE->set_url($baseurl);
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('pluginname', 'local_cohort_manager'));
$PAGE->set_heading(get_string('pluginname', 'local_cohort_manager'));

$totalcount = \local_cohort_manager\manager::count_cohorts($search);
$cohorts = \local_cohort_manager\manager::search_cohorts($search, $page, $perpage, $sort, $dir);

// Build sort URLs for column headers (toggle direction if already sorting by this column).
$sortparams = ['search' => $search];
$makesorturl = function(string $column) use ($sort, $dir, $sortparams) {
    $newdir = ($sort === $column && $dir === 'ASC') ? 'DESC' : 'ASC';
    return (new moodle_url('/local/cohort_manager/index.php',
        array_merge($sortparams, ['sort' => $column, 'dir' => $newdir])))->out(false);
};

// Sort indicator icon (decorative, empty alt) and aria-sort value for the active column.
$sorticon = $dir === 'ASC' ? $OUTPUT->pix_icon('t/sort_asc', '') : $OUTPUT->pix_icon('t/sort_desc', '');
$ariasort = $dir === 'ASC' ? 'ascending' : 'descending';

$data = [
    'searchurl'   => (new moodle_url('/local/cohort_manager/index.php'))->out(false),
    'searchvalue' => $search,
    'has_cohorts' => !empty($cohorts),
    'cohorts'     => array_values(array_map(function($cohort) use ($context) {
        return [
            'id'          => $cohort->id,
            // Mustache escapes {{ }} output itself, so ask format_string/content_to_text
            // for unescaped values to avoid double-encoded entities.
            'name'        => format_string($cohort->name, true, ['context' => $context, 'escape' => false]),
            'idnumber'    => $cohort->idnumber,
            'description' => content_to_text(format_text($cohort->description ?? '',
                $cohort->descriptionformat ?? FORMAT_HTML, ['context' => $context]), false),
            'membercount' => (int)$cohort->membercount,
            'membersurl'  => (new moodle_url('/cohort/assign.php', ['id' => $cohort->id]))->out(false),
            'enrolcount'  => (int)$cohort->enrolcount,
            'viewurl'     => (new moodle_url('/local/cohort_manager/view.php', ['id' => $cohort->id]))->out(false),
        ];
    }, $cohorts)),
    'pagination'  => $totalcount > $perpage ? $OUTPUT->paging_bar($totalcount, $page, $perpage, $baseurl) : '',
    'usercohortsurl' => (new moodle_url('/local/cohort_manager/user.php'))->out(false),
    'sort_name_url'        => $makesorturl('name'),
    'sort_idnumber_url'    => $makesorturl('idnumber'),
    'sort_membercount_url' => $makesorturl('membercount'),
    'sort_enrolcount_url'  => $makesorturl('enrolcount'),
    'sort_name_icon'        => $sort === 'name' ? $sorticon : '',
    'sort_idnumber_icon'    => $sort === 'idnumber' ? $sorticon : '',
    'sort_membercount_icon' => $sort === 'membercount' ? $sorticon : '',
    'sort_enrolcount_icon'  => $sort === 'enrolcount' ? $sorticon : '',
    'sort_name_ariasort'        => $sort === 'name' ? $ariasort : '',
    'sort_idnumber_ariasort'    => $sort === 'idnumber' ? $ariasort : '',
    'sort_membercount_ariasort' => $sort === 'membercount' ? $ariasort : '',
    'sort_enrolcount_ariasort'  => $sort === 'enrolcount' ? $ariasort : '',
];

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_cohort_manager/cohort_list', $data);
echo $OUTPUT->footer();
