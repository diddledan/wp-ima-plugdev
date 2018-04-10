<div class="plugin-directory-plugin">
    <?php if ( have_ima_plugdev_plugin_banner() ) : ?>
        <div class="plugin-banner">
            <?php the_ima_plugdev_plugin_banner(); ?>
        </div>
    <?php endif; ?>

    <?php if ( true === get_ima_plugdev_plugin_retired() ) : ?>
        <p class="retired-plugin"><?php _e( 'This plugin has been retired. It is recommended that you stop using it.', 'ima-plugdev' ); ?></p>
    <?php endif; ?>

    <p><a href="<?php echo esc_attr( get_ima_plugdev_plugin_zip() ); ?>">Download <?php the_title(); ?> version <?php the_ima_plugdev_plugin_version(); ?></a></p>

    <div>
        <?php the_ima_plugdev_plugin_description(); ?>
    </div>
</div>
