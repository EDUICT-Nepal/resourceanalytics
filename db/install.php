<?php
function xmldb_local_resourceanalytics_install() {
    if (!get_config('local_resourceanalytics', 'installedon')) {
        set_config('installedon', time(), 'local_resourceanalytics');
    }
}
