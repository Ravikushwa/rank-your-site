<!-- Save Keyword Screen Start -->
<div class="komodo-main-wrapper komodo-fullwidth">
    <div class="komodo-page-title">
        <h2>Event Show</h2>
        <p>Unleash Event Traffic Potential</p>
    </div>
    <div class="komodo-container">
        <div class="komodo-page-title">
            <h2>Events</h2>  
            <div class="planner-activity-total-count">                
                <div class="activity-total-count">
                    <!-- <h4>Keyword Ideas Available <span class="total-count"></span></h4>                    -->
                    <div class="komodo-input">
                        <input id="search" type="text" placeholder="Search for name..." >
                    </div>
                </div>
            </div> 
        </div>
        <?php $tUser = []; $tEventC = []; $tEper = []; $tRev = [];?>
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
                                    Events Name
                                </th>
                                <th class="manage-column">Events Count</th>
                                <th class="manage-column">Event Count Per User</th>
                                <th class="manage-column">Total Revenue</th>
                                <th class="manage-column">Total Users</th>
                            </tr>                       
                        </thead>
                        <tbody>                         
                            <?php
                                if (isset($result['rows'])) {                              
                            
                                    foreach ($result['rows'] as $key => $value) {                                  
                                    ?>                                                           
                                    <tr>                           
                                            <td class="manage-column"><?php
                                                foreach ($value['dimensionValues'] as $key => $DValue) {
                                                    // echo '<a href="javascript:;">'.$DValue['value'].'</a>';
                                                    echo $DValue['value'];
                                                }                                        
                                            ?></td>
                                            <?php 
                                            
                                                $check = [];
                                                foreach ($value['metricValues'] as $key => $Mvalue) {
                                                    if($key==3){                                                    
                                                        array_push($tUser,$Mvalue['value']);                                                   
                                                    }else if($key==0){
                                                        array_push($tEventC,$Mvalue['value']);                                                   
                                                    }else if($key==1){
                                                        array_push($tEper,$Mvalue['value']);                                                   
                                                    }else{
                                                        array_push($tRev,$Mvalue['value']);                                                   
                                                    }
                                                ?>
                                                    <td class="manage-column"><?=round($Mvalue['value'],2);?></td>                                                
                                                <?php
                                                } 
                                            
                                            ?>                                       
                                        </tr>
                                        
                                    <?php 
                                    }
                                    ?>
                                    <tr>                           
                                        <th class="manage-column"></th>
                                        <th class="manage-column"><span><?php echo array_sum($tEventC);?></span> 100% of total</th>
                                        <th class="manage-column"><span><?php echo round(array_sum($tEper),2);?></span> Avg 100%</th>
                                        <th class="manage-column">$<?php echo array_sum($tRev);?>.00</th>
                                        <th class="manage-column"><span><?php echo array_sum($tUser);?></span> 100% of total</th>
                                    </tr>
                                    <?php
                                    
                                }else{
                                    echo ' <tr>
                                      <td colspan="5" class="text-center">No Data Fund</td>
                                    </tr>';
                                }
                                
                            ?>
                        
                        </tbody>
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