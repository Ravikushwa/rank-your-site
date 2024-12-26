<div class="komodo-main-wrapper komodo-googletrends-page">
    <div class="komodo-page-title">
        <h2>Google Trends</h2>
        <p>Integrate Google Trends Insights into Your WordPress Post</p>
    </div>
    <div class="komodo-container">

        <div class="komodo-trend-header">
            <div class="komodo-input">
                <label>Select Country</label>
                <select name="post_type" id="googletrendsget"> 
                    <option value="US" >United States</option> 
                    <option value="IN" >India</option>
                    <option value="AR" >Argentina</option>
                    <option value="AU" >Australia</option>
                    <option value="AT" >Austria</option>
                    <option value="BE" >Belgium</option>
                    <option value="BR" >Brazil</option>
                    <option value="CA" >Canada</option>
                    <option value="CL" >Chile</option>
                    <option value="CO" >Colombia</option>
                    <option value="CZ" >Czechia</option>
                    <option value="DK" >Denmark</option>
                    <option value="EG" >Egypt</option>
                    <option value="FI" >Finland</option>
                    <option value="FR" >France</option>
                    <option value="DE" >Germany</option>
                    <option value="GR" >Greece</option>
                    <option value="HK" >Hong Kong</option>
                    <option value="HU" >Hungary</option>
                    <option value="ID" >Indonesia</option>
                    <option value="IE" >Ireland</option>
                    <option value="IL" >Israel</option>
                    <option value="IT" >Italy</option>
                    <option value="JP" >Japan</option>
                    <option value="KE" >Kenya</option>
                    <option value="MY" >Malaysia</option>
                    <option value="MX" >Mexico</option>
                    <option value="NL" >Netherlands</option>
                    <option value="NZ" >New Zealand</option>
                    <option value="NG" >Nigeria</option>
                    <option value="NO" >Norway</option>
                    <option value="PE" >Peru</option>
                    <option value="PH" >Philippines</option>
                    <option value="PL" >Poland</option>
                    <option value="PT" >Portugal</option>
                    <option value="RO" >Romania</option>
                    <option value="RU" >Russia</option>
                    <option value="SA" >Saudi Arabia</option>
                    <option value="SG" >Singapore</option>
                    <option value="ZA" >South Africa</option>
                    <option value="KR" >South Korea</option>
                    <option value="ES" >Spain</option>
                    <option value="SE" >Sweden</option>
                    <option value="CH" >Switzerland</option>
                    <option value="TW" >Taiwan</option>
                    <option value="TH" >Thailand</option>
                    <option value="TR" >Türkiye</option>
                    <option value="UA" >Ukraine</option>
                    <option value="GB" >United Kingdom</option>                    
                    <option value="VN" >Vietnam</option>
                </select>
            </div>
        </div>

        <form class="form">
            <div class="google-trennds-wrapper" >
                <div class="google-trends-head">
                    <div class="komodo-input">
                        <div class="ee-checkbox">
                            <input type="checkbox" id="checkAll"> 
                            <span><!-- span has design  --></span>
                        </div>
                        <label for="checkAll">Select All</label>
                    </div>
                

                    <h4><?=date("l jS \of F Y");?></h4>
                </div>
                <div class="komodo-accordion">
                    <?php     
                        $i = 1;
                        foreach ($Gtrends as $key => $value) {
                            $data = array(
                                'Title'=>$value["Item Title"],
                                'Traffic'=>$value["Approx Traffic"],
                                'Link'=>$value["Link"],
                                'Date'=>$value["Publication Date"],
                                'Picture'=>$value["Picture"],
                                'PictureSource'=>$value["Picture Source"],
                                'Description'=>$value["Description"],
                                'RelatedNews'=>$value['RelatedNews']
                            );
                            ?>
                            <div class="komodo-accordian-item">  
                                <div class="ee-checkbox">
                                    <input class="checkItem" type="checkbox" name="trendsPosst[]" value="<?=base64_encode(json_encode($data));?>">
                                    <span><!-- span has design  --></span>
                                </div> 
                                <div class="komodo-accordian-title">
                                    <span class="post-counting"><?= $i++; ?> </span>
                                    <div class="komodo-trend-info">
                                        <div class="komodo-treand-title-info">
                                            <a class="komodo-trend-title" href="<?= $value["Link"]; ?>" target="_blank"><?= $value["Item Title"]; ?></a>
                                        <p> <?= $value["Description"]; ?></p>
                                        <span class="komodo-publish-date"><?= $value["Publication Date"]; ?></span>
                                        <span class="komodo-post-date">
                                                <?php $tlt = $value['RelatedNews'][0]['News Item Title']; $tsrc = $value['RelatedNews'][0]['News Item Source'];?>
                                                <a href="<?= $value["Link"]; ?>" target="_blank"><?= $tlt; ?></a>
                                                <span><?= $tsrc ?> </span>
                                                <span class="bold-text"><?= $value['Hours Ago']; ?> </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="komodo-search-count">
                                        <div class="">
                                            <?= $value["Approx Traffic"]; ?>
                                            <span>searches</span>
                                        </div>
                                    </div>
                                    <div class="komodo-trend-thumb">
                                        
                                        <img src="<?= $value["Picture"]; ?>" alt="<?= $value["Picture Source"]; ?>" />
                                        <h5><?= $value["Picture Source"]; ?></h5>
                                    </div>

                                </div>
                                <div class="komodo-accordian-tab">
                                    <div class="komodo-google-trend-posts">
                                        <h6>Related News</h6>
                                        <?php 
                                            foreach ($value['RelatedNews']  as $key => $subChild) {                               
                                                ?>

                                                    <a href="<?= $subChild["News Item URL"]; ?>" target="_blank" class="komodo-google-trend-content">
                                                        <img src="<?= $value["Picture"]; ?>" alt="<?= $value["Picture Source"]; ?>" />
                                                        <div class="komodo-post-content">
                                                            <span class="komodo-post-date"><?= $subChild["News Item Source"].'<span><b>.</b></span> '.$value['Hours Ago']; ?></span>
                                                            <h4><?=$subChild['News Item Title'];?></h4>
                                                            <p><?=$subChild['News Item Snippet'];?></p>
                                                        </div>
                                                    </a>

                                            <?php }?>
                                    </div>
                                </div>
                                
                            </div>
                        <?php
                        }
                    ?>

                </div>
            </div>
            <button type="button" name="submit" action="GoogleAdsPlanner" class="komodo-btn trensPostCreate w-50" >Save Seed Keywords</button>   
        </form>

    </div>
   
    <!-- notification popup -->
    <div class="rys-alert-wrap"><p></p></div>

</div>

<div class="komodo-preloader ">
	<div class="komodo-preloader-inner">
        <img src="<?=KOMODO_BLOGS_URL;?>/admin/images/preloader.gif">
        <h4>Loading...</h4>
    </div>
</div>

<script>
    jQuery(document).ready(function () {
        jQuery(".komodo-accordion .komodo-accordian-item:first-child() .komodo-accordian-title").addClass("active");
        jQuery(".komodo-accordion .komodo-accordian-item:first-child() .komodo-accordian-tab").slideDown();
        jQuery(".komodo-accordian-title").click(function () {
            jQuery(this)
            .toggleClass("active")
            .next(".komodo-accordian-tab")
            .slideToggle()
            .parent()
            .siblings()
            .find(".komodo-accordian-tab")
            .slideUp()
            .prev()
            .removeClass("active");
        });
    });
</script>