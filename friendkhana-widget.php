<?php
/**
 * Adds FriendkhanaWidget widget.
 */
class Friendkhana_Widget extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  function __construct() {
    parent::__construct(
      FRIENDKHANA_WIDGET_UNIQUE_ID,
      __( FRIENDKHANA_WIDGET_TITLE, FRIENDKHANA_UNIQUE_ID ),
      array( 'description' => __( FRIENDKHANA_WIDGET_DESCRIPTION, FRIENDKHANA_UNIQUE_ID ),)
    );
  }

  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget( $args, $instance ) {
    echo $args['before_widget'];
    if ( ! empty( $instance['id'] ) ) {
      $current_user = wp_get_current_user();
      $name = $current_user->user_firstname . " " . $current_user->user_lastname;
      $email = $current_user->user_email;

      wp_enqueue_script( 'widget', FRIENDKHANA_WIDGET_BASE_URL, '', false, true );
    ?>
      <a class='friendkhana-poll-widget' href='<?php echo FRIENDKHANA_POLLS_BASE_URL . $instance['id'] ?>/app?name=<?php echo $name ?>&email=<?php echo $email ?>'></a>
    <?php
    }
    echo $args['after_widget'];
  }

  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form( $instance ) {
    $id = ! empty( $instance['id'] ) ? $instance['id'] : '';
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'Quiz ID:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" type="text" value="<?php echo esc_attr( $id ); ?>">
    </p>
    <?php
  }

  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['id'] = ( ! empty( $new_instance['id'] ) ) ? strip_tags( $new_instance['id'] ) : '';

    return $instance;
  }

} // class Friendkhana_Widget
