<?php
/**
 * Title: Header
 * Slug: titan-tools-center/header
 * Categories: header
 * Block Types: core/template-part/header
 */
?>

<!-- wp:group {"className":"header-box-upper","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"100%","justifyContent":"center"}} -->
<div class="wp-block-group header-box-upper" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:group {"style":{"spacing":{"padding":{"top":"12px","bottom":"12px"}}},"backgroundColor":"contrast","layout":{"type":"constrained","contentSize":"80%"}} -->
<div class="wp-block-group has-contrast-background-color has-background" style="padding-top:12px;padding-bottom:12px"><!-- wp:columns {"className":"header-main-column"} -->
<div class="wp-block-columns header-main-column"><!-- wp:column {"verticalAlignment":"center","width":"25%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:25%"><!-- wp:group {"className":"social-row","style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group social-row"><!-- wp:social-links {"customIconBackgroundColor":"#ffffff00","iconBackgroundColorValue":"#ffffff00","className":"header-social","style":{"spacing":{"blockGap":{"left":"6px"}}}} -->
<ul class="wp-block-social-links has-icon-background-color header-social"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"instagram"} /-->

<!-- wp:social-link {"url":"#","service":"x"} /-->

<!-- wp:social-link {"url":"#","service":"youtube"} /--></ul>
<!-- /wp:social-links -->

<!-- wp:shortcode -->
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%","className":"top-center-text"} -->
<div class="wp-block-column is-vertically-aligned-center top-center-text" style="flex-basis:50%"><!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400"}},"textColor":"base","fontFamily":"poppins"} -->
<p class="has-text-align-center has-base-color has-text-color has-link-color has-poppins-font-family" style="font-size:14px;font-style:normal;font-weight:400"><?php esc_html_e('Free Shipping on Orders Over $50! Limited Time Offer –','titan-tools-center'); ?> <a href="#"><?php esc_html_e('Shop Now','titan-tools-center'); ?></a>!</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"25%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:25%"><!-- wp:group {"className":"top-btn-row","style":{"spacing":{"blockGap":"15px"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
<div class="wp-block-group top-btn-row"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400","lineHeight":"1.2"},"border":{"right":{"color":"var:preset|color|secondary-third","width":"1px"}},"spacing":{"padding":{"right":"15px"}}},"textColor":"base","fontFamily":"poppins"} -->
<p class="has-base-color has-text-color has-link-color has-poppins-font-family" style="border-right-color:var(--wp--preset--color--secondary-third);border-right-width:1px;padding-right:15px;font-size:14px;font-style:normal;font-weight:400;line-height:1.2"><a href="#"><span class="dashicons dashicons-location"></span><?php esc_html_e('Store Locator','titan-tools-center'); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400","lineHeight":"1.2"}},"textColor":"base","fontFamily":"poppins"} -->
<p class="has-base-color has-text-color has-link-color has-poppins-font-family" style="font-size:14px;font-style:normal;font-weight:400;line-height:1.2"><a href="#"><span class="dashicons dashicons-car"></span><?php esc_html_e('Track your Order','titan-tools-center'); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"general-header-middle","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px"}},"border":{"radius":"0px"}},"backgroundColor":"base","layout":{"type":"constrained","contentSize":"80%","justifyContent":"center"}} -->
<div class="wp-block-group general-header-middle has-base-background-color has-background" style="border-radius:0px;margin-top:0;margin-bottom:0;padding-top:10px;padding-bottom:10px"><!-- wp:columns {"verticalAlignment":"center","className":"header-box","style":{"border":{"bottom":{"color":"var:preset|color|base","width":"0px"}},"spacing":{"padding":{"bottom":"0px"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center header-box" style="border-bottom-color:var(--wp--preset--color--base);border-bottom-width:0px;padding-bottom:0px"><!-- wp:column {"verticalAlignment":"center","width":"230px","className":"header-logo"} -->
<div class="wp-block-column is-vertically-aligned-center header-logo" style="flex-basis:230px"><!-- wp:site-title {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontStyle":"normal","fontWeight":"600","fontSize":"22px","textTransform":"capitalize"}},"textColor":"primary","fontFamily":"poppins"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"65%","className":"header-inner-menu"} -->
<div class="wp-block-column is-vertically-aligned-center header-inner-menu" style="flex-basis:65%"><!-- wp:navigation {"textColor":"secondary-third","overlayTextColor":"contrast","metadata":{"ignoredHookedBlocks":["woocommerce/customer-account","woocommerce/mini-cart"]},"className":"is-head-menu","style":{"typography":{"textTransform":"capitalize","fontSize":"15px","fontStyle":"normal","fontWeight":"500"},"spacing":{"blockGap":"var:preset|spacing|40"}},"fontFamily":"poppins","layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:navigation-link {"label":"Home","type":"","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"About Us","type":"","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Shop","type":"","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Pages","type":"","url":"#","kind":"custom","isTopLevelLink":true} /-->

<!-- wp:navigation-link {"label":"Contact Us","type":"","url":"#","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"25%","className":"header-inner-meta"} -->
<div class="wp-block-column is-vertically-aligned-center header-inner-meta" style="flex-basis:25%"><!-- wp:group {"className":"header-meta-row","style":{"spacing":{"blockGap":"15px"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
<div class="wp-block-group header-meta-row"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500"},"border":{"right":{"color":"var:preset|color|secondary-third","width":"1px"}},"spacing":{"padding":{"right":"15px"}}},"textColor":"contrast","fontFamily":"poppins"} -->
<p class="has-contrast-color has-text-color has-link-color has-poppins-font-family" style="border-right-color:var(--wp--preset--color--secondary-third);border-right-width:1px;padding-right:15px;font-size:14px;font-style:normal;font-weight:500"><span class="dashicons dashicons-heart"></span><?php esc_html_e('Like','titan-tools-center'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:woocommerce/mini-cart {"priceColor":{"color":"#1C1B1B","name":"Secondary","slug":"secondary","class":"has-secondary-icon-color"},"iconColor":{"color":"#1C1B1B","name":"Secondary","slug":"secondary","class":"has-secondary-icon-color"},"productCountVisibility":"never"} /-->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"500"},"border":{"right":{"color":"var:preset|color|secondary-third","width":"1px"}},"spacing":{"padding":{"right":"15px"}}},"textColor":"contrast","fontFamily":"poppins"} -->
<p class="has-contrast-color has-text-color has-link-color has-poppins-font-family" style="border-right-color:var(--wp--preset--color--secondary-third);border-right-width:1px;padding-right:15px;font-size:14px;font-style:normal;font-weight:500"><?php esc_html_e('Cart','titan-tools-center'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:woocommerce/customer-account {"textColor":"contrast","fontFamily":"poppins","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"14px"}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"general-header-middle","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"10px","bottom":"10px"}},"border":{"radius":"0px"}},"backgroundColor":"secondary-fourth","layout":{"type":"constrained","contentSize":"80%","justifyContent":"center"}} -->
<div class="wp-block-group general-header-middle has-secondary-fourth-background-color has-background" style="border-radius:0px;margin-top:0;margin-bottom:0;padding-top:10px;padding-bottom:10px"><!-- wp:columns {"verticalAlignment":"center","className":"header-box","style":{"border":{"bottom":{"color":"var:preset|color|base","width":"0px"}},"spacing":{"padding":{"bottom":"0px"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center header-box" style="border-bottom-color:var(--wp--preset--color--base);border-bottom-width:0px;padding-bottom:0px"><!-- wp:column {"verticalAlignment":"center","width":"20%","className":"header-categories"} -->
<div class="wp-block-column is-vertically-aligned-center header-categories" style="flex-basis:20%"><?php if ( class_exists( 'WooCommerce' ) ) { ?><!-- wp:categories {"taxonomy":"product_cat","displayAsDropdown":true,"showLabel":false,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400"}},"textColor":"contrast","fontFamily":"poppins"} /--><?php } ?></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"60%","className":"header-inner-menu"} -->
<div class="wp-block-column is-vertically-aligned-center header-inner-menu" style="flex-basis:60%"><!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Search products…","buttonText":"Search","buttonPosition":"button-inside","buttonUseIcon":true,"query":{"post_type":"product"},"style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary-third"}}},"spacing":{"margin":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"border":{"width":"1px","color":"#FFB701","radius":"5px"},"color":{"background":"#ffffff00"}},"textColor":"secondary-third","namespace":"woocommerce/product-search"} /--></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"20%","className":"header-inner-meta"} -->
<div class="wp-block-column is-vertically-aligned-center header-inner-meta" style="flex-basis:20%"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:group {"className":"header-contact-box","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
<div class="wp-block-group header-contact-box">
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"right","level":6,"style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary-third"}}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400"}},"textColor":"secondary-third","fontFamily":"poppins"} -->
<h6 class="wp-block-heading has-text-align-right has-secondary-third-color has-text-color has-link-color has-poppins-font-family" style="font-size:14px;font-style:normal;font-weight:400"><?php esc_html_e('Support : 1-234-567-89','titan-tools-center'); ?></h6>
<!-- /wp:heading -->

<!-- wp:heading {"textAlign":"right","level":6,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"15px","fontStyle":"normal","fontWeight":"500","textTransform":"capitalize"},"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}}},"textColor":"contrast","fontFamily":"poppins"} -->
<h6 class="wp-block-heading has-text-align-right has-contrast-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;font-size:15px;font-style:normal;font-weight:500;text-transform:capitalize"><?php esc_html_e('info@example.com','titan-tools-center'); ?></h6>
<!-- /wp:heading --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->