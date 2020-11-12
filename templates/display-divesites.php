<?php

$args = array(
    'post_type' => 'divesite',
    'post_status' => 'publish',
    'posts_per_page' => 10,
    /*'meta_query' => array(
        array(
            'key' => '_cfish_dive_site_key',
            'value' => 's:8:"approved";i:1;s:8:"featured";i:1;',
            'compare' => 'LIKE'
        )
    )*/
);

$query = new WP_Query( $args );

if ($query->have_posts()) :?>
    <div class="divesites-container alignwide">
        <?php while ($query->have_posts()) : $query->the_post();?>
            <div class="divesite-container">
                <div class="divesite-title-container">
                    <h3 class="divesite-title"><?php echo get_the_title();?> </h3>
                    <h5 class="divesite-subtitle"><?php echo get_the_excerpt();?> </h5>
                </div>
                <div class="divesite-image"><?php the_post_thumbnail();?></div>
                <div class="divesite-options-container">
                    <span class="divesite-option-title">Dive Type: </span><span class="divesite-option-value"><?php echo get_post_meta( get_the_ID(), '_cfish_dive_site_key', true )['diveType'] ?? '';?> </span><br>
                    <span class="divesite-option-title">Depth: </span><span class="divesite-option-value"><?php echo get_post_meta( get_the_ID(), '_cfish_dive_site_key', true )['diveDepth'] ?? '';?></span><br>
                    <span class="divesite-option-title">Level: </span><span class="divesite-option-value"><?php echo get_post_meta( get_the_ID(), '_cfish_dive_site_key', true )['diveLevel'] ?? '';?></span><br>
                    <span class="divesite-option-title">Entry Type: </span><span class="divesite-option-value"><?php echo get_post_meta( get_the_ID(), '_cfish_dive_site_key', true )['diveEntry'] ?? '';?></span><br>
                    <span class="divesite-option-title">Distance to Shop: </span><span class="divesite-option-value"><?php echo get_post_meta( get_the_ID(), '_cfish_dive_site_key', true )['diveDistance'] ?? '';?></span>
                </div>
                <div class="divesite-description-container">
                    <h5 class="divesite-description-title">Dive Site Description</h5>
                    <p class="divesite-description"><?php echo get_the_content();?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

<?php endif;
wp_reset_postdata();