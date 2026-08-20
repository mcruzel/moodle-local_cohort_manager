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
 * External function to search cohorts available for a user (AJAX autocomplete).
 *
 * @package    local_cohort_manager
 * @copyright  2026 Maxime Cruzel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_cohort_manager\external;

defined('MOODLE_INTERNAL') || die();

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_value;
use core_external\external_single_structure;
use core_external\external_multiple_structure;

/**
 * Search cohorts that a given user can be added to.
 */
class search_available_cohorts extends external_api {

    /**
     * Describe the parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'userid' => new external_value(PARAM_INT, 'The user ID'),
            'query'  => new external_value(PARAM_TEXT, 'Search query string'),
        ]);
    }

    /**
     * Execute the search.
     *
     * @param int $userid The user ID.
     * @param string $query The search query.
     * @return array Array of cohort results.
     */
    public static function execute(int $userid, string $query): array {
        $params = self::validate_parameters(self::execute_parameters(), [
            'userid' => $userid,
            'query'  => $query,
        ]);

        $context = \context_system::instance();
        self::validate_context($context);
        require_capability('local/cohort_manager:manage', $context);

        return \local_cohort_manager\manager::search_available_cohorts_for_user(
            $params['userid'], $params['query']
        );
    }

    /**
     * Describe the return value.
     *
     * @return external_multiple_structure
     */
    public static function execute_returns(): external_multiple_structure {
        return new external_multiple_structure(
            new external_single_structure([
                'id'   => new external_value(PARAM_INT, 'Cohort ID'),
                'name' => new external_value(PARAM_TEXT, 'Cohort display name'),
            ])
        );
    }
}
