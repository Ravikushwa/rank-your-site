<?php
    $property = [];
    $i = 0;
 
    if(isset($websites)){
        foreach($websites as $website){
            foreach($website as $web){
                foreach($website[$i]['propertySummaries'] as $prop){
                    array_push($property,$prop);
                }
            $i++;
        }}        
    }
// echo "<pre>";print_r($gdn['rows']['dimensionValues']);die;
?>
<!--Main Wrapper-->
<div class="komodo-main-wrapper komodo-analytics-page">
    <div class="komodo-page-title">
        <h2>Google Analytics</h2>
        <p>We integrate Google Analytics to provide comprehensive insights directly within your WordPress dashboard</p>
    </div>

    <!-- NEW HTML  -->
    <div class="komodo-container">
            <?php 
                 if(isset($websites) && !empty($websites)){                 
            ?>
            <div class="komodo-report-wrapper">
                <div class="komodo-form-wrap">
                    <input type="hidden" value="<?=isset($mapsApi)?$mapsApi:'';?>" id="rys_mapsApi" />
                    <form class="komodo-analytics-form">
                        <div class="komodo-input komodo-daterange">
                            <label>Select Date</label>
                            <div id="dateRangePicker" class="komodo-dateRangePicker"><span></span></div>
                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 34 34" ><g><path d="M29.6 2h-3v3c0 .6-.5 1-1 1s-1-.4-1-1V2h-16v3c0 .6-.5 1-1 1s-1-.4-1-1V2h-3C2.1 2 1 3.3 1 5v3.6h32V5c0-1.7-1.8-3-3.4-3zM1 10.7V29c0 1.8 1.1 3 2.7 3h26c1.6 0 3.4-1.3 3.4-3V10.7zm8.9 16.8H7.5c-.4 0-.8-.3-.8-.8v-2.5c0-.4.3-.8.8-.8H10c.4 0 .8.3.8.8v2.5c-.1.5-.4.8-.9.8zm0-9H7.5c-.4 0-.8-.3-.8-.8v-2.5c0-.4.3-.8.8-.8H10c.4 0 .8.3.8.8v2.5c-.1.5-.4.8-.9.8zm8 9h-2.5c-.4 0-.8-.3-.8-.8v-2.5c0-.4.3-.8.8-.8h2.5c.4 0 .8.3.8.8v2.5c0 .5-.3.8-.8.8zm0-9h-2.5c-.4 0-.8-.3-.8-.8v-2.5c0-.4.3-.8.8-.8h2.5c.4 0 .8.3.8.8v2.5c0 .5-.3.8-.8.8zm8 9h-2.5c-.4 0-.8-.3-.8-.8v-2.5c0-.4.3-.8.8-.8h2.5c.4 0 .8.3.8.8v2.5c0 .5-.3.8-.8.8zm0-9h-2.5c-.4 0-.8-.3-.8-.8v-2.5c0-.4.3-.8.8-.8h2.5c.4 0 .8.3.8.8v2.5c0 .5-.3.8-.8.8z" fill="currentColor" opacity="1" data-original="currentColor"/></g></svg>
                        </div>
                        <div class="komodo-input"> 
                            <label>Domain</label>
                            <select class="selectappName filter" id="rys_appName">                           
                                <?php
                                    foreach($gdn as $key=>$domain){          

                                        echo '<option value="'.$domain.'" '.($domain=="plrfunnels.in" ? 'selected':'').'>'.$domain.'</option>';
                                    }                                
                                    ?>
                            </select>
                        </div>
                        <div class="komodo-input"> 
                            <label>Websites</label>
                            <select class="selectPropertyId filter" id="rys_propertyId">                           
                                <?php
                                    foreach($property as $key=>$webProperty){
                                        $select = ($webProperty['property']=="$wbsel") ? "selected" : "";
                                        echo '<option value="'.$webProperty['property'].'" '.$select.'>'.$webProperty['displayName'].'</option>';
                                    }
                                    
                                    ?>
                            </select>
                        </div>
                        <div class="komodo-input">
                            <label>Type</label>
                            <select data-placeholder="Select App" class="filter" id="rys_Dtype">
                                <option value="Visits">Visits</option>
                                <!-- <option value="installs">Installs</option> -->
                            </select>
                        </div>
                        
                        <div class="komodo-input">
                            <label>Location</label>
                            <select data-placeholder="Select App" class="filter" id="rys_Locations">
                                <option value="worldwide">Worldwide</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="komodo-col-2">
                    <div class="komodo-col-box">
                        <div class="komodo-box-title">
                            <h4>Users By Country</h4>
                        </div>
                        <div class="chart-holder">
                            <div id="regions_div" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>

                    <div class="komodo-col-box">
                        <div class="komodo-box-title">
                            <h4>Users And Session </h4>
                        </div>
                        <div class="chart-holder">
                            <div id="chart_div" style="width: 100%; height: 350px;"></div>    
                        </div>
                    </div>
                </div>
                <!-- <h2>Report</h2> -->

             <div class="komodo-col-2">
                    <div class="komodo-col-box">
                        <div class="komodo-box-title">
                            <h4>Where do your new users come from?</h4>
                        </div>
                        <div class="chart-holder">
                            <div id="chartC"></div>
                            <!-- <canvas id="horizontalBarChartCanvas"></canvas> -->
                        </div>
                    </div>  
                    <div class="komodo-col-box">
                        <div class="komodo-box-title">
                            <h4>What are your top campaigns?</h4>
                        </div>
                        <div class="komodo-progress-list-holder">
                            <div class="komodo-progress-list-head">
                                <div class="komodo-input">                                    
                                    <select class="selectPropertyId TopCampaignfilter" id="topcampaign">                           
                                       <option value="sessionDefaultChannelGroup">sessionDefaultChannelGroup</option>
                                       <option value="sessionCampaignId">sessionCampaignId</option>
                                       <option value="sessionMedium">sessionMedium</option>
                                       <option value="sessionPrimaryChannelGroup">sessionPrimaryChannelGroup</option>
                                       <option value="sessionSource">sessionSource</option>
                                       <option value="sessionSourceMedium">sessionSourceMedium</option>
                                       <option value="sessionSourcePlatform">sessionSourcePlatform</option>
                                    </select>
                                </div>
                                <span>Session</span>
                            </div>
                            <ul class="TopCampaignData"></ul>
                            <div class="komodo-link-box"><a href="javascript:;" class="top-campaigns" url="<?=admin_url();?>" >View traffic acquisition <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M21.883 12l-7.527 6.235.644.765 9-7.521-9-7.479-.645.764 7.529 6.236h-21.884v1h21.883z"/></svg></a></div>
                        </div>
                    </div>               

                </div>
                

                <div class="komodo-col-3">  
                    <div class="komodo-col-box">
                        <div class="komodo-box-title">
                            <h4>Which pages and screens get the most views?</h4>
                        </div>
                        <div class="komodo-progress-list-holder">
                            <div class="komodo-progress-list-head">
                                <span> Page Title And Screen </span>
                                <span>Views</span>
                            </div>
                            <ul class="PageAndScreen"></ul>
                            <div class="komodo-link-box"><a url="<?=admin_url();?>" href="javascript:;" class="page-screen" >View pages and screens <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M21.883 12l-7.527 6.235.644.765 9-7.521-9-7.479-.645.764 7.529 6.236h-21.884v1h21.883z"/></svg></a></div>
                        </div>
                    </div>

                    <div class="komodo-col-box">
                        <div class="komodo-box-title">
                            <h4>What are your top events?</h4>
                        </div>
                        <div class="komodo-progress-list-holder">
                            <div class="komodo-progress-list-head">
                                <span> Session primary</span>
                                <span>Sessions</span>
                            </div>
                            <ul class="TopEvents"></ul>
                            <div class="komodo-link-box"><a url="<?=admin_url();?>" href="javascript:;" class="top-event">View Events <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M21.883 12l-7.527 6.235.644.765 9-7.521-9-7.479-.645.764 7.529 6.236h-21.884v1h21.883z"/></svg></a></div>
                        </div>
                    </div>

                
                </div>
               

            </div>

             <?php 
                }
                else { ?>
                    <div class="komodo-accinfo-box">
                        <!-- Save Keyword Screen Start -->
                        <div class="komodo-page-title">
                            <h2>Analytics</h2>    
                            <p>First, connect your Google account in the member area, after that, this feature will be activated</p>
                        </div>
                        <a href="https://rankyoursites.net/ga4" target="_blank" class="komodo-btn">Connect</a>
                    </div> 

                <?php
                }
            ?>
    </div>
   
</div>


<!-- Notification popup -->
<div class="rys-alert-wrap">
    <p></p>
</div>

  
<div class="komodo-preloader ">
	<div class="komodo-preloader-inner">
        <img src="<?=KOMODO_BLOGS_URL;?>/admin/images/preloader.gif">
        <h4>Loading...</h4>
    </div>
</div>