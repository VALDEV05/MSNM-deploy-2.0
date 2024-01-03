<?php
/**
 *  Aurum WordPress Theme
 *
 *  Laborator.co
 *  www.laborator.co
 */

global $more;

$hover_effect = get_data( 'blog_thumbnail_hover_effect' );
$author_info  = get_data( 'blog_author_info' );
$permalink    = get_permalink();

$has_thumbnail = ( is_single() ? get_data( 'blog_single_thumbnails' ) : get_data( 'blog_thumbnails' ) ) && has_post_thumbnail();
$hover_effect  = get_data( 'blog_thumbnail_hover_effect' );

$title_tag = is_single() ? 'h1' : 'h2';
?>
<article <?php post_class( 'post' ); ?>>
	
	<?php do_action( 'aurum_blog_post_single_before_thumbnail' ); ?>
	
	<?php if ( $has_thumbnail ) : ?>
	<div class="col-lg-12">
		<?php include 'blog-post-thumbnail.php'; ?>
	</div>
	<?php endif; ?>

	<div class="col-lg-8 col-lg-offset-2">

		<div class="post-content">
			<<?php echo $title_tag; ?> class="title">
				<?php if ( is_single() ) : ?>
					<?php the_title(); ?>
				<?php else : ?>
			    	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				<?php endif; ?>

				<?php require locate_template( 'tpls/blog-post-meta.php' ); ?>
			</<?php echo $title_tag; ?>>

			<?php require locate_template( 'tpls/blog-post-content.php' ); ?>
			
			<?php require locate_template( 'tpls/blog-post-nextprev.php' ); ?>

		</div>

		<?php if ( is_single() ) : ?>

			<?php include locate_template( 'tpls/blog-post-share.php' ); ?>

			<?php include locate_template( 'tpls/blog-post-author-info.php' ); ?>

			<?php comments_template(); ?>

		<?php endif; ?>

	</div>
</article>
