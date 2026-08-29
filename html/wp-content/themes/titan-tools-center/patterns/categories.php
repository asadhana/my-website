<?php
/**
 * Title: Categories
 * Slug: titan-tools-center/categories
 * Categories: categories
 * Block Types: core/template-part/categories
 */
?>

<?php if ( class_exists( 'WooCommerce' ) && wc_get_products( array( 'status' => 'publish', 'limit' => 1 ) ) ) : ?>

<!-- wp:group {"tagName":"main","className":"about-section wp-block-group","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"right":"20px","left":"20px","top":"70px","bottom":"70px"}},"border":{"radius":"20px"}},"backgroundColor":"secondary-fourth","layout":{"type":"constrained","contentSize":"80%"}} -->
<main class="wp-block-group about-section has-secondary-fourth-background-color has-background" style="border-radius:20px;margin-top:0;margin-bottom:0;padding-top:70px;padding-right:20px;padding-bottom:70px;padding-left:20px"><!-- wp:group {"className":"service-text-main animations-hidden-item","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group service-text-main animations-hidden-item"><!-- wp:group {"style":{"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"color":"#dcdcdc","width":"1px"},"left":{"width":"0px","style":"none"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-color:#dcdcdc;border-bottom-width:1px;border-left-style:none;border-left-width:0px"><!-- wp:heading {"level":5,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600","textTransform":"capitalize"},"spacing":{"margin":{"top":"0","bottom":"10px"},"padding":{"top":"0","bottom":"0"}}},"textColor":"contrast","fontFamily":"poppins"} -->
<h5 class="wp-block-heading has-contrast-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-bottom:10px;padding-top:0;padding-bottom:0;font-size:20px;font-style:normal;font-weight:600;text-transform:capitalize"><?php esc_html_e('Product ','titan-tools-center'); ?><span><?php esc_html_e('Categories ','titan-tools-center'); ?></span></h5>
<!-- /wp:heading -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"secondary-third","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary-third"}}},"spacing":{"padding":{"left":"0px","right":"0px","top":"0px","bottom":"0px"}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600"},"color":{"background":"#ffffff00"}},"fontFamily":"poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-secondary-third-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" href="#" style="background-color:#ffffff00;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:16px;font-style:normal;font-weight:600"><?php esc_html_e('View all','titan-tools-center'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"category-main","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group category-main"><!-- wp:gutentor/t1 {"gID":"g-ckfsk91","pName":"gutentor/t1","blockItemsColumn":{"desktop":"grid-lg-2","tablet":"grid-md-4","mobile":"grid-12"},"t1Taxonomy":"product_cat","tBtnTypography":{"fontType":"default","desktopFontSize":16,"tabletFontSize":16,"mobileFontSize":16,"textTransform":"normal"},"tOnDesc":true,"tBxP":{"type":"px","dTop":"15","dBottom":"15","tTop":"15","tBottom":"15","mTop":"15","mBottom":"15"},"tTitleTypography":{"desktopFontSize":"18px","fontType":"google","googleFont":"Poppins","fontWeight":"600"},"tOnCount":false,"tCountOpt":{"display":"sorting","prefix":"","suffix":"Items"}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></main>
<!-- /wp:group -->

<?php else : ?>

<!-- wp:group {"tagName":"main","className":"about-section wp-block-group","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"right":"20px","left":"20px","top":"70px","bottom":"70px"}},"border":{"radius":"20px"}},"backgroundColor":"secondary-fourth","layout":{"type":"constrained","contentSize":"80%"}} -->
<main class="wp-block-group about-section has-secondary-fourth-background-color has-background" style="border-radius:20px;margin-top:0;margin-bottom:0;padding-top:70px;padding-right:20px;padding-bottom:70px;padding-left:20px"><!-- wp:group {"className":"service-text-main animations-hidden-item","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group service-text-main animations-hidden-item"><!-- wp:group {"style":{"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"color":"#dcdcdc","width":"1px"},"left":{"width":"0px","style":"none"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-color:#dcdcdc;border-bottom-width:1px;border-left-style:none;border-left-width:0px"><!-- wp:heading {"level":5,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600","textTransform":"capitalize"},"spacing":{"margin":{"top":"0","bottom":"10px"},"padding":{"top":"0","bottom":"0"}}},"textColor":"contrast","fontFamily":"poppins"} -->
<h5 class="wp-block-heading has-contrast-color has-text-color has-link-color has-poppins-font-family" style="margin-top:0;margin-bottom:10px;padding-top:0;padding-bottom:0;font-size:20px;font-style:normal;font-weight:600;text-transform:capitalize"><?php esc_html_e('Product ','titan-tools-center'); ?><span><?php esc_html_e('Categories ','titan-tools-center'); ?></span></h5>
<!-- /wp:heading -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"secondary-third","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary-third"}}},"spacing":{"padding":{"left":"0px","right":"0px","top":"0px","bottom":"0px"}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"600"},"color":{"background":"#ffffff00"}},"fontFamily":"poppins"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-secondary-third-color has-text-color has-background has-link-color has-poppins-font-family has-custom-font-size wp-element-button" href="#" style="background-color:#ffffff00;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;font-size:16px;font-style:normal;font-weight:600"><?php esc_html_e('View all','titan-tools-center'); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"category-main","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group category-main"><!-- wp:columns {"className":"categories-cloumn"} -->
<div class="wp-block-columns categories-cloumn"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"category-box","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group category-box"><!-- wp:image {"id":247,"sizeSlug":"full","linkDestination":"none","align":"center"} -->
<figure class="wp-block-image aligncenter size-full"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/category1.png" alt="" class="wp-image-247"/></figure>
<!-- /wp:image -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"90%"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"poppins"} -->
<h3 class="wp-block-heading has-text-align-center has-poppins-font-family" style="font-size:20px;font-style:normal;font-weight:600"><a href="#"><?php esc_html_e('Pressure Washers','titan-tools-center'); ?></a></h3>
<!-- /wp:heading --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"category-box","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group category-box"><!-- wp:image {"id":253,"sizeSlug":"full","linkDestination":"none","align":"center"} -->
<figure class="wp-block-image aligncenter size-full"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/category2.png" alt="" class="wp-image-253"/></figure>
<!-- /wp:image -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"90%"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"poppins"} -->
<h3 class="wp-block-heading has-text-align-center has-poppins-font-family" style="font-size:20px;font-style:normal;font-weight:600"><a href="#"><?php esc_html_e('Cordless Tool','titan-tools-center'); ?></a></h3>
<!-- /wp:heading --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"category-box","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group category-box"><!-- wp:image {"id":254,"sizeSlug":"full","linkDestination":"none","align":"center"} -->
<figure class="wp-block-image aligncenter size-full"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/category3.png" alt="" class="wp-image-254"/></figure>
<!-- /wp:image -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"90%"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"poppins"} -->
<h3 class="wp-block-heading has-text-align-center has-poppins-font-family" style="font-size:20px;font-style:normal;font-weight:600"><a href="#"><?php esc_html_e('Air Tools','titan-tools-center'); ?></a></h3>
<!-- /wp:heading --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"category-box","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group category-box"><!-- wp:image {"id":255,"sizeSlug":"full","linkDestination":"none","align":"center"} -->
<figure class="wp-block-image aligncenter size-full"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/category4.png" alt="" class="wp-image-255"/></figure>
<!-- /wp:image -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"90%"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"poppins"} -->
<h3 class="wp-block-heading has-text-align-center has-poppins-font-family" style="font-size:20px;font-style:normal;font-weight:600"><a href="#"><?php esc_html_e('Blades','titan-tools-center'); ?></a></h3>
<!-- /wp:heading --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"category-box","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group category-box"><!-- wp:image {"id":256,"sizeSlug":"full","linkDestination":"none","align":"center"} -->
<figure class="wp-block-image aligncenter size-full"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/category5.png" alt="" class="wp-image-256"/></figure>
<!-- /wp:image -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"90%"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"poppins"} -->
<h3 class="wp-block-heading has-text-align-center has-poppins-font-family" style="font-size:20px;font-style:normal;font-weight:600"><a href="#"><?php esc_html_e('Nailers','titan-tools-center'); ?></a></h3>
<!-- /wp:heading --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"category-box","layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-group category-box"><!-- wp:image {"id":257,"sizeSlug":"full","linkDestination":"none","align":"center"} -->
<figure class="wp-block-image aligncenter size-full"><img src="<?php echo esc_url(get_template_directory_uri()) ?>/assets/images/category6.png" alt="" class="wp-image-257"/></figure>
<!-- /wp:image -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"90%"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"20px","fontStyle":"normal","fontWeight":"600"}},"fontFamily":"poppins"} -->
<h3 class="wp-block-heading has-text-align-center has-poppins-font-family" style="font-size:20px;font-style:normal;font-weight:600"><a href="#"><?php esc_html_e('Staple Guns ','titan-tools-center'); ?></a></h3>
<!-- /wp:heading --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></main>
<!-- /wp:group -->

<?php endif; ?>