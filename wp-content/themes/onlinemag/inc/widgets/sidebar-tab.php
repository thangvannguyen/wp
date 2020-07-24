<?php

if ( ! class_exists( 'Onlinemag_Sidebar_Tab_post' ) ) :

    /**
     * Latest News Widget Class
     *
     * @since Onlinemag 1.0.0
     *
     */
    class Onlinemag_Sidebar_Tab_post extends WP_Widget {

        function __construct() {
            parent::__construct(
                'onlinemag_sidebar_tab_post', // Base ID
                __('OnlineMag Widget Tab Sidebar', 'onlinemag'), // Name
                array( 'description' => __( 'Especially On Sidebar Effective For Recent-Post', 'onlinemag' ) ) // Args
            );
        }


        function widget( $args, $instance ) {
            extract( $args );

            $title             = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base );
            $popular_heading     = ! empty( $instance['popular_heading'] ) ? $instance['popular_heading'] : '';
            $popular_number       = ! empty( $instance['popular_number'] ) ? $instance['popular_number'] : 5;
            $recent_heading     = ! empty( $instance['recent_heading'] ) ? $instance['recent_heading'] : '';
            $recent_number       = ! empty( $instance['recent_number'] ) ? $instance['recent_number'] : 5;
            $comments_heading     = ! empty( $instance['comments_heading'] ) ? $instance['comments_heading'] : '';
            $comments_number       = ! empty( $instance['comments_number'] ) ? $instance['comments_number'] : 5;
            $custom_class      = apply_filters( 'widget_custom_class', empty( $instance['custom_class'] ) ? '' : $instance['custom_class'], $instance, $this->id_base );
            $featured_image    = ! empty( $instance['featured_image'] ) ? $instance['featured_image'] : 'onlinemag-recent-sidebar';
            $excerpt_length    = ! empty( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 50;
            // Add Custom class
            if ( $custom_class ) {
                $before_widget = str_replace( 'class="', 'class="'. $custom_class . ' ', $before_widget );
            }
            $tab_id = 'tabbed-' . $this->number;

           echo $args['before_widget'];
           
           if ( $title ) echo $before_title . $title . $after_title;

           ?>
           <div class="tabs-container">
            <ul class="tabs-menu">
                <li class="current"><a href="#<?php echo esc_attr( $tab_id ); ?>-popular"><?php esc_html_e( 'Popular', 'onlinemag' ); ?></a></li>
                <li><a href="#<?php echo esc_attr( $tab_id ); ?>-recent"><?php esc_html_e( 'Recent', 'onlinemag' ); ?></a></li>
                <li><a href="#<?php echo esc_attr( $tab_id ); ?>-comments"><?php esc_html_e( 'Comments', 'onlinemag' ); ?></a></li>
            </ul>
            <div class="tab">
            <div id="<?php echo esc_attr( $tab_id ); ?>-popular" class="tab-content first-tab">
                <?php $this->render_news( 'popular', $instance ); ?>
            </div>
            <div id="<?php echo esc_attr( $tab_id ); ?>-recent" class="tab-content second-tab">
                <?php $this->render_news( 'recent', $instance ); ?>
            </div>
            <div id="<?php echo esc_attr( $tab_id ); ?>-comments" class="tab-content third-tab">
                <?php $this->render_comments( $instance ); ?>
            </div>
           </div>
           </div>
           <?php

           echo $args['after_widget'];
        }
        /**
         * Render news.
         *
         * @since 1.0.0
         *
         * @param array $type Type.
         * @param array $instance Parameters.
         * @return void
         */
        function render_news( $type, $instance ) {

            if ( ! in_array( $type, array( 'popular', 'recent' ) ) ) {
                return;
            }

            switch ( $type ) {
                case 'popular':
                    $qargs = array(
                        'posts_per_page' => $instance['popular_number'],
                        'no_found_rows'  => true,
                        'orderby'        => 'comment_count',
                    );
                    break;

                case 'recent':
                    $qargs = array(
                        'posts_per_page' => $instance['recent_number'],
                        'no_found_rows'  => true,
                    );
                    break;

                default:
                    break;
            }

            $all_posts = get_posts( $qargs );
            ?>
            <?php if ( ! empty( $all_posts ) ) : ?>
                <?php global $post; ?>

                <ul class="col-md-12  news-list">
                <?php foreach ( $all_posts as $key => $post ) : ?>
                    <?php setup_postdata( $post ); ?>
                    <li class="news-item clearfix">
                        <div class="col-md-3 col-sm-3 col-xs-3 news-thumb">
                            <a href="<?php the_permalink(); ?>" class="news-item-thumb">
                            <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) ); ?>
                                <?php if ( ! empty( $image ) ) : ?>
                                    <img class="img-responsive" src="<?php echo esc_url( $image[0] ); ?>" alt="" />
                                <?php endif; ?>
                            <?php else : ?>
                                <img class="img-responsive" src="<?php echo get_template_directory_uri() . '/images/no-image-65.png'; ?>" alt="" />
                            <?php endif; ?>
                            </a>
                        </div><!-- .news-thumb -->
                        <div class="col-md-9 col-xs-9 col-sm-9 news-content">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            <div class="date"><?php the_time( get_option( 'date_format' ) ); ?></div>
                        </div><!-- .news-content -->
                    </li>
                <?php endforeach; ?>
                </ul><!-- .news-list -->

                <?php wp_reset_postdata(); ?>

            <?php endif; ?>

            <?php

        }

        /**
         * Render comments.
         *
         * @since 1.0.0
         *
         * @param array $instance Parameters.
         * @return void
         */
        function render_comments( $instance ) {

            $comment_args = array(
                'number'      => $instance['comments_number'],
                'status'      => 'approve',
                'post_status' => 'publish',
            );

            $comments = get_comments( $comment_args );
            ?>
            <?php if ( ! empty( $comments ) ) : ?>
                <ul class="comments-list">
                    <?php foreach ( $comments as $key => $comment ) : ?>
                        <li class="comment-list">
                        <div class="comments-thumb">
                            <?php $comment_author_url = get_comment_author_url( $comment ); ?>
                            <?php if ( ! empty( $comment_author_url) ) : ?>
                                <a href="<?php echo esc_url( $comment_author_url ); ?>"><?php echo get_avatar( $comment, 65 ); ?></a>
                            <?php else : ?>
                                <?php echo get_avatar( $comment, 65 ); ?>
                            <?php endif; ?>
                        </div><!-- .comments-thumb -->
                        <div class="comments-content">
                            <?php echo get_comment_author_link( $comment ); ?>&nbsp;<?php echo esc_html_x( 'on', 'Tabbed Widget', 'onlinemag' ); ?>&nbsp;<a href="<?php echo esc_url( get_comment_link( $comment ) );?>"><?php echo get_the_title( $comment->comment_post_ID ); ?></a>
                        </div><!-- .comments-content -->
                        </li>
                    <?php endforeach; ?>
                </ul><!-- .comments-list -->
            <?php endif; ?>
            <?php
        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            $instance['title']            = strip_tags($new_instance['title']);
            $instance['popular_heading']  = strip_tags($new_instance['popular_heading']);
            $instance['popular_number']      = absint( $new_instance['popular_number'] );
            $instance['recent_heading']  = strip_tags($new_instance['recent_heading']);
            $instance['recent_number']      = absint( $new_instance['recent_number'] );
            $instance['comments_heading']  = strip_tags($new_instance['comments_heading']);
            $instance['comments_number']      = absint( $new_instance['comments_number'] );
            $instance['custom_class']     = esc_attr( $new_instance['custom_class'] );

            return $instance;
        }

        function form( $instance ) {

            //Defaults
            $instance = wp_parse_args( (array) $instance, array(
                'title'            => '',
                'popular_heading'  => '',
                'popular_number'   => 5,
                'recent_heading'  => '',
                'recent_number'   => 5,
                'comments_heading'  => '',
                'comments_number'   => 5,
                'custom_class'     => '',
            ) );
            $title            = strip_tags( $instance['title'] );
            $popular_heading  = strip_tags( $instance['popular_heading'] );
            $popular_number   = absint( $instance['popular_number'] );
            $recent_heading  = strip_tags( $instance['recent_heading'] );
            $recent_number   = absint( $instance['recent_number'] );
            $comments_heading  = strip_tags( $instance['comments_heading'] );
            $comments_number   = absint( $instance['comments_number'] );
            $custom_class     = esc_attr( $instance['custom_class'] );

            ?>
            <p>
                <label for="<?php echo absint($this->get_field_id('title')); ?>"><?php _e( 'Title:', 'onlinemag' ); ?></label>
                <input class="widefat" id="<?php echo absint($this->get_field_id('title')); ?>" name="<?php echo esc_html($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <p>
                <label for="<?php echo absint($this->get_field_id('popular_heading')); ?>"><?php _e( 'Popular Heading Title:', 'onlinemag' ); ?></label>
                <input class="widefat" id="<?php echo absint($this->get_field_id('popular_heading')); ?>" name="<?php echo esc_html($this->get_field_name( 'popular_heading' )); ?>" type="text" value="<?php echo esc_attr( $popular_heading ); ?>" />
            </p>
            <p>
                <label for="<?php echo absint($this->get_field_id( 'popular_number' )); ?>"><?php _e('Number of Popular Posts:', 'onlinemag' ); ?></label>
                <input class="widefat1" id="<?php echo absint($this->get_field_id( 'popular_number' )); ?>" name="<?php echo esc_html($this->get_field_name( 'popular_number' )); ?>" type="number" value="<?php echo absint( $popular_number ); ?>" min="1" style="max-width:50px;" />
            </p>
            <p>
                <label for="<?php echo absint($this->get_field_id('recent_heading')); ?>"><?php _e( 'Recent Heading Title:', 'onlinemag' ); ?></label>
                <input class="widefat" id="<?php echo absint($this->get_field_id('recent_heading')); ?>" name="<?php echo esc_html($this->get_field_name( 'recent_heading' )); ?>" type="text" value="<?php echo esc_attr( $recent_heading ); ?>" />
            </p>
            <p>
                <label for="<?php echo absint($this->get_field_id( 'recent_number' )); ?>"><?php _e('Number of Recent Posts:', 'onlinemag' ); ?></label>
                <input class="widefat1" id="<?php echo absint($this->get_field_id( 'recent_number' )); ?>" name="<?php echo esc_html($this->get_field_name( 'recent_number' )); ?>" type="number" value="<?php echo absint( $recent_number ); ?>" min="1" style="max-width:50px;" />
            </p>
            <p>
                <label for="<?php echo absint($this->get_field_id('comments_heading')); ?>"><?php _e( 'Comment Heading Title:', 'onlinemag' ); ?></label>
                <input class="widefat" id="<?php echo absint($this->get_field_id('comments_heading')); ?>" name="<?php echo esc_html($this->get_field_name( 'comments_heading' )); ?>" type="text" value="<?php echo esc_attr( $comments_heading ); ?>" />
            </p>
            <p>
                <label for="<?php echo absint($this->get_field_id( 'comments_number' )); ?>"><?php _e('Number of Coments Posts:', 'onlinemag' ); ?></label>
                <input class="widefat1" id="<?php echo absint($this->get_field_id( 'comments_number' )); ?>" name="<?php echo esc_html($this->get_field_name( 'comments_number' )); ?>" type="number" value="<?php echo absint( $comments_number ); ?>" min="1" style="max-width:50px;" />
            </p>
            <p>
                <label for="<?php echo absint($this->get_field_id('custom_class')); ?>"><?php _e( 'Custom Class:', 'onlinemag' ); ?></label>
                <input class="widefat" id="<?php echo absint($this->get_field_id('custom_class')); ?>" name="<?php echo esc_attr($this->get_field_name( 'custom_class' )); ?>" type="text" value="<?php echo esc_attr( $custom_class ); ?>" />
            </p>
            <?php
        }
    }
    add_action( 'widgets_init', 'onlinemag_recent_sidebar_tab_post' );

    if ( ! function_exists( 'onlinemag_recent_sidebar_tab_post' ) ) :

        /**
         * Load widget
         *
         * @since Onlinemag 1.0.0
         *
         */
        function onlinemag_recent_sidebar_tab_post(){
            // Latest News widget
            register_widget( 'Onlinemag_Sidebar_Tab_post' );
        }

    endif;

endif;