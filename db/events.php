<?php
defined('MOODLE_INTERNAL') || die();

$observers = [
    [
        'eventname' => '\core\event\course_module_viewed',
        'callback'  => '\local_resourceanalytics\observer::log_view',
    ]
];
