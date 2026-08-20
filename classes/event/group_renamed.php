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
 * Event triggered when a group is renamed via the Cohort Manager plugin.
 *
 * @package    local_cohort_manager
 * @copyright  2026 Maxime Cruzel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_cohort_manager\event;

defined('MOODLE_INTERNAL') || die();

/**
 * Group renamed event class.
 */
class group_renamed extends \core\event\base {

    /**
     * Initialise the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'groups';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns the event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventgrouprenamed', 'local_cohort_manager');
    }

    /**
     * Returns the event description.
     *
     * @return string
     */
    public function get_description() {
        $newname = $this->other['newname'] ?? '(unknown)';
        return "The user with id '{$this->userid}' renamed the group with id '{$this->objectid}' to '{$newname}'.";
    }

    /**
     * Returns the URL related to this event.
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/group/index.php', ['id' => $this->courseid]);
    }

    /**
     * Returns the objectid mapping for backup/restore.
     *
     * @return array
     */
    public static function get_objectid_mapping() {
        return ['db' => 'groups', 'restore' => 'group'];
    }

    /**
     * Returns the mapping of the 'other' data for backup/restore.
     *
     * The 'other' array only contains the new group name — no ids to re-map on restore.
     *
     * @return bool
     */
    public static function get_other_mapping() {
        return false;
    }
}
