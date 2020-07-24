<?php
if ( ! class_exists( 'Onlinemag_Two_Column_Widget_Style3' ) ) :

    /**
     * Latest News Widget Class
     *
     * @since Onlinemag 1.0.0
     *
     */
    class Onlinemag_Two_Column_Widget_Style3 extends WP_Widget {

        function __construct() {
            parent::__construct(
                'onlinemag_two_column_widget_style3', // Base ID
                __('OnlineMag Widget Grid Style', 'onlinemag'), // Name
                array( 'description' => __( 'Homepage Widget with two column listing post', 'onlinemag' ) ) // Args
            );
        }


        function widget( $args, $instance ) {
            extract( $args );

            $title             = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base );
            $post_category     = ! empty( $instance['post_category'] ) ? $instance['post_category'] : 0;
            $custom_class      = apply_filters( 'widget_custom_class', empty( $instance['custom_class'] ) ? '' : $instance['custom_class'], $instance, $this->id_base );
            $featured_image    = ! empty( $instance['featured_image'] ) ? $instance['featured_image'] : 'onlinemag-style-one';
            $excerpt_length    = ! empty( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 50;

            // Add Custom class
            if ( $custom_class ) {
                $before_widget = str_replace( 'class="', 'class="'. $custom_class . ' ', $before_widget );
            }

            echo $before_widget;

            // Title
            if ( $title ) echo $before_title . $title . $after_title;
            $onlinemag_widget_id = $this->id_base.'-'.$this->number;

            //
            ?>
            <?php
            $qargs = array(
                'posts_per_page' => 6,
                'no_found_rows'  => true,
                'ignore_sticky_posts'  => 1
            );
            if ( absint( $post_category ) > 0  ) {
                $qargs['cat'] = $post_category;
            }
            $all_posts = new WP_Query( $qargs );
            global $onlinemag_customizer_all_values;
            ?>
            <?php if ( ! empty( $all_posts )): //|| ! empty($all_content)): ?>
                <!--html generate-->
                <div class="mp-feature-widget">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 pad0l">
                        <?php
                        // The Loop
                        if ( $all_posts->have_posts() ) {
                            $flag = true;
                            while ( $all_posts->have_posts() ) {
                                $all_posts->the_post(); ?>
                                <?php if ($flag == true) { ?>
                                <div class="col-xs-12 col-sm-6 col-md-6 left-post-content">
                                    <div class="thumb-post">
                                        <figure class="post-img">
                                            <?php 
                                                if(has_post_thumbnail()){
                                                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $featured_image );
                                                    $url = $thumb['0'];
                                                }
                                                else{
                                                    $url = get_template_directory_uri().'/assets/images/slider-post.jpg';
                                                }
                                            ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <img src="<?php echo esc_url($url);?>">
                                        </a>
                                        </figure>                                      
                                        <div class="bottom-post-content">
                                            <div class="bottom-post-content-text">
                                                <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                                <div class="par">
                                                <?php
                                                $excerpt = onlinemag_words_count( $excerpt_length, get_the_excerpt() );
                                                echo esc_html( $excerpt );
                                                ?>
                                                </div>
                                             </div>   
                                            <div class="entry-comments-links">                                          
                                                <span>
                                                    <?php 
                                                    $author_name   = get_the_author_meta('display_name');
                                                    $author_url   = get_author_posts_url( get_the_author_meta( 'ID' ) );?>
                                                    <a href="<?php echo esc_url($author_url); ?>" class="icon" title=""><i class="fa fa-user"></i><span><?php echo esc_html($author_name ); ?></span></a>
                                                </span>
                                               <!--<div class="post-icons">                                            
                                                                                             
                                                </div> -->
                                                <span>
                                                    <?php 
                                                    $archive_year   = get_the_time('Y');
                                                    ?>
                                                    <a href="<?php echo esc_url(get_year_link($archive_year)); ?>" class="icon"><i class="fa fa-calendar"></i><?php echo esc_html(get_the_date('M j, Y'));?></a>
                                                </span>   
                                                  <span class="comments-links">
                                                    <a href="<?php the_permalink(); ?>" class="icon">
                                                        <i class="fa fa-comment"></i> 
                                                        <?php
                                                            $commentscount = get_comments_number();
                                                            if($commentscount == 1): $commenttext = ''; endif;
                                                            if($commentscount > 1 || $commentscount == 0): $commenttext = ''; endif;
                                                            echo (esc_html($commentscount).' '.(esc_html($commenttext)));
                                                        ?>
                                                    </a>
                                                </span>
                                          </div>  
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                $flag = false;
                                } else{ ?>
                                <div class="col-xs-12 col-sm-6 col-md-6 right-post-content">
                                    <div class="small-right-post-content-list">
                                        <div class="thumb-post">
                                            <figure class="post-img">
                                                <?php 
                                                if(has_post_thumbnail()){
                                                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $featured_image );
                                                    $url = $thumb['0'];
                                                }
                                                else{
                                                    $url = get_template_directory_uri().'/assets/images/slider-post.jpg';
                                                }
                                                ?>
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php echo esc_url($url);?>">
                                            </a>
                                            </figure>
                                            <div class="small-right-post-content">
                                                <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a></h3>
                                                <div class="post-icons">                                                   
                                                    <span>
                                                        <?php 
                                                        $archive_year   = get_the_time('Y');
                                                        ?>
                                                        <a href="<?php echo get_year_link($archive_year); ?>" class="icon"><i class="fa fa-calendar"></i><?php echo esc_html(get_the_date('M j, Y'));?></a>
                                                    </span>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                            }
                        } else {
                            // no posts found
                        }
                        /* Restore original Post Data */
                        wp_reset_postdata();
                        ?>
                        <div>
                    </div><!-- content-bottom-post -->
                <!-- Main-panel Full Widget -->
                </div><!-- block holder -->
                <?php wp_reset_postdata(); // Reset ?>

            <?php endif; ?>
            <?php
            echo $after_widget;

        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            $instance['title']            = strip_tags($new_instance['title']);
            $instance['post_category']    = absint( $new_instance['post_category'] );
            $instance['custom_class']     = esc_attr( $new_instance['custom_class'] );

            return $instance;
        }

        function form( $instance ) {

            //Defaults
            $instance = wp_parse_args( (array) $instance, array(
                'title'            => '',
                'post_category'    => '',
                'custom_class'     => '',
            ) );
            $title            = strip_tags( $instance['title'] );
            $post_category    = absint( $instance['post_category'] );
            $custom_class     = esc_attr( $instance['custom_class'] );

            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'onlinemag' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'post_category' ); ?>"><?php _e( 'Category:', 'onlinemag' ); ?></label>
                <?php
                $cat_args = array(
                    'orderby'         => 'name',
                    'hide_empty'      => 0,
                    'taxonomy'        => 'category',
                    'name'            => $this->get_field_name('post_category'),
                    'id'              => $this->get_field_id('post_category'),
                    'selected'        => $post_category,
                    'show_option_all' => __( 'All Categories','onlinemag' ),
                );
                wp_dropdown_categories( $cat_args );
                ?>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'custom_class' ); ?>"><?php _e( 'Custom Class:', 'onlinemag' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'custom_class'); ?>" name="<?php echo $this->get_field_name( 'custom_class' ); ?>" type="text" value="<?php echo esc_attr( $custom_class ); ?>" />
            </p>
            <?php
        }
    }
    add_action( 'widgets_init', 'onlinemag_two_coloumn_widget_style3' );

    if ( ! function_exists( 'onlinemag_two_coloumn_widget_style3' ) ) :

        /**
         * Load widget
         *
         * @since Onlinemag 1.0.0
         *
         */
        function onlinemag_two_coloumn_widget_style3(){
            // Latest News widget
            register_widget( 'Onlinemag_Two_Column_Widget_Style3' );
        }

    endif;

endif;