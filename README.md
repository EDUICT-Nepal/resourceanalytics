 Moodle Plugin: Resource Analytics
**Plugin Type**: Local plugin  
**Location**: `/local/resourceanalytics`
**Author**: Dr. Shesha Kanta Pangeni\
## Description
This plugin provides a report for teachers to view detailed analytics of course resources and activities, including:
- **View count** of each activity (based on Moodle\'92s core logging)
- **Download count** for files set to "Force download" (tracked in real-time)
- Accurate tracking of student interactions with course content
- Compatible with all core modules (resources and activities)
- Automatically detects and uses event logs from all `*\\\\course_module_viewed` events
- Displays the first tracked event date for historical insight

## Features

- Integrated into the course navigation under Reports
- Tracks downloads via custom event observers
- Uses Moodle\'92s `logstore_standard_log` for historical view data
- Compatible with Moodle 4.x
- Displays an attribution footer for the plugin author

## Installation

1. Place the plugin folder inside `/local/resourceanalytics`
2. Visit **Site administration > Notifications** to complete the installation
3. Ensure that:
   - Standard logstore is enabled
   - Course activity views are logged (via event logging)

## Usage

- Navigate to any course as a teacher
- Go to **Course administration > Reports > Resource view/download count**
- The report displays:
  - Activity/resource name
  - Total number of views
  - Total number of tracked downloads
  - Note showing the first tracked event date
  - Attribution line in red italic text

## Screenshots

*(Add screenshots of the report UI here if desired)*

## License

[GNU GPL v3](https://www.gnu.org/licenses/gpl-3.0.html)

This plugin is developed by: *Dr. Shesha Kanta Pangeni*
