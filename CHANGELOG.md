{\rtf1\ansi\ansicpg1252\cocoartf2821
\cocoatextscaling0\cocoaplatform0{\fonttbl\f0\fswiss\fcharset0 Helvetica;}
{\colortbl;\red255\green255\blue255;}
{\*\expandedcolortbl;;}
\margl1440\margr1440\vieww11520\viewh8400\viewkind0
\pard\tx720\tx1440\tx2160\tx2880\tx3600\tx4320\tx5040\tx5760\tx6480\tx7200\tx7920\tx8640\pardirnatural\partightenfactor0

\f0\fs24 \cf0 # Changelog\
\
## 1.0.0 \'96 Initial Release (2025-05-01)\
\
- Initial release of `local_resourceanalytics`\
- Tracks file download count via event observer\
- Displays view count using `logstore_standard_log`\
- Automatically links logs to course module instances\
- Displays "Tracking started on" date from first event\
- Attribution message included in footer\
\
## 1.0.1 \'96 Minor Fixes (2025-05-02)\
\
- Fixed bug where contextinstanceid did not map to course module ID\
- Switched to `LIKE %course_module_viewed` to support all modules (mod_quiz, mod_h5pactivity, etc.)\
- Improved footer to load strings from `lang` file\
}