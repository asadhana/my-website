<?php
/**
 * Title: Banner
 * Slug: titan-tools-center/banner
 * Categories: banner
 * Block Types: core/template-part/banner
 */
?>

<?php if ( class_exists( 'WooCommerce' ) && wc_get_products( array( 'status' => 'publish', 'limit' => 1 ) ) ) : ?>

<!-- wp:group {"tagName":"main","className":"wp-block-group","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"right":"0","left":"0","top":"0","bottom":"0"}}}} -->
<main class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:group {"tagName":"main","className":"wp-block-group","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"right":"0","left":"0","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}}} -->
<main class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--30);padding-right:0;padding-bottom:var(--wp--preset--spacing--30);padding-left:0"><!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"center","width":"70%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:70%"><!-- wp:group {"className":"slider animations-hidden-item","style":{"background":{"backgroundImage":{"url":"<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/banner.png","id":89,"source":"file","title":"Banner"},"backgroundSize":"cover"},"dimensions":{"minHeight":"500px"},"border":{"radius":"15px"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group slider animations-hidden-item" style="border-radius:15px;min-height:500px"><!-- wp:group {"style":{"border":{"radius":"15px"},"dimensions":{"minHeight":"500px"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group" style="border-radius:15px;min-height:500px"><!-- wp:woocommerce/product-collection {"queryId":13,"query":{"perPage":5,"pages":1,"offset":0,"postType":"product","order":"desc","orderBy":"date","search":"","exclude":[],"inherit":false,"taxQuery":[],"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","onbackorder","outofstock"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[],"timeFrame":{"operator":"in","value":"-7 days"},"filterable":false,"relatedBy":{"categories":true,"tags":true}},"tagName":"div","displayLayout":{"type":"list","columns":5,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/new-arrivals","hideControls":["inherit","order","filterable"],"queryContextIncludes":["collection"],"__privatePreviewState":{"isPreview":false,"previewMessage":"Actual products will vary depending on the page being viewed."}} -->
<div class="wp-block-woocommerce-product-collection"><!-- wp:woocommerce/product-template {"className":"owl-carousel"} -->
<!-- wp:group {"className":"dyna-product-box","style":{"spacing":{"padding":{"left":"13%","right":"20px"}},"dimensions":{"minHeight":"500px"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group dyna-product-box" style="min-height:500px;padding-right:20px;padding-left:13%"><!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"60%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:60%"><!-- wp:heading {"level":5,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400","textTransform":"capitalize"}},"textColor":"contrast","fontFamily":"poppins"} -->
<h5 class="wp-block-heading has-contrast-color has-text-color has-link-color has-poppins-font-family" style="font-size:14px;font-style:normal;font-weight:400;text-transform:capitalize"><?php esc_html_e('One Time Buy Offer','titan-tools-center'); ?></h5>
<!-- /wp:heading -->

<!-- wp:post-title {"textAlign":"left","isLink":true,"style":{"spacing":{"margin":{"bottom":"0.75rem","top":"0"}},"typography":{"lineHeight":"1.4","fontSize":"40px","fontStyle":"normal","fontWeight":"600"},"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"textColor":"contrast","fontFamily":"poppins","__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

<!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"textAlign":"left","textColor":"primary","fontFamily":"roboto","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"30px","fontStyle":"normal","fontWeight":"600"}}} /-->

<!-- wp:woocommerce/product-button {"textAlign":"left","isDescendentOfQueryLoop":true,"textColor":"base","fontFamily":"poppins","style":{"elements":{"link":{"color":{"text":"var:preset|color|base"}}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"600"},"border":{"radius":"5px"}}} /--></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"40%","className":"dynamic-product-image"} -->
<div class="wp-block-column is-vertically-aligned-center dynamic-product-image" style="flex-basis:40%"><!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"thumbnail","isDescendentOfQueryLoop":true} -->
<!-- wp:woocommerce/product-sale-badge {"align":"right"} /-->
<!-- /wp:woocommerce/product-image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
<!-- /wp:woocommerce/product-template --></div>
<!-- /wp:woocommerce/product-collection --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top","width":"22%","className":"slider-right"} -->
<div class="wp-block-column is-vertically-aligned-top slider-right" style="flex-basis:22%"><!-- wp:group {"className":"slider-right","style":{"dimensions":{"minHeight":"400px"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group slider-right" style="min-height:400px"><!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:woocommerce/product-collection {"queryId":14,"query":{"perPage":5,"pages":"5","offset":0,"postType":"product","order":"desc","orderBy":"date","search":"","exclude":[],"inherit":false,"taxQuery":[],"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","outofstock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[],"timeFrame":{"operator":"in","value":"-7 days"},"filterable":false,"relatedBy":{"categories":true,"tags":true}},"tagName":"div","displayLayout":{"type":"list","columns":5,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/new-arrivals","hideControls":["inherit","order","filterable"],"queryContextIncludes":["collection"],"__privatePreviewState":{"isPreview":false,"previewMessage":"Actual products will vary depending on the page being viewed."}} -->
<div class="wp-block-woocommerce-product-collection"><!-- wp:woocommerce/product-template {"className":"owl-carousel"} -->
<!-- wp:group {"className":"right-product-box","style":{"dimensions":{"minHeight":"400px"},"border":{"width":"1px","color":"#FFB701","radius":"12px"},"spacing":{"padding":{"top":"30px","bottom":"30px","left":"20px","right":"20px"}}},"backgroundColor":"secondary-fourth","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group right-product-box has-border-color has-secondary-fourth-background-color has-background" style="border-color:#FFB701;border-width:1px;border-radius:12px;min-height:400px;padding-top:30px;padding-right:20px;padding-bottom:30px;padding-left:20px"><!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"thumbnail","isDescendentOfQueryLoop":true,"width":"100%","height":"220px","scale":"contain"} -->
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
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top","width":"8%","className":"slider-empty"} -->
<div class="wp-block-column is-vertically-aligned-top slider-empty" style="flex-basis:8%"></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></main>
<!-- /wp:group --></main>
<!-- /wp:group -->

<?php else : ?>

<!-- wp:group {"tagName":"main","className":"wp-block-group","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"right":"0","left":"0","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}}} -->
<main class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--30);padding-right:0;padding-bottom:var(--wp--preset--spacing--30);padding-left:0"><!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"70%"} -->
<div class="wp-block-column" style="flex-basis:70%"><!-- wp:group {"className":"slider animations-hidden-item","style":{"background":{"backgroundImage":{"url":"<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/banner.png","id":89,"source":"file","title":"Banner"},"backgroundSize":"cover"},"dimensions":{"minHeight":"500px"},"border":{"radius":"15px"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group slider animations-hidden-item" style="border-radius:15px;min-height:500px"><!-- wp:group {"className":"owl-carousel","style":{"border":{"radius":"15px"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group owl-carousel" style="border-radius:15px"><!-- wp:cover {"dimRatio":0,"minHeight":500,"isDark":false,"className":"left-slider-cover","style":{"border":{"radius":"15px"}}} -->
<div class="wp-block-cover is-light left-slider-cover" style="border-radius:15px;min-height:500px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"dimensions":{"minHeight":""}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:columns {"verticalAlignment":"center","className":"slider-left-column"} -->
<div class="wp-block-columns are-vertically-aligned-center slider-left-column"><!-- wp:column {"verticalAlignment":"center","width":"66.66%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:66.66%"><!-- wp:group {"className":"slider-left-content","layout":{"type":"constrained"}} -->
<div class="wp-block-group slider-left-content"><!-- wp:heading {"level":6,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","textTransform":"capitalize"}},"textColor":"contrast","fontFamily":"poppins"} -->
<h6 class="wp-block-heading has-contrast-color has-text-color has-link-color has-poppins-font-family" style="font-size:16px;font-style:normal;font-weight:400;text-transform:capitalize"><?php esc_html_e('One Time Buy Offer','titan-tools-center'); ?></h6>
<!-- /wp:heading -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"40px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"roboto"} -->
<h3 class="wp-block-heading has-roboto-font-family" style="font-size:40px;font-style:normal;font-weight:600"><?php esc_html_e('Trendy Products','titan-tools-center'); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"30px","fontStyle":"normal","fontWeight":"600"}},"textColor":"primary","fontFamily":"poppins"} -->
<p class="has-primary-color has-text-color has-link-color has-poppins-font-family" style="font-size:30px;font-style:normal;font-weight:600"><?php esc_html_e('$140.00','titan-tools-center'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"30px"}}}} -->
<div class="wp-block-buttons" style="margin-top:30px"><!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"border":{"radius":"6px"},"spacing":{"padding":{"left":"25px","right":"25px","top":"10px","bottom":"10px"}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"600"},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"fontFamily":"poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" href="#" style="border-radius:6px;padding-top:10px;padding-right:25px;padding-bottom:10px;padding-left:25px;font-size:14px;font-style:normal;font-weight:600"><?php esc_html_e('Shop Now','titan-tools-center'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"33.33%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:33.33%"><!-- wp:image {"id":91,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/slider-left1.png" alt="" class="wp-image-91"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->

<!-- wp:cover {"dimRatio":0,"minHeight":500,"isDark":false,"className":"left-slider-cover","style":{"border":{"radius":"15px"}}} -->
<div class="wp-block-cover is-light left-slider-cover" style="border-radius:15px;min-height:500px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"dimensions":{"minHeight":""}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:columns {"verticalAlignment":"center","className":"slider-left-column"} -->
<div class="wp-block-columns are-vertically-aligned-center slider-left-column"><!-- wp:column {"verticalAlignment":"center","width":"66.66%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:66.66%"><!-- wp:group {"className":"slider-left-content","layout":{"type":"constrained"}} -->
<div class="wp-block-group slider-left-content"><!-- wp:heading {"level":6,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","textTransform":"capitalize"}},"textColor":"contrast","fontFamily":"poppins"} -->
<h6 class="wp-block-heading has-contrast-color has-text-color has-link-color has-poppins-font-family" style="font-size:16px;font-style:normal;font-weight:400;text-transform:capitalize"><?php esc_html_e('One Time Buy Offer','titan-tools-center'); ?></h6>
<!-- /wp:heading -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"40px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"roboto"} -->
<h3 class="wp-block-heading has-roboto-font-family" style="font-size:40px;font-style:normal;font-weight:600"><?php esc_html_e('Trendy Products','titan-tools-center'); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"30px","fontStyle":"normal","fontWeight":"600"}},"textColor":"primary","fontFamily":"poppins"} -->
<p class="has-primary-color has-text-color has-link-color has-poppins-font-family" style="font-size:30px;font-style:normal;font-weight:600"><?php esc_html_e('$140.00','titan-tools-center'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"30px"}}}} -->
<div class="wp-block-buttons" style="margin-top:30px"><!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"border":{"radius":"6px"},"spacing":{"padding":{"left":"25px","right":"25px","top":"10px","bottom":"10px"}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"600"},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"fontFamily":"poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" href="#" style="border-radius:6px;padding-top:10px;padding-right:25px;padding-bottom:10px;padding-left:25px;font-size:14px;font-style:normal;font-weight:600"><?php esc_html_e('Shop Now','titan-tools-center'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"33.33%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:33.33%"><!-- wp:image {"id":294,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/slider-left2.png" alt="" class="wp-image-294"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->

<!-- wp:cover {"dimRatio":0,"minHeight":500,"isDark":false,"className":"left-slider-cover","style":{"border":{"radius":"15px"}}} -->
<div class="wp-block-cover is-light left-slider-cover" style="border-radius:15px;min-height:500px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"dimensions":{"minHeight":""}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:columns {"verticalAlignment":"center","className":"slider-left-column"} -->
<div class="wp-block-columns are-vertically-aligned-center slider-left-column"><!-- wp:column {"verticalAlignment":"center","width":"66.66%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:66.66%"><!-- wp:group {"className":"slider-left-content","layout":{"type":"constrained"}} -->
<div class="wp-block-group slider-left-content"><!-- wp:heading {"level":6,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400","textTransform":"capitalize"}},"textColor":"contrast","fontFamily":"poppins"} -->
<h6 class="wp-block-heading has-contrast-color has-text-color has-link-color has-poppins-font-family" style="font-size:16px;font-style:normal;font-weight:400;text-transform:capitalize"><?php esc_html_e('One Time Buy Offerr','titan-tools-center'); ?></h6>
<!-- /wp:heading -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"40px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"roboto"} -->
<h3 class="wp-block-heading has-roboto-font-family" style="font-size:40px;font-style:normal;font-weight:600"><?php esc_html_e('Trendy Products','titan-tools-center'); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"30px","fontStyle":"normal","fontWeight":"600"}},"textColor":"primary","fontFamily":"poppins"} -->
<p class="has-primary-color has-text-color has-link-color has-poppins-font-family" style="font-size:30px;font-style:normal;font-weight:600"><?php esc_html_e('$140.00','titan-tools-center'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"30px"}}}} -->
<div class="wp-block-buttons" style="margin-top:30px"><!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"border":{"radius":"6px"},"spacing":{"padding":{"left":"25px","right":"25px","top":"10px","bottom":"10px"}},"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"600"},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"fontFamily":"poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" href="#" style="border-radius:6px;padding-top:10px;padding-right:25px;padding-bottom:10px;padding-left:25px;font-size:14px;font-style:normal;font-weight:600"><?php esc_html_e('Shop Now','titan-tools-center'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"33.33%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:33.33%"><!-- wp:image {"id":295,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/slider-left3.png" alt="" class="wp-image-295"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top","width":"22%","className":"slider-right"} -->
<div class="wp-block-column is-vertically-aligned-top slider-right" style="flex-basis:22%"><!-- wp:group {"className":"slider-right","style":{"dimensions":{"minHeight":"400px"}},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group slider-right" style="min-height:400px"><!-- wp:group {"className":"owl-carousel","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group owl-carousel"><!-- wp:group {"className":"right-product-box","style":{"dimensions":{"minHeight":"400px"},"border":{"width":"1px","color":"#FFB701","radius":"12px"},"spacing":{"padding":{"top":"30px","bottom":"30px","left":"20px","right":"20px"}}},"backgroundColor":"secondary-fourth","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group right-product-box has-border-color has-secondary-fourth-background-color has-background" style="border-color:#FFB701;border-width:1px;border-radius:12px;min-height:400px;padding-top:30px;padding-right:20px;padding-bottom:30px;padding-left:20px"><!-- wp:image {"id":95,"sizeSlug":"full","linkDestination":"none","align":"center","className":"product-image-right"} -->
<figure class="wp-block-image aligncenter size-full product-image-right"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/slider-right1.png" alt="" class="wp-image-95"/></figure>
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
<h3 class="wp-block-heading has-poppins-font-family" style="font-size:16px;font-style:normal;font-weight:600"><?php esc_html_e('Watch with different color (42mm)','titan-tools-center'); ?></h3>
<!-- /wp:heading -->

<!-- wp:group {"className":"right-btn-row","style":{"spacing":{"margin":{"top":"20px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group right-btn-row" style="margin-top:20px"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600"}},"textColor":"primary","fontFamily":"poppins"} -->
<p class="has-primary-color has-text-color has-link-color has-poppins-font-family" style="font-size:20px;font-style:normal;font-weight:600"><?php esc_html_e('$450 $500','titan-tools-center'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"600"},"spacing":{"padding":{"left":"20px","right":"20px","top":"10px","bottom":"10px"}},"border":{"radius":"5px"},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"fontFamily":"poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" style="border-radius:5px;padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:20px;font-size:14px;font-style:normal;font-weight:600"><?php esc_html_e('Shop Now','titan-tools-center'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"right-product-box","style":{"dimensions":{"minHeight":"400px"},"border":{"width":"1px","color":"#FFB701","radius":"12px"},"spacing":{"padding":{"top":"30px","bottom":"30px","left":"20px","right":"20px"}}},"backgroundColor":"secondary-fourth","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group right-product-box has-border-color has-secondary-fourth-background-color has-background" style="border-color:#FFB701;border-width:1px;border-radius:12px;min-height:400px;padding-top:30px;padding-right:20px;padding-bottom:30px;padding-left:20px"><!-- wp:image {"id":300,"sizeSlug":"full","linkDestination":"none","align":"center","className":"product-image-right"} -->
<figure class="wp-block-image aligncenter size-full product-image-right"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/slider-left2.png" alt="" class="wp-image-300"/></figure>
<!-- /wp:image -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"border":{"top":{"color":"#dcdcdc","width":"1px"},"right":[],"bottom":[],"left":[]},"spacing":{"margin":{"top":"0px"},"padding":{"top":"10px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="border-top-color:#dcdcdc;border-top-width:1px;margin-top:0px;padding-top:10px"><!-- wp:paragraph {"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|secondary-third"}}}},"textColor":"secondary-third","fontFamily":"poppins"} -->
<p class="has-secondary-third-color has-text-color has-link-color has-poppins-font-family" style="font-size:14px;font-style:normal;font-weight:400">Tools</p>
<!-- /wp:paragraph -->

<!-- wp:image {"id":97,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/star.png" alt="" class="wp-image-97"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"poppins"} -->
<h3 class="wp-block-heading has-poppins-font-family" style="font-size:16px;font-style:normal;font-weight:600"><?php esc_html_e('Watch with different color (42mm)','titan-tools-center'); ?></h3>
<!-- /wp:heading -->

<!-- wp:group {"className":"right-btn-row","style":{"spacing":{"margin":{"top":"20px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group right-btn-row" style="margin-top:20px"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600"}},"textColor":"primary","fontFamily":"poppins"} -->
<p class="has-primary-color has-text-color has-link-color has-poppins-font-family" style="font-size:20px;font-style:normal;font-weight:600"><?php esc_html_e('$450 $500','titan-tools-center'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"600"},"spacing":{"padding":{"left":"20px","right":"20px","top":"10px","bottom":"10px"}},"border":{"radius":"5px"},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"fontFamily":"poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" style="border-radius:5px;padding-top:10px;padding-right:20px;padding-bottom:10px;padding-left:20px;font-size:14px;font-style:normal;font-weight:600"><?php esc_html_e('Shop Now','titan-tools-center'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"right-product-box","style":{"dimensions":{"minHeight":"400px"},"border":{"width":"1px","color":"#FFB701","radius":"12px"},"spacing":{"padding":{"top":"30px","bottom":"30px","left":"20px","right":"20px"}}},"backgroundColor":"secondary-fourth","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group right-product-box has-border-color has-secondary-fourth-background-color has-background" style="border-color:#FFB701;border-width:1px;border-radius:12px;min-height:400px;padding-top:30px;padding-right:20px;padding-bottom:30px;padding-left:20px"><!-- wp:image {"id":301,"sizeSlug":"full","linkDestination":"none","align":"center","className":"product-image-right"} -->
<figure class="wp-block-image aligncenter size-full product-image-right"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/slider-left3.png" alt="" class="wp-image-301"/></figure>
<!-- /wp:image -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"border":{"top":{"color":"#dcdcdc","width":"1px"},"right":[],"bottom":[],"left":[]},"spacing":{"margin":{"top":"0px"},"padding":{"top":"10px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="border-top-color:#dcdcdc;border-top-width:1px;margin-top:0px;padding-top:10px"><!-- wp:paragraph {"style":{"typography":{"fontSize":"14px","fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|secondary-third"}}}},"textColor":"secondary-third","fontFamily":"poppins"} -->
<p class="has-secondary-third-color has-text-color has-link-color has-poppins-font-family" style="font-size:14px;font-style:normal;font-weight:400">Tools</p>
<!-- /wp:paragraph -->

<!-- wp:image {"id":97,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/star.png" alt="" class="wp-image-97"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"poppins"} -->
<h3 class="wp-block-heading has-poppins-font-family" style="font-size:16px;font-style:normal;font-weight:600"><?php esc_html_e('Watch with different color (42mm)','titan-tools-center'); ?></h3>
<!-- /wp:heading -->

<!-- wp:group {"className":"right-btn-row","style":{"spacing":{"margin":{"top":"20px"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group right-btn-row" style="margin-top:20px"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600"}},"textColor":"primary","fontFamily":"poppins"} -->
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
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top","width":"8%","className":"slider-empty"} -->
<div class="wp-block-column is-vertically-aligned-top slider-empty" style="flex-basis:8%"></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></main>
<!-- /wp:group -->

<?php endif; ?>