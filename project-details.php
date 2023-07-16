<div class="project-details">
    <h3><?php echo esc_html($title); ?></h3>
    <p><?php echo esc_html($description); ?></p>
    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>">
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
