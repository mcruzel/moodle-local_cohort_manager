/**
 * Cohort selector AJAX transport for core/form-autocomplete.
 *
 * @module     local_cohort_manager/cohort_selector
 * @copyright  2026 Maxime Cruzel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['core/ajax'], function(Ajax) {
    return {
        /**
         * Process the results returned by the AJAX call.
         *
         * @param {string} selector The select element selector.
         * @param {Array} results The raw AJAX response.
         * @return {Array} Processed options with value and label.
         */
        processResults: function(selector, results) {
            var options = [];
            results.forEach(function(result) {
                options.push({
                    value: result.id,
                    label: result.name
                });
            });
            return options;
        },

        /**
         * Fetch results from the web service.
         *
         * @param {string} selector The select element selector.
         * @param {string} query The search query.
         * @param {Function} success Callback on success.
         * @param {Function} failure Callback on failure.
         */
        transport: function(selector, query, success, failure) {
            var el = document.querySelector(selector);
            var userid = el.getAttribute('data-userid');
            var promises = Ajax.call([{
                methodname: 'local_cohort_manager_search_available_cohorts',
                args: {userid: parseInt(userid), query: query}
            }]);
            promises[0].then(success).catch(failure);
        }
    };
});
