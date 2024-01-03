<div class="container-header-logo-secondary">
    <div class="container-header-logo-secondary container-header-logo-secondary_first-logo">
        <?php $first_logo = get_field('header_first_logo', 'option');
        if (!empty($first_logo)) : ?>
            <img src="<?php echo esc_url($first_logo['url']); ?>" alt="<?php echo esc_attr($first_logo['alt']); ?>" />
        <?php endif; ?>
    </div>
    <!-- /.container-header-logo-secondary container-header-logo-secondary_first-logo -->
    <div class="container-header-logo-secondary container-header-logo-secondary_second-logo">
        <?php $second_logo = get_field('header_second_logo', 'option');
        if (!empty($second_logo)) : ?>
            <img src="<?php echo esc_url($second_logo['url']); ?>" alt="<?php echo esc_attr($second_logo['alt']); ?>" />
        <?php endif; ?>
    </div>
    <!-- /.container-header-logo-secondary container-header-logo-secondary_second-logo -->
</div>
<!-- /.container-header-logo-secondary -->