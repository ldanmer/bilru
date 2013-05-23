------------------------------------------------
---------"Morrowind Interactive Map"------------
------------------------------------------------

version 0.7 beta (31.10.02)

Small utility for orientation in Morrowind.

1. Description.
2. System requirements.
3. Control.
4. Setup.
5. Authors and contacts.
6. Disclaimer.
------------------------------------------

1.Description.

"Morrowind Interactive Map" is NOT replacement for in-game map, but can greatly lighten you in-game life . Warning: this program is spoiler...
"Morrowind Interactive Map" can:
a) help to learn full islands map in different zoom level. The map can display all in-game locations with their names and/or pop-up hints.
b) search any location on the map.
c) change the condition/status of every location to "visited", "active" and "unvisited". Locations of different status noted by colors and can be showed/hided separately.
d) add text description to location, which will show in pop-up hint.
e) show/hide displaying on the map routes of silt striders, ships and mages guild.
f) set users markers with text description on the map.
g) copy current map region to clipboard (for printing for example).

2. System requirements.

Program was tested on PIII 600 + 128 mb RAM (worst I can find). Screen resolution more than 800x600 recommended.

3. Control.

Map:
Reduce/enlarge - buttons with magnifier on the toolbar, "+" and "-" on the numeric keyboard, mouse wheel + ctrl.
Drag - cursor with left mouse button, mouse wheel (up/down), mouse wheel + shift (left/right), scrollbars.

Locations:
Search - type or select location name in combo box on toolbar (or double click on needed location on the map) and press button "Go".
Change status and/or add/change description - double click on the location. Title of window in bottom of program will change to name of location. To change status of locaction press one of buttons. To change description type text (less than 250 symbols) in "Notes". To end editing click on free region of the map.
Show/hide locations - buttons with letter U (unvisited), A (active), V (visited) on toolbar.
Show/hide names of locations - button "T" on tolbar.
Show/hide routes - buttons with netch, anchor and magic wand on toolbar.
Delete all descriptions and reset all location status to "unvisited" - just delete "user.gdb" from program folder.

Markers:
Work with markers can possible only with zoom level more than 20% (curren zoom level displayed in program title).
Add - press button with pen and "+" on toolbar (or mouse right click) and click on the map. To cancel adding click on toolbar button again.
Change - double click on the marker. Title of window in bottom of program will change to "Edit marker". To change description type text (less than 250 symbols) in "Notes". To end editing click on free region of the map. (By default on the map displayed only first 10 letters of discription. Read below how to change it).
Delete - press button with pen and "-" and click on the marker. To cancel deleting click on free region on the map.
Delete all markers - press button "x" on toolbar and confirm it.

Hints:
Show/hide hints - button "I" on toolbar.

Other:
Read "readme.txt" - press button with question-mark on toolbar and select language.
Copy current map region to clipboard - press button "camera" on toolbar "Options".

4. Setup.

Program configuration is stored in "tes.ini" and can be edited both manually and through user interface - just press button "Options" on the toolbar.

General options:
"Program"
 - "Restore window size and toolbars positions on startup" - if it's checked, window size, toolbar's positions, zoom level and current map region will saved on exit and restored on program startup .
 - "Keep zoom level" - if it's checked, minimum zoom level calculated according to size of program window.
 - "Enable database autosaving" - if it's checked, all user changes (new markers, descriptions etc) will be saved immediatelly, else - on program exit.
 - "Use map antialiasing for zoom level from ... and above" - if it's checked, for all zoom level from selected and above map will be antialiased. Recommended zoom level - 100%.


"Map"
 - "Font and size" - to change font for map captions press button "..." and select what you need.
 - "Caption length for locations and markers" - if 0 there are no limitations.

"Hints"
 - "Font and size" - to change font for pop-up hints press button "..." and select what you need.
 - "Transparency" - work only in Windows 2000/XP. 0% - opaque.

Miscellaneous options:
All operations with databases performed immediatelly, be careful.

5. Authors and contacts.

Lech March "Geronimo" (http://www.rolemancer.com, http://www.crpg.ru).
Dave Humphrey (http://www.m0use.net/~uesp/) - basic idea, database of locations, map.
Khabarik (http://morrowind.kamrad.ru/) - database of routes.
Gurthamoth (http://www.euro-morrowind.com/morrowind-france/) - french readme translation.
Bethesda Softworks Inc. - game and all resources.

Also thanks for my testers from http://morrowind.kamrad.ru/ (in alphabetical order)
Benedict (http://www.elderscrolls.net/),
Khabarik,
Night Romantic,

and all who email their feedback to me.

All suggestions and bug reports send to lechmarch@mailru.com
Last version of "Morrowind Intercative Map" always on http://morrowind.freetime.md/tesmap/ 

6. Disclaimer.

This program is freeware and freely distribute "as is". This program don't cange code and resources of original game an also don't change OS files. This program is not made, distributed or supported by Bethesda Softworks Inc.
