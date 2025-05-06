
# Changelog
## 1.0.0 \'96 Initial Release (2025-05-01)

- Initial release of `local_resourceanalytics`
- Tracks file download count via event observer\
- Displays view count using `logstore_standard_log`
- Automatically links logs to course module instances
- Displays "Tracking started on" date from first event
- Attribution message included in footer

## 1.0.1 \'96 Minor Fixes (2025-05-02)

- Fixed bug where contextinstanceid did not map to course module ID
- Switched to `LIKE %course_module_viewed` to support all modules (mod_quiz, mod_h5pactivity, etc.)
- Improved footer to load strings from `lang` file
