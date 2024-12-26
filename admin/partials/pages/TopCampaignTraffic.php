<!-- Save Keyword Screen Start -->
<div class="komodo-main-wrapper komodo-fullwidth"> 
    <div class="komodo-page-title">
        <h2>Top Campaign Traffic</h2>
        <p>Effortless Traffic Acquisition with RankYourSite</p>
    </div>
    <div class="komodo-container">
        <div class="komodo-page-title">
            <h2>Top Campaign Traffic </h2>  
            <div class="planner-activity-total-count">                
                <div class="activity-total-count">
                    <!-- <h4>Keyword Ideas Available <span class="total-count"></span></h4> -->
                    <div class="komodo-input">
                        <input id="search" type="text" placeholder="Search for name..." >
                    </div>
                </div>
            </div>
        </div> 
        <div class="google-planner-activty-saveData">
            <form class="form">
                <div class="komodo-fixed-height-table">
                    <table id="table" class="komodo-custom-table">
                        <thead>
                            <tr>
                                <th class="manage-column">
                                    <!-- <div class="komodo-input">                                    
                                        <select class="selectPropertyId TopCampaignfilter" id="topcampaign">                           
                                            <option value="sessionPrimaryChannelGroup">Page title and screen class</option>
                                            <option value="sessionMedium">Page path and screen class</option>
                                            <option value="sessionCampaignId">Page title and screen name</option>
                                        <option value="sessionDefaultChannelGroup">Content group</option>
                                        </select>
                                    </div> -->
                                    Title
                                </th>
                                <th class="manage-column">Users</th>
                                <th class="manage-column">Sessions</th>
                                <th class="manage-column">Engaged <br> Sessions</th>
                                <th class="manage-column">Average <br> Engagement<br> Time Per Session</th>
                                <th class="manage-column">Engaged<br>  Sessions <br> Per User</th>
                                <th class="manage-column">Events<br>  Per Session</th>
                                <th class="manage-column">Engagement <br> Rate</th>
                                <th class="manage-column">Event<br>  Count</th>
                                <th class="manage-column">Key Events</th>
                            </tr>                        
                        </thead>
                        <tbody>
                            <?php
                            $totalUsers= [];
                            $sessions= [];
                            $engagedSessions= [];
                            $averageSessionDuration= [];
                            $eventsPerSession= [];
                            $sessionsPerUser= [];
                            $engagementRate= [];
                            $eventCount= [];
                            $keyEvents= [];
                        
                                if (isset($result['rows'])) {                              
                                    // echo "<pre>";print_r($result);
                                    foreach ($result['rows'] as $key => $value) {                                  
                                    ?>                                                           
                                    <tr>                           
                                            <td class="manage-column"><?php
                                                foreach ($value['dimensionValues'] as $key => $DValue) {
                                                    echo $DValue['value'];
                                                }                                        
                                            ?></td>
                                            <?php 
                                            
                                                foreach ($value['metricValues'] as $key => $Mvalue) {
                                                    if($key==0){   
                                                        array_push($totalUsers,$Mvalue['value']);
                                                    }else if($key==1){
                                                        array_push($sessions,$Mvalue['value']);
                                                    }else if($key==2){
                                                        array_push($engagedSessions,$Mvalue['value']);
                                                    }else if($key==3){
                                                        array_push($averageSessionDuration,$Mvalue['value']);
                                                    }else if($key==4){
                                                        array_push($eventsPerSession,$Mvalue['value']);
                                                    }else if($key==5){
                                                        array_push($sessionsPerUser,$Mvalue['value']);
                                                    }else if($key==6){
                                                        array_push($engagementRate,$Mvalue['value']);
                                                    }else if($key==7){
                                                        array_push($eventCount,$Mvalue['value']);
                                                    }else{
                                                        array_push( $keyEvents,$Mvalue['value']);
                                                    }
                                                ?>
                                                    <td class="manage-column"><?=round($Mvalue['value'],2);?></td>                                                
                                                <?php
                                                } 
                                            
                                            ?>                                       
                                        </tr>
                                        
                                    <?php 
                                    $Atl = count($averageSessionDuration);
                                    $EPrstl = count($eventsPerSession);
                                    $SprUtl = count($sessionsPerUser);
                                    $ERTtl = count($engagementRate);
                                    }
                                    ?>
                                
                                    <?php
                                    
                                }else{
                                    echo ' <tr>
                                        <td colspan="10" class="text-center">No Data Fund</td>
                                    </tr>';
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>                           
                                <th class="manage-column"></th>
                                <th class="manage-column"><?=(round(array_sum($totalUsers),2)!=0)?round(array_sum($totalUsers),2):0;?> 100% of total</th>
                                <th class="manage-column"><?=(round(array_sum($sessions),2)!=0)?round(array_sum($sessions),2):0;?> 100% of total</th>
                                <th class="manage-column"><?=(round(array_sum($engagedSessions),2)!=0)?round(array_sum($engagedSessions),2):0;?> 100% of total</th>
                                <th class="manage-column"><?=(round(array_sum($averageSessionDuration),2)!=0)?round(array_sum($averageSessionDuration)/$Atl,2):0;?> Avg 0%</th>
                                <th class="manage-column"><?=(round(array_sum($eventsPerSession),2)!=0)?round(array_sum($eventsPerSession)/$EPrstl,2):0;?> Avg 0%</th>
                                <th class="manage-column"><?=(round(array_sum($sessionsPerUser),2)!=0)?round(array_sum($sessionsPerUser)/$SprUtl,2):0;?> Avg 0%</th>
                                <th class="manage-column"><?=(round(array_sum($engagementRate),2)!=0)?round(array_sum($engagementRate)/$ERTtl,2):0;?> Avg 0%</th>
                                <th class="manage-column"><?=(round(array_sum($eventCount),2)!=0)?round(array_sum($eventCount),2):0;?> 100% of total</th>
                                <th class="manage-column"><?=(round(array_sum($keyEvents),2)!=0)?round(array_sum($keyEvents),2):0;?> 100% of total</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="komodo-preloader ">
	<div class="komodo-preloader-inner">
        <img src="<?=KOMODO_BLOGS_URL;?>/admin/images/preloader.gif">
        <h4>Loading...</h4>
    </div>
</div>