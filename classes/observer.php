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

namespace local_resourceanalytics;

defined('MOODLE_INTERNAL') || die();

use \core\event\course_module_viewed as course_module_viewed_event;
use \core\event\file_viewed as file_viewed_event;

/**
 * Observer class for handling events related to resource analytics.
 */
class observer {

    /**
     * Logs a view action for a course module.
     *
     * @param course_module_viewed_event $event The event object.
     * @return void
     */
    public static function log_view(course_module_viewed_event $event) {
        global $DB, $USER;

        $cmid = $event->contextinstanceid;

        $record = [
            'cmid' => $cmid,
            'userid' => $USER->id,
            'action' => get_string('action_view', 'local_resourceanalytics'),
            'timecreated' => time(),
        ];
        $DB->insert_record('local_resourceanalytics', $record);

        // OPTIONAL: Also log as download if it's a resource set to "force download"
        $cm = get_coursemodule_from_id(null, $cmid);
        if ($cm && $cm->modname === 'resource') {
            // Check display option
            $resource = $DB->get_record('resource', ['id' => $cm->instance]);
            if ($resource && $resource->display == RESOURCELIB_DISPLAY_DOWNLOAD) {
                $downloadrecord = [
                    'cmid' => $cmid,
                    'userid' => $USER->id,
                    'action' => get_string('action_download', 'local_resourceanalytics'),
                    'timecreated' => time(),
                ];
                $DB->insert_record('local_resourceanalytics', $downloadrecord);
            }
        }
    }

    /**
     * Logs a download action for a course module.
     *
     * @param file_viewed_event $event The event object.
     * @return void
     */
    public static function log_download(file_viewed_event $event) {
        global $DB, $USER;

        $context = $event->get_context();
        if ($context->contextlevel === CONTEXT_MODULE) {
            $cmid = $context->instanceid;

            $record = [
                'cmid' => $cmid,
                'userid' => $USER->id,
                'action' => get_string('action_download', 'local_resourceanalytics'),
                'timecreated' => time(),
            ];

            $DB->insert_record('local_resourceanalytics', $record);
        }
    }
}
