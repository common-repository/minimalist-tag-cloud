<?php
/*
Plugin Name: Minimalist Tag Cloud
Plugin URI:  http://www.saucecode.com.sg/
Description: Displays your Wordpress tag cloud (and other taxonomies) in a minimalist design with tag count
Version:     1.0
Author:      Sauce Code
Author URI:  http://www.saucecode.com.sg/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Minimalist Tag Cloud is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Minimalist Tag Cloud is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Minimalist Tag Cloud. If not, see {License URI}.
*/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class MinimalistTagCloud extends WP_Widget {

	// Initialise widget
	function MinimalistTagCloud() {
		// Register style sheet
		wp_enqueue_style('minimalisttagcloud-style', plugins_url('/style.css', __FILE__));
		
		$widget_ops = array(
						'classname' => 'widget_MinimalistTagCloud',
						'description' => 'Minimalist Tag Cloud'
						);
		$this->WP_Widget('minimalisttagcloud', 'Minimalist Tag Cloud', $widget_ops);
	}
	
	// Display widget
	function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? ' ' : $instance['title']);
		$tagcount = empty($instance['tagcount']) ? 0 : $instance['tagcount'];
		$smallest = empty($instance['smallest']) ? 12 : $instance['smallest'];
		$largest = empty($instance['largest']) ? 12 : $instance['largest'];
		$unit = empty($instance['unit']) ? 'px' : $instance['unit'];
		$format = empty($instance['format']) ? 'flat' : $instance['format'];
		$orderby = empty($instance['orderby']) ? 'count' : $instance['orderby'];
		$order = empty($instance['order']) ? 'DESC' : $instance['order'];
		$taxonomy = empty($instance['taxonomy']) ? 'post_tag' : $instance['taxonomy'];
		$separator = empty($instance['separator']) ? ' ' : $instance['separator'];
		$include = empty($instance['include']) ? ' ' : $instance['include'];
		$exclude = empty($instance['exclude']) ? ' ' : $instance['exclude'];
		$showcount = empty($instance['showcount']) ? 'no' : $instance['showcount'];

		echo $before_widget;

		if($title) {
			echo $before_title . $title . $after_title;
		}

		wp_tag_cloud(
			"smallest=$smallest" .
			"&largest=$largest" .
			"&number=$tagcount" .
			"&orderby=$orderby" .
			"&order=$order" .
			"&unit=$unit" .
			"&format=$format" .
			"&taxonomy=$taxonomy" .
			"&include=$include" .
			"&exclude=$exclude" .
			"&separator=$separator" .
			"&showcount=$showcount");

		echo $after_widget;
	}

	// Called when the instance of a widget is saved
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['tagcount'] = intval($new_instance['tagcount']);
		$instance['smallest'] = floatval($new_instance['smallest']);
		$instance['largest'] = floatval($new_instance['largest']);
		$instance['unit'] = $new_instance['unit'];
		$instance['format'] = $new_instance['format'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['order'] = $new_instance['order'];
		$instance['taxonomy'] = $new_instance['taxonomy'];
		$instance['separator'] = $new_instance['separator'];
		$instance['include'] = $new_instance['include'];
		$instance['exclude'] = $new_instance['exclude'];
		$instance['showcount'] = $new_instance['showcount'];
		
		return $instance;
	}

	// Construct widget form
	function form($instance) {
		$instance = wp_parse_args(
						(array)$instance, 
						array(
							'title' => 'Most Used Tags',
							'tagcount' => 0,
							'smallest' => 12,
							'largest' => 12,
							'unit' => 'px',
							'format' => 'flat',
							'orderby' => 'count',
							'order' => 'DESC',
							'taxonomy' => 'post_tag',
							'separator' => '',
							'include' => '',
							'exclude' => '', 
							'showcount' => 'no'
						));

		$title = esc_html($instance['title']);
		$unit = $instance['unit'];
		$format = $instance['format'];
		$orderby = $instance['orderby'];
		$order = $instance['order'];
		$taxonomy = $instance['taxonomy'];
		$separator = esc_html($instance['separator']);
		$include = esc_html($instance['include']);
		$exclude = esc_html($instance['exclude']);
		$showcount = $instance['showcount'];
		
		// For "taxonomy" dropdown list
		$t1 = $t2 = $t3 = $t4 = '';
		// For "unit" dropdown list
		$s1 = $s2 = $s3 = $s4 = $s5 = $s6 = $s7 = $s8 = $s9 = $s10 = $s11 = $s12 = '';
		// For "format" dropdown list
		$f1 = $f2 = '';
		// For "orderby" and "order" dropdown lists 
		$ob1 = $ob2 = $o1 = $o2 = $o3 = '';
		// For "showcount" dropdown list
		$sc1 = $sc2 = '';

		$selected = "selected";		
		switch($unit) {
			case "px":
				$s1 = $selected;
				break;
			case "pt":
				$s2 = $selected;
				break;
			case "%":
				$s3 = $selected;
				break;
			case "em":
				$s4 = $selected;
				break;
			case "rem":
				$s5 = $selected;
				break;
			case "pc":
				$s6 = $selected;
				break;
			case "mm":
				$s7 = $selected;
				break;
			case "cm":
				$s8 = $selected;
				break;
			case "in":
				$s9 = $selected;
				break;
			case "ex":
				$s10 = $selected;
				break;
			case "vw":
				$s11 = $selected;
				break;
			case "vh":
				$s12 = $selected;
				break;
		}

		if($format == "flat") {
			$f1 = $selected;
			$sepcss = "";
		}
		else {
			$f2 = $selected;
			$sepcss = "display:none";
		}

		if($orderby == "count")
			$ob1 = $selected;
		else
			$ob2 = $selected;

		if($order == "ASC")
			$o1 = $selected;
		elseif($order == "DESC")
			$o2 = $selected;
		else
			$o3 = $selected;

		$taxcss = "display:none";
		if($taxonomy == "post_tag")
			$t1 = $selected;
		elseif($taxonomy == "category")
			$t2 = $selected;
		elseif($taxonomy == "link_category")
			$t3 = $selected;
		else {
			$t4 = $selected;
			$taxcss = "";
		}
		
		if($showcount == "no")
			$sc1 = $selected;
		else
			$sc2 = selected;

		echo 
			'<div class="sc-container">
				<div class="sc-row">
					<div class="sc-cell">
						<label for="' . $this->get_field_name('title') . '">Title: </label><br />
						<input type="text" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" value="' . $title . '" />
					</div>
					<div class="sc-cell">
						<label for="' . $this->get_field_name('tagcount') . '">Number of items to show: </label><br />
						<input type="text" id="' . $this->get_field_id('tagcount') . '" name="' . $this->get_field_name('tagcount') . '" value="' . $instance['tagcount'] . '"  class="input-number" /><br />
						<div class="sc-info">0 shows all available items.</div>
					</div>
				</div>
				<div class="sc-row">
					<div class="sc-cell">
						<label for="' . $this->get_field_name('taxonomy') . '">Show: </label><br />
						<select id="' . $this->get_field_id('taxonomy') . '" name="' . $this->get_field_name('taxonomy') . '" onChange="if(document.getElementById(\'' . $this->get_field_id('taxonomy') . '\').selectedIndex == 3) {document.getElementById(\'' . $this->get_field_id('custom_taxonomy') . 'mptags\').style.display = \'\';} else {document.getElementById(\'' . $this->get_field_id('custom_taxonomy') . 'mptags\').style.display = \'none\';}">>
							<option value="post_tag" ' . $t1 . '>Tags</option>
							<option value="category" ' . $t2 . '>Categories</option>
							<option value="link_category" ' . $t3 . '>Link categories</option>
							<option value="' . $taxonomy . '" ' . $t4 . '>Custom taxonomy</option>
						</select>
					</div>		
					<div class="sc-cell" id="' . $this->get_field_id('custom_taxonomy') . 'mptags" style="' . $taxcss . '">
						<label for="' . $this->get_field_name('custom_taxonomy') . '">Name of custom taxonomy: </label><br />
						<input type="text" id="' . $this->get_field_id('custom_taxonomy') . '" name="' . $this->get_field_name('custom_taxonomy') . '" value="' . $taxonomy . '" onChange="document.getElementById(\'' . $this->get_field_id('taxonomy') . '\').options[3].value = document.getElementById(\'' . $this->get_field_id('custom_taxonomy') . '\').value " />
					</div>
				</div>
				<div class="sc-row">
					<div class="sc-cell">
						<label for="' . $this->get_field_name('include') . '">Include tags: </label><br />
						<input type="text" id="' . $this->get_field_id('include') . '" name="' . $this->get_field_name('include') . '" value="' . $include . '"/>
					</div>
					<div class="sc-cell">
						<label for="' . $this->get_field_name('exclude').'">Exclude tags: </label><br />
						<input type="text" id="' . $this->get_field_id('exclude') . '" name="' . $this->get_field_name('exclude') . '" value="' . $exclude . '"/>
					</div>
				</div>
				<div class="sc-row">
					<div class="sc-cell">
						<div class="sc-info">(comma separated list of IDs)</div>
					</div>
				</div>
				<div class="sc-row">
					<div class="sc-cell">
						<label for="' . $this->get_field_name('smallest') . '">Smallest font size: </label><br />
						<input type="text" id="' . $this->get_field_id('smallest') . '" name="' . $this->get_field_name('smallest') . '" value="' . $instance['smallest'] . '" class="input-number" />
					</div>
					<div class="sc-cell">
						<label for="' . $this->get_field_name('largest') . '">Largest font size: </label><br />
						<input type="text" id="' . $this->get_field_id('largest') . '" name="' . $this->get_field_name('largest') . '" value="' . $instance['largest'] . '" class="input-number" />
					</div>
				</div>
				<div class="sc-row">
					<div class="sc-cell">
						<label for="' . $this->get_field_name('unit') . '">Font size unit: </label><br />
						<select id="' . $this->get_field_id('unit') . '" name="' . $this->get_field_name('unit') . '">
						  <option value="px" ' . $s1 . '>Pixels (px)</option>
						  <option value="pt" ' . $s2 . '>Points (pt)</option>
						  <option value="%" ' . $s3 . '>Percent (%)</option>
						  <option value="em" ' . $s4 . '>Ems (em)</option>
						  <option value="rem" ' . $s5 . '>Root em (rem)</option>
						  <option value="pc" ' . $s6 . '>Picas (pc)</option>
						  <option value="mm" ' . $s7 . '>Millimeters (mm)</option>
						  <option value="cm" ' . $s8 . '>Centimeters (cm)</option>
						  <option value="in" ' . $s9 . '>Inches (in)</option>
						  <option value="ex" ' . $s10 . '>x-height (ex)</option>
						  <option value="vw" ' . $s11 . '>Viewport width (vw)</option>
						  <option value="vh" ' . $s12 . '>Viewport height (vh)</option>
						</select>
					</div>
					<div class="sc-cell">
						<label for="' . $this->get_field_name('showcount') . '">Show tag count: </label><br />
						<select id="' . $this->get_field_id('showcount') . '" name="' . $this->get_field_name('showcount') . '">
							<option value="no" ' . $sc1 . '>No</option>
							<option value="yes" ' . $sc2 . '>Yes</option>
						</select>
					</div>
				</div>
				<div class="sc-row">
					<div class="sc-cell">
						<label for="' . $this->get_field_name('format') . '">Display format: </label><br />
						<select id="' . $this->get_field_id('format') . '" name="' . $this->get_field_name('format') . '" onChange="if(document.getElementById(\'' . $this->get_field_id('format') . '\').selectedIndex == 0) {document.getElementById(\'' . $this->get_field_id('separator') . 'mptags\').style.display = \'\';} else {document.getElementById(\'' . $this->get_field_id('separator') . 'mptags\').style.display = \'none\';}">
							<option value="flat" ' . $f1 . '>Flat</option>
							<option value="list" ' . $f2 . '>List</option>
						</select>
					</div>
					<div class="sc-cell" id="' . $this->get_field_id('separator') . 'mptags" style="' . $sepcss . '">
						<label for="' . $this->get_field_name('separator') . '">Separator: </label><br />
						<input type="text" id="' . $this->get_field_id('separator') . '" name="' . $this->get_field_name('separator') . '" value="' . $separator . '" class="input-number" />
						<div class="sc-info">Leave empty for the default value (space).</div>        	
					</div>
				</div>
				<div class="sc-row">
					<div class="sc-cell">
						<label for="' . $this->get_field_name('orderby') . '">Order by: </label><br />
						<select id="' . $this->get_field_id('orderby') . '" name="' . $this->get_field_name('orderby') . '">
							<option value="count" ' . $ob1 . '>Number of posts</option>
							<option value="name" ' . $ob2 . '>Tag name</option>
						</select>
					</div>
					<div class="sc-cell">
						<label for="' . $this->get_field_name('order') . '">Order: </label><br />
						<select id="' . $this->get_field_id('order') . '" name="' . $this->get_field_name('order') . '">
							<option value="ASC" ' . $o1 . '>Ascending</option>
							<option value="DESC" ' . $o2 . '>Descending</option>
							<option value="RAND" ' . $o3 . '>Random</option>
						</select>
					</div>
				</div>
			</div>
			<br/>
			<div class="sc-container">
				<div class="sc-row">
					<div class="sc-cell-full">
						Have comments / suggestions? Drop us a <a href="mailto:info@saucecode.com.sg?subject=SC%20Minimalist%20Tag%20Cloud">note</a>!
					</div>
				</div>		
			</div><br/>';
	}
}

// Register widget
function MinimalistTagCloud_Init() {
	register_widget('MinimalistTagCloud');
}
add_action('widgets_init', 'MinimalistTagCloud_Init');

// Add shortcode to enable post/page embed
function scmintagcloud($atts) {
	$s = shortcode_atts( 
			array('smallest' => 8,
			'largest' => 22,
			'unit' => 'pt',
			'number' => 45,
			'format' => 'flat',
			'separator' => "",
			'orderby' => 'name',
			'order' => 'ASC',
			'exclude' => null,
			'include' => null,
			'link' => 'view',
			'echo' => false,
			'taxonomy' => 'post_tag',
			'showcount' => 'no'
			), 
			$atts );
			
	return wp_tag_cloud($s);
}
add_shortcode('scmintagcloud', 'scmintagcloud');

// Extends wp_generate_tag_cloud to show tag count
function sc_wp_generate_tag_cloud($content, $tags, $args)
{ 
	$output = $content;
	
	if(!empty($args['showcount']) && $args['showcount'] == 'yes') {
		$count = 0;
		$output = preg_replace_callback('(</a\s*>)', 
					function($match) use ($tags, &$count) {
						return "</a><span class='sc-tagcount'>x".$tags[$count++]->count."</span>";  
					}, 
					$content);
	}
	
	return $output;
}
add_filter('wp_generate_tag_cloud','sc_wp_generate_tag_cloud', 10, 3);

?>