<?php
/*
Template Name: Projects Page
*/

get_header();

$projects = new WP_Query(array(
    'post_type' => 'project',
    'posts_per_page' => -1,
));
?>

<div class="projects-container">
    <div class="sorting-options">
        <label for="sort-by">Sort by:</label>
        <select id="sort-by">
            <option value="title">Title</option>
            <option value="category">Category</option>
        </select>

        <label for="filter-by">Filter by Category:</label>
        <select id="filter-by">
            <option value="">All</option>
            <?php
            $categories = get_terms('category');
            foreach ($categories as $category) {
                echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
            }
            ?>
        </select>
    </div>

    <div class="projects-grid">
        <?php while ($projects->have_posts()) : $projects->the_post(); ?>
            <?php
            $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $title = get_the_title();
            $category_terms = get_the_terms(get_the_ID(), 'category');
            $category_list = array();

            foreach ($category_terms as $term) {
                $category_list[] = $term->name;
            }

            $external_url = get_post_meta(get_the_ID(), 'external_url', true);
            $preview_images = get_post_meta(get_the_ID(), 'preview_images', true);
            $description = get_the_content(); // Define the $description variable
            $preview_images_array = explode(',', $preview_images);
            ?>
            <div class="project-item" data-project-id="<?php echo esc_attr(get_the_ID()); ?>">
                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>">
                <h3><?php echo esc_html($title); ?></h3>
                <p>Category: <?php echo esc_html(implode(', ', $category_list)); ?></p>
                <div class="project-details hidden">
                    <h4><?php echo esc_html($title); ?></h4>
                    <p><?php echo esc_html($description); ?></p>
                    <?php if ($external_url) : ?>
                        <p>External URL: <a href="<?php echo esc_url($external_url); ?>"><?php echo esc_html($external_url); ?></a></p>
                    <?php endif; ?>
                    <?php if (!empty($preview_images_array)) : ?>
                        <div class="preview-images">
                            <?php foreach ($preview_images_array as $preview_image) : ?>
                                <img src="<?php echo esc_url($preview_image); ?>" alt="Preview Image">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div id="project-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="project-details-placeholder"></div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
