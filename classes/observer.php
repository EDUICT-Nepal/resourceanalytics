<?php
namespace local_resourceanalytics;

defined('MOODLE_INTERNAL') || die();

class observer {

     public static function log_view(\core\event\course_module_viewed $event) {
    global $DB, $USER;

    $cmid = $event->contextinstanceid;

    $record = [
        'cmid' => $cmid,
        'userid' => $USER->id,
        'action' => 'view',
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
                'action' => 'download',
                'timecreated' => time(),
            ];
            $DB->insert_record('local_resourceanalytics', $downloadrecord);
        }
    }
}

    public static function log_download(\core\event\file_viewed $event) {
        global $DB, $USER;

        $context = $event->get_context();
        if ($context->contextlevel === CONTEXT_MODULE) {
            $cmid = $context->instanceid;

            $record = [
                'cmid' => $cmid,
                'userid' => $USER->id,
                'action' => 'download',
                'timecreated' => time(),
            ];

            $DB->insert_record('local_resourceanalytics', $record);
        }
    }
}
