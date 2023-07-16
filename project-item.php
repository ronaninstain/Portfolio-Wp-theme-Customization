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
