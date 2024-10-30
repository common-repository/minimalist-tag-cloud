=== Minimalist Tag Cloud ===
Contributors: Sauce Code
Tags: widgets, tags, categories, popular, tagcloud, tag count
Requires at least: 4.6
Tested up to: 4.9
Stable tag: trunk

Customisable widget and shortcode to display tag cloud with option to show tag count anywhere you want.

== Description ==

Minimalist Tag Cloud is a WordPress plugin that allows you to display your website's most popular tags, categories or custom taxonomies as a widget or using a shortcode. 
The plugin styles the tag cloud in a minimalist style with the option to include tag count.

You can use Minimalist Tag Cloud as a widget or shortcode.

There are a number of options that you can customise:

* 	number of items (tags) to show
* 	type of taxonomies (tags / categories / custom taxonomies) to show 
* 	include/exclude a list of tags
* 	smallest and largest font sizes
* 	font size unit
* 	display format (flat / list)
* 	flat format separator
* 	order by and order
* 	show/hide tag count

Check 'Installation' tab for details on how to embed the shortcode.

== Installation ==

1. Upload 'minimalist-tag-cloud' folder to the '/wp-content/plugins/' directory of your WordPress installation.

2. Activate the plugin through the 'Plugins' menu in WordPress.

3. The Minimalist Tag Cloud widget can now be configured and used from the Appearance -> Widgets menu

4. If you want to embed a tag cloud in your posts or pages, use the [scmintagcloud] shortcode.
Example: [scmintagcloud taxonomy="category" smallest="12" largest="12" unit="px" format="list" showcount="yes"]

All attributes and possible values for selected attributes:

*	tagcount
*	taxonomy
* 	include
* 	exclude
* 	smallest
* 	largest
* 	unit
* 	showcount: yes, no
* 	format: flat, list
* 	separator
* 	orderby: count, name
* 	order: asc, desc, rand		

== Screenshots ==
1. Widget configuration.
2. Example of tag cloud generated with list format + tag count.
3. Example of tag cloud generated with list format + without tag count.

== Changelog ==

= 1.0 =
* Initial version.
