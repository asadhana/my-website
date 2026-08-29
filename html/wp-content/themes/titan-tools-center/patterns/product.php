<?php
/**
 * Title: Product
 * Slug: titan-tools-center/product
 * Categories: product
 * Block Types: core/template-part/product
 */
?>

<?php if ( class_exists( 'WooCommerce' ) && wc_get_products( array( 'status' => 'publish', 'limit' => 1 ) ) ) : ?>

<!-- wp:group {"tagName":"main","className":"gallery-section wp-block-group","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"right":"0","left":"0","top":"50px","bottom":"50px"}}},"layout":{"type":"constrained","contentSize":"80%"}} -->
<main class="wp-block-group gallery-section" style="margin-top:0;margin-bottom:0;padding-top:50px;padding-right:0;padding-bottom:50px;padding-left:0"><!-- wp:columns {"verticalAlignment":"center","className":"animations-hidden-item sale-main-cloumn","style":{"spacing":{"blockGap":{"top":"10px","left":"30px"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center animations-hidden-item sale-main-cloumn"><!-- wp:column {"verticalAlignment":"center","width":"25%","className":"sale-left"} -->
<div class="wp-block-column is-vertically-aligned-center sale-left" style="flex-basis:25%"><!-- wp:group {"className":"about-left-image-box","style":{"spacing":{"padding":{"bottom":"0px","left":"0px","right":"0px","top":"0px"},"margin":{"top":"0","bottom":"0"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained","contentSize":""}} -->
<div class="wp-block-group about-left-image-box" style="margin-top:0;margin-bottom:0;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:cover {"url":"<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/sale-banner.png","id":122,"dimRatio":20,"customOverlayColor":"#1f1f1f","isUserOverlayColor":true,"minHeight":530,"contentPosition":"top center","isDark":false,"sizeSlug":"full","style":{"border":{"radius":"12px"},"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-cover is-light has-custom-content-position is-position-top-center" style="border-radius:12px;padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30);min-height:530px"><img class="wp-block-cover__image-background wp-image-122 size-full" alt="" src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/sale-banner.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-20 has-background-dim" style="background-color:#1f1f1f"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"level":5,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","textTransform":"capitalize"}},"textColor":"contrast","fontFamily":"poppins"} -->
<h5 class="wp-block-heading has-contrast-color has-text-color has-link-color has-poppins-font-family" style="font-size:16px;font-style:normal;font-weight:400;text-transform:capitalize"><?php esc_html_e('Mega Sale Offer','titan-tools-center'); ?></h5>
<!-- /wp:heading -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"30px","fontStyle":"normal","fontWeight":"600"},"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}}},"fontFamily":"poppins"} -->
<h3 class="wp-block-heading has-poppins-font-family" style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;font-size:30px;font-style:normal;font-weight:600"><?php esc_html_e('Tool Machine','titan-tools-center'); ?></h3>
<!-- /wp:heading -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"base","textColor":"primary","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"15px","fontStyle":"normal","fontWeight":"600"},"spacing":{"padding":{"left":"25px","right":"25px","top":"10px","bottom":"10px"}}},"fontFamily":"poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-primary-color has-base-background-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" style="padding-top:10px;padding-right:25px;padding-bottom:10px;padding-left:25px;font-size:15px;font-style:normal;font-weight:600"><?php esc_html_e('Shop Now','titan-tools-center'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"75%","className":"sale-right"} -->
<div class="wp-block-column is-vertically-aligned-center sale-right" style="flex-basis:75%"><!-- wp:group {"className":"about-content","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group about-content" style="margin-top:0;margin-bottom:0;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"style":{"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"color":"#dcdcdc","width":"1px"},"left":{"width":"0px","style":"none"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-color:#dcdcdc;border-bottom-width:1px;border-left-style:none;border-left-width:0px"><!-- wp:heading {"level":5,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600","textTransform":"capitalize"},"spacing":{"margin":{"top":"0","bottom":"10px"},"padding":{"top":"0","bottom":"0"}}},"textColor":"contrast","fontFamily":"poppins"} -->
<h5 class="wp-block-heading has-contrast-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-bottom:10px;padding-top:0;padding-bottom:0;font-size:20px;font-style:normal;font-weight:600;text-transform:capitalize"><?php esc_html_e('Today’s ','titan-tools-center'); ?><span><?php esc_html_e('Top Picks ','titan-tools-center'); ?></span></h5>
<!-- /wp:heading -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"base","textColor":"secondary-third","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary-third"}}},"spacing":{"padding":{"left":"0px","right":"0px","top":"0px","bottom":"0px"}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-secondary-third-color has-base-background-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" href="#" style="padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:16px;font-style:normal;font-weight:600"><?php esc_html_e('View all','titan-tools-center'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:woocommerce/product-collection {"queryId":15,"query":{"perPage":3,"pages":"5","offset":0,"postType":"product","order":"desc","orderBy":"date","search":"","exclude":[],"inherit":false,"taxQuery":[],"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","outofstock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[],"timeFrame":{"operator":"in","value":"-7 days"},"filterable":false,"relatedBy":{"categories":true,"tags":true}},"tagName":"div","displayLayout":{"type":"flex","columns":3,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/new-arrivals","hideControls":["inherit","order","filterable"],"queryContextIncludes":["collection"],"__privatePreviewState":{"isPreview":false,"previewMessage":"Actual products will vary depending on the page being viewed."}} -->
<div class="wp-block-woocommerce-product-collection"><!-- wp:woocommerce/product-template {"className":"sale-product-column"} -->
<!-- wp:group {"className":"sale-product-box","style":{"dimensions":{"minHeight":"400px"},"border":{"radius":"12px","width":"1px"},"spacing":{"padding":{"top":"30px","bottom":"30px","left":"20px","right":"20px"}}},"backgroundColor":"secondary-fourth","borderColor":"secondary","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group sale-product-box has-border-color has-secondary-border-color has-secondary-fourth-background-color has-background" style="border-width:1px;border-radius:12px;min-height:400px;padding-top:30px;padding-right:20px;padding-bottom:30px;padding-left:20px"><!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"thumbnail","isDescendentOfQueryLoop":true,"width":"100%","height":"220px","scale":"contain"} -->
<!-- wp:woocommerce/product-sale-badge {"align":"right"} /-->
<!-- /wp:woocommerce/product-image -->

<!-- wp:group {"style":{"border":{"top":{"color":"var:preset|color|secondary-third","width":"1px"},"right":{"width":"0px","style":"none"},"bottom":{"width":"0px","style":"none"},"left":{"width":"0px","style":"none"}},"spacing":{"padding":{"top":"10px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="border-top-color:var(--wp--preset--color--secondary-third);border-top-width:1px;border-right-style:none;border-right-width:0px;border-bottom-style:none;border-bottom-width:0px;border-left-style:none;border-left-width:0px;padding-top:10px"><!-- wp:post-terms {"term":"product_cat","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary-third"}}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400"}},"textColor":"secondary-third","fontFamily":"roboto"} /-->

<!-- wp:woocommerce/product-rating {"isDescendentOfQueryLoop":true,"textColor":"secondary","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}}} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"textAlign":"left","isLink":true,"style":{"spacing":{"margin":{"bottom":"0.75rem","top":"0"}},"typography":{"lineHeight":"1.4","fontSize":"16px","fontStyle":"normal","fontWeight":"600"},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast","fontFamily":"poppins","__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

<!-- wp:group {"className":"right-slider-product-btn","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group right-slider-product-btn"><!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"textAlign":"left","textColor":"primary","fontFamily":"poppins","style":{"typography":{"fontSize":"18px","fontStyle":"normal","fontWeight":"600"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}}} /-->

<!-- wp:woocommerce/product-button {"textAlign":"left","isDescendentOfQueryLoop":true,"textColor":"base","fontFamily":"poppins","style":{"spacing":{"padding":{"top":"10px","bottom":"10px","left":"25px","right":"25px"}},"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"typography":{"fontSize":"15px","fontStyle":"normal","fontWeight":"600"},"border":{"radius":"5px"}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:woocommerce/product-template --></div>
<!-- /wp:woocommerce/product-collection --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></main>
<!-- /wp:group -->

<?php else : ?>

<!-- wp:group {"tagName":"main","className":"gallery-section wp-block-group","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"right":"0","left":"0","top":"50px","bottom":"50px"}}},"layout":{"type":"constrained","contentSize":"80%"}} -->
<main class="wp-block-group gallery-section" style="margin-top:0;margin-bottom:0;padding-top:50px;padding-right:0;padding-bottom:50px;padding-left:0"><!-- wp:columns {"verticalAlignment":"center","className":"animations-hidden-item sale-main-cloumn","style":{"spacing":{"blockGap":{"top":"10px","left":"30px"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center animations-hidden-item sale-main-cloumn"><!-- wp:column {"verticalAlignment":"center","width":"25%","className":"sale-left"} -->
<div class="wp-block-column is-vertically-aligned-center sale-left" style="flex-basis:25%"><!-- wp:group {"className":"about-left-image-box","style":{"spacing":{"padding":{"bottom":"0px","left":"0px","right":"0px","top":"0px"},"margin":{"top":"0","bottom":"0"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained","contentSize":""}} -->
<div class="wp-block-group about-left-image-box" style="margin-top:0;margin-bottom:0;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:cover {"url":"<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/sale-banner.png","id":122,"dimRatio":20,"customOverlayColor":"#1f1f1f","isUserOverlayColor":true,"minHeight":530,"contentPosition":"top center","isDark":false,"sizeSlug":"full","style":{"border":{"radius":"12px"},"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-cover is-light has-custom-content-position is-position-top-center" style="border-radius:12px;padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30);min-height:530px"><img class="wp-block-cover__image-background wp-image-122 size-full" alt="" src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/sale-banner.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-20 has-background-dim" style="background-color:#1f1f1f"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"level":5,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","textTransform":"capitalize"}},"textColor":"contrast","fontFamily":"poppins"} -->
<h5 class="wp-block-heading has-contrast-color has-text-color has-link-color has-poppins-font-family" style="font-size:16px;font-style:normal;font-weight:400;text-transform:capitalize"><?php esc_html_e('Mega Sale Offer','titan-tools-center'); ?></h5>
<!-- /wp:heading -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"30px","fontStyle":"normal","fontWeight":"600"},"spacing":{"padding":{"top":"0","bottom":"0"},"margin":{"top":"0","bottom":"0"}}},"fontFamily":"poppins"} -->
<h3 class="wp-block-heading has-poppins-font-family" style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;font-size:30px;font-style:normal;font-weight:600"><?php esc_html_e('Tool Machine','titan-tools-center'); ?></h3>
<!-- /wp:heading -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"base","textColor":"primary","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"15px","fontStyle":"normal","fontWeight":"600"},"spacing":{"padding":{"left":"25px","right":"25px","top":"10px","bottom":"10px"}},"border":{"radius":"6px"}},"fontFamily":"poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-primary-color has-base-background-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" style="border-radius:6px;padding-top:10px;padding-right:25px;padding-bottom:10px;padding-left:25px;font-size:15px;font-style:normal;font-weight:600"><?php esc_html_e('Shop Now','titan-tools-center'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"75%","className":"sale-right"} -->
<div class="wp-block-column is-vertically-aligned-center sale-right" style="flex-basis:75%"><!-- wp:group {"className":"about-content","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"dimensions":{"minHeight":""}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group about-content" style="margin-top:0;margin-bottom:0;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:group {"style":{"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"color":"#dcdcdc","width":"1px"},"left":{"width":"0px","style":"none"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-color:#dcdcdc;border-bottom-width:1px;border-left-style:none;border-left-width:0px"><!-- wp:heading {"level":5,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600","textTransform":"capitalize"},"spacing":{"margin":{"top":"0","bottom":"10px"},"padding":{"top":"0","bottom":"0"}}},"textColor":"contrast","fontFamily":"poppins"} -->
<h5 class="wp-block-heading has-contrast-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-bottom:10px;padding-top:0;padding-bottom:0;font-size:20px;font-style:normal;font-weight:600;text-transform:capitalize"><?php esc_html_e('Today’s ','titan-tools-center'); ?><span><?php esc_html_e('Top Picks ','titan-tools-center'); ?></span></h5>
<!-- /wp:heading -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"base","textColor":"secondary-third","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary-third"}}},"spacing":{"padding":{"left":"0px","right":"0px","top":"0px","bottom":"0px"}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-secondary-third-color has-base-background-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" href="#" style="padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:16px;font-style:normal;font-weight:600"><?php esc_html_e('View all','titan-tools-center'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:columns {"className":"sale-product-column"} -->
<div class="wp-block-columns sale-product-column"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"right-product-box","style":{"dimensions":{"minHeight":"400px"},"border":{"radius":"12px","width":"1px"},"spacing":{"padding":{"top":"30px","bottom":"30px","left":"20px","right":"20px"}}},"backgroundColor":"secondary-fourth","borderColor":"secondary","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group right-product-box has-border-color has-secondary-border-color has-secondary-fourth-background-color has-background" style="border-width:1px;border-radius:12px;min-height:400px;padding-top:30px;padding-right:20px;padding-bottom:30px;padding-left:20px"><!-- wp:image {"id":243,"sizeSlug":"full","linkDestination":"none","align":"center","className":"product-image-right"} -->
<figure class="wp-block-image aligncenter size-full product-image-right"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/top-product1.png" alt="" class="wp-image-243"/></figure>
<!-- /wp:image -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"border":{"top":{"color":"#dcdcdc","width":"1px"},"right":[],"bottom":[],"left":[]},"spacing":{"margin":{"top":"0px"},"padding":{"top":"10px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="border-top-color:#dcdcdc;border-top-width:1px;margin-top:0px;padding-top:10px"><!-- wp:paragraph {"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|secondary-third"}}}},"textColor":"secondary-third","fontFamily":"poppins"} -->
<p class="has-secondary-third-color has-text-color has-link-color has-poppins-font-family" style="font-size:14px;font-style:normal;font-weight:400"><?php esc_html_e('Tools','titan-tools-center'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:image {"id":97,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/star.png" alt="" class="wp-image-97"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"poppins"} -->
<h3 class="wp-block-heading has-poppins-font-family" style="font-size:16px;font-style:normal;font-weight:600"><?php esc_html_e('Metabo HPT 16 Gauge Pneumatic Finish','titan-tools-center'); ?></h3>
<!-- /wp:heading -->

<!-- wp:group {"className":"sale-btn-row","style":{"spacing":{"margin":{"top":"20px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group sale-btn-row" style="margin-top:20px"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600"}},"textColor":"primary","fontFamily":"poppins"} -->
<p class="has-primary-color has-text-color has-link-color has-poppins-font-family" style="font-size:20px;font-style:normal;font-weight:600"><?php esc_html_e('$450 $500','titan-tools-center'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"600"},"spacing":{"padding":{"left":"20px","right":"20px","top":"10px","bottom":"10px"}},"border":{"radius":"5px"},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"fontFamily":"poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" style="border-radius:5px;padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:20px;font-size:14px;font-style:normal;font-weight:600"><?php esc_html_e('Shop Now','titan-tools-center'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"right-product-box","style":{"dimensions":{"minHeight":"400px"},"border":{"radius":"12px","width":"1px"},"spacing":{"padding":{"top":"30px","bottom":"30px","left":"20px","right":"20px"}}},"backgroundColor":"secondary-fourth","borderColor":"secondary","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group right-product-box has-border-color has-secondary-border-color has-secondary-fourth-background-color has-background" style="border-width:1px;border-radius:12px;min-height:400px;padding-top:30px;padding-right:20px;padding-bottom:30px;padding-left:20px"><!-- wp:image {"id":297,"sizeSlug":"full","linkDestination":"none","align":"center","className":"product-image-right"} -->
<figure class="wp-block-image aligncenter size-full product-image-right"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/top-product2.png" alt="" class="wp-image-297"/></figure>
<!-- /wp:image -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"border":{"top":{"color":"#dcdcdc","width":"1px"},"right":[],"bottom":[],"left":[]},"spacing":{"margin":{"top":"0px"},"padding":{"top":"10px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="border-top-color:#dcdcdc;border-top-width:1px;margin-top:0px;padding-top:10px"><!-- wp:paragraph {"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|secondary-third"}}}},"textColor":"secondary-third","fontFamily":"poppins"} -->
<p class="has-secondary-third-color has-text-color has-link-color has-poppins-font-family" style="font-size:14px;font-style:normal;font-weight:400"><?php esc_html_e('Tools','titan-tools-center'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:image {"id":97,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/star.png" alt="" class="wp-image-97"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"poppins"} -->
<h3 class="wp-block-heading has-poppins-font-family" style="font-size:16px;font-style:normal;font-weight:600"><?php esc_html_e('Metabo HPT 16 Gauge Pneumatic Finish','titan-tools-center'); ?></h3>
<!-- /wp:heading -->

<!-- wp:group {"className":"sale-btn-row","style":{"spacing":{"margin":{"top":"20px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group sale-btn-row" style="margin-top:20px"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600"}},"textColor":"primary","fontFamily":"poppins"} -->
<p class="has-primary-color has-text-color has-link-color has-poppins-font-family" style="font-size:20px;font-style:normal;font-weight:600"><?php esc_html_e('$450 $500','titan-tools-center'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"600"},"spacing":{"padding":{"left":"20px","right":"20px","top":"10px","bottom":"10px"}},"border":{"radius":"5px"},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"fontFamily":"poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" style="border-radius:5px;padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:20px;font-size:14px;font-style:normal;font-weight:600">Shop Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"right-product-box","style":{"dimensions":{"minHeight":"400px"},"border":{"radius":"12px","width":"1px"},"spacing":{"padding":{"top":"30px","bottom":"30px","left":"20px","right":"20px"}}},"backgroundColor":"secondary-fourth","borderColor":"secondary","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group right-product-box has-border-color has-secondary-border-color has-secondary-fourth-background-color has-background" style="border-width:1px;border-radius:12px;min-height:400px;padding-top:30px;padding-right:20px;padding-bottom:30px;padding-left:20px"><!-- wp:image {"id":298,"sizeSlug":"full","linkDestination":"none","align":"center","className":"product-image-right"} -->
<figure class="wp-block-image aligncenter size-full product-image-right"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/top-product3.png" alt="" class="wp-image-298"/></figure>
<!-- /wp:image -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"border":{"top":{"color":"#dcdcdc","width":"1px"},"right":[],"bottom":[],"left":[]},"spacing":{"margin":{"top":"0px"},"padding":{"top":"10px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="border-top-color:#dcdcdc;border-top-width:1px;margin-top:0px;padding-top:10px"><!-- wp:paragraph {"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|secondary-third"}}}},"textColor":"secondary-third","fontFamily":"poppins"} -->
<p class="has-secondary-third-color has-text-color has-link-color has-poppins-font-family" style="font-size:14px;font-style:normal;font-weight:400"><?php esc_html_e('Tools','titan-tools-center'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:image {"id":97,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/star.png" alt="" class="wp-image-97"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"poppins"} -->
<h3 class="wp-block-heading has-poppins-font-family" style="font-size:16px;font-style:normal;font-weight:600"><?php esc_html_e('Metabo HPT 16 Gauge Pneumatic Finish','titan-tools-center'); ?></h3>
<!-- /wp:heading -->

<!-- wp:group {"className":"sale-btn-row","style":{"spacing":{"margin":{"top":"20px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group sale-btn-row" style="margin-top:20px"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600"}},"textColor":"primary","fontFamily":"poppins"} -->
<p class="has-primary-color has-text-color has-link-color has-poppins-font-family" style="font-size:20px;font-style:normal;font-weight:600"><?php esc_html_e('$450 $500','titan-tools-center'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"600"},"spacing":{"padding":{"left":"20px","right":"20px","top":"10px","bottom":"10px"}},"border":{"radius":"5px"},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"fontFamily":"poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" style="border-radius:5px;padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:20px;font-size:14px;font-style:normal;font-weight:600"><?php esc_html_e('Shop Now','titan-tools-center'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></main>
<!-- /wp:group -->

<?php endif; ?>