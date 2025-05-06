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

defined('MOODLE_INTERNAL') || die();

/**
 * Extend the course navigation to include the resourceanalytics report link.
 */
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/report/outline/lib.php');

function local_resourceanalytics_extend_navigation_course($navigation, $course, $context) {
    // Only show to users with the right capability.
    if (!has_capability('local/resourceanalytics:view', $context)) {
        return;
    }

    // Add under Reports if available.
    if ($reportnode = $navigation->get('coursereports')) {
        $url = new moodle_url('/local/resourceanalytics/report.php', ['id' => $course->id]);
        $reportnode->add(
            get_string('resourceanalytics', 'local_resourceanalytics'),
            $url,
            navigation_node::TYPE_SETTING,
            null,
            'resourceanalytics'
        );
    }
}
