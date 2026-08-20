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
 * Business logic for the Cohort Manager plugin.
 *
 * @package    local_cohort_manager
 * @copyright  2026 Maxime Cruzel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_cohort_manager;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/cohort/lib.php');
require_once($CFG->dirroot . '/group/lib.php');

/**
 * Manager class containing all business logic for cohort management.
 */
class manager {

    /** @var int Default number of cohorts per page. */
    const COHORTS_PER_PAGE = 50;

    /** @var array Allowed sort columns for cohort list. */
    const SORT_COLUMNS = ['name', 'idnumber', 'enrolcount', 'membercount'];

    /**
     * Build the WHERE clause and params for cohort search.
     *
     * @param string $search Search term.
     * @return array [$where, $params] where $where is '' or 'WHERE ...'
     */
    private static function search_cohorts_where(string $search): array {
        global $DB;

        if (trim($search) === '') {
            return ['', []];
        }

        $likename = $DB->sql_like('c.name', ':name', false);
        $likeid = $DB->sql_like('c.idnumber', ':idnumber', false);
        $likedesc = $DB->sql_like('c.description', ':description', false);

        $where = "WHERE ({$likename} OR {$likeid} OR {$likedesc})";
        $params = [
            'name'        => '%' . $DB->sql_like_escape($search) . '%',
            'idnumber'    => '%' . $DB->sql_like_escape($search) . '%',
            'description' => '%' . $DB->sql_like_escape($search) . '%',
        ];

        return [$where, $params];
    }

    /**
     * Count cohorts matching a search term.
     *
     * @param string $search Search term (empty string counts all cohorts).
     * @return int Total number of matching cohorts.
     */
    public static function count_cohorts(string $search = ''): int {
        global $DB;

        [$where, $params] = self::search_cohorts_where($search);
        return $DB->count_records_sql("SELECT COUNT(*) FROM {cohort} c {$where}", $params);
    }

    /**
     * Search cohorts by name or idnumber with pagination, enrolment count, and sorting.
     *
     * @param string $search Search term (empty string returns all cohorts).
     * @param int $page Page number (0-based).
     * @param int $perpage Number of results per page.
     * @param string $sort Column to sort by (name, idnumber, enrolcount).
     * @param string $dir Sort direction (ASC or DESC).
     * @return array Array of cohort records with enrolcount field.
     */
    public static function search_cohorts(string $search = '', int $page = 0, int $perpage = self::COHORTS_PER_PAGE,
            string $sort = 'name', string $dir = 'ASC'): array {
        global $DB;

        $page = max(0, $page);
        $perpage = min(max(1, $perpage), self::COHORTS_PER_PAGE);

        [$where, $params] = self::search_cohorts_where($search);

        // Validate sort parameters.
        if (!in_array($sort, self::SORT_COLUMNS)) {
            $sort = 'name';
        }
        $dir = strtoupper($dir) === 'DESC' ? 'DESC' : 'ASC';

        $sql = "SELECT c.id, c.name, c.idnumber, c.description, c.descriptionformat,
                       (SELECT COUNT(*)
                          FROM {enrol} e
                         WHERE e.enrol = 'cohort'
                           AND e.customint1 = c.id) AS enrolcount,
                       (SELECT COUNT(*)
                          FROM {cohort_members} cm
                         WHERE cm.cohortid = c.id) AS membercount
                  FROM {cohort} c
                 {$where}
              ORDER BY {$sort} {$dir}";

        return $DB->get_records_sql($sql, $params, $page * $perpage, $perpage);
    }

    /**
     * Get a single cohort by ID.
     *
     * @param int $cohortid The cohort ID.
     * @return \stdClass The cohort record.
     * @throws \moodle_exception If the cohort is not found.
     */
    public static function get_cohort(int $cohortid): \stdClass {
        global $DB;

        $cohort = $DB->get_record('cohort', ['id' => $cohortid]);
        if (!$cohort) {
            throw new \moodle_exception('cohortnotfound', 'local_cohort_manager');
        }
        return $cohort;
    }

    /**
     * Ensure a cohort is not managed by an external component.
     *
     * Cohorts created by another component (e.g. an enrolment or sync plugin)
     * must not be modified or deleted through this plugin.
     *
     * @param \stdClass $cohort The cohort record.
     * @throws \moodle_exception If the cohort is managed by another component.
     */
    private static function require_not_component_managed(\stdClass $cohort): void {
        if (!empty($cohort->component)) {
            throw new \moodle_exception('cannotmanagecohort', 'local_cohort_manager', '', $cohort->component);
        }
    }

    /**
     * Get all courses where a cohort is enrolled via the cohort sync enrolment method,
     * along with the associated group information.
     *
     * @param int $cohortid The cohort ID.
     * @return array Array of objects with: enrolid, courseid, fullname, shortname, groupid, groupname.
     */
    public static function get_cohort_enrolments(int $cohortid): array {
        global $DB;

        $sql = "SELECT e.id AS enrolid, e.courseid,
                       c.fullname, c.shortname,
                       g.id AS groupid, g.name AS groupname
                  FROM {enrol} e
                  JOIN {course} c ON c.id = e.courseid
             LEFT JOIN {groups} g ON g.id = e.customint2
                 WHERE e.enrol = 'cohort'
                   AND e.customint1 = :cohortid
              ORDER BY c.fullname ASC";

        return $DB->get_records_sql($sql, ['cohortid' => $cohortid]);
    }

    /**
     * Rename a cohort.
     *
     * @param int $cohortid The cohort ID.
     * @param string $newname The new name for the cohort.
     * @throws \moodle_exception If the name is empty or the cohort is not found.
     */
    public static function rename_cohort(int $cohortid, string $newname): void {
        $cohort = self::get_cohort($cohortid);
        self::require_not_component_managed($cohort);

        $newname = trim($newname);
        if ($newname === '') {
            throw new \moodle_exception('emptycohortname', 'local_cohort_manager');
        }

        $cohort->name = $newname;
        cohort_update_cohort($cohort);

        $event = \local_cohort_manager\event\cohort_renamed::create([
            'context'  => \context::instance_by_id($cohort->contextid),
            'objectid' => $cohort->id,
        ]);
        $event->trigger();
    }

    /**
     * Delete a cohort.
     *
     * @param int $cohortid The cohort ID.
     * @param string $confirmname The name typed by the user for confirmation.
     * @throws \moodle_exception If the confirmation name does not match.
     */
    public static function delete_cohort(int $cohortid, string $confirmname): void {
        $cohort = self::get_cohort($cohortid);
        self::require_not_component_managed($cohort);

        if (trim($confirmname) !== $cohort->name) {
            throw new \moodle_exception('deletenamenotmatch', 'local_cohort_manager');
        }

        cohort_delete_cohort($cohort);
    }

    /**
     * Rename a single group.
     *
     * @param int $groupid The group ID.
     * @param string $newname The new name for the group.
     * @throws \moodle_exception If the name is empty or the group is not found.
     */
    public static function rename_group(int $groupid, string $newname): void {
        global $DB;

        $group = $DB->get_record('groups', ['id' => $groupid], '*', MUST_EXIST);

        $newname = trim($newname);
        if ($newname === '') {
            throw new \moodle_exception('emptygroupname', 'local_cohort_manager');
        }

        $group->name = $newname;
        groups_update_group($group);

        $event = \local_cohort_manager\event\group_renamed::create([
            'context'  => \context_course::instance($group->courseid),
            'objectid' => $group->id,
            'other'    => ['newname' => $newname],
        ]);
        $event->trigger();
    }

    /**
     * Create a group for a cohort enrolment that has no group.
     *
     * Creates a group named after the cohort and links it to the enrol instance.
     *
     * @param int $cohortid The cohort ID (used to get the group name).
     * @param int $enrolid The enrol instance ID to link the group to.
     * @return int The ID of the newly created group.
     */
    public static function create_group_for_enrolment(int $cohortid, int $enrolid): int {
        global $DB;

        $cohort = self::get_cohort($cohortid);
        $enrol = $DB->get_record('enrol', ['id' => $enrolid, 'enrol' => 'cohort', 'customint1' => $cohortid], '*', MUST_EXIST);

        if (!empty($enrol->customint2)) {
            throw new \moodle_exception('groupalreadyexists', 'local_cohort_manager');
        }

        $groupdata = new \stdClass();
        $groupdata->courseid = $enrol->courseid;
        $groupdata->name = $cohort->name;

        $groupid = groups_create_group($groupdata);

        // Link the group to the enrol instance (single-field update to avoid overwriting concurrent changes).
        $DB->set_field('enrol', 'customint2', $groupid, ['id' => $enrolid]);

        return $groupid;
    }

    /**
     * Batch rename all groups associated with a cohort's enrolments.
     *
     * Groups that do not exist (customint2 = 0) are skipped.
     *
     * @param int $cohortid The cohort ID.
     * @param string $newname The new name for all groups.
     * @return int The number of groups renamed.
     * @throws \moodle_exception If the name is empty.
     */
    public static function batch_rename_groups(int $cohortid, string $newname): int {
        global $DB;

        $newname = trim($newname);
        if ($newname === '') {
            throw new \moodle_exception('emptygroupname', 'local_cohort_manager');
        }

        // Fetch all group IDs for this cohort's enrolments in a single query.
        $sql = "SELECT DISTINCT g.id
                  FROM {enrol} e
                  JOIN {groups} g ON g.id = e.customint2
                 WHERE e.enrol = 'cohort'
                   AND e.customint1 = :cohortid
                   AND e.customint2 <> 0";
        $groupids = $DB->get_fieldset_sql($sql, ['cohortid' => $cohortid]);

        if (empty($groupids)) {
            return 0;
        }

        // Fetch all group records in a single query.
        $groups = $DB->get_records_list('groups', 'id', $groupids);

        // Wrap all updates in a transaction for atomicity.
        $transaction = $DB->start_delegated_transaction();

        $count = 0;
        foreach ($groups as $group) {
            $group->name = $newname;
            groups_update_group($group);
            $count++;
        }

        $transaction->allow_commit();

        $event = \local_cohort_manager\event\groups_batch_renamed::create([
            'context'  => \context_system::instance(),
            'objectid' => $cohortid,
            'other'    => ['newname' => $newname, 'count' => $count],
        ]);
        $event->trigger();

        return $count;
    }

    /**
     * Search users by name, email or username.
     *
     * @param string $search Search term.
     * @param int $page Page number (0-based).
     * @param int $perpage Results per page.
     * @return array Array of user records (id, email, username and all name fields).
     */
    public static function search_users(string $search, int $page = 0, int $perpage = self::COHORTS_PER_PAGE): array {
        global $CFG, $DB;

        $page = max(0, $page);
        $perpage = min(max(1, $perpage), self::COHORTS_PER_PAGE);

        $search = trim($search);
        if ($search === '') {
            return [];
        }

        $fullname = $DB->sql_fullname('firstname', 'lastname');
        $likefull = $DB->sql_like($fullname, ':fullname', false);
        $likeemail = $DB->sql_like('email', ':email', false);
        $likeuser = $DB->sql_like('username', ':username', false);

        // Select all name fields so fullname() can honour the site's fullname display settings.
        $namefields = \core_user\fields::for_name()->get_required_fields();
        $fields = implode(', ', array_unique(array_merge(['id', 'email', 'username'], $namefields)));

        $sql = "SELECT {$fields}
                  FROM {user}
                 WHERE deleted = 0
                   AND suspended = 0
                   AND id <> :guestid
                   AND ({$likefull} OR {$likeemail} OR {$likeuser})
              ORDER BY lastname ASC, firstname ASC";
        $params = [
            'guestid'  => $CFG->siteguest,
            'fullname' => '%' . $DB->sql_like_escape($search) . '%',
            'email'    => '%' . $DB->sql_like_escape($search) . '%',
            'username' => '%' . $DB->sql_like_escape($search) . '%',
        ];

        return $DB->get_records_sql($sql, $params, $page * $perpage, $perpage);
    }

    /**
     * Get all cohorts a user belongs to.
     *
     * @param int $userid The user ID.
     * @return array Array of cohort records (id, name, idnumber).
     */
    public static function get_user_cohorts(int $userid): array {
        global $DB;

        $sql = "SELECT c.id, c.name, c.idnumber, c.component
                  FROM {cohort} c
                  JOIN {cohort_members} cm ON cm.cohortid = c.id
                 WHERE cm.userid = :userid
              ORDER BY c.name ASC";

        return $DB->get_records_sql($sql, ['userid' => $userid]);
    }

    /**
     * Search cohorts a user does NOT belong to (for AJAX autocomplete).
     *
     * @param int $userid The user ID.
     * @param string $query Search query (name or idnumber).
     * @param int $limit Maximum number of results.
     * @return array Array of ['id' => int, 'name' => string].
     */
    public static function search_available_cohorts_for_user(int $userid, string $query, int $limit = 20): array {
        global $DB;

        $query = trim($query);
        if ($query === '') {
            return [];
        }

        $likename = $DB->sql_like('c.name', ':name', false);
        $likeid = $DB->sql_like('c.idnumber', ':idnumber', false);

        // Cohorts managed by another component cannot be joined through this plugin,
        // so do not offer them in the autocomplete.
        $sql = "SELECT c.id, c.name, c.idnumber
                  FROM {cohort} c
                 WHERE ({$likename} OR {$likeid})
                   AND c.component = :emptycomponent
                   AND c.id NOT IN (
                       SELECT cm.cohortid FROM {cohort_members} cm WHERE cm.userid = :userid
                   )
              ORDER BY c.name ASC";
        $params = [
            'name'           => '%' . $DB->sql_like_escape($query) . '%',
            'idnumber'       => '%' . $DB->sql_like_escape($query) . '%',
            'emptycomponent' => '',
            'userid'         => $userid,
        ];

        $records = $DB->get_records_sql($sql, $params, 0, $limit);

        $results = [];
        foreach ($records as $record) {
            $label = $record->name;
            if ($record->idnumber) {
                $label .= ' [' . $record->idnumber . ']';
            }
            $results[] = ['id' => (int)$record->id, 'name' => $label];
        }

        return $results;
    }

    /**
     * Add a user to a cohort.
     *
     * @param int $cohortid The cohort ID.
     * @param int $userid The user ID.
     */
    public static function add_user_to_cohort(int $cohortid, int $userid): void {
        $cohort = self::get_cohort($cohortid);
        self::require_not_component_managed($cohort);

        cohort_add_member($cohortid, $userid);
    }

    /**
     * Remove a user from a cohort.
     *
     * @param int $cohortid The cohort ID.
     * @param int $userid The user ID.
     */
    public static function remove_user_from_cohort(int $cohortid, int $userid): void {
        $cohort = self::get_cohort($cohortid);
        self::require_not_component_managed($cohort);

        cohort_remove_member($cohortid, $userid);
    }
}
