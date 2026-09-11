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
 * Event triggered when a cohort enrolment instance is removed via the Cohort Manager plugin.
 *
 * @package    local_cohort_manager
 * @copyright  2026 Maxime Cruzel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_cohort_manager\event;

defined('MOODLE_INTERNAL') || die();

/**
 * Cohort enrolment instance deleted event class.
 */
class enrolment_deleted extends \core\event\base {

    /**
     * Initialise the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'enrol';
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns the event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventenrolmentdeleted', 'local_cohort_manager');
    }

    /**
     * Returns the event description.
     *
     * @return string
     */
    public function get_description() {
        $cohortid = $this->other['cohortid'] ?? '(unknown)';
        $groupstatus = $this->other['groupstatus'] ?? '(unknown)';
        return "The user with id '{$this->userid}' removed the cohort enrolment instance with id " .
            "'{$this->objectid}' (cohort id '{$cohortid}') from the course with id '{$this->courseid}'. " .
            "Linked group: '{$groupstatus}'.";
    }

    /**
     * Returns the URL related to this event.
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/enrol/instances.php', ['id' => $this->courseid]);
    }

    /**
     * Returns the objectid mapping for backup/restore.
     *
     * The enrolment instance no longer exists when this event is read back, so it is
     * never re-mapped, exactly as core does for \core\event\enrol_instance_deleted.
     *
     * @return array
     */
    public static function get_objectid_mapping() {
        return ['db' => 'enrol', 'restore' => \core\event\base::NOT_MAPPED];
    }

    /**
     * Returns the mapping of the 'other' data for backup/restore.
     *
     * @return array
     */
    public static function get_other_mapping() {
        return ['cohortid' => ['db' => 'cohort', 'restore' => \core\event\base::NOT_MAPPED]];
    }
}
