<?php
/**
 * Title: Related Post
 * Slug: titan-tools-center/related-post
 * Categories: titan-tools-center, related-post
 */
?>
<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--40)"><!-- wp:heading {"textAlign":"left","level":4} -->
<h4 class="wp-block-heading has-text-align-left"><strong><?php esc_html_e('Related Posts :-','titan-tools-center'); ?></strong></h4>
<!-- /wp:heading -->

<!-- wp:query {"queryId":10,"query":{"perPage":"3","pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false}} -->
<div class="wp-block-query"><!-- wp:post-template {"className":"related-post","fontSize":"small","layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"10px","bottom":"10px","left":"10px","right":"10px"}},"color":{"background":"#f6f6f6"}},"layout":{"type":"default"}} -->
<div class="wp-block-group has-background" style="background-color:#f6f6f6;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px"><!-- wp:post-featured-image {"style":{"border":{"radius":"10px"}}} /-->

<!-- wp:post-title {"textAlign":"left","level":4,"style":{"elements":{"link":{"color":{"text":"var:preset|color|heading"}}}},"textColor":"heading"} /-->

<!-- wp:post-excerpt {"textAlign":"left","moreText":"","excerptLength":10} /-->

<!-- wp:group {"className":"archieve-readmore","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group archieve-readmore"><!-- wp:separator {"backgroundColor":"primary"} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background"/>
<!-- /wp:separator -->

<!-- wp:read-more {"content":"Read More","style":{"typography":{"textDecoration":"none"},"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"spacing":{"padding":{"right":"14px","left":"14px","top":"10px","bottom":"10px"}},"border":{"radius":"8px"}},"backgroundColor":"primary","textColor":"base","fontSize":"small"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->