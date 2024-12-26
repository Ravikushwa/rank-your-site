<!--Main Wrapper-->
<div class="komodo-main-wrapper komodo-dashboard-page">
	<div class="komodo-container">
        <div class="komodo-page-title">
            <h2>Sitemap Option</h2>
            <p>Sitemap is updated whenever a new post or page is published</p>
        </div>
		<div class="komodo-sitemap-options">
           <form class="form" method="post">
            <div class="komodo-input komodo-has-switch">
                    <label>Sitemap Status</label>
                    <div class="komodo-switch-label">
                        <input type="checkbox" name="site_map_status" id="knowledgeBase" <?= (!empty($sikteMaps['site_map_status']) && $sikteMaps['site_map_status']=="on") ? 'checked' : '';?>>
                        <label for="knowledgeBase"></label>
                    </div>
                </div>
                <div class="komodo-input">
                    <?php                    
                        $post_types = get_post_types([], 'objects');                    
                        $postype = [];
                        foreach ($post_types as $post_type) {
                            if($post_type->public=="Yes"){
                                array_push($postype,$post_type->label);
                            }                           
                        }                     
                        ?>
                    <label>Select Post Type</label>
                    <select name="post_type" id="">
                        <?php 
                            foreach ($postype as $key => $value) {
                                $sel = (!empty($sikteMaps['post_type']) && $sikteMaps['post_type']==$value) ? 'selected' : '';
                                ?><option value="<?=$value;?>" <?=$sel;?>><?=$value;?></option><?php
                            }
                        ?>
                    </select>
                </div>
                <div class="komodo-input">
                    <label>Sitemap URL</label>
                    <input type="text" id="" name="sitemap_url" value="<?= (!empty($sikteMaps['sitemap_url'])) ? $sikteMaps['sitemap_url'] : home_url().'sitemap.xml';?>" readonly />
                </div>
                <div class="komodo-btn-wrap">
                    <a href="javascript:void(0);" action="SiteMapsSetting" class="komodo-btn w-100 rys-site-maps-settings">Save</a>
                </div>
           </form>
        </div>
	</div>
</div>

  <!-- notification popup -->
  <div class="rys-alert-wrap">
    <p></p>
  </div>

<div class="komodo-preloader ">
	<div class="komodo-preloader-inner">
        <img src="<?=KOMODO_BLOGS_URL;?>/admin/images/preloader.gif">
        <h4>Loading...</h4>
    </div>
</div>