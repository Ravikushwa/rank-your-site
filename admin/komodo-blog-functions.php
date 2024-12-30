<?php
function komodo_add_meta_box() {
    add_meta_box(
        'komodo-seo-box',      // Unique ID for the meta box
        'Komodo Seo',         // Title of the meta box
        'komodo_render_meta_box',  // Callback function to render the content of the meta box
        'post',                    // Post type where the meta box should appear
        'side',                    // Context: 'normal', 'advanced', or 'side'
        'high'                     // Priority: 'high', 'core', 'default', or 'low'
    );
}
//add_action('add_meta_boxes', 'komodo_add_meta_box');

function komodo_render_meta_box( $post ){
    $komodo_focuskeyword = get_post_meta($post->ID, '_komodo_focuskeyword', true);
    $focuskeywordarr = explode(',', $komodo_focuskeyword);
    /**
     * Check SEO Parameter
     */
    $basicseo = 6;
    $finalseo = 6;
    $basictitle = $basicdesc = $firstfocus = $urlfocus = $wordCount = $wordCountvar = '0';
    global $post;

    // Get the post object
    $post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : 0);
    $post = get_post($post_id);

    // Get the post title
    $post_title = get_the_title($post);
    if(!empty($focuskeywordarr[0])){
        if( stripos($post_title, $focuskeywordarr[0]) !== false ){
            $basictitle = 1;
        }else{
            $basictitle = 0;
        }
    }else{
        $basictitle = 0;
    }
    
    // Get the post Description
    $post_content = get_the_content($post);
    if(!empty($focuskeywordarr[0])){
        if( stripos($post_content, $focuskeywordarr[0]) !== false ){
            $basicdesc = 1;
        }else{
            $basicdesc = 0;
        }
    }else{
        $basictitle = 0;
    }
    
    // Check first word is foucus word or not
    $contentLength = strlen($post_content);
    
    $wordCount = str_word_count($post_content);
	if($wordCount != 0){
		$wordCountvar = 1;
	}
    // Calculate the length of the first 10% of the content
    $first10PercentLength = ceil($contentLength * 0.1);
    
    // Extract the first 10% of the content
    $first10PercentContent = substr($post_content, 0, $first10PercentLength);
    if(!empty($focuskeywordarr[0])){
        if(strcasecmp($first10PercentContent, $focuskeywordarr[0]) !== false){
            $firstfocus = 1;
        }else{
            $firstfocus = 0;
        }
    }else{
        $basictitle = 0;
    }

    //check focuse keyword in url 
    $keyword1 = str_replace(' ', '-', $focuskeywordarr[0]);
    $keyword2 = str_replace(' ', '_', $focuskeywordarr[0]);

    $post_url = get_permalink($post);
    
    $url_path = parse_url($post_url, PHP_URL_PATH);
    if(!empty($focuskeywordarr[0])){
        if( stripos($url_path, $keyword1) !== false || stripos($url_path, $keyword2) !== false ){
            $urlfocus = 1;
        }else{
            $urlfocus = 0;
        }
    }else{
        $urlfocus = 0;
    }

    $finalseo = $basicseo - $urlfocus - $firstfocus - $basicdesc - $basicdesc - $basictitle - $wordCountvar;
    
	?>
    <div class="komodo-seocon-wrapper">
        <div class="seo-modal-cls-btn"></div>
        <div id="tags-input">
            <label for="komodo_focuskeyword">Focus Keyword</label>
            <div class="tooltip">Hover over me
              <span class="tooltiptext">Tooltip text</span>
            </div>
            <input type="text" id="komodo-focuskeyword" placeholder="Example: Are You Ready to Improve Your Sleep Quality" /> 
            <div id="komodo-list">
                <?php
                    if (!empty($focuskeywordarr)) {
                        foreach ($focuskeywordarr as $komodo_focuskeyword_child) {
                            if(!empty($komodo_focuskeyword_child)){
                                echo '<div class="tag-item">' . esc_html($komodo_focuskeyword_child) . '<span class="tag-remove">x</span></div>';
                            }
                        }
                    }
                ?>
            <!-- </div> -->
            <input type="hidden" id="komodo_focuskeyword" name="komodo_focuskeyword"  class="komodo_focuskeyword" value="<?php echo esc_attr($komodo_focuskeyword); ?>">
        </div>

        <section class="kb-accordion">
            <div class="kb-tab">
                <input type="checkbox" name="accordion-1" id="cb1" checked>
                <?php if($finalseo == 0){ ?>
                <label for="cb1" class="cb1 kb-tab__label kb-accordian-tab-green">Core SEO 
                    <span >All Good </span>
                </label>
                <?php
                }else{ ?>
                <label for="cb1" class="cb1 kb-tab__label kb-accordian-tab-red">Core SEO 
                    <span>Error <b class="komodo-basicseo"><?php echo $finalseo; ?></b> </span>
                </label>
                <?php } ?>

                <div class="kb-tab__content">
                    <ul>
                    <?php if($basictitle != 1){ ?>
                        <li class="basictitle"> 
                            <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
							<div>
                            Place the focus keyword in the SEO title.
							<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_title" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
							</div>
                        </li>
                    <?php }else{ ?>
                        <li class="basictitle"> 
                            <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
							<div>
                            Place the focus keyword in the SEO title.
							<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_title" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
							</div>
                        </li>
                    <?php } 
                    if($basicdesc != 1){
                    ?>
                        <li class="basicdesc"> 
                            <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
							<div>
                            Place the focus keyword within SEO meta description.
							<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_md" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
							</div>
                        </li>
                    <?php }else{
                        ?>
                        <li class="basicdesc"> 
                            <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
							<div>
                            Place the focus keyword within SEO meta description.
							<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_md" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
							</div>
                        </li>
                        <?php
                    } 
                    if($urlfocus != 1){ 
                    ?>
                        <li class="urlfocus"> 
                            <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
							<div>
                            Embed the focus keyword in the URL.
							<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_url" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
							</div>
                        </li>
                    <?php }else{ ?>
                        <li class="urlfocus"> 
							<img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
							<div>
							Embed the focus keyword in the URL.
							<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_url" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
							</div>
                        </li>
                    <?php
                    }
                    if($firstfocus != 1){ ?>
                        <li class="firstfocus"> 
                            <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
							<div>
                            Focus keyword is included in the first portion of the content.
							<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_text" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
							</div>
                        </li>
                    <?php }else{ ?>
                        <li class="firstfocus"> 
                            <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
							<div>
                            Focus keyword is included in the first portion of the content.
							<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_text" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
							</div>
                        </li>
                    <?php 
                    }
                    if($basicdesc != 1){
                    ?>
                        <li class="basicdesc"> 
                            <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
							<div>
                            Include the focus keyword within the text.
							<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_wtext" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
							</div>
                        </li>
                    <?php }else{ ?>
                        <li class="basicdesc"> 
                            <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
							<div>
                            Include the focus keyword within the text.
							<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_wtext" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
							</div>
                        </li>
                    <?php } ?>
                    <?php if($wordCount < 600){ ?>
                        <li class="wordCount"> 
                            <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
							<div>
							<span class="contentofwordcount">
                            Content is <?php echo esc_html($wordCount); ?> words long. Consider using at least 600 words.
							</span>
							<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#content_limit" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
							</div>
                        </li>
                    <?php }else{ ?>
                        <li class="wordCount"> 
                            <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
							<div>
							<div>
							<span class="contentofwordcount">
                            Content is <?php echo esc_html($wordCount); ?> words long. Good job!
							</span>
							<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#content_limit" target="_blank">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
							</div>
						</div>
						</li>
                    <?php } ?>
                    </ul>
                </div>
            </div>
            <?php 

            $post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : 0);
            $post = get_post($post_id);
            $post_content = get_the_content($post);
            $pattern = '/<!--.*?-->/s';
            $post_content = preg_replace($pattern, '', $post_content);
            $post_content = str_replace("'", "", $post_content);
            $adfinalseo = 5;
            $ad_focus_key = '0';
            $word_to_find = $focuskeywordarr[0];

            //CHECK Focus Keyword in subheading(s) like H2, H3, H4, etc..
            $search_tags = ['h1', 'h2', 'h3'];
            $internallink = $externallink = $focusimg = $focuskeyword = $keyworddensity = $keywordtext = $externallink = $density = $density_intwo = $keywordCount = 0;
            foreach ($search_tags as $tag) {
                $pattern = '/<'.$tag.'[^>]*>(.*?)<\/'.$tag.'>/is';
                if (preg_match_all($pattern, $post_content, $matches)) {
                    foreach ($matches[1] as $h2_content) {
						if(!empty($focuskeywordarr[0])){
							$keyword1 = str_replace(' ', '-', $focuskeywordarr[0]);
							$keyword2 = str_replace(' ', '_', $focuskeywordarr[0]);
							if(strpos($h2_content, $focuskeywordarr[0]) !== false || strpos($h2_content, $keyword1) !== false || strpos($h2_content, $keyword2) !== false ){
								$focuskeyword = 1;
							}
						}
                    }
                } 
            }

            // Check image alt tag
            $pattern = '/<img[^>]+alt=["\']([^"\']+)["\'][^>]*>/i';
            if (preg_match_all($pattern, $post_content, $matches, PREG_SET_ORDER)) {
                
                $matches_div = $matches;               
                foreach ($matches as $match) {
                    //$alt_text = $match;
                    if(!empty($focuskeywordarr[0])){
                        $keyword1 = str_replace(' ', '-', $focuskeywordarr[0]);
                        $keyword2 = str_replace(' ', '_', $focuskeywordarr[0]);
                        
                        if(in_array($focuskeywordarr[0], $match) || in_array($keyword1, $match) || in_array($keyword2, $match)){
                            if($focusimgkey == "false"){
                                $focusimg = 1;
                            }
                        }
                    }
                }
            }
            
            if(empty($matches_div)){
                if($focusimgkey == "true"){
                    $focusimg = 0;
                }
            }

            // Keyword Density
            if(!empty($post_content)){
            
                $totalWords = str_word_count($post_content);
                if(!empty($focuskeywordarr[0]) && !empty($post_content)){
                    $keywordCount = substr_count(strtolower($post_content), strtolower($focuskeywordarr[0]));
                    $density = ($keywordCount / $totalWords) * 100;
                    $density_intwo = number_format((float)$density, 2, '.', '');
                }
            }
            if($density == 0){
                $keyworddensity = 0;
                $keywordtext = 'Keyword Density is 0. Aim for around 1% Keyword Density.';
            }elseif($density >0.78 && $density <2.78){
                $keyworddensity = 1;
                $keywordtext = 'Keyword Density is '.$density_intwo.', the Focus Keyword and combination appears '.$keywordCount.' times.';
            }elseif($density >2.78){
                $keyworddensity = 0;
                $keywordtext = 'Keyword Density is '.$density_intwo.', the Focus Keyword and combination appears '.$keywordCount.' times.';
            }else{
                $keyworddensity = 0;
                $keywordtext = 'Keyword Density is '.$density_intwo.', the Focus Keyword and combination appears '.$keywordCount.' times.';
            }

            //External Url 
            $currentdomain = get_site_url();
            $pattern = '/\bhttps?:\/\/\S+/i';

            // Perform the search
            if (preg_match_all($pattern, $post_content, $matches)) {
                
                foreach($matches[0] as $match_child){
                    if(str_contains($match_child, $currentdomain)){
                        $internallink = 1;
                    }else{
                        $externallink = 1;
                    }
                }
            }
            $adfinalseo = $adfinalseo - $focuskeyword - $focusimg - $keyworddensity - $externallink - $externallink;
            ?>
            <div class="kb-tab">
                <input type="checkbox" name="accordion-1" id="cb2" >
                <?php if($adfinalseo == 0){ ?>
                <label for="cb2" class="cb2 kb-tab__label kb-accordian-tab-green">Extended 
                    <span >All Good </span>
                </label>
                <?php
                }else{ ?>
                <label for="cb2" class="cb2 kb-tab__label kb-accordian-tab-red">Extended
                    <span> Error <b class="komodo-adfinalseo"><?php echo $adfinalseo; ?></b></span>
                </label>
                <?php } ?>

                <div class="kb-tab__content">
                    <ul>
                        <?php if($focuskeyword == 1){ ?>
                            <li class="focuskeyword"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
								<div>
                                Focus keyword used in the subheading(s).
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_subhead" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php }else{ ?>
                            <li class="focuskeyword"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
								<div>
                                Use Focus Keyword in subheading(s) like H2, H3, H4, etc..
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_subhead" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php } ?>

                        <?php if($focusimg == 1){ ?>
                            <li class="focusimg"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
								<div>
                                Place an image and assign the focus keyword as alt text.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_altext" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php }else{ ?>
                            <li class="focusimg"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
								<div>
                                Place an image and assign the focus keyword as alt text.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_altext" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php } ?>

                        <?php if($keyworddensity == 1){ ?>
                            <li class="keyworddensity">
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
								<div>
                                <span class="contentofkeyword"><?php echo $keywordtext; ?></span>
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#kd" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php }else{ ?>
                            <li class="keyworddensity"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
								<div>
                                <span class="contentofkeyword"><?php echo $keywordtext; ?></span>
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#kd" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php } ?>

                        <?php if($externallink == 1){ ?>
                            <li class="externallink"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
								<div>
                                Direct users to outside resources.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#direct_users" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php }else{ ?>
                            <li class="externallink"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
								<div>
                                Direct users to outside resources.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#direct_users" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php } ?>
                        <?php if($externallink == 1){ ?>
                            <li class="externallink"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
								<div>
                                Use DoFollow links to link to external sources.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#dofollow_links" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php }else{ ?>
                            <li class="externallink"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
								<div>
                                Use DoFollow links to link to external sources.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#dofollow_links" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php 
            $titleseo = 4;
            $post_title = get_the_title($post);
            $keyword = $focuskeywordarr[0];
            if(!empty($focuskeywordarr[0])){
                // Begin Word
                if (stripos($post_title, $keyword) >= 0 && stripos($post_title, $keyword) <= 10 && stripos($post_title, $keyword) != "") {
                    $begintitle = 1;
                } else {
                    $begintitle = 0;
                }
            }else {
                $begintitle = 0;
            }

            // POSITIVE OR NAGATIVE SAGMENT
            $keywords = ["good", "bad", "not", "yes", "no"];

            $sagmentfound = 0;
            foreach ($keywords as $keyword) {
                if (strpos($post_title, $keyword) !== false) {
                    $sagmentfound = 1;
                    break;
                }
            }

            //  Power Keyword
            $powerarr = [
                "A Cut Above", "Absolute", "Absolutely Lowest Absolutely", "Absurd", "Abuse Accurate", "Accuse", "Achieve Actionable", "Adaptable", "Adequate Admit", "Adorable", "Advantage Advice", "Affordable", "Aggravate Aggressive", "Agitated", "Agonizing Agony", "Alarmed", "Alarming Alienated", "Aligned", "All-inclusive Alluring", "Always", "Amazing Amp", "Animated", "Annihilate Announcing", "Anonymous", "Antagonistic Anxious", "Apocalypse", "Appalled Approved", "Approving", "Argumentative Armageddon", "Arrogant", "Ass Kicking Assault", "Assured", "Astonishing Astounded", "Astounding", "At Ease Atrocious", "Attractive", "Audacity Authentic", "Authoritative", "Authority Aware", "Awe-inspiring", "Awesome Awkward", "Backbone", "Backdoor Backed", "Backlash", "Backstabbing Badass", "Balanced", "Banned Bargain", "Barrage", "Basic Battle", "Beaming", "Beat Down Beating", "Beautiful", "Beauty Begging", "Behind The Scenes", "Belief Best-selling", "Best", "Better Beware", "Big", "Billion Black Market", "Blacklisted", "Blast Blessed", "Blinded", "Blissful Blood", "Bloodbath", "Bloodcurdling Bloody", "Blunder", "Blushing Bold", "Bomb", "Bona Fide Bonanza", "Bonus", "Bootleg Bottom Line", "Bountiful", "Brave Bravery", "Brazen", "Break Breaking", "Breakthrough", "Breathtaking Bright", "Brilliant", "Broke Brutal","Budget", "Buffoon Bullshit", "Bully", "Bumbling Buy", "Cadaver", "Calm Cancel Anytime", "Capable", "Captivate Captivating", "Carefree", "Case Study Cash", "Cataclysmic", "Catapult Catastrophe", "Caution", "Censored Centered", "Certain", "Certainly Certified", "Challenge", "Charming Cheap", "Cheat-sheet", "Cheat Cheer", "Cheerful", "Child-like Clarity", "Classified", "Clear Clueless", "Collapse", "Colorful Colossal", "Comfortable", "Compare Competitive", "Complete", "Completely Completeness", "Comprehensive", "Compromise Compulsive", "Concealed", "Conclusive Condemning", "Condescending", "Confess Confession", "Confessions", "Confident Confidential", "Conquer", "Conscientious Constructive", "Content", "Contrary Controlling", "Controversial", "Convenient Convert", "Cooperative", "Copy Corpse", "Corrupt", "Corrupting Courage", "Courageous", "Cover-up Covert", "Coward", "Cowardly Crammed", "Crave", "Crazy Creative", "Cringeworthy", "Cripple Crisis", "Critical", "Crooked Crush", "Crushing", "Damaging Danger", "Dangerous", "Daring Dazzling", "Dead", "Deadline Deadly", "Death", "Decadent Deceived", "Deceptive", "Defiance Definitely", "Definitive", "Defying Dejected", "Delicious", "Delight Delighted", "Delightful", "Delirious Delivered", "Deplorable", "Depraved Desire", "Desperate", "Despicable Destiny", "Destroy", "Detailed Devastating", "Devoted", "Diagnosed Direct", "Dirty", "Disadvantages Disastrous", "Discount", "Discover Disdainful", "Disempowered", "Disgusted Disgusting", "Dishonest", "Disillusioned Disoriented", "Distracted", "Distraught Distressed", "Distrustful", "Divulge Document", "Dollar", "Doomed Double", "Doubtful", "Download Dreadful", "Dreamy", "Drive Drowning", "Dumb", "Dynamic Eager", "Earnest", "Easily Easy", "Economical", "Ecstatic Edge", "Effective", "Efficient Effortless", "Elated", "Eliminate Elite", "Embarrass", "Embarrassed Emergency", "Emerging", "Emphasize Empowered", "Enchant", "Encouraged Endorsed", "Energetic", "Energy Enormous", "Enraged", "Enthusiastic Epic", "Epidemic", "Essential Ethical", "Euphoric", "Evil Exactly", "Exasperated", "Excellent Excited", "Excitement", "Exciting Exclusive", "Exclusivity", "Excruciating Exhilarated", "Expensive", "Expert Explode", "Exploit", "Explosive Exposed", "Exquisite", "Extra Extraordinary", "Extremely", "Exuberant Eye-opening", "Fail-proof", "Fail Failure", "Faith", "Famous Fantasy", "Fascinating", "Fatigued Faux Pas", "Fearless", "Feast Feeble", "Festive", "Fierce Fight", "Final", "Fine Fired", "First Ever", "First Flirt", "Fluid", "Focus Focused", "Fool", "Fooled Foolish", "Forbidden", "Force-fed Forever", "Forgiving", "Forgotten Formula", "Fortune", "Foul Frantic", "Free", "Freebie Freedom", "Frenzied", "Frenzy Frightening", "Frisky", "Frugal Frustrated", "Fulfill", "Fulfilled Full", "Fully", "Fun-loving Fundamentals", "Funniest", "Funny Furious", "Gambling", "Gargantuan Genius", "Genuine", "Gift Gigantic", "Giveaway", "Glamorous Gleeful", "Glorious", "Glowing Gorgeous", "Graceful", "Grateful Gratified", "Gravity", "Greatest Greatness", "Greed", "Greedy Grit", "Grounded", "Growth Guaranteed", "Guilt-free", "Guilt Gullible", "Guts", "Hack Happiness", "Happy", "Harmful Harsh", "Hate", "Have You Heard Havoc", "Hazardous", "Healthy Heart", "Heartbreaking", "Heartwarming Heavenly", "Helpful", "Helplessness Hero", "Hesitant", "Hidden High Tech", "Highest", "Highly Effective Hilarious", "Hoak", "Hoax Holocaust", "Honest", "Honored Hope", "Hopeful", "Horrific Horror", "Hostile", "How To Huge", "Humility", "Humor Hurricane", "Hurry", "Hypnotic Idiot", "Ignite", "Illegal Illusive", "Imagination", "Immediately Imminently", "Impatience", "Impatient Impenetrable", "Important", "Improved In The Zone", "Incapable", "Incapacitated Incompetent", "Inconsiderate", "Increase Incredible", "Indecisive", "Indulgence Indulgent", "Inexpensive", "Inferior Informative", "Infuriated", "Ingredients Innocent", "Innovative", "Insane Insecure", "Insider", "Insider Insidious", "Inspired", "Inspiring Instant Savings", "Instantly", "Instructive Intel", "Intelligent", "Intense Interesting", "Intriguing Introducing", "Invasion", "Investment", "Iron-clad Ironclad", "Irresistible", "Irs Jackpot", "Jail", "Jaw-dropping Jealous", "Jeopardy", "Jittery Jovial", "Joyous", "Jubilant Judgmental", "Jumpstart", "Just Arrived Keen", "Kickass", "Kickstart Know It All", "Lame", "Largest Lascivious", "Last Chance", "Last Minute Last", "Latest", "Laugh Laughing", "Launch", "Launching Lavishly", "Lawsuit", "Left Behind Legendary", "Legitimate", "Liberal Liberated", "Lick", "Lies Life-changing", "Lifetime", "Light Lighthearted", "Likely", "Limited Literally", "Little-known", "Loathsome Lonely", "Looming", "Loser Lost", "Love", "Lunatic Lurking", "Lust", "Luxurious Luxury", "Lying", "Magic Magical", "Magnificent", "Mainstream Malicious", "Mammoth", "Manipulative Marked Down", "Massive", "Maul Mediocre", "Meditative", "Meltdown Memorable", "Menacing", "Mendacious Merely", "Mesmerized", "Mesmerizing Might", "Mind-blowing", "Mindless Miracle", "Miraculous", "Misery Misleading", "Mistake", "Mixed-up Moan", "Modern Money-saving", "Money Mood", "Mood Boosting", "Moody", "More Most", "Motivated Mouthwatering", "Moving", "Murder Mystified", "Na�ve Near-unbeatable", "Negative", "Nervous Newest", "Newly", "Ninja No Commitment", "Noble", "No-cost No-frills", "No-nonsense", "Non-competitive", "Non-judgmental Non-stop", "Notably", "Notorious", "Novelty", "Numb Nutty", "Obnoxious", "Obsessive Obtain", "Ominous", "One-time", "Open", "Optimal", "Optimistic", "Opulent Ordeal", "Organic", "Out of This World Out-of-the-box", "Outclass", "Outlaw", "Outrage", "Outstanding", "Overconfident Overcome", "Overjoyed Overwhelming", "Painstaking Paralyzed", "Pardon", "Parody Passionate", "Pathetic Patient", "Peaceful", "Peerless", "Penetrate Perceived", "Perfect", "Perky Persecuted", "Persuasive", "Petrified Philanthropic", "Picturesque", "Pioneering Pitiful", "Plagued Playful", "Please", "Pleasant", "Pleased", "Pleasing Plummet", "Poised", "Popular", "Positive Possessive", "Powerful", "Powerless", "Practical Preposterous", "Preserved Pretty", "Priceless Pride", "Principled", "Prize", "Productive Profanity", "Profitable", "Profit Progress", "Progressive Prominent", "Promised", "Proven Prying", "Psychological", "Pure", "Purposeful", "Puzzled", "Quake Qualitative", "Quality Quarantine", "Quarrel", "Quell", "Quest Questionable", "Quick", "Quickest", "Quintessential", "Quirky Quit", "Quivering", "Quixotic", "Radiant", "Raging", "Rant", "Rare", "Rational Ravaged", "Raving", "Read", "Real", "Rebel", "Rebellious", "Reckless", "Reconcile", "Redundant", "Refined", "Rejoice", "Relaxed", "Relentless", "Relevant", "Reliable", "Revealed", "Revelatory", "Revenge", "Revitalize", "Revolution", "Reward", "Rich", "Ridiculous", "Rigorous", "Risky", "Riveting", "Robust", "Rock-bottom", "Romantic", "Rotten", "Ruin", "Rule-breaking", "Rush", "Sacred", "Safe", "Sane", "Satisfied", "Scam", "Scandal", "Scandalous", "Scarcity", "Scared", "Scary", "Screaming", "Scrutinize", "Secure", "Self-absorbed", "Selfish", "Selfless", "Sensible", "Sensual", "Sentimental", "Serene", "Serious", "Settled", "Sexy", "Shady", "Shameful", "Shattered", "Shocking", "Shunned", "Simple", "Simplicity", "Sincere", "Sinister", "Sizzling", "Skeleton", "Skillful", "Slammed", "Sleazy", "Slightly", "Sluggish", "Smart", "Smashing", "Sneak Peek", "Sneak", "Soothing", "Sophisticated", "Sorry", "Soulful", "Sound", "Sovereign", "Spam", "Sparkling", "Spectacular", "Speedy", "Spellbinding", "Spiritual", "Splendid", "Spontaneous", "Sporadic", "Spotlight", "Staggering", "Stale", "Star", "Startling", "Stately", "Stealthy", "Stellar", "Stimulating", "Stingy", "Stoked", "Storm", "Strange", "Strategic", "Streamlined", "Strengthened", "Stress", "Striking", "Stubborn", "Stunned", "Stupefied", "Stunning", "Substantial", "Successful", "Suffering", "Suicidal", "Suitable", "Sulky", "Summon", "Super", "Superb", "Superior", "Supportive", "Surpassing", "Surprised", "Surprising", "Survival", "Suspicious", "Sustainable", "Sweet", "Swift", "Sympathetic", "Talented", "Tantalizing", "Tarnished", "Terrible","Terrific", "Thankful", "Thirsty", "Threat", "Thrifty", "Thrilling", "Thrive", "Thwart", "Tidy", "Tight", "Time-limited", "Timeless", "Timely", "Tired", "Titillating", "To Die For", "Tolerant", "Tombstone", "Torn", "Tormented", "Tortured", "Tough", "Toxic", "Tragic", "Traitor", "Tranquil", "Transformative", "Transform", "Transparent", "Traumatic", "Treason", "Treasured", "Trendy", "Triumphant", "True", "Trustworthy", "Truthful", "Turnkey", "Ultimate", "Unbeatable", "Unbelievable", "Unbreakable", "Uncover","Underdog", "Underestimated", "Undeniable", "Undeniably","Undeniably", "Undetectable", "Undeterred", "Undisputed", "Unemotional", "Unfazed", "Unforgettable", "Unforgivable", "Unhindered", "Unique", "United", "Universal", "Unlimited", "Unparalleled", "Unpredictable", "Unquestionably", "Unrivaled", "Unstoppable", "Unthinkable", "Untouched", "Untouched", "Untraceable", "Unwavering", "Unyielding", "Uplifting", "Upset", "Urgent", "Usable", "Valiant", "Valuable", "Vanquish", "Vast", "Venerable", "Vent", "Vibrant", "Victory", "Villain", "Vindicated", "Violent", "Virtue", "Visionary", "Vital", "Vivid", "Volatile", "Wacky", "Wanted", "Warrant", "Wary", "Wasted", "Wavering", "Weak", "Wealthy", "Weapon", "Whimsical", "Whole", "Wicked", "Wild", "Winning", "Witty", "Wonderful", "Worried", "Wretched", "Worthy", "Wow", "Wrath", "Wrathful", "Wreck", "Wrecked", "Wronged", "Yawn", "Yearning", "Yell", "Youthful", "Zealot", "Zero-cost", "new"
            ];
            $powerkeyfound = 0;
            foreach ($powerarr as $keyword) {
                if (strpos($post_title, $keyword) !== false) {
                    $powerkeyfound = 1;
                    break;
                }
            }

            //check post title contains number
            $containsnumber = 0;
            if (preg_match('/\d/', $post_title)) {
                $containsnumber = 1;
            } else {
                $containsnumber = 0;
            }
            $titleseo = $titleseo - $containsnumber - $powerkeyfound - $sagmentfound - $begintitle;
            ?>
            <div class="kb-tab">
                <input type="checkbox" name="accordion-1" id="cb3" >

                <?php if($titleseo == 0){ ?>
                <label for="cb3" class="cb3 kb-tab__label kb-accordian-tab-green">Heading Readability 
                    <span>All Good </span>
                </label>
                <?php
                }else{ ?>
                <label for="cb3" class="cb3 kb-tab__label kb-accordian-tab-red">Heading Readability
                    <span> Error <b class="komodo-titleseo"><?php echo $titleseo; ?></b> </span>
                </label>
                <?php } ?>
                <div class="kb-tab__content">
                    <ul>
                        <?php if($begintitle == 1){ ?>
                            <li class="begintitle"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
								<div>
                                SEO title starts with the focus keyword.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#seo_fkey" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php }else{ ?>
                            <li class="begintitle"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
								<div>
                                SEO title starts with the focus keyword.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#seo_fkey" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php } ?>
                        
                        <?php if($sagmentfound == 1){ ?>
                            <li class="sagmentfound"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
								<div>
                                Your title shows a positive or negative sentiment.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#seo_fkey" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php }else{ ?>
                            <li class="sagmentfound"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
								<div>
                                Your title shows a positive or negative sentiment.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#seo_fkey" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php } ?>
                        <?php if($powerkeyfound == 1){ ?>
                            <li class="powerkeyfound">
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
								<div>
                                Your title contains 1 power word.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#power_word" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php }else{ ?>
                            <li class="powerkeyfound"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
								<div>
                                Your title contains 1 power word.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#power_word" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php } ?>
                        <?php if($containsnumber == 1){ ?>
                            <li class="containsnumber"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
								<div>
                                SEO title includes a numeric value.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#num_value" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php }else{ ?>
                            <li class="containsnumber"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
								<div>
                                SEO title includes a numeric value.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#num_value" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php
            $contentreadability = 2;
            $imgcontain = $paragraph_readability = 0;
            $pattern = '/<img[^>]+>/i';
            if (preg_match_all($pattern, $post_content, $matches, PREG_SET_ORDER)) {
                if(!empty($matches[0])){
                    $imgcontain = 1;
                }else{
                    $imgcontain = 0;
                }
            }

            //Check large paragraph 

            $content_with_paragraphs = wpautop($post_content);
            $paragraphs = explode('</p>', strip_tags($content_with_paragraphs, '<p>'));

            // Clean up any empty paragraphs
            $paragraphs = array_filter($paragraphs, 'trim');
            if(!empty($paragraphs)){
                foreach($paragraphs as $para){
                    $word_count = str_word_count($para);
                    if($word_count < 120){
                        $parapraph_limit[] = 1;
                    }else{
                        $parapraph_limit[] = 0;
                    }
                }
                if (in_array(0, $parapraph_limit, true)) {
                    $paragraph_readability = 0;
                } else {
                    $paragraph_readability = 1;
                }
            }

            $contentreadability = $contentreadability - $paragraph_readability - $imgcontain;
            ?>
            <div class="kb-tab">
                <input type="checkbox" name="accordion-1" id="cb4" >
                <?php if($contentreadability == 0){ ?>
                    <label for="cb4" class="cb4 kb-tab__label kb-accordian-tab-green">Content Accessibility
                        <span >All Good</span>
                    </label>
                <?php
                }else{ ?>
                    <label for="cb4" class="cb4 kb-tab__label kb-accordian-tab-red">Content Accessibility
                        <span>Error <b class="komodo-contentreadability"><?php echo $contentreadability; ?></b> </span>
                    </label>
                <?php } ?>
                <div class="kb-tab__content">
                    <ul>
                        <?php if($paragraph_readability == 1){ ?>
                            <li class="paragraph_readability"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
								<div>
                                Add short and concise paragraphs for better readability and UX.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#readability" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php }else{ ?>
                            <li class="paragraph_readability"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
								<div>
                                Add short and concise paragraphs for better readability and UX.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#readability" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php } ?>
                        <?php if($imgcontain == 1){ ?>
                            <li class="imgcontain">
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
								<div>
                                Add a few images and/or videos to make your content appealing.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#content_appealing" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php }else{ ?>
                            <li class="imgcontain">
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
								<div>
                                Add a few images and/or videos to make your content appealing.
								<a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#content_appealing" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
								</div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </section>
	</div>
	<?php
    wp_nonce_field( 'komodo_meta_box_with_button_nonce', 'komodo_meta_box_with_button_nonce' );
}

add_action( 'save_post', 'komodo_save_custom_meta_box_with_button_data' );
function komodo_save_custom_meta_box_with_button_data( $post_id ) {
    if ( ! isset( $_POST['komodo_meta_box_with_button_nonce'] ) ) {
        return;
    }

    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['komodo_meta_box_with_button_nonce'], 'komodo_meta_box_with_button_nonce' ) ) {
        return;
    }

    // Check if this is an autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    //save feedback type
    if( isset( $_POST['komodo_focuskeyword'] ) ){
        $komodo_focuskeyword = sanitize_text_field( $_POST['komodo_focuskeyword'] );
        update_post_meta( $post_id, '_komodo_focuskeyword', $komodo_focuskeyword );
    }
}

add_action( 'wp_ajax_komodo_delete_404redirection', 'komodo_delete_404redirection' );
function komodo_delete_404redirection(){
    global $wpdb;
	$table_name = $wpdb->prefix . 'rys_redirects'; // Replace with your table name
    if ($_POST['action'] == 'komodo_delete_404redirection') {
        $wpdb->query("TRUNCATE TABLE $table_name");

        $res = array( 'status'=>true, 'msg'=>'All data has been cleared.' );
    }else{
        $res = array( 'status'=>false, 'msg'=>'Something went wrong' );
    }
    echo json_encode($res);
    die();
}

add_action( 'wp_ajax_komodo_updatealttagonimages', 'komodo_updatealttagonimages' );
function komodo_updatealttagonimages(){
    $args = array(
        'post_type' => 'attachment',
        'posts_per_page' => -1,
    );
    
    $attachments = get_posts($args);
    
    foreach ($attachments as $attachment) {
        add_image_alt_title_tags($attachment->ID);
    }
}

add_action( 'wp_ajax_komodo_check_postitle', 'komodo_check_postitle' );
function komodo_check_postitle(){
    $res = '';
    if(!empty($_POST)){
        if(!empty($_POST['keyword'])){
            $keyword = $_POST['keyword'];
        }
        if(!empty($_POST['title'])){
            $post_title = $_POST['title'];
        }
        if(!empty($_POST['basicseo'])){
            $basicseo = $_POST['basicseo'];
        }else{
            $basicseo = 0;
        }
        $mytest = $basicseo;

        if(!empty($_POST['titleseo'])){
            $titleseo = $_POST['titleseo'];
        }else{
            $titleseo = 0;
        }

        $basictitle = $begintitle = $sagmentfound = $powerkeyfound = $containsnumber = 0;
        //Parameters 
        if(!empty($_POST['numberkey'])){
            $numberkey = $_POST['numberkey'];
            if($numberkey == "true"){
                $containsnumber = 1;
            }
        }
        if(!empty($_POST['powerkey'])){
            $powerkey = $_POST['powerkey'];
            if($powerkey == "true"){
                $powerkeyfound = 1;
            }
        }
        if(!empty($_POST['sagmentkey'])){
            $sagmentkey = $_POST['sagmentkey'];
            if($sagmentkey == "true"){
                $sagmentfound = 1;
            }
        }
        if(!empty($_POST['beginkey'])){
            $beginkey = $_POST['beginkey'];
            if($beginkey == "true"){
                $begintitle = 1;
            }
        }
        if(!empty($_POST['basictitlekey'])){
            $basictitlekey = $_POST['basictitlekey'];
            if($basictitlekey == "true"){
                $basictitle = 1;
            }
        }

        if(!empty($keyword) && !empty($post_title)){
            $keyarr = explode(',',$keyword);
            /**
             * Basic seo start 
             */
            //Basic SEO Title
            if(!empty($keyarr[0])){
                if( stripos($post_title, $keyarr[0]) !== false ){
                    if($basictitlekey == "false"){
                        $basictitle = 1;
                        if(!empty($basicseo)){
                           $basicseo = $basicseo - $basictitle;
                        }
                    }
                }else{
                    if($basictitlekey == "true"){
                        $basictitle = 0;
                        $basicseo = $basicseo - 1;
                    }
                }
            }else{
                $basictitle = 0;
            }
            
            /**
             * Basic seo end 
             */
            /**
             * Title seo end 
             */
            //Focus Keyword used at the beginning
            if(!empty($keyarr[0])){
                if (stripos($post_title, $keyarr[0]) >= 0 && stripos($post_title, $keyarr[0]) <= 10 && stripos($post_title, $keyarr[0]) != "") {
                    if($beginkey == "false"){
                        $begintitle = 1;
                        if(!empty($titleseo)){
                            $titleseo = $titleseo - $begintitle;
                        }
                    }
                } else {
                    if($beginkey =="true"){
                        $begintitle = 0;
                        $titleseo = $titleseo + 1;
                    }
                }
            }else {
                $begintitle = 0;
            }

            // POSITIVE OR NAGATIVE SAGMENT
            $keywords = ["good", "bad", "not", "yes", "no"];
            foreach ($keywords as $keyword) {
                $sagmenttest = stripos($post_title, $keyword);
                if ($sagmenttest !== false) {
                    if($sagmentkey == "false"){
                        $sagmentfound = 1;
                        if(!empty($titleseo)){
                            $titleseo = $titleseo - $sagmentfound;
                        }
                    }
                    break;
                }
            }
            if($sagmenttest == false){
                if($sagmentkey == "true"){
                   $sagmentfound = 0;
                   $titleseo = $titleseo + 1;
                }
            }

            //  Power Keyword
            $powerarr = [
                "A Cut Above", "Absolute", "Absolutely Lowest Absolutely", "Absurd", "Abuse Accurate", "Accuse", "Achieve Actionable", "Adaptable", "Adequate Admit", "Adorable", "Advantage Advice", "Affordable", "Aggravate Aggressive", "Agitated", "Agonizing Agony", "Alarmed", "Alarming Alienated", "Aligned", "All-inclusive Alluring", "Always", "Amazing Amp", "Animated", "Annihilate Announcing", "Anonymous", "Antagonistic Anxious", "Apocalypse", "Appalled Approved", "Approving", "Argumentative Armageddon", "Arrogant", "Ass Kicking Assault", "Assured", "Astonishing Astounded", "Astounding", "At Ease Atrocious", "Attractive", "Audacity Authentic", "Authoritative", "Authority Aware", "Awe-inspiring", "Awesome Awkward", "Backbone", "Backdoor Backed", "Backlash", "Backstabbing Badass", "Balanced", "Banned Bargain", "Barrage", "Basic Battle", "Beaming", "Beat Down Beating", "Beautiful", "Beauty Begging", "Behind The Scenes", "Belief Best-selling", "Best", "Better Beware", "Big", "Billion Black Market", "Blacklisted", "Blast Blessed", "Blinded", "Blissful Blood", "Bloodbath", "Bloodcurdling Bloody", "Blunder", "Blushing Bold", "Bomb", "Bona Fide Bonanza", "Bonus", "Bootleg Bottom Line", "Bountiful", "Brave Bravery", "Brazen", "Break Breaking", "Breakthrough", "Breathtaking Bright", "Brilliant", "Broke Brutal","Budget", "Buffoon Bullshit", "Bully", "Bumbling Buy", "Cadaver", "Calm Cancel Anytime", "Capable", "Captivate Captivating", "Carefree", "Case Study Cash", "Cataclysmic", "Catapult Catastrophe", "Caution", "Censored Centered", "Certain", "Certainly Certified", "Challenge", "Charming Cheap", "Cheat-sheet", "Cheat Cheer", "Cheerful", "Child-like Clarity", "Classified", "Clear Clueless", "Collapse", "Colorful Colossal", "Comfortable", "Compare Competitive", "Complete", "Completely Completeness", "Comprehensive", "Compromise Compulsive", "Concealed", "Conclusive Condemning", "Condescending", "Confess Confession", "Confessions", "Confident Confidential", "Conquer", "Conscientious Constructive", "Content", "Contrary Controlling", "Controversial", "Convenient Convert", "Cooperative", "Copy Corpse", "Corrupt", "Corrupting Courage", "Courageous", "Cover-up Covert", "Coward", "Cowardly Crammed", "Crave", "Crazy Creative", "Cringeworthy", "Cripple Crisis", "Critical", "Crooked Crush", "Crushing", "Damaging Danger", "Dangerous", "Daring Dazzling", "Dead", "Deadline Deadly", "Death", "Decadent Deceived", "Deceptive", "Defiance Definitely", "Definitive", "Defying Dejected", "Delicious", "Delight Delighted", "Delightful", "Delirious Delivered", "Deplorable", "Depraved Desire", "Desperate", "Despicable Destiny", "Destroy", "Detailed Devastating", "Devoted", "Diagnosed Direct", "Dirty", "Disadvantages Disastrous", "Discount", "Discover Disdainful", "Disempowered", "Disgusted Disgusting", "Dishonest", "Disillusioned Disoriented", "Distracted", "Distraught Distressed", "Distrustful", "Divulge Document", "Dollar", "Doomed Double", "Doubtful", "Download Dreadful", "Dreamy", "Drive Drowning", "Dumb", "Dynamic Eager", "Earnest", "Easily Easy", "Economical", "Ecstatic Edge", "Effective", "Efficient Effortless", "Elated", "Eliminate Elite", "Embarrass", "Embarrassed Emergency", "Emerging", "Emphasize Empowered", "Enchant", "Encouraged Endorsed", "Energetic", "Energy Enormous", "Enraged", "Enthusiastic Epic", "Epidemic", "Essential Ethical", "Euphoric", "Evil Exactly", "Exasperated", "Excellent Excited", "Excitement", "Exciting Exclusive", "Exclusivity", "Excruciating Exhilarated", "Expensive", "Expert Explode", "Exploit", "Explosive Exposed", "Exquisite", "Extra Extraordinary", "Extremely", "Exuberant Eye-opening", "Fail-proof", "Fail Failure", "Faith", "Famous Fantasy", "Fascinating", "Fatigued Faux Pas", "Fearless", "Feast Feeble", "Festive", "Fierce Fight", "Final", "Fine Fired", "First Ever", "First Flirt", "Fluid", "Focus Focused", "Fool", "Fooled Foolish", "Forbidden", "Force-fed Forever", "Forgiving", "Forgotten Formula", "Fortune", "Foul Frantic", "Free", "Freebie Freedom", "Frenzied", "Frenzy Frightening", "Frisky", "Frugal Frustrated", "Fulfill", "Fulfilled Full", "Fully", "Fun-loving Fundamentals", "Funniest", "Funny Furious", "Gambling", "Gargantuan Genius", "Genuine", "Gift Gigantic", "Giveaway", "Glamorous Gleeful", "Glorious", "Glowing Gorgeous", "Graceful", "Grateful Gratified", "Gravity", "Greatest Greatness", "Greed", "Greedy Grit", "Grounded", "Growth Guaranteed", "Guilt-free", "Guilt Gullible", "Guts", "Hack Happiness", "Happy", "Harmful Harsh", "Hate", "Have You Heard Havoc", "Hazardous", "Healthy Heart", "Heartbreaking", "Heartwarming Heavenly", "Helpful", "Helplessness Hero", "Hesitant", "Hidden High Tech", "Highest", "Highly Effective Hilarious", "Hoak", "Hoax Holocaust", "Honest", "Honored Hope", "Hopeful", "Horrific Horror", "Hostile", "How To Huge", "Humility", "Humor Hurricane", "Hurry", "Hypnotic Idiot", "Ignite", "Illegal Illusive", "Imagination", "Immediately Imminently", "Impatience", "Impatient Impenetrable", "Important", "Improved In The Zone", "Incapable", "Incapacitated Incompetent", "Inconsiderate", "Increase Incredible", "Indecisive", "Indulgence Indulgent", "Inexpensive", "Inferior Informative", "Infuriated", "Ingredients Innocent", "Innovative", "Insane Insecure", "Insider", "Insider Insidious", "Inspired", "Inspiring Instant Savings", "Instantly", "Instructive Intel", "Intelligent", "Intense Interesting", "Intriguing Introducing", "Invasion", "Investment", "Iron-clad Ironclad", "Irresistible", "Irs Jackpot", "Jail", "Jaw-dropping Jealous", "Jeopardy", "Jittery Jovial", "Joyous", "Jubilant Judgmental", "Jumpstart", "Just Arrived Keen", "Kickass", "Kickstart Know It All", "Lame", "Largest Lascivious", "Last Chance", "Last Minute Last", "Latest", "Laugh Laughing", "Launch", "Launching Lavishly", "Lawsuit", "Left Behind Legendary", "Legitimate", "Liberal Liberated", "Lick", "Lies Life-changing", "Lifetime", "Light Lighthearted", "Likely", "Limited Literally", "Little-known", "Loathsome Lonely", "Looming", "Loser Lost", "Love", "Lunatic Lurking", "Lust", "Luxurious Luxury", "Lying", "Magic Magical", "Magnificent", "Mainstream Malicious", "Mammoth", "Manipulative Marked Down", "Massive", "Maul Mediocre", "Meditative", "Meltdown Memorable", "Menacing", "Mendacious Merely", "Mesmerized", "Mesmerizing Might", "Mind-blowing", "Mindless Miracle", "Miraculous", "Misery Misleading", "Mistake", "Mixed-up Moan", "Modern Money-saving", "Money Mood", "Mood Boosting", "Moody", "More Most", "Motivated Mouthwatering", "Moving", "Murder Mystified", "Na�ve Near-unbeatable", "Negative", "Nervous Newest", "Newly", "Ninja No Commitment", "Noble", "No-cost No-frills", "No-nonsense", "Non-competitive", "Non-judgmental Non-stop", "Notably", "Notorious", "Novelty", "Numb Nutty", "Obnoxious", "Obsessive Obtain", "Ominous", "One-time", "Open", "Optimal", "Optimistic", "Opulent Ordeal", "Organic", "Out of This World Out-of-the-box", "Outclass", "Outlaw", "Outrage", "Outstanding", "Overconfident Overcome", "Overjoyed Overwhelming", "Painstaking Paralyzed", "Pardon", "Parody Passionate", "Pathetic Patient", "Peaceful", "Peerless", "Penetrate Perceived", "Perfect", "Perky Persecuted", "Persuasive", "Petrified Philanthropic", "Picturesque", "Pioneering Pitiful", "Plagued Playful", "Please", "Pleasant", "Pleased", "Pleasing Plummet", "Poised", "Popular", "Positive Possessive", "Powerful", "Powerless", "Practical Preposterous", "Preserved Pretty", "Priceless Pride", "Principled", "Prize", "Productive Profanity", "Profitable", "Profit Progress", "Progressive Prominent", "Promised", "Proven Prying", "Psychological", "Pure", "Purposeful", "Puzzled", "Quake Qualitative", "Quality Quarantine", "Quarrel", "Quell", "Quest Questionable", "Quick", "Quickest", "Quintessential", "Quirky Quit", "Quivering", "Quixotic", "Radiant", "Raging", "Rant", "Rare", "Rational Ravaged", "Raving", "Read", "Real", "Rebel", "Rebellious", "Reckless", "Reconcile", "Redundant", "Refined", "Rejoice", "Relaxed", "Relentless", "Relevant", "Reliable", "Revealed", "Revelatory", "Revenge", "Revitalize", "Revolution", "Reward", "Rich", "Ridiculous", "Rigorous", "Risky", "Riveting", "Robust", "Rock-bottom", "Romantic", "Rotten", "Ruin", "Rule-breaking", "Rush", "Sacred", "Safe", "Sane", "Satisfied", "Scam", "Scandal", "Scandalous", "Scarcity", "Scared", "Scary", "Screaming", "Scrutinize", "Secure", "Self-absorbed", "Selfish", "Selfless", "Sensible", "Sensual", "Sentimental", "Serene", "Serious", "Settled", "Sexy", "Shady", "Shameful", "Shattered", "Shocking", "Shunned", "Simple", "Simplicity", "Sincere", "Sinister", "Sizzling", "Skeleton", "Skillful", "Slammed", "Sleazy", "Slightly", "Sluggish", "Smart", "Smashing", "Sneak Peek", "Sneak", "Soothing", "Sophisticated", "Sorry", "Soulful", "Sound", "Sovereign", "Spam", "Sparkling", "Spectacular", "Speedy", "Spellbinding", "Spiritual", "Splendid", "Spontaneous", "Sporadic", "Spotlight", "Staggering", "Stale", "Star", "Startling", "Stately", "Stealthy", "Stellar", "Stimulating", "Stingy", "Stoked", "Storm", "Strange", "Strategic", "Streamlined", "Strengthened", "Stress", "Striking", "Stubborn", "Stunned", "Stupefied", "Stunning", "Substantial", "Successful", "Suffering", "Suicidal", "Suitable", "Sulky", "Summon", "Super", "Superb", "Superior", "Supportive", "Surpassing", "Surprised", "Surprising", "Survival", "Suspicious", "Sustainable", "Sweet", "Swift", "Sympathetic", "Talented", "Tantalizing", "Tarnished", "Terrible","Terrific", "Thankful", "Thirsty", "Threat", "Thrifty", "Thrilling", "Thrive", "Thwart", "Tidy", "Tight", "Time-limited", "Timeless", "Timely", "Tired", "Titillating", "To Die For", "Tolerant", "Tombstone", "Torn", "Tormented", "Tortured", "Tough", "Toxic", "Tragic", "Traitor", "Tranquil", "Transformative", "Transform", "Transparent", "Traumatic", "Treason", "Treasured", "Trendy", "Triumphant", "True", "Trustworthy", "Truthful", "Turnkey", "Ultimate", "Unbeatable", "Unbelievable", "Unbreakable", "Uncover","Underdog", "Underestimated", "Undeniable", "Undeniably","Undeniably", "Undetectable", "Undeterred", "Undisputed", "Unemotional", "Unfazed", "Unforgettable", "Unforgivable", "Unhindered", "Unique", "United", "Universal", "Unlimited", "Unparalleled", "Unpredictable", "Unquestionably", "Unrivaled", "Unstoppable", "Unthinkable", "Untouched", "Untouched", "Untraceable", "Unwavering", "Unyielding", "Uplifting", "Upset", "Urgent", "Usable", "Valiant", "Valuable", "Vanquish", "Vast", "Venerable", "Vent", "Vibrant", "Victory", "Villain", "Vindicated", "Violent", "Virtue", "Visionary", "Vital", "Vivid", "Volatile", "Wacky", "Wanted", "Warrant", "Wary", "Wasted", "Wavering", "Weak", "Wealthy", "Weapon", "Whimsical", "Whole", "Wicked", "Wild", "Winning", "Witty", "Wonderful", "Worried", "Wretched", "Worthy", "Wow", "Wrath", "Wrathful", "Wreck", "Wrecked", "Wronged", "Yawn", "Yearning", "Yell", "Youthful", "Zealot", "Zero-cost", "new"
            ];
            foreach ($powerarr as $keyword) {
                $powerkeywordtest = stripos($post_title, $keyword);
                $myteto[] = $powerkeywordtest;
                if ($powerkeywordtest !== false) {
                    if($powerkey == "false"){
                        $powerkeyfound = 1;
                        if(!empty($titleseo)){
                           $titleseo = $titleseo - $powerkeyfound;
                        }
                    }
                    break;
                }
            }
            if($powerkeywordtest == false){
                if($powerkey == "true"){
                    $powerkeyfound = 0;
                    $titleseo = $titleseo + 1;
                }
            }
            //check post title contains number
            if (preg_match('/\d/', $post_title)) {
                if($numberkey == "false"){
                    $containsnumber = 1;
                    if(!empty($titleseo)){
                       $titleseo = $titleseo - $containsnumber;
                    }
                }
            } else {
                if($numberkey == "true"){
                    $containsnumber = 0;
                    $titleseo = $titleseo + 1;
                }
            }
            $basicseo = ltrim($basicseo, '-');
            $titleseo = ltrim($titleseo, '-');
            $res = array('status'=>true, 'titleseo'=>$titleseo, 'basicseo'=>$basicseo, 'basictitle'=>$basictitle, 'begintitle'=>$begintitle, 'sagmentfound'=>$sagmentfound, 'powerkeyfound'=>$powerkeyfound, 'containsnumber'=>$containsnumber, 'containsnumber'=>$containsnumber);
        }
    }
    echo json_encode($res);
    die();
}

add_action( 'wp_ajax_komodo_check_postcontent', 'komodo_check_postcontent' );
function komodo_check_postcontent(){
    $res = '';
    $contentreadability = $basicseo = $adfinalseo = 0;
    if(!empty($_POST)){
        if(!empty($_POST['keyword'])){
            $keyword = $_POST['keyword'];
        }
        if(!empty($_POST['postid'])){
            $postid = $_POST['postid'];
        }
        if(!empty($_POST['content'])){
            $content = $_POST['content'];
        }
        if(!empty($_POST['contentreadability'])){
            $contentreadability = $_POST['contentreadability'];
            $mytest= $contentreadability;
        }else{
            $contentreadability = 0;
        }
        if(!empty($_POST['basicseo'])){
            $basicseo = $_POST['basicseo'];
        }else{
            $basicseo = 0;
        }
        if(!empty($_POST['adfinalseo'])){
            $adfinalseo = $_POST['adfinalseo'];
        }else{
            $adfinalseo = 0;
        }

        $basicdesckey = $urlfocuskey = $firstfocuskey = $wordCountkey = $focuskey = $focusimgkey = $keyworddensitykey = $externallinkkey = $parareadabilitykey = $imgcontainkey = $wordCountvar = $imgcontain = 0;

        //Parameters
        if(!empty($_POST['basicdesckey'])){
            $basicdesckey = $_POST['basicdesckey'];
            if($basicdesckey == "true"){
                $basicdesc = 1;
            }
        }
        if(!empty($_POST['parareadabilitykey'])){
            $parareadabilitykey = $_POST['parareadabilitykey'];
            if($parareadabilitykey == "true"){
                $parareadfound = 1;
            }
        }
        if(!empty($_POST['externallinkkey'])){
            $externallinkkey = $_POST['externallinkkey'];
            if($externallinkkey == "true"){
                $externallinkfound = 1;
            }
        }
        if(!empty($_POST['keyworddensitykey'])){
            $keyworddensitykey = $_POST['keyworddensitykey'];
            if($keyworddensitykey == "true"){
                $keyworddensity = 1;
            }
        }
        if(!empty($_POST['focusimgkey'])){
            $focusimgkey = $_POST['focusimgkey'];
            if($focusimgkey == "true"){
                $focusimg = 1;
            }
        }

        if(!empty($_POST['focuskey'])){
            $focuskey = $_POST['focuskey'];
            if($focuskey == "true"){
                $focus = 1;
            }
        }
        if(!empty($_POST['wordCountkey'])){
            $wordCountkey = $_POST['wordCountkey'];
            if($wordCountkey == true){
                $wordCount = 1;
            }
        }
        if(!empty($_POST['firstfocuskey'])){
            $firstfocuskey = $_POST['firstfocuskey'];
            if($firstfocuskey == "true"){
                $firstfocus = 1;
            }
        }
        if(!empty($_POST['urlfocuskey'])){
            $urlfocuskey = $_POST['urlfocuskey'];
            if($urlfocuskey == "true"){
                $urlfocus = 1;
            }
        }
        if(!empty($_POST['basicdesckey'])){
            $basicdesckey = $_POST['basicdesckey'];
            if($basicdesckey == "true"){
                $basicdesc = 1;
            }
        }
        if(!empty($_POST['imgcontainkey'])){
            $imgcontainkey = $_POST['imgcontainkey'];
            if($imgcontainkey == "true"){
                $imgcontain = 1;
            }
        }

        if(!empty($keyword) && !empty($content)){
            $keyarr = explode(',',$keyword);
            /**
             * Basic seo start 
             */
            //Basic SEO Title
            if(!empty($keyarr[0])){
                if( stripos($content, $keyarr[0]) !== false ){
                    if($basicdesckey == "false"){
                        $basicdesc = 1;
                        if(!empty($basicseo)){
                           $basicseo = $basicseo - $basicdesc - $basicdesc;
                        }
                    }
                }else{
                    if($basicdesckey == "true"){
                        $basicdesc = 0;
                        $basicseo = $basicseo + 1;
                    }
                }

                // Find First focus
                $contentLength = strlen($content);
                $wordCount = str_word_count($content);
                $first10PercentLength = ceil($contentLength * 0.1);
                
                $first10PercentContent = substr($content, 0, $first10PercentLength);
                if(strcasecmp($first10PercentContent, $keyarr[0]) !== false){
                    if($firstfocuskey == "false"){
                        $firstfocus = 1;
                        if(!empty($basicseo)){
                                $basicseo = $basicseo - $firstfocus;
                            }
                    }
                }else{
                    if($firstfocuskey == "true"){
                        $li = "test";
                        $firstfocuskey = "false";
                        $firstfocus = 0;
                        $basicseo = $basicseo + 1;
                    }
                }

                //Check focuse keyword in url 
                $keyword1 = str_replace(' ', '-', $keyarr[0]);
                $keyword2 = str_replace(' ', '_', $keyarr[0]);
                if(!empty($postid)){
                    $post_url = get_permalink($postid);
                    $url_path = parse_url($post_url, PHP_URL_PATH);
                    if( stripos($url_path, $keyword1) !== false || stripos($url_path, $keyword2) !== false ){
                        if($urlfocuskey == "false"){
                            $urlfocus = 1;
                            if(!empty($basicseo)){
                                $basicseo = $basicseo - $urlfocus;
                            }
                        }
                    }else{
                        if($urlfocuskey == "true"){
                            $urlfocus = 0;
                            $basicseo = $basicseo + 1;
                        }
                    }
                }

                // wordCount 
                if($wordCount > 600){
                    $wordCountvar = 1;
					$worddesc = 'Content is '. esc_html($wordCount).' words long. Good job!';
                    if($wordCountkey == "false"){
                        if(!empty($basicseo)){
                            $basicseo = $basicseo - $wordCountvar;
                        }
                    }
                }
                else{
                    $wordCountvar = 0;
                    $li = $wordCountkey;
				 	$worddesc = 'Content is '. esc_html($wordCount).' Consider using at least 600 words.';
                    if($wordCountkey == "true"){
                        $li2 = "testdddd";
                        $wordCountvar = 0;
                        $basicseo = $basicseo + 1;
                    }
                }
            }            
            /**
             * Basic seo end 
             *
             * Advance seo Start 
             */
            if(!empty($keyarr[0])){
                //Check Focus Keyword in subheading(s) like H2, H3, H4, etc..
                $pattern = '/<!--.*?-->/s';
                $content = preg_replace($pattern, '', $content);
                $content = str_replace("'", "", $content);
                $search_tags = ['h1', 'h2', 'h3'];
                foreach ($search_tags as $tag) {
                    $pattern = '/<'.$tag.'[^>]*>(.*?)<\/'.$tag.'>/is';
                    if (preg_match_all($pattern, $content, $matches)) {
                        //$h2_arr[] = $matches[1];
                        foreach ($matches[1] as $h2_content) {
                            $h2_arr[] = $h2_content;
                            if(!empty($keyarr[0])){
                                $keyword1 = str_replace(' ', '-', $keyarr[0]);
                                $keyword2 = str_replace(' ', '_', $keyarr[0]);
                                if(strpos($h2_content, $keyarr[0]) !== false || strpos($h2_content, $keyword1) !== false || strpos($h2_content, $keyword2 ) !== false ){
                                    if($focuskey == "false"){
                                        $focuskey = "true";
                                        $focus = 1;
                                        if(!empty($adfinalseo)){
                                            $adfinalseo = $adfinalseo - $focus;
                                        }
                                    }
                                }else{
                                    if($focuskey == "true"){
                                        $focus = 0;
                                        $focuskey = "false";
                                        $adfinalseo = $adfinalseo + 1;
                                    }
                                }
                            }
                            if($focus == 1){
                                break;
                            }
                        }
                    }
                }
                    
                if(empty($matches)){
                    if($focuskey == "true"){
                        $focus = 0;
                        $adfinalseo = $adfinalseo + 1;
                    }
                } 

                // Check image alt tag
                $pattern = '/<img[^>]+alt=["\']([^"\']+)["\'][^>]*>/i';
                if (preg_match_all($pattern, stripcslashes($content), $matches)) {
                    $matches_div = $matches;               
                    foreach ($matches as $match) {
                        //$alt_text = $match;
                        if(!empty($keyarr[0])){
                            $keyword1 = str_replace(' ', '-', $keyarr[0]);
                            $keyword2 = str_replace(' ', '_', $keyarr[0]);
                            
                            if(in_array($keyarr[0], $match) || in_array($keyword1, $match) || in_array($keyword2, $match)){
                                if($focusimgkey == "false"){
                                    $focusimg = 1;
                                    $adfinalseo = $adfinalseo - 1;
                                }
                            }
                        }
                    }
                }
                if(empty($matches_div)){
                    if($focusimgkey == "true"){
                        $focusimg = 0;
                        $adfinalseo = $adfinalseo + 1;
                    }
                }

                // Keyword Density
                if(!empty($content)){
                
                    $totalWords = str_word_count($content);
                    if(!empty($keyarr[0]) && !empty($content)){
                        $keywordCount = substr_count(strtolower($content), strtolower($keyarr[0]));
                        $density = ($keywordCount / $totalWords) * 100;
                        $density_intwo = number_format((float)$density, 2, '.', '');
                    }
                }
                if($density == 0){
                    if($keyworddensitykey == "true"){
                        $keyworddensity = 0;
                        $adfinalseo = $adfinalseo + 1;
                    }
                    $keywordtext = 'Keyword Density is 0. Aim for around 1% Keyword Density.';
                }elseif($density >0.78 && $density <2.78){
                    if($keyworddensitykey == "false"){
                        $keyworddensity = 1;
                        $adfinalseo = $adfinalseo - $keyworddensity;
                    }
					$keywordtext = 'Keyword Density is '.$density_intwo.', the Focus Keyword and combination appears '.$keywordCount.' times.';
					$jhk = $keywordtext;
                }elseif($density > 2.78){
                    if($keyworddensitykey == "true"){
                        $keyworddensity = 0;
                        $adfinalseo = $adfinalseo + 1;
                    }
                    $keywordtext = 'Keyword Density is '.$density_intwo.', the Focus Keyword and combination appears '.$keywordCount.' times.';
                }else{
                    if($keyworddensitykey == "true"){
                        $keyworddensity = 0;
                        $adfinalseo = $adfinalseo + 1;
                    }
                    $keywordtext = 'Keyword Density is '.$density_intwo.', the Focus Keyword and combination appears '.$keywordCount.' times.';
                }

                //External Url 
                $currentdomain = get_site_url();
                $pattern = '/\bhttps?:\/\/\S+/i';

                // Perform the search
                if (preg_match_all($pattern, $content, $matches)) {
                    foreach($matches[0] as $match_child){
                        if($externallinkkey == 'false'){
                            $externallinkfound = 1;
                            if(!empty($adfinalseo)){
                                $adfinalseo = $adfinalseo - 2;
                            }
                        }
                        break;
                    }
                }else{
                    if($externallinkkey == 'true'){
                        $internallink = 0;
                        $externallinkfound = 0;
                        $adfinalseo = $adfinalseo + 1;
                    }
                }

                /**
                 * Advance seo end
                 * 
                 * Content readability start
                 */
                $paragraph_readability = 0;
                $pattern = '/<img[^>]+>/i';
                if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
                    if(!empty($matches[0])){
                        if($imgcontainkey == 'false'){
                            $imgcontain = 1;
                            if(!empty($contentreadability)){
                                $contentreadability = $contentreadability - $imgcontain;
                            }
                        }
                    }
                }else{
                    if($imgcontainkey == 'true'){
                        $imgcontain = 0;
                        $contentreadability = $contentreadability + 1;
                    }
                }

                //Check large paragraph 

                $content_with_paragraphs = wpautop($content);
                $paragraphs = explode('</p>', strip_tags($content_with_paragraphs, '<p>'));

                // Clean up any empty paragraphs
                $paragraphs = array_filter($paragraphs, 'trim');
                if(!empty($paragraphs)){
                    foreach($paragraphs as $para){
                        $word_count = str_word_count($para);
                        if($word_count < 120){
                            $parapraph_limit[] = 1;
                        }else{
                            $parapraph_limit[] = 0;
                        }
                    }
                    if (in_array(0, $parapraph_limit, true)) {
						$paragraph_readability = 1;
                        if($parareadabilitykey == "true"){
                            if(!empty($contentreadability)){
                                $contentreadability = $contentreadability - 1;
                            }
                        }
                    } else {
						$paragraph_readability = 1;
                        if($parareadabilitykey == "false"){
                            $paragraph_readability = 1;
                            $contentreadability = $contentreadability + 1;
                        }
                    }
                }
            }

            $res = array('status'=>true, 'basicseo'=>$basicseo, 'adfinalseo'=>$adfinalseo, 'contentreadability'=>$contentreadability, 'basicdesc'=>$basicdesc, 'firstfocus'=>$firstfocus, 'urlfocus'=>$urlfocus, 'wordCountvar'=>$wordCountvar, 'focus'=>$focus, 'focusimg'=>$focusimg, 'keyworddensity'=> $keyworddensity, 'externallinkfound'=>$externallinkfound, 'imgcontain'=>$imgcontain, 'paragraph_readability'=>$paragraph_readability, 'keywordtext'=> $keywordtext, 'worddesc'=>$worddesc, 'test'=>$li, 'test2'=>$li2 );
        }
    }else{
        $basicseo = 5;
        $adfinalseo = 5;
        $contentreadability = 2;
        $basicdesckey = $urlfocuskey = $firstfocuskey = $wordCountkey = $focuskey = $focusimgkey = $keyworddensitykey = $externallinkkey = $parareadabilitykey = $imgcontainkey = 0;

        $res = array('status'=>false, 'basicseo'=>$basicseo, 'adfinalseo'=>$adfinalseo, 'contentreadability'=>$contentreadability, 'basicdesc'=>$basicdesc, 'firstfocus'=>$firstfocus, 'urlfocus'=>$urlfocus, 'wordCountvar'=>$wordCountvar, 'focus'=>$focus, 'focusimg'=>$focusimg, 'keyworddensity'=> $keyworddensity, 'externallinkfound'=>$externallinkfound, 'imgcontain'=>$imgcontain, 'paragraph_readability'=>$paragraph_readability );
    }
    echo json_encode($res);
    die();
}

add_action('admin_footer', 'komodo_add_custom_button_admin_footer');
function komodo_add_custom_button_admin_footer() {
    $current_screen = get_current_screen();
    if ($current_screen && ($current_screen->id === 'post' || $current_screen->id === 'page')) {
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Create a new button element
            var customButton = '<a href="javascript:;" class="rys_btn_head komodo-seo-btn"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="17" height="17" x="0" y="0" viewBox="0 0 486.742 486.742" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M33 362.371v78.9c0 4.8 3.9 8.8 8.8 8.8h61c4.8 0 8.8-3.9 8.8-8.8v-138.8l-44.3 44.3c-9.4 9.3-21.4 14.7-34.3 15.6zM142 301.471v139.8c0 4.8 3.9 8.8 8.8 8.8h61c4.8 0 8.8-3.9 8.8-8.8v-82.3c-13.9-.3-26.9-5.8-36.7-15.6l-41.9-41.9zM251 350.271v91c0 4.8 3.9 8.8 8.8 8.8h61c4.8 0 8.8-3.9 8.8-8.8v-167.9l-69.9 69.9c-2.7 2.7-5.6 5-8.7 7zM432.7 170.171l-72.7 72.7v198.4c0 4.8 3.9 8.8 8.8 8.8h61c4.8 0 8.8-3.9 8.8-8.8v-265.6c-2-1.7-3.5-3.2-4.6-4.2l-1.3-1.3z" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></path><path d="M482.6 41.371c-2.9-3.1-7.3-4.7-12.9-4.7h-1.6c-28.4 1.3-56.7 2.7-85.1 4-3.8.2-9 .4-13.1 4.5-1.3 1.3-2.3 2.8-3.1 4.6-4.2 9.1 1.7 15 4.5 17.8l7.1 7.2c4.9 5 9.9 10 14.9 14.9l-171.6 171.7-77.1-77.1c-4.6-4.6-10.8-7.2-17.4-7.2-6.6 0-12.7 2.6-17.3 7.2L7.2 286.871c-9.6 9.6-9.6 25.1 0 34.7l4.6 4.6c4.6 4.6 10.8 7.2 17.4 7.2s12.7-2.6 17.3-7.2l80.7-80.7 77.1 77.1c4.6 4.6 10.8 7.2 17.4 7.2 6.6 0 12.7-2.6 17.4-7.2l193.6-193.6 21.9 21.8c2.6 2.6 6.2 6.2 11.7 6.2 2.3 0 4.6-.6 7-1.9 1.6-.9 3-1.9 4.2-3.1 4.3-4.3 5.1-9.8 5.3-14.1.8-18.4 1.7-36.8 2.6-55.3l1.3-27.7c.3-5.8-1-10.3-4.1-13.5z" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></path></g></svg><span class="mathpercent"> RYS SEO</span></a>';
            
            // Append the custom button after the "Add New Post" button
            $('.page-title-action').after(customButton);
        });
        </script>
        <?php
    }
}

add_action('template_redirect', 'komodo_404_redirection');
function komodo_404_redirection() {
    global $wpdb;

    // Check if we are on a 404 error page
    if (is_404()) {
        $requested_url = esc_url($_SERVER['REQUEST_URI']);
        $redirect_url = ''; // Initialize redirect URL

        // Implement your custom logic to determine the redirect URL
        // Example: redirect all 404 errors to the homepage
        $redirect_url = home_url('/');

        // Insert the redirection into the database
        $table_name = $wpdb->prefix . 'rys_redirects';
        $wpdb->insert($table_name, array(
            'requested_url' => $requested_url,
            'redirect_url' => $redirect_url,
            'created_at' => current_time('mysql'),
        ));

        // Perform the redirection
        wp_redirect($redirect_url, 301);
        exit;
    }
}

/**
 * Cleanup old data of 404
 */
 
// Schedule the event on plugin activation or theme activation
function komodo_schedule_cleanup_event() {
    if (! wp_next_scheduled('komodo_cleanup_event')) {
        wp_schedule_event(time(), 'daily', 'komodo_cleanup_event');
    }
}
register_activation_hook(__FILE__, 'komodo_schedule_cleanup_event');

// Hook the cleanup function to the scheduled event
add_action('komodo_cleanup_event', 'cleanup_old_redirects');
function cleanup_old_redirects() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'rys_redirects';

    // Delete redirects older than 30 days
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM $table_name WHERE created_at < DATE_SUB(NOW(), INTERVAL %d DAY)",
            30
        )
    );
}

// Deactivate hook after on plugins deactivation
register_deactivation_hook(__FILE__, 'komodo_unschedule_cleanup_event');

function komodo_unschedule_cleanup_event() {
    wp_clear_scheduled_hook('komodo_cleanup_event');
}

//Update alt tag
function add_image_alt_title_tags($post_id) {
    if (get_post_type($post_id) === 'attachment') {
        $image = get_post($post_id);
        $image_meta = wp_get_attachment_metadata($post_id);
        $alttext = get_post_meta($post_id, '_wp_attachment_image_alt', true);
        if(empty($alttext)){
            if (!empty($image->post_excerpt)) {
                // ALT text from post_excerpt if available
                $alt_text = $image->post_excerpt;
            } else {
                // Use image filename as ALT text
                $alt_text = pathinfo($image->guid, PATHINFO_FILENAME);
            }
            $site_title = get_bloginfo('name'); 
            $modified_site_title = str_replace(' ', '-', $site_title);
            $alt_text = $modified_site_title.$alt_text;
            // Update ALT and TITLE tags
            update_post_meta($post_id, '_wp_attachment_image_alt', $alt_text);
            update_post_meta($post_id, '_wp_attachment_title', $alt_text);
        }
    }
}

//Add ranking option on all post page

// Add a new column to the post list table
function add_custom_column_to_posts($columns) {
    $columns['rys_details'] = __('RYS Details'); // You can name the column anything
    return $columns;
}
add_filter('manage_posts_columns', 'add_custom_column_to_posts');
add_filter('manage_pages_columns', 'add_custom_column_to_posts');

// Display content in the custom column
function display_custom_column_content($column, $post_id) {
	
	$keyword = get_post_meta($post_id, '_komodo_focuskeyword', true);
	$percent = get_post_meta($post_id, '_komodo_postpercent', true);
    $arr = explode("/", $percent, 2);
    $first = $arr[0];

    $exclass= '';
    if( $first < 40 ){
        $exclass = 'has-low-rank';
    }elseif( $first > 40 && $first < 80 ){
        $exclass = 'has-mid-rank';
    }else{
        $exclass = 'has-high-rank';
    }
    if ($column == 'rys_details') {
        // Example: Get the content word count
        if(!empty($percent)){
            echo '<span class="rys-column-display seo-score no-score ">
                <strong class="'.$exclass.'">'.$percent.'</strong>
            </span>';
        }else{
            echo '<span class="rys-column-display seo-score no-score ">
                <strong>N/A</strong>
            </span>';
        }

		echo '<label>Focus Keyword:</label>
		<span class="rys-column-display">
			<strong title="Focus Keyword">Keyword: </strong>';
			if(!empty($keyword)){
				echo '<span>'.$keyword.'</span>';
			}else{
				echo '<span>Not Set</span>';
			}
		echo '</span>

		<input type="hidden" class="rys-column-value" data-field="focus_keyword" tabindex="11" value="">

		<span class="rys-column-display schema-type">
			<strong>Schema: </strong>';
            if(get_post_type() == 'page'){
                echo 'Article';	
            }else{
			    echo 'Article (BlogPosting)';	
            }	
		echo '</span>';
    }
}
add_action('manage_posts_custom_column', 'display_custom_column_content', 10, 2);
add_action('manage_pages_custom_column', 'display_custom_column_content', 10, 2);

// Make the Word Count column sortable
function make_custom_column_sortable($columns) {
    $columns['rys_details'] = 'rys_details';
    return $columns;
}
add_filter('manage_edit-post_sortable_columns', 'make_custom_column_sortable');
add_filter('manage_edit-page_sortable_columns', 'make_custom_column_sortable');

// Sort posts by Word Count when the column is clicked
function custom_column_sorting($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->get('orderby') == 'rys_details') {
        $query->set('meta_key', 'rys_details');  // If sorting by a custom meta field
        $query->set('orderby', 'meta_value_num');
    }
}
add_action('pre_get_posts', 'custom_column_sorting');

//Add sidebar slide html in footer
add_action('admin_footer', 'my_admin_footer_function');
function my_admin_footer_function(){
    $id = get_the_id();
    if(!empty($id)){
        $komodo_focuskeyword = get_post_meta($id, '_komodo_focuskeyword', true);
        $focuskeywordarr = explode(',', $komodo_focuskeyword);
        /**
         * Check SEO Parameter
         */
        $basicseo = 6;
        $finalseo = 6;
        $basictitle = $basicdesc = $firstfocus = $urlfocus = $wordCount = $wordCountvar = '0';
        global $post;

        // Get the post object
        //$post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : 0);
        $post = get_post($id);

        // Get the post title
        $post_title = get_the_title($post);
        if(!empty($focuskeywordarr[0])){
            if( stripos($post_title, $focuskeywordarr[0]) !== false ){
                $basictitle = 1;
            }else{
                $basictitle = 0;
            }
        }else{
            $basictitle = 0;
        }
        
        // Get the post Description
        $post_content = get_the_content($post);
        if(!empty($focuskeywordarr[0])){
            if( stripos($post_content, $focuskeywordarr[0]) !== false ){
                $basicdesc = 1;
            }else{
                $basicdesc = 0;
            }
        }else{
            $basictitle = 0;
        }
        
        // Check first word is foucus word or not
        $contentLength = strlen($post_content);
        
        $wordCount = str_word_count($post_content);
        if($wordCount != 0){
            $wordCountvar = 1;
        }
        // Calculate the length of the first 10% of the content
        $first10PercentLength = ceil($contentLength * 0.1);
        
        // Extract the first 10% of the content
        $first10PercentContent = substr($post_content, 0, $first10PercentLength);
        if(!empty($focuskeywordarr[0])){
            if(strcasecmp($first10PercentContent, $focuskeywordarr[0]) !== false){
                $firstfocus = 1;
            }else{
                $firstfocus = 0;
            }
        }else{
            $basictitle = 0;
        }

        //check focuse keyword in url 
        $keyword1 = str_replace(' ', '-', $focuskeywordarr[0]);
        $keyword2 = str_replace(' ', '_', $focuskeywordarr[0]);

        $post_url = get_permalink($post);
        
        $url_path = parse_url($post_url, PHP_URL_PATH);
        if(!empty($focuskeywordarr[0])){
            if( stripos($url_path, $keyword1) !== false || stripos($url_path, $keyword2) !== false ){
                $urlfocus = 1;
            }else{
                $urlfocus = 0;
            }
        }else{
            $urlfocus = 0;
        }

        $finalseo = $basicseo - $urlfocus - $firstfocus - $basicdesc - $basicdesc - $basictitle - $wordCountvar;
        
        ?>
        <div class="komodo-seocon-wrapper">
            <div class="seo-modal-cls-btn"></div>
            <div id="tags-input">
                <label for="komodo_focuskeyword">Focus Keyword</label>
                <div class="tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg>
                  <span class="tooltiptext">To assess the SEO, please input the keyword and press enter.</span>
                </div>
                <input type="text" id="komodo-focuskeyword" placeholder="Example: Are You Ready to Improve Your Sleep Quality" /> 
                <div id="komodo-list">
                    <?php
                        if (!empty($focuskeywordarr)) {
                            foreach ($focuskeywordarr as $komodo_focuskeyword_child) {
                                if(!empty($komodo_focuskeyword_child)){
                                    echo '<div class="tag-item">' . esc_html($komodo_focuskeyword_child) . '<span class="tag-remove">x</span></div>';
                                }
                            }
                        }
                    ?>
                <!-- </div> -->
                <input type="hidden" id="komodo_focuskeyword" name="komodo_focuskeyword"  class="komodo_focuskeyword" value="<?php echo esc_attr($komodo_focuskeyword); ?>">
            </div>

            <section class="kb-accordion">
                <div class="kb-tab">
                    <input type="checkbox" name="accordion-1" id="cb1" checked>
                    <?php if($finalseo == 0){ ?>
                    <label for="cb1" class="cb1 kb-tab__label kb-accordian-tab-green">Core SEO 
                        <span >All Good </span>
                    </label>
                    <?php
                    }else{ ?>
                    <label for="cb1" class="cb1 kb-tab__label kb-accordian-tab-red">Core SEO 
                        <span>Error <b class="komodo-basicseo"><?php echo $finalseo; ?></b> </span>
                    </label>
                    <?php } ?>

                    <div class="kb-tab__content">
                        <ul>
                        <?php if($basictitle != 1){ ?>
                            <li class="basictitle"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                <div>
                                Place the focus keyword in the SEO title.
                                <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_title" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                </div>
                            </li>
                        <?php }else{ ?>
                            <li class="basictitle"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                <div>
                                Place the focus keyword in the SEO title.
                                <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_title" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                </div>
                            </li>
                        <?php } 
                        if($basicdesc != 1){
                        ?>
                            <li class="basicdesc"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                <div>
                                Place the focus keyword within SEO meta description.
                                <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_md" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                </div>
                            </li>
                        <?php }else{
                            ?>
                            <li class="basicdesc"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                <div>
                                Place the focus keyword within SEO meta description.
                                <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_md" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                </div>
                            </li>
                            <?php
                        } 
                        if($urlfocus != 1){ 
                        ?>
                            <li class="urlfocus"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                <div>
                                Embed the focus keyword in the URL.
                                <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_url" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                </div>
                            </li>
                        <?php }else{ ?>
                            <li class="urlfocus"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                <div>
                                Embed the focus keyword in the URL.
                                <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_url" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                </div>
                            </li>
                        <?php
                        }
                        if($firstfocus != 1){ ?>
                            <li class="firstfocus"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                <div>
                                Focus keyword is included in the first portion of the content.
                                <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_text" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                </div>
                            </li>
                        <?php }else{ ?>
                            <li class="firstfocus"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                <div>
                                Focus keyword is included in the first portion of the content.
                                <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_text" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                </div>
                            </li>
                        <?php 
                        }
                        if($basicdesc != 1){
                        ?>
                            <li class="basicdesc"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                <div>
                                Include the focus keyword within the text.
                                <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_wtext" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                </div>
                            </li>
                        <?php }else{ ?>
                            <li class="basicdesc"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                <div>
                                Include the focus keyword within the text.
                                <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_wtext" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                </div>
                            </li>
                        <?php } ?>
                        <?php if($wordCount < 600){ ?>
                            <li class="wordCount"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                <div>
                                <span class="contentofwordcount">
                                Content is <?php echo esc_html($wordCount); ?> words long. Consider using at least 600 words.
                                </span>
                                <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#content_limit" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                </div>
                            </li>
                        <?php }else{ ?>
                            <li class="wordCount"> 
                                <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                <div>
                                <div>
                                <span class="contentofwordcount">
                                Content is <?php echo esc_html($wordCount); ?> words long. Good job!
                                </span>
                                <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#content_limit" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                </div>
                            </div>
                            </li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php

               // $post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : 0);
                $post = get_post($id);
                $post_content = get_the_content($post);
                $pattern = '/<!--.*?-->/s';
                $post_content = preg_replace($pattern, '', $post_content);
                $post_content = str_replace("'", "", $post_content);
                $adfinalseo = 5;
                $ad_focus_key = '0';
                $word_to_find = $focuskeywordarr[0];

                //CHECK Focus Keyword in subheading(s) like H2, H3, H4, etc..
                $search_tags = ['h1', 'h2', 'h3'];
                $internallink = $externallink = $focusimg = $focuskeyword = $keyworddensity = $keywordtext = $externallink = $density = $density_intwo = $keywordCount = 0;
                foreach ($search_tags as $tag) {
                    $pattern = '/<'.$tag.'[^>]*>(.*?)<\/'.$tag.'>/is';
                    if (preg_match_all($pattern, $post_content, $matches)) {
                        foreach ($matches[1] as $h2_content) {
                            if(!empty($focuskeywordarr[0])){
                                $keyword1 = str_replace(' ', '-', $focuskeywordarr[0]);
                                $keyword2 = str_replace(' ', '_', $focuskeywordarr[0]);
                                if(strpos($h2_content, $focuskeywordarr[0]) !== false || strpos($h2_content, $keyword1) !== false || strpos($h2_content, $keyword2) !== false ){
                                    $focuskeyword = 1;
                                }
                            }
                        }
                    } 
                }

                // Check image alt tag
                $pattern = '/<img[^>]+alt=["\']([^"\']+)["\'][^>]*>/i';
                if (preg_match_all($pattern, $post_content, $matches, PREG_SET_ORDER)) {
                    $matches_div = $matches;               
                    foreach ($matches as $match) {
                        //$alt_text = $match;
                        if(!empty($focuskeywordarr[0])){
                            $keyword1 = str_replace(' ', '-', $focuskeywordarr[0]);
                            $keyword2 = str_replace(' ', '_', $focuskeywordarr[0]);
                            
                            if(in_array($focuskeywordarr[0], $match) || in_array($keyword1, $match) || in_array($keyword2, $match)){
                                //if($focusimgkey == "false"){
                                    $focusimg = 1;
                                //}
                            }
                        }
                    }
                }
                
                if(empty($matches_div)){
                    //if($focusimgkey == "true"){
                        $focusimg = 0;
                    //}
                }
                // Keyword Density
                if(!empty($post_content)){
                
                    $totalWords = str_word_count($post_content);
                    if(!empty($focuskeywordarr[0]) && !empty($post_content)){
                        $keywordCount = substr_count(strtolower($post_content), strtolower($focuskeywordarr[0]));
                        $density = ($keywordCount / $totalWords) * 100;
                        $density_intwo = number_format((float)$density, 2, '.', '');
                    }
                }
                if($density == 0){
                    $keyworddensity = 0;
                    $keywordtext = 'Keyword Density is 0. Aim for around 1% Keyword Density.';
                }elseif($density >0.78 && $density <2.78){
                    $keyworddensity = 1;
                    $keywordtext = 'Keyword Density is '.$density_intwo.', the Focus Keyword and combination appears '.$keywordCount.' times.';
                }elseif($density >2.78){
                    $keyworddensity = 0;
                    $keywordtext = 'Keyword Density is '.$density_intwo.', the Focus Keyword and combination appears '.$keywordCount.' times.';
                }else{
                    $keyworddensity = 0;
                    $keywordtext = 'Keyword Density is '.$density_intwo.', the Focus Keyword and combination appears '.$keywordCount.' times.';
                }

                //External Url 
                $currentdomain = get_site_url();
                $pattern = '/\bhttps?:\/\/\S+/i';

                // Perform the search
                if (preg_match_all($pattern, $post_content, $matches)) {
                    
                    foreach($matches[0] as $match_child){
                        if(str_contains($match_child, $currentdomain)){
                            $internallink = 1;
                        }else{
                            $externallink = 1;
                        }
                    }
                }
                $adfinalseo = $adfinalseo - $focuskeyword - $focusimg - $keyworddensity - $externallink - $externallink;
                ?>
                <div class="kb-tab">
                    <input type="checkbox" name="accordion-1" id="cb2" >
                    <?php if($adfinalseo == 0){ ?>
                    <label for="cb2" class="cb2 kb-tab__label kb-accordian-tab-green">Extended 
                        <span >All Good </span>
                    </label>
                    <?php
                    }else{ ?>
                    <label for="cb2" class="cb2 kb-tab__label kb-accordian-tab-red">Extended
                        <span> Error <b class="komodo-adfinalseo"><?php echo $adfinalseo; ?></b></span>
                    </label>
                    <?php } ?>

                    <div class="kb-tab__content">
                        <ul>
                            <?php if($focuskeyword == 1){ ?>
                                <li class="focuskeyword"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                    <div>
                                    Focus keyword used in the subheading(s).
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_subhead" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php }else{ ?>
                                <li class="focuskeyword"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                    <div>
                                    Use Focus Keyword in subheading(s) like H2, H3, H4, etc..
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_subhead" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php } ?>

                            <?php if($focusimg == 1){ ?>
                                <li class="focusimg"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                    <div>
                                    Place an image and assign the focus keyword as alt text.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_altext" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php }else{ ?>
                                <li class="focusimg"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                    <div>
                                    Place an image and assign the focus keyword as alt text.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#focus_key_altext" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php } ?>

                            <?php if($keyworddensity == 1){ ?>
                                <li class="keyworddensity">
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                    <div>
                                    <span class="contentofkeyword"><?php echo $keywordtext; ?></span>
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#kd" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php }else{ ?>
                                <li class="keyworddensity"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                    <div>
                                    <span class="contentofkeyword"><?php echo $keywordtext; ?></span>
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#kd" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php } ?>

                            <?php if($externallink == 1){ ?>
                                <li class="externallink"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                    <div>
                                    Direct users to outside resources.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#direct_users" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php }else{ ?>
                                <li class="externallink"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                    <div>
                                    Direct users to outside resources.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#direct_users" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php } ?>
                            <?php if($externallink == 1){ ?>
                                <li class="externallink"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                    <div>
                                    Use DoFollow links to link to external sources.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#dofollow_links" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php }else{ ?>
                                <li class="externallink"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                    <div>
                                    Use DoFollow links to link to external sources.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#dofollow_links" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php 
                $titleseo = 4;
                $post_title = get_the_title($post);
                $keyword = $focuskeywordarr[0];
                if(!empty($focuskeywordarr[0])){
                    // Begin Word
                    if (stripos($post_title, $keyword) >= 0 && stripos($post_title, $keyword) <= 10 && stripos($post_title, $keyword) != "") {
                        $begintitle = 1;
                    } else {
                        $begintitle = 0;
                    }
                }else {
                    $begintitle = 0;
                }

                // POSITIVE OR NAGATIVE SAGMENT
                $keywords = ["good", "bad", "not", "yes", "no"];

                $sagmentfound = 0;
                foreach ($keywords as $keyword) {
                    if (strpos($post_title, $keyword) !== false) {
                        $sagmentfound = 1;
                        break;
                    }
                }

                //  Power Keyword
                $powerarr = [
                    "A Cut Above", "Absolute", "Absolutely Lowest Absolutely", "Absurd", "Abuse Accurate", "Accuse", "Achieve Actionable", "Adaptable", "Adequate Admit", "Adorable", "Advantage Advice", "Affordable", "Aggravate Aggressive", "Agitated", "Agonizing Agony", "Alarmed", "Alarming Alienated", "Aligned", "All-inclusive Alluring", "Always", "Amazing Amp", "Animated", "Annihilate Announcing", "Anonymous", "Antagonistic Anxious", "Apocalypse", "Appalled Approved", "Approving", "Argumentative Armageddon", "Arrogant", "Ass Kicking Assault", "Assured", "Astonishing Astounded", "Astounding", "At Ease Atrocious", "Attractive", "Audacity Authentic", "Authoritative", "Authority Aware", "Awe-inspiring", "Awesome Awkward", "Backbone", "Backdoor Backed", "Backlash", "Backstabbing Badass", "Balanced", "Banned Bargain", "Barrage", "Basic Battle", "Beaming", "Beat Down Beating", "Beautiful", "Beauty Begging", "Behind The Scenes", "Belief Best-selling", "Best", "Better Beware", "Big", "Billion Black Market", "Blacklisted", "Blast Blessed", "Blinded", "Blissful Blood", "Bloodbath", "Bloodcurdling Bloody", "Blunder", "Blushing Bold", "Bomb", "Bona Fide Bonanza", "Bonus", "Bootleg Bottom Line", "Bountiful", "Brave Bravery", "Brazen", "Break Breaking", "Breakthrough", "Breathtaking Bright", "Brilliant", "Broke Brutal","Budget", "Buffoon Bullshit", "Bully", "Bumbling Buy", "Cadaver", "Calm Cancel Anytime", "Capable", "Captivate Captivating", "Carefree", "Case Study Cash", "Cataclysmic", "Catapult Catastrophe", "Caution", "Censored Centered", "Certain", "Certainly Certified", "Challenge", "Charming Cheap", "Cheat-sheet", "Cheat Cheer", "Cheerful", "Child-like Clarity", "Classified", "Clear Clueless", "Collapse", "Colorful Colossal", "Comfortable", "Compare Competitive", "Complete", "Completely Completeness", "Comprehensive", "Compromise Compulsive", "Concealed", "Conclusive Condemning", "Condescending", "Confess Confession", "Confessions", "Confident Confidential", "Conquer", "Conscientious Constructive", "Content", "Contrary Controlling", "Controversial", "Convenient Convert", "Cooperative", "Copy Corpse", "Corrupt", "Corrupting Courage", "Courageous", "Cover-up Covert", "Coward", "Cowardly Crammed", "Crave", "Crazy Creative", "Cringeworthy", "Cripple Crisis", "Critical", "Crooked Crush", "Crushing", "Damaging Danger", "Dangerous", "Daring Dazzling", "Dead", "Deadline Deadly", "Death", "Decadent Deceived", "Deceptive", "Defiance Definitely", "Definitive", "Defying Dejected", "Delicious", "Delight Delighted", "Delightful", "Delirious Delivered", "Deplorable", "Depraved Desire", "Desperate", "Despicable Destiny", "Destroy", "Detailed Devastating", "Devoted", "Diagnosed Direct", "Dirty", "Disadvantages Disastrous", "Discount", "Discover Disdainful", "Disempowered", "Disgusted Disgusting", "Dishonest", "Disillusioned Disoriented", "Distracted", "Distraught Distressed", "Distrustful", "Divulge Document", "Dollar", "Doomed Double", "Doubtful", "Download Dreadful", "Dreamy", "Drive Drowning", "Dumb", "Dynamic Eager", "Earnest", "Easily Easy", "Economical", "Ecstatic Edge", "Effective", "Efficient Effortless", "Elated", "Eliminate Elite", "Embarrass", "Embarrassed Emergency", "Emerging", "Emphasize Empowered", "Enchant", "Encouraged Endorsed", "Energetic", "Energy Enormous", "Enraged", "Enthusiastic Epic", "Epidemic", "Essential Ethical", "Euphoric", "Evil Exactly", "Exasperated", "Excellent Excited", "Excitement", "Exciting Exclusive", "Exclusivity", "Excruciating Exhilarated", "Expensive", "Expert Explode", "Exploit", "Explosive Exposed", "Exquisite", "Extra Extraordinary", "Extremely", "Exuberant Eye-opening", "Fail-proof", "Fail Failure", "Faith", "Famous Fantasy", "Fascinating", "Fatigued Faux Pas", "Fearless", "Feast Feeble", "Festive", "Fierce Fight", "Final", "Fine Fired", "First Ever", "First Flirt", "Fluid", "Focus Focused", "Fool", "Fooled Foolish", "Forbidden", "Force-fed Forever", "Forgiving", "Forgotten Formula", "Fortune", "Foul Frantic", "Free", "Freebie Freedom", "Frenzied", "Frenzy Frightening", "Frisky", "Frugal Frustrated", "Fulfill", "Fulfilled Full", "Fully", "Fun-loving Fundamentals", "Funniest", "Funny Furious", "Gambling", "Gargantuan Genius", "Genuine", "Gift Gigantic", "Giveaway", "Glamorous Gleeful", "Glorious", "Glowing Gorgeous", "Graceful", "Grateful Gratified", "Gravity", "Greatest Greatness", "Greed", "Greedy Grit", "Grounded", "Growth Guaranteed", "Guilt-free", "Guilt Gullible", "Guts", "Hack Happiness", "Happy", "Harmful Harsh", "Hate", "Have You Heard Havoc", "Hazardous", "Healthy Heart", "Heartbreaking", "Heartwarming Heavenly", "Helpful", "Helplessness Hero", "Hesitant", "Hidden High Tech", "Highest", "Highly Effective Hilarious", "Hoak", "Hoax Holocaust", "Honest", "Honored Hope", "Hopeful", "Horrific Horror", "Hostile", "How To Huge", "Humility", "Humor Hurricane", "Hurry", "Hypnotic Idiot", "Ignite", "Illegal Illusive", "Imagination", "Immediately Imminently", "Impatience", "Impatient Impenetrable", "Important", "Improved In The Zone", "Incapable", "Incapacitated Incompetent", "Inconsiderate", "Increase Incredible", "Indecisive", "Indulgence Indulgent", "Inexpensive", "Inferior Informative", "Infuriated", "Ingredients Innocent", "Innovative", "Insane Insecure", "Insider", "Insider Insidious", "Inspired", "Inspiring Instant Savings", "Instantly", "Instructive Intel", "Intelligent", "Intense Interesting", "Intriguing Introducing", "Invasion", "Investment", "Iron-clad Ironclad", "Irresistible", "Irs Jackpot", "Jail", "Jaw-dropping Jealous", "Jeopardy", "Jittery Jovial", "Joyous", "Jubilant Judgmental", "Jumpstart", "Just Arrived Keen", "Kickass", "Kickstart Know It All", "Lame", "Largest Lascivious", "Last Chance", "Last Minute Last", "Latest", "Laugh Laughing", "Launch", "Launching Lavishly", "Lawsuit", "Left Behind Legendary", "Legitimate", "Liberal Liberated", "Lick", "Lies Life-changing", "Lifetime", "Light Lighthearted", "Likely", "Limited Literally", "Little-known", "Loathsome Lonely", "Looming", "Loser Lost", "Love", "Lunatic Lurking", "Lust", "Luxurious Luxury", "Lying", "Magic Magical", "Magnificent", "Mainstream Malicious", "Mammoth", "Manipulative Marked Down", "Massive", "Maul Mediocre", "Meditative", "Meltdown Memorable", "Menacing", "Mendacious Merely", "Mesmerized", "Mesmerizing Might", "Mind-blowing", "Mindless Miracle", "Miraculous", "Misery Misleading", "Mistake", "Mixed-up Moan", "Modern Money-saving", "Money Mood", "Mood Boosting", "Moody", "More Most", "Motivated Mouthwatering", "Moving", "Murder Mystified", "Na�ve Near-unbeatable", "Negative", "Nervous Newest", "Newly", "Ninja No Commitment", "Noble", "No-cost No-frills", "No-nonsense", "Non-competitive", "Non-judgmental Non-stop", "Notably", "Notorious", "Novelty", "Numb Nutty", "Obnoxious", "Obsessive Obtain", "Ominous", "One-time", "Open", "Optimal", "Optimistic", "Opulent Ordeal", "Organic", "Out of This World Out-of-the-box", "Outclass", "Outlaw", "Outrage", "Outstanding", "Overconfident Overcome", "Overjoyed Overwhelming", "Painstaking Paralyzed", "Pardon", "Parody Passionate", "Pathetic Patient", "Peaceful", "Peerless", "Penetrate Perceived", "Perfect", "Perky Persecuted", "Persuasive", "Petrified Philanthropic", "Picturesque", "Pioneering Pitiful", "Plagued Playful", "Please", "Pleasant", "Pleased", "Pleasing Plummet", "Poised", "Popular", "Positive Possessive", "Powerful", "Powerless", "Practical Preposterous", "Preserved Pretty", "Priceless Pride", "Principled", "Prize", "Productive Profanity", "Profitable", "Profit Progress", "Progressive Prominent", "Promised", "Proven Prying", "Psychological", "Pure", "Purposeful", "Puzzled", "Quake Qualitative", "Quality Quarantine", "Quarrel", "Quell", "Quest Questionable", "Quick", "Quickest", "Quintessential", "Quirky Quit", "Quivering", "Quixotic", "Radiant", "Raging", "Rant", "Rare", "Rational Ravaged", "Raving", "Read", "Real", "Rebel", "Rebellious", "Reckless", "Reconcile", "Redundant", "Refined", "Rejoice", "Relaxed", "Relentless", "Relevant", "Reliable", "Revealed", "Revelatory", "Revenge", "Revitalize", "Revolution", "Reward", "Rich", "Ridiculous", "Rigorous", "Risky", "Riveting", "Robust", "Rock-bottom", "Romantic", "Rotten", "Ruin", "Rule-breaking", "Rush", "Sacred", "Safe", "Sane", "Satisfied", "Scam", "Scandal", "Scandalous", "Scarcity", "Scared", "Scary", "Screaming", "Scrutinize", "Secure", "Self-absorbed", "Selfish", "Selfless", "Sensible", "Sensual", "Sentimental", "Serene", "Serious", "Settled", "Sexy", "Shady", "Shameful", "Shattered", "Shocking", "Shunned", "Simple", "Simplicity", "Sincere", "Sinister", "Sizzling", "Skeleton", "Skillful", "Slammed", "Sleazy", "Slightly", "Sluggish", "Smart", "Smashing", "Sneak Peek", "Sneak", "Soothing", "Sophisticated", "Sorry", "Soulful", "Sound", "Sovereign", "Spam", "Sparkling", "Spectacular", "Speedy", "Spellbinding", "Spiritual", "Splendid", "Spontaneous", "Sporadic", "Spotlight", "Staggering", "Stale", "Star", "Startling", "Stately", "Stealthy", "Stellar", "Stimulating", "Stingy", "Stoked", "Storm", "Strange", "Strategic", "Streamlined", "Strengthened", "Stress", "Striking", "Stubborn", "Stunned", "Stupefied", "Stunning", "Substantial", "Successful", "Suffering", "Suicidal", "Suitable", "Sulky", "Summon", "Super", "Superb", "Superior", "Supportive", "Surpassing", "Surprised", "Surprising", "Survival", "Suspicious", "Sustainable", "Sweet", "Swift", "Sympathetic", "Talented", "Tantalizing", "Tarnished", "Terrible","Terrific", "Thankful", "Thirsty", "Threat", "Thrifty", "Thrilling", "Thrive", "Thwart", "Tidy", "Tight", "Time-limited", "Timeless", "Timely", "Tired", "Titillating", "To Die For", "Tolerant", "Tombstone", "Torn", "Tormented", "Tortured", "Tough", "Toxic", "Tragic", "Traitor", "Tranquil", "Transformative", "Transform", "Transparent", "Traumatic", "Treason", "Treasured", "Trendy", "Triumphant", "True", "Trustworthy", "Truthful", "Turnkey", "Ultimate", "Unbeatable", "Unbelievable", "Unbreakable", "Uncover","Underdog", "Underestimated", "Undeniable", "Undeniably","Undeniably", "Undetectable", "Undeterred", "Undisputed", "Unemotional", "Unfazed", "Unforgettable", "Unforgivable", "Unhindered", "Unique", "United", "Universal", "Unlimited", "Unparalleled", "Unpredictable", "Unquestionably", "Unrivaled", "Unstoppable", "Unthinkable", "Untouched", "Untouched", "Untraceable", "Unwavering", "Unyielding", "Uplifting", "Upset", "Urgent", "Usable", "Valiant", "Valuable", "Vanquish", "Vast", "Venerable", "Vent", "Vibrant", "Victory", "Villain", "Vindicated", "Violent", "Virtue", "Visionary", "Vital", "Vivid", "Volatile", "Wacky", "Wanted", "Warrant", "Wary", "Wasted", "Wavering", "Weak", "Wealthy", "Weapon", "Whimsical", "Whole", "Wicked", "Wild", "Winning", "Witty", "Wonderful", "Worried", "Wretched", "Worthy", "Wow", "Wrath", "Wrathful", "Wreck", "Wrecked", "Wronged", "Yawn", "Yearning", "Yell", "Youthful", "Zealot", "Zero-cost", "new"
                ];
                $powerkeyfound = 0;
                foreach ($powerarr as $keyword) {
                    if (strpos($post_title, $keyword) !== false) {
                        $powerkeyfound = 1;
                        break;
                    }
                }

                //check post title contains number
                $containsnumber = 0;
                if (preg_match('/\d/', $post_title)) {
                    $containsnumber = 1;
                } else {
                    $containsnumber = 0;
                }
                $titleseo = $titleseo - $containsnumber - $powerkeyfound - $sagmentfound - $begintitle;
                ?>
                <div class="kb-tab">
                    <input type="checkbox" name="accordion-1" id="cb3" >

                    <?php if($titleseo == 0){ ?>
                    <label for="cb3" class="cb3 kb-tab__label kb-accordian-tab-green">Heading Readability 
                        <span>All Good </span>
                    </label>
                    <?php
                    }else{ ?>
                    <label for="cb3" class="cb3 kb-tab__label kb-accordian-tab-red">Heading Readability
                        <span> Error <b class="komodo-titleseo"><?php echo $titleseo; ?></b> </span>
                    </label>
                    <?php } ?>
                    <div class="kb-tab__content">
                        <ul>
                            <?php if($begintitle == 1){ ?>
                                <li class="begintitle"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                    <div>
                                    SEO title starts with the focus keyword.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#seo_fkey" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php }else{ ?>
                                <li class="begintitle"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                    <div>
                                    SEO title starts with the focus keyword.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#seo_fkey" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php } ?>
                            
                            <?php if($sagmentfound == 1){ ?>
                                <li class="sagmentfound"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                    <div>
                                    Your title shows a positive or negative sentiment.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#seo_fkey" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php }else{ ?>
                                <li class="sagmentfound"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                    <div>
                                    Your title shows a positive or negative sentiment.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#seo_fkey" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php } ?>
                            <?php if($powerkeyfound == 1){ ?>
                                <li class="powerkeyfound">
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                    <div>
                                    Your title contains 1 power word.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#power_word" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php }else{ ?>
                                <li class="powerkeyfound"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                    <div>
                                    Your title contains 1 power word.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#power_word" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php } ?>
                            <?php if($containsnumber == 1){ ?>
                                <li class="containsnumber"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                    <div>
                                    SEO title includes a numeric value.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#num_value" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php }else{ ?>
                                <li class="containsnumber"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                    <div>
                                    SEO title includes a numeric value.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#num_value" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php
                $contentreadability = 2;
                $imgcontain = $paragraph_readability = 0;
                $pattern = '/<img[^>]+>/i';
                if (preg_match_all($pattern, $post_content, $matches, PREG_SET_ORDER)) {
                    if(!empty($matches[0])){
                        $imgcontain = 1;
                    }else{
                        $imgcontain = 0;
                    }
                }

                //Check large paragraph 

                $content_with_paragraphs = wpautop($post_content);
                $paragraphs = explode('</p>', strip_tags($content_with_paragraphs, '<p>'));

                // Clean up any empty paragraphs
                $paragraphs = array_filter($paragraphs, 'trim');
                if(!empty($paragraphs)){
                    foreach($paragraphs as $para){
                        $word_count = str_word_count($para);
                        if($word_count < 120){
                            $parapraph_limit[] = 1;
                        }else{
                            $parapraph_limit[] = 0;
                        }
                    }
                    if (in_array(0, $parapraph_limit, true)) {
                        $paragraph_readability = 0;
                    } else {
                        $paragraph_readability = 1;
                    }
                }

                $contentreadability = $contentreadability - $paragraph_readability - $imgcontain;
                ?>
                <div class="kb-tab">
                    <input type="checkbox" name="accordion-1" id="cb4" >
                    <?php if($contentreadability == 0){ ?>
                        <label for="cb4" class="cb4 kb-tab__label kb-accordian-tab-green">Content Accessibility
                            <span >All Good</span>
                        </label>
                    <?php
                    }else{ ?>
                        <label for="cb4" class="cb4 kb-tab__label kb-accordian-tab-red">Content Accessibility
                            <span>Error <b class="komodo-contentreadability"><?php echo $contentreadability; ?></b> </span>
                        </label>
                    <?php } ?>
                    <div class="kb-tab__content">
                        <ul>
                            <?php if($paragraph_readability == 1){ ?>
                                <li class="paragraph_readability"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                    <div>
                                    Add short and concise paragraphs for better readability and UX.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#readability" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php }else{ ?>
                                <li class="paragraph_readability"> 
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                    <div>
                                    Add short and concise paragraphs for better readability and UX.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#readability" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php } ?>
                            <?php if($imgcontain == 1){ ?>
                                <li class="imgcontain">
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/success.svg'; ?>" class="komodo-success cross-icon">
                                    <div>
                                    Add a few images and/or videos to make your content appealing.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#content_appealing" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php }else{ ?>
                                <li class="imgcontain">
                                    <img src="<?php echo plugin_dir_url( __FILE__ ).'images/error.svg'; ?>" class="komodo-err cross-icon">
                                    <div>
                                    Add a few images and/or videos to make your content appealing.
                                    <a class="rys-svg-seo" href="https://rankyoursites.net/documentations/#content_appealing" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></a>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
	<?php
    }
}

add_action( 'wp_ajax_komodo_save_metadata', 'komodo_save_metadata' );
function komodo_save_metadata(){
	if(!empty($_POST['taglist'])){
		$data = update_post_meta($_POST['postid'], '_komodo_focuskeyword', $_POST['taglist']);
		
	}
    if(!empty($_POST['percent'])){
		$data = update_post_meta($_POST['postid'], '_komodo_postpercent', $_POST['percent']);
    }
	die();
}

/**
 * Add social sharing option on blog single
 */
function komodo_add_to_content( $content ) {    
    if( is_single() ) {
        $content .= '<div class="komodo_share_text">
						<h1>'. esc_html__('Share With','miraculous').'</h1>
						<ul>
							<li><a href="https://www.facebook.com/sharer/sharer.php?u='.urlencode(get_the_permalink(get_the_ID())).'" class="komodo_share_facebook" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							<li><a href="https://www.linkedin.com/shareArticle?mini=true&url='.urlencode(get_the_permalink(get_the_ID())).'" class="komodo_share_linkedin" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
							<li><a href="https://twitter.com/intent/tweet?text='.urlencode(get_the_permalink(get_the_ID())).'" class="komodo_share_twitter" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							<li><a href="https://api.whatsapp.com/send?text='.urlencode(get_the_permalink(get_the_ID())).'" class="komodo_share_whatsapp" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
						</ul>
					</div>';
    }
    return $content;
}
add_filter( 'the_content', 'komodo_add_to_content' );