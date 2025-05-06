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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

namespace mod_myplugin\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\writer;

class provider implements \core_privacy\local\metadata\provider, \core_privacy\local\request\plugin_provider {

    /**
     * Returns metadata about the data stored by the plugin.
     *
     * @param collection $collection The metadata collection to add items to.
     * @return collection The updated collection.
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_database_table(
            'myplugin_table',
            [
                'userid' => 'privacy:metadata:myplugin_table:userid',
                // ...other fields...
            ],
            'privacy:metadata:myplugin_table'
        );

        return $collection;
    }

    /**
     * Export user data for the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to export information for.
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        // Implement data export logic here.
    }

    /**
     * Delete user data for the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to delete information for.
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        global $DB;

        // Delete all records for the given context.
        $DB->delete_records_select('local_resourceanalytics', 'cmid IN (SELECT id FROM {course_modules} WHERE course = ?)', [$context->instanceid]);
    }

    /**
     * Delete user data for the specified user and contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to delete information for.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        // Implement user-specific data deletion logic here.
    }
}