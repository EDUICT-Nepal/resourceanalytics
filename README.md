{\rtf1\ansi\ansicpg1252\cocoartf2821
\cocoatextscaling0\cocoaplatform0{\fonttbl\f0\fswiss\fcharset0 Helvetica;}
{\colortbl;\red255\green255\blue255;}
{\*\expandedcolortbl;;}
\margl1440\margr1440\vieww11520\viewh8400\viewkind0
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\pardirnatural\partightenfactor0

\f0\fs24 \cf0 # Moodle Plugin: Resource Analytics\
\
**Plugin Type**: Local plugin  \
**Location**: `/local/resourceanalytics`  \
**Author**: Dr. Shesha Kanta Pangeni\
\
## Description\
\
This plugin provides a report for teachers to view detailed analytics of course resources and activities, including:\
\
- **View count** of each activity (based on Moodle\'92s core logging)\
- **Download count** for files set to "Force download" (tracked in real-time)\
- Accurate tracking of student interactions with course content\
- Compatible with all core modules (resources and activities)\
- Automatically detects and uses event logs from all `*\\\\course_module_viewed` events\
- Displays the first tracked event date for historical insight\
\
## Features\
\
- Integrated into the course navigation under Reports\
- Tracks downloads via custom event observers\
- Uses Moodle\'92s `logstore_standard_log` for historical view data\
- Compatible with Moodle 4.x\
- Displays an attribution footer for the plugin author\
\
## Installation\
\
1. Place the plugin folder inside `/local/resourceanalytics`\
2. Visit **Site administration > Notifications** to complete the installation\
3. Ensure that:\
   - Standard logstore is enabled\
   - Course activity views are logged (via event logging)\
\
## Usage\
\
- Navigate to any course as a teacher\
- Go to **Course administration > Reports > Resource view/download count**\
- The report displays:\
  - Activity/resource name\
  - Total number of views\
  - Total number of tracked downloads\
  - Note showing the first tracked event date\
  - Attribution line in red italic text\
\
## Screenshots\
\
*(Add screenshots of the report UI here if desired)*\
\
## License\
\
[GNU GPL v3](https://www.gnu.org/licenses/gpl-3.0.html)\
\
---\
This plugin is developed by: *Dr. Shesha Kanta Pangeni*\
}