<?php
require('../../config.php');
require_once($CFG->libdir . '/tablelib.php');

$courseid = required_param('id', PARAM_INT);
require_login($courseid);
$context = context_course::instance($courseid);
require_capability('local/resourceanalytics:view', $context);

$PAGE->set_url(new moodle_url('/local/resourceanalytics/report.php', ['id' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_title(get_string('resourceanalytics', 'local_resourceanalytics'));
$PAGE->set_heading(get_string('resourceanalytics', 'local_resourceanalytics'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('resourceanalytics', 'local_resourceanalytics'));

$modules = get_fast_modinfo($courseid)->get_cms();
$table = new html_table();
$table->head = ['Activity name', 'View count', 'Download count'];

global $DB;

// ✅ FIX: Proper join from log → context → course_modules
$logdata = $DB->get_records_sql("
    SELECT cm.id AS cmid, COUNT(l.id) AS views
    FROM {logstore_standard_log} l
    JOIN {context} ctx ON ctx.id = l.contextid AND ctx.contextlevel = ?
    JOIN {course_modules} cm ON cm.id = ctx.instanceid
    WHERE l.courseid = ?
      AND l.eventname LIKE ?
    GROUP BY cm.id
", [CONTEXT_MODULE, $courseid, '%\\course_module_viewed']);

$viewcounts = [];
foreach ($logdata as $row) {
    $viewcounts[$row->cmid] = $row->views;
}

// ✅ Generate report rows
foreach ($modules as $cm) {
    if (!$cm->uservisible) {
        continue;
    }

    $cmid = $cm->id;
    $name = format_string($cm->name);
    $viewcount = $viewcounts[$cmid] ?? 0;

    $downloadcount = $DB->count_records('local_resourceanalytics', [
        'cmid' => $cmid,
        'action' => 'download',
    ]);

    $table->data[] = [
        $name,
        $viewcount,
        $downloadcount
    ];
}

if (empty($table->data)) {
    echo $OUTPUT->notification(get_string('noresourcesfound', 'local_resourceanalytics'), 'notifymessage');
} else {
    echo html_writer::table($table);
}

$firstevent = $DB->get_field_sql("
    SELECT MIN(timecreated)
    FROM {logstore_standard_log}
    WHERE courseid = ?
      AND eventname LIKE ?
", [$courseid, '%\\course_module_viewed']);

if (!empty($firstevent)) {
    echo html_writer::div(
        html_writer::tag('strong', 'Note:') . ' Tracking started on ' . userdate($firstevent),
        'small text-muted mt-3'
    );
} else {
    echo html_writer::div(
        html_writer::tag('strong', 'Note:') . ' No tracking data found.',
        'small text-muted mt-3'
    );
}
// Attribution in italic red from lang string
echo html_writer::div(
    html_writer::tag('em', get_string('developedby', 'local_resourceanalytics')),
    'mt-2',
    ['style' => 'color: red;']
);
echo $OUTPUT->footer();
