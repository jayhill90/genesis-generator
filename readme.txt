=== Genesis Generator ===
Contributors: jayhill90
Donate link: https://wpdev.life
Tags: Genesis, theme, generator
Requires at least: 4.5
Tested up to: 5.2.2
Stable tag: 0.4.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin adds a WP CLI command to be able to scaffold a Genesis Sample theme. 

== Description ==

This plugin adds a WP-CLI command to be able to generate a Genesis Sample theme, with all of the replacements being complete.
This is a work in progress, and is meant as a proof of concept on how valuable this could be to Genesis core. 

Currently this only supports Genesis/Genesis Sample 3.0.1. If you're running 2.10 or lower please upgrade.

I value feedback so if there's anything amiss feel free to open up an issue or hit me on twitter @wpdevlife. 

== Installation ==
Git clone this repo or download as zip to your plugins folder.
Activate the plugin.
Open up WP CLI and run a version of: 

`wp scaffold genesis my-theme --author="Jay Hill" --uri="wpdev.life" --description="My awesome theme" --theme_uri="testinproduction.systems"`

== Frequently Asked Questions ==



== Screenshots ==



== Changelog ==
= 0.4.2 = 
Fixed some missing replacement strings.

= 0.4.1 =
Added functionality to download Genesis Sample based on installed Genesis version

= 0.4.0 = 
Added theme_uri author_uri description and other args for command.
Expanded documentation.
Cleaned up more code.

= 0.1.2 =
Ensured theme is installed locally.
Minor bug fixes.

= 0.1.0 = 
* Initial base functionality.

