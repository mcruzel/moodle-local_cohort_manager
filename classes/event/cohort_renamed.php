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
 * Event triggered when a cohort is renamed via the Cohort Manager plugin.
 *
 * @package    local_cohort_manager
 * @copyright  2026 Maxime Cruzel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_cohort_manager\event;

defined('MOODLE_INTERNAL') || die();

/**
 * Cohort renamed event class.
 */
class cohort_renamed extends \core\event\base {

    /**
     * Initialise the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'cohort';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns the event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcohortrenamed', 'local_cohort_manager');
    }

    /**
     * Returns the event description.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '{$this->userid}' renamed the cohort with id '{$this->objectid}'.";
    }

    /**
     * Returns the URL related to this event.
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/local/cohort_manager/view.php', ['id' => $this->objectid]);
    }
}
