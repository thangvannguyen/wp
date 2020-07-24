<?php
if ( ! function_exists( 'onlinemag_home_blog' ) ) :
    /**
     * Blog Section
     *
     * @since onlinemag 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function onlinemag_home_blog() {
        global $onlinemag_customizer_all_values;
        if( 1 != $onlinemag_customizer_all_values['onlinemag-blog-enable'] ){
            return null;
        }       
        ?>    
        <section class="wrapper wrap-below-banner">
            <div class="container">
                <div class="category-grid">
                  <?php
                    $repeated_category = array( 'onlinemag-blog-category-ids' );

                    $onlinemag_blog_cat_posts_ids = evision_customizer_get_repeated_all_value(3 , $repeated_category);
                    
                    $onlinemag_logs_args = array(
                        'post_type' => 'post',
                        'ignore_sticky_posts' => true,
                        'posts_per_page' => 3,
                    );
                
                foreach ( $onlinemag_blog_cat_posts_ids as $key => $val ) {
                
                  $onlinemag_category = esc_html__( 'All', 'onlinemag' );

                  $onlinemag_cat_link = get_post_type_archive_link( 'post' );
                
                  if( isset( $val[ 'onlinemag-blog-category-ids' ] ) && 0 !== $val[ 'onlinemag-blog-category-ids' ]  ) {
                    
                    $onlinemag_logs_args['cat'] =   $val['onlinemag-blog-category-ids'];

                    $onlinemag_category = get_cat_name( $val['onlinemag-blog-category-ids'] );

                    $onlinemag_cat_link = get_category_link( $val['onlinemag-blog-category-ids'] );
                  } else {
                    unset( $onlinemag_logs_args['cat'] );
                  }
                  
                  ?> 
                  <div class="col-md-4">
                      <div class="card ">
                        <p class="card-title">
                          <a href="<?php echo esc_url($onlinemag_cat_link); ?>">
                              <?php echo esc_html( $onlinemag_category ); ?>
                          </a>
                        </p>
                      <?php 
                      $i = 1;                       
                      $onlinemag_blogs_post_query = new WP_Query( $onlinemag_logs_args );
                      
                      if ( $onlinemag_blogs_post_query->have_posts() ) :
                          $data_delay = 0;
                          while ($onlinemag_blogs_post_query->have_posts()) : $onlinemag_blogs_post_query->the_post(); 
                            if ( $i == 1) { ?>
                              <a href="<?php the_permalink(); ?>">
                                <div class="card-img-top">
                                  <?php the_post_thumbnail(); ?>
                                  <div class="img-overlay"></div>
                                </div>
                              </a>
                            <div class="card-block">
                              <h4 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                              <?php 
                              $onlinemag_blog_single_words = 20;
                              $onlinemag_blog_content = onlinemag_words_count( $onlinemag_blog_single_words ,get_the_content());
                              ?>
                              <p class="card-text"><?php echo wp_kses_post($onlinemag_blog_content); ?></p>                            
                            </div>
                           <?php $i++; } else {?>
                             <div class="card-block">
                                <h4 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                              </div>
                           <?php }  ?>
                               <?php endwhile;
                           wp_reset_postdata();
                           wp_reset_query();
                           endif;
                            ?>
                        <div class="category-link">
                        <a href="<?php echo esc_url( $onlinemag_cat_link ); ?> " class="category-more"><?php echo esc_html__( 'View More', 'onlinemag' ); ?></a>
                        </div>
                      </div>
                  </div>
                <?php } ?>
                </div>
            </div>
        </section>
        <?php
    }
endif;
add_action( 'onlinemag_action_front_page_blog', 'onlinemag_home_blog', 40 );