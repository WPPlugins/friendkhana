<?php
/*
Plugin Name: Friendkhana
Plugin URI:  http://wordpress.org/plugins/friendkhana
Description: Friendkhana is a micro-surveys SaaS platform that collects user preferences in real time and enhances that data using social networks.
Version:     1.0.3
Author:      Friendkhana
Author URI:  https://www.friendkhana.com
Text Domain: friendkhana
License:     GPL2

This file is part of Friendkhana.

Friendkhana is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Friendkhana is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Friendkhana. If not, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.html.
*/

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

define( 'FRIENDKHANA_UNIQUE_LOCATION', __FILE__ );
define( 'FRIENDKHANA_UNIQUE_ID', 'friendkhana' );

define( 'FRIENDKHANA_MENU_NAME', 'Friendkhana' );

define( 'FRIENDKHANA_WIDGET_UNIQUE_ID', 'friendkhana_widget' );
define( 'FRIENDKHANA_WIDGET_TITLE', 'Friendkhana Widget' );
define( 'FRIENDKHANA_WIDGET_DESCRIPTION', 'Share your quizzes to know your customers better' );

define( 'FRIENDKHANA_POLLS_BASE_URL', 'https://friendkhana.com/polls/' );
define( 'FRIENDKHANA_WIDGET_BASE_URL', 'https://friendkhana.com/polls/widget.js' );

define( 'FRIENDKHANA_POLL_SHORTCODE', 'fkquiz' );
define( 'FRIENDKHANA_TRACK_SHORTCODE', 'fktrack' );

require_once( WP_PLUGIN_DIR . '/' . FRIENDKHANA_UNIQUE_ID . '/friendkhana-widget.php' );
require_once( WP_PLUGIN_DIR . '/' . FRIENDKHANA_UNIQUE_ID . '/friendkhana-menu-page.php' );

add_action( 'admin_menu', 'friendkhana_poll_menu' );
add_action( 'widgets_init', 'friendkhana_register_widget' );
add_action( 'woocommerce_thankyou', 'friendkhana_autoembed_track', 10 );

add_shortcode( FRIENDKHANA_POLL_SHORTCODE, 'friendkhana_embed_poll' );
add_shortcode( FRIENDKHANA_TRACK_SHORTCODE, 'friendkhana_embed_track' );

function friendkhana_poll_menu() {
  add_action( 'admin_init', 'friendkhana_register_settings' );

  if ( function_exists( 'add_menu_page' ) ) {
    add_menu_page(
      __( FRIENDKHANA_MENU_NAME, FRIENDKHANA_UNIQUE_ID ),
      __( FRIENDKHANA_MENU_NAME, FRIENDKHANA_MENU_NAME ),
      'manage_options',
      FRIENDKHANA_UNIQUE_LOCATION,
      'friendkhana_menu_page',
      'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCIgdmlld0JveD0iMCAwIDE2IDE2IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCAxNiAxNiIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGZpbGw9IiNGRkZGRkYiIGQ9Ik0xMy42NjgsMTIuODE2Yy0wLjAyMy0wLjA0NS0wLjA0MS0wLjA3NS0wLjA1NS0wLjEwM2MtMC44MDEtMS4zOTYtMS42LTIuNzk0LTIuNDAyLTQuMTg5Yy0wLjA0My0wLjA3My0wLjAzNS0wLjExMiwwLjAyNS0wLjE2OWMxLjM0Mi0xLjIyMywyLjY4Mi0yLjQ0Nyw0LjAyNS0zLjY3MWMwLjAyNy0wLjAyNSwwLjA1Ny0wLjA0OSwwLjA4NC0wLjA3NGMtMC4wMDItMC4wMDctMC4wMDYtMC4wMTQtMC4wMDgtMC4wMjFjLTAuMDM3LDAtMC4wNywwLTAuMTA1LDBjLTAuNzA1LDAtMS40MTIsMC4wMDEtMi4xMTktMC4wMDFjLTAuMDc2LTAuMDAxLTAuMTI5LDAuMDIyLTAuMTgyLDAuMDc0Yy0xLjE3NiwxLjEyOS0yLjM1NSwyLjI1Ny0zLjUzMywzLjM4NUM5LjM3MSw4LjA3Miw5LjM0LDguMDk3LDkuMzEzLDguMTIyQzkuMzA1LDguMTE4LDkuMjk5LDguMTE0LDkuMjkxLDguMTFjMC41MzEtMi40ODYsMS4wNjMtNC45NzIsMS41OTItNy40NjFjLTAuNjUsMC0xLjI5MywwLTEuOTM2LDBDOC4wODIsNC43MDcsNy4yMiw4Ljc1Nyw2LjM1NywxMi44MDljMC4wMTcsMC4wMDQsMC4wMjMsMC4wMDcsMC4wMjksMC4wMDdjMC42MTUsMCwxLjIzLDAsMS44NDUsMC4wMDNjMC4wNjYsMCwwLjA3LTAuMDM5LDAuMDgtMC4wODVjMC4yNzQtMS4yOTgsMC41NTEtMi41OTYsMC44MjgtMy44OTRDOS4xNjIsOC43Myw5LjE4OCw4LjYyMSw5LjIxMyw4LjUxMUM5LjIyMSw4LjUxLDkuMjI5LDguNTA5LDkuMjM4LDguNTA4QzkuMjU2LDguNTQsOS4yNzUsOC41NzMsOS4yOTUsOC42MDVjMC43MTksMS4zNzMsMS40MzksMi43NDYsMi4xNTQsNC4xMjFjMC4wMzUsMC4wNjcsMC4wNzIsMC4wOTUsMC4xNSwwLjA5M2MwLjI4MS0wLjAwNiwwLjU1OS0wLjAwMywwLjgzOC0wLjAwM0MxMi44NDIsMTIuODE2LDEzLjI0OCwxMi44MTYsMTMuNjY4LDEyLjgxNnoiLz48cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZmlsbD0iI0ZGRkZGRiIgZD0iTTQuNjA2LDYuMDkyYzAuNjQsMCwxLjI4LDAsMS45MjYsMGMwLjExMS0wLjUwMywwLjIyLTAuOTk5LDAuMzMxLTEuNTA1Yy0wLjY0LDAtMS4yNjcsMC0xLjkwNiwwYzAuMTA4LTAuNDcyLDAuMi0wLjkzNywwLjMyNC0xLjM5MmMwLjA1OS0wLjIxOSwwLjE2MS0wLjQzMiwwLjI3Mi0wLjYzYzAuMTgtMC4zMiwwLjQ3MS0wLjQ5NCwwLjgzNS0wLjU0M2MwLjI2MS0wLjAzNSwwLjUyLTAuMDI0LDAuNzc0LDAuMDM2YzAuMTYxLDAuMDM3LDAuMzE3LDAuMDk0LDAuNDgzLDAuMTQ1YzAuMS0wLjUxMywwLjE5OS0xLjAyNCwwLjMwMS0xLjU0MmMtMC4wNDYtMC4wMTUtMC4wODItMC4wMjgtMC4xMi0wLjAzOUM3LjIwOCwwLjQ0Niw2LjU4MiwwLjQyNiw1Ljk1LDAuNTIxQzQuODIxLDAuNjg5LDQuMDI1LDEuMjg5LDMuNTgzLDIuMzQ5QzMuMzg0LDIuODIyLDMuMjg3LDMuMzIyLDMuMTc1LDMuODE4Yy0wLjA1NywwLjI1NS0wLjExMywwLjUxMS0wLjE3LDAuNzdjLTAuMDQ1LDAtMC4wODEsMC0wLjExNywwYy0wLjM5OCwwLTAuNzk1LDAuMDAxLTEuMTkzLTAuMDAxYy0wLjA2MywwLTAuMDkyLDAuMDEyLTAuMTA0LDAuMDgyYy0wLjAyOCwwLjE2MS0wLjA3LDAuMzItMC4xMDUsMC40OEMxLjQxNyw1LjQ2LDEuMzUsNS43NywxLjI4LDYuMDkxYzAuNDcyLDAsMC45MzQsMCwxLjQwMywwYy0wLjY3NywzLjE1My0xLjM1Myw2LjI5Ny0yLjAyOSw5LjQ0NGMwLjY1MiwwLDEuMjg5LDAsMS45MzEsMEMzLjI1OSwxMi4zODgsMy45MzIsOS4yNDYsNC42MDYsNi4wOTJ6Ii8+PHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGZpbGw9IiNGRkZGRkYiIGQ9Ik0xMy42NjgsMTIuODE2Yy0wLjQyLDAtMC44MjYsMC0xLjIzLDBjLTAuMjc5LDAtMC41NTctMC4wMDMtMC44MzgsMC4wMDNjLTAuMDc4LDAuMDAyLTAuMTE1LTAuMDI1LTAuMTUtMC4wOTNjLTAuNzE1LTEuMzc1LTEuNDM2LTIuNzQ4LTIuMTU0LTQuMTIxQzkuMjc1LDguNTczLDkuMjU2LDguNTQsOS4yMzgsOC41MDhDOS4yMjksOC41MDksOS4yMjEsOC41MSw5LjIxMyw4LjUxMUM5LjE4OCw4LjYyMSw5LjE2Miw4LjczLDkuMTM5LDguODRjLTAuMjc3LDEuMjk4LTAuNTUzLDIuNTk2LTAuODI4LDMuODk0Yy0wLjAxLDAuMDQ2LTAuMDE0LDAuMDg1LTAuMDgsMC4wODVjLTAuNjE1LTAuMDAzLTEuMjMtMC4wMDMtMS44NDUtMC4wMDNjLTAuMDA2LDAtMC4wMTItMC4wMDMtMC4wMjktMC4wMDdDNy4yMiw4Ljc1Nyw4LjA4Miw0LjcwNyw4Ljk0NywwLjY0OWMwLjY0MywwLDEuMjg2LDAsMS45MzYsMEMxMC4zNTQsMy4xMzksOS44MjIsNS42MjQsOS4yOTEsOC4xMWMwLjAwOCwwLjAwMywwLjAxNCwwLjAwNywwLjAyMSwwLjAxMWMwLjAyNy0wLjAyNSwwLjA1OS0wLjA1LDAuMDg2LTAuMDc2YzEuMTc4LTEuMTI3LDIuMzU3LTIuMjU1LDMuNTMzLTMuMzg1YzAuMDUzLTAuMDUxLDAuMTA1LTAuMDc1LDAuMTgyLTAuMDc0YzAuNzA3LDAuMDAyLDEuNDE0LDAuMDAxLDIuMTE5LDAuMDAxYzAuMDM1LDAsMC4wNjgsMCwwLjEwNSwwYzAuMDAyLDAuMDA3LDAuMDA2LDAuMDE0LDAuMDA4LDAuMDIxYy0wLjAyNywwLjAyNS0wLjA1NywwLjA0OS0wLjA4NCwwLjA3NGMtMS4zNDQsMS4yMjQtMi42ODQsMi40NDgtNC4wMjUsMy42NzFjLTAuMDYxLDAuMDU3LTAuMDY4LDAuMDk2LTAuMDI1LDAuMTY5YzAuODAzLDEuMzk2LDEuNjAyLDIuNzkzLDIuNDAyLDQuMTg5QzEzLjYyNywxMi43NDEsMTMuNjQ1LDEyLjc3MSwxMy42NjgsMTIuODE2eiIvPjxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgY2xpcC1ydWxlPSJldmVub2RkIiBmaWxsPSIjRkZGRkZGIiBkPSJNNC42MDYsNi4wOTJjLTAuNjc0LDMuMTU0LTEuMzQ3LDYuMjk1LTIuMDIxLDkuNDQzYy0wLjY0MiwwLTEuMjc5LDAtMS45MzEsMGMwLjY3Ni0zLjE0NywxLjM1Mi02LjI5MSwyLjAyOS05LjQ0NGMtMC40NywwLTAuOTMxLDAtMS40MDMsMEMxLjM1LDUuNzcsMS40MTcsNS40NiwxLjQ4NSw1LjE0OUMxLjUyLDQuOTg5LDEuNTYyLDQuODMsMS41OSw0LjY2OWMwLjAxMi0wLjA3LDAuMDQyLTAuMDgyLDAuMTA0LTAuMDgyQzIuMDkzLDQuNTksMi40OSw0LjU4OCwyLjg4OCw0LjU4OGMwLjAzNiwwLDAuMDcyLDAsMC4xMTcsMGMwLjA1Ny0wLjI1OSwwLjExMy0wLjUxNSwwLjE3LTAuNzdjMC4xMTItMC40OTcsMC4yMDgtMC45OTYsMC40MDctMS40NjljMC40NDMtMS4wNiwxLjIzOS0xLjY2LDIuMzY4LTEuODI5YzAuNjMyLTAuMDk1LDEuMjU4LTAuMDc0LDEuODc1LDAuMTAxYzAuMDM4LDAuMDExLDAuMDc0LDAuMDI0LDAuMTIsMC4wMzlDNy44NDQsMS4xNzgsNy43NDQsMS42ODksNy42NDUsMi4yMDNjLTAuMTY2LTAuMDUtMC4zMjItMC4xMDctMC40ODMtMC4xNDVjLTAuMjU0LTAuMDYtMC41MTMtMC4wNzEtMC43NzQtMC4wMzZjLTAuMzY0LDAuMDUtMC42NTUsMC4yMjMtMC44MzUsMC41NDNDNS40NDEsMi43NjQsNS4zMzksMi45NzcsNS4yOCwzLjE5NkM1LjE1NywzLjY1MSw1LjA2NCw0LjExNSw0Ljk1Nyw0LjU4N2MwLjY0LDAsMS4yNjYsMCwxLjkwNiwwYy0wLjExMSwwLjUwNi0wLjIyLDEuMDAxLTAuMzMxLDEuNTA1QzUuODg2LDYuMDkyLDUuMjQ2LDYuMDkyLDQuNjA2LDYuMDkyeiIvPjwvc3ZnPg==',
      '25.234323221'
    );
  }
}

function friendkhana_register_widget() {
  register_widget( 'Friendkhana_Widget' );
}

function friendkhana_register_settings() {
  register_setting( 'friendkhana', 'autotrackid' );
}

function friendkhana_embed_poll($atts) {
  extract( shortcode_atts( array( 'id' => 0 ), $atts ) );
  if ( ! is_feed() ) {
    $id = intval( $id );
    $current_user = wp_get_current_user();
    $name = $current_user->user_firstname . " " . $current_user->user_lastname;
    $email = $current_user->user_email;


    wp_enqueue_script( 'widget', FRIENDKHANA_WIDGET_BASE_URL, '', false, true );

    return "<a class='friendkhana-poll-widget' href='" . FRIENDKHANA_POLLS_BASE_URL . $id . "/app?name=".$name."&email=".$email."'></a>";
  }
}

function friendkhana_embed_track($atts) {
  extract( shortcode_atts( array( 'id' => 0 ), $atts ) );
  if ( ! is_feed() ) {
    $id = intval( $id );
    return "<img src='" . FRIENDKHANA_POLLS_BASE_URL . $id . "/track.png' width=1 height=1>";
  }
}

function friendkhana_autoembed_track() {
  $id = esc_attr( get_option( 'autotrackid' ) );
?>
  <img src='<?php echo FRIENDKHANA_POLLS_BASE_URL . $id . '/track.png'; ?>' width=1 height=1>
<?php
}

function friendkhana_add_stylesheet() {
  wp_register_style( 'friendkhana-style', plugins_url('friendkhana.css', __FILE__) );
  wp_enqueue_style( 'friendkhana-style' );
}

?>
