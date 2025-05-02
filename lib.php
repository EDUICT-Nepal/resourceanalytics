<?php
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
