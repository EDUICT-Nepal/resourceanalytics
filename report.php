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

/**
 * Resource Analytics report page.
 *
 * @package   local_resourceanalytics
 * @copyright 2025 Dr. Shesha Kanta Pangeni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

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
$table->head = [
    get_string('resourcename', 'local_resourceanalytics'),
    get_string('viewcount', 'local_resourceanalytics'),
    get_string('downloadcount', 'local_resourceanalytics'),
];


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
       html_writer::tag('strong', get_string('note', 'local_resourceanalytics')) . ' ' . get_string('trackingstarted', 'local_resourceanalytics', userdate($firstevent)),
        'small text-muted mt-3'
    );
} else {
    echo html_writer::div(
       html_writer::tag('strong', get_string('note', 'local_resourceanalytics')) . ' ' . get_string('notrackingdata', 'local_resourceanalytics'),
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
