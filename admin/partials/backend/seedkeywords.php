<div class="komodo-main-wrapper komodo-seed-page">
    <div class="komodo-page-title">
        <h2>Seed Keywords</h2>
        <p>Essential for initiating effective SEO strategies</p>
    </div>
    <div class="komodo-container ">
        <div class="komodo-gird">
            <div class="komodos-saved-words">
                <div class="komodo-page-title">
                    <h2>Saved Trending  Keywords</h2>
                </div>       
                <div class="seed-keywords-list">
                    <form class="form">     
                        <div class="ee-checkbox">
                            <input type="checkbox" id="seed_keyword_checkAll"> 
                            <span for="seed_keyword_checkAll"> Select All</span>													
                        </div>                   
                        <div class="save-seed-keywords-list-data">
                            <?php
                                foreach ($savekeyword as $key => $value) {
                                echo '<div  class="kb-seed-keywords-suggestion remove-tag-'.$value['tk_id'].' savedKeyOption">  
                                        <div class="ee-checkbox">
                                            <input class="seed_keyword_checkItem" type="checkbox" name="save_seed_keywords[]" value="'.$value['tk_id'].'">
                                            <span><!-- span has design  --></span>
                                        </div>                                        
                                        <span class="remove-saved-key" cls="remove-tag-'.$value['tk_id'].'" site_url="'.$site_url.'" data-id="'.$value['tk_id'].'">
                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="m17.414 16 6.293-6.293a1 1 0 0 0-1.414-1.414L16 14.586 9.707 8.293a1 1 0 0 0-1.414 1.414L14.586 16l-6.293 6.293a1 1 0 1 0 1.414 1.414L16 17.414l6.293 6.293a1 1 0 0 0 1.414-1.414z" fill="currentColor" opacity="1" data-original="#000000" class=""/></g></svg>
                                        </span>                          
                                        <span class="saved-keyword">'.$value['tk_name'].'</span>
                                    </div>';
                                }
                            ?>               
                        </div>
                    </form>
                </div>   
                <p class='komodo-delete-btn'>
                    <button type='button' name='submit' id='delete-save-seed-keywords' action="GoogleAdsPlanner" class='komodo-btn delete-save-seed-keywords komodo-el-hidden' value='Check Activity'>Delete</button>
                </p>        
            </div>
            <div class="komodos-seed-filter">
                <div class="seed-keywords-search">
                    <div class="komodo-col-2">
                        <div class="komodo-input"> 
                            <label>Select Country</label>
                            <select id="geoTarget" name="geoTarget">
                                <option value="geoTargetConstants/2840">United States</option>
                                <option value="geoTargetConstants/2036">Australia</option>
                                <option value="geoTargetConstants/2076">Brazil</option>
                                <option value="geoTargetConstants/2158">Canada</option>
                                <option value="geoTargetConstants/2392">India</option>
                                <option value="geoTargetConstants/2084">Italy</option>
                                <option value="geoTargetConstants/2072">Spain</option>
                                <option value="geoTargetConstants/2140">Japan</option>
                                <option value="geoTargetConstants/2092">Russia</option>
                                <option value="geoTargetConstants/2108">Thailand</option>
                                <option value="geoTargetConstants/2051">Vietnam</option>
                                <option value="geoTargetConstants/2086">New Zealand</option>
                                <option value="geoTargetConstants/2040">Colombia</option>                            
                                <option value="geoTargetConstants/2120">Greece</option>
                                <option value="geoTargetConstants/2148">Hungary</option>
                                <option value="geoTargetConstants/2116">Denmark</option>
                                <option value="geoTargetConstants/2136">Belgium</option>
                                <option value="geoTargetConstants/2052">Switzerland</option>
                                <!-- Add more geo target options as needed -->
                            </select>           
                        </div>
                        <div class="komodo-input">
                            <label>Find Keywords                           
                            <a class="rys-svg-seo" href="javascript:;">
                            <span class="tooltip" data-tooltip=" Type And Get Keyword Ideas Instantly." data-tooltip-pos="up" data-tooltip-length="medium"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg></span>
                            </a>
                            </label>
                            <form class="form" method="post">                               
                                <input type="text" name="seed-keywords" data-error="Please Enter Any Keyword " placeholder="Find Seed Keywords" action="<?=base64_encode('seed_keywords_serach');?>" class="regular-text require search-keywords" />
                              
                                <span class="komodo-search-icon prelooader">                                   
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none" role="img">
                                        <path d="M1.5 7.75C1.5 9.4076 2.15848 10.9973 3.33058 12.1694C4.50269 13.3415 6.0924 14 7.75 14C9.4076 14 10.9973 13.3415 12.1694 12.1694C13.3415 10.9973 14 9.4076 14 7.75C14 6.0924 13.3415 4.50269 12.1694 3.33058C10.9973 2.15848 9.4076 1.5 7.75 1.5C6.0924 1.5 4.50269 2.15848 3.33058 3.33058C2.15848 4.50269 1.5 6.0924 1.5 7.75V7.75Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M12.814 12.8132L15.5 15.4999" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </span>    
                                <div id="output"></div>               
                            </form>
                        </div>
                    </div>
                </div>
                <div class="seed-keywords-list">
                        <div class="seed-keywords-list-data">
                            <!-- <div class='please-wait-text'>Please Wait ...!</div> -->
                        </div>
                    </div>
                    <div class="google-planner-activity">
                    <p class='submit text-center'>
                        <button type='button' name='submit' id='submit' action="GoogleAdsPlanner" class='komodo-btn Check-google-planner-activity' value='Check Activity'>Mine These Keywords</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
</div>



<!-- Save Keyword Screen End -->

<!-- Next Screen  -->
<div class="komodo-main-wrapper komodo-seed-keyword-slide">
    <div class="komodo-slide-cls-btn">
        <div class="modal-cls-btn" title="close"></div>
    </div>
    <div class="komodo-page-title">
        <h2>Seed Keyword Ideas</h2>
        <p>Generating diverse keyword suggestions based on a central topic</p>
        <div  class="komodo-keyword-listing selected-keyword-listing"></div>
    </div>
    <div class="komodo-table-wrapper">
        <div class="seed-keywords-data">
            <div class="planner-activity-total-count">                
                <div class="activity-total-count">
                    <h4>Keyword Ideas Available <span class="total-count"></span></h4>                                      
                </div>
            </div>
            <div class="komodo-blog-table">
                <div class="table-responsive">
                    <form class="form">
                        <div class="google-planner-activty komodo-fixed-height-tablee">
                            <!-- Table Appended  -->
                        </div>
                        <button type='button' action="SaveDataActivity" ac-type="saveData" class='komodo-btn Check-google-planner-saveData komodo-el-hidden w-50'>Save Data</button>
                        <button type='button' ac-type="CreatePost" action="OepenAiGeneratePost" class='komodo-btn Check-google-planner-createPost komodo-el-hidden w-50'>Create Post</button>
                    </form>
                    <a href="<?=site_url()."/wp-admin/admin.php?page=saved-compitition-data";?>">Go TO Saved Keyword</a>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div id="funnelModal" class="komodo-custom-modal">
    <div class="komodo-custom-modal-dialog">
        <div class="komodo-custom-modal-content">
            <div class="komodo-custom-modal-inner">
                <h3 class="komodo-modal-title">Post Name - <span class="google-post-name"></span></h3>
                <span class="komodo-close-modal" komodo-close-modal>X</span>
            </div>
            <div class="komodo-custom-modal-body">
                <form class="form" method="post">
                    <div class="komodo-input">
                        <input type="text" name="google-genarate-post-content-query" class="komodo-input google-genarate-post-content regular-text require" placeholder="Please Enter Prompt">
                    </div>
                    <a href="javascript:void(0);" action="OepenAiGeneratePost" class="komodo-btn google-genarate-post">Create Post</a>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Monthly SearchVolumes -->
<div id="volumesModal" class="komodo-custom-modal">
    <div class="komodo-custom-modal-dialog">
        <div class="komodo-custom-modal-content">
            <div class="komodo-custom-modal-inner">
                <h3 class="komodo-modal-title">Monthly SearchVolumes</h3>
                <span class="komodo-close-modal" komodo-close-modal>X</span>
            </div>
            <div class="komodo-custom-modal-body">

                    <div class="komodo-month-info " id="komodo-month-info">
                       <!-- Dynamic data  -->
                    </div>

            </div>
        </div>
    </div>
</div>
<!-- Monthly SearchVolumes -->
<div id="CheckExactResult" class="komodo-custom-modal">
    <div class="komodo-custom-modal-dialog">
        <div class="komodo-custom-modal-content">
            <div class="komodo-custom-modal-inner">
                <h3 class="komodo-modal-title">Google Exact Result Show </h3>
                <span class="komodo-close-modal" komodo-close-modal>X</span>
            </div>
            <div class="komodo-custom-modal-body">

                    <div class="exact_resultSHow " id="exact_resultSHow">
                       <!-- Dynamic data  -->
                    </div>

            </div>
        </div>
    </div>
</div>

<!-- Created Post  -->
<div id="CreatedPostUrl" class="komodo-custom-modal">
    <div class="komodo-custom-modal-dialog">
        <div class="komodo-custom-modal-content">
            <div class="komodo-custom-modal-inner">
                <h3 class="komodo-modal-title">Created Post Url's</h3>
                <span class="komodo-close-modal" komodo-close-modal>X</span>
            </div>
            <div class="komodo-custom-modal-body">
                <div class="komodo-created-post" id="komodo-created-post-data">
                    <!-- Dynamic data  -->
                </div>                   
            </div>
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
        <h4 class="loading-text">Loading...</h4>
    </div>
</div>

  <div class="check-activity  check-activity-keyword">
	<div class="komodo-preloader-inner">
        <img src="<?=KOMODO_BLOGS_URL;?>/admin/images/preloader.gif">
        <h4 class="loading-text">Please wait a while...</h4>
    </div>
</div>





<!-- Delete popup -->
<div id="deletePopup" class="komodo-delete-modal komodo-custom-modal">
    <div class="komodo-custom-modal-dialog">
        <div class="komodo-custom-modal-content">
            <div class="komodo-custom-modal-inner">
                <span class="komodo-close-modal" komodo-close-modal>X</span>
            </div>
            <div class="komodo-custom-modal-body">
                <div class="komodo-delete-modal-body ">
                    <img src="<?=KOMODO_BLOGS_URL;?>/admin/images/delete.png">
                    <h3 class="komodo-modal-title">Are you sure you want to delete it?</h3>
                    <p>This action cannot be undone</p>    

                    <div class="komodo-btn-wrap">
                        <button type="button" class="komodo-btn komodo-btn-dark"  komodo-close-modal>Cancel</button>
                        <button type="button" class="komodo-btn seed-keyword-delete">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Multi Delete popup -->
<div id="multi-delete-seed-keyword" class="komodo-delete-modal komodo-custom-modal">
    <div class="komodo-custom-modal-dialog">
        <div class="komodo-custom-modal-content">
            <div class="komodo-custom-modal-inner">
                <span class="komodo-close-modal" komodo-close-modal>X</span>
            </div>
            <div class="komodo-custom-modal-body">
                <div class="komodo-delete-modal-body ">
                    <img src="<?=KOMODO_BLOGS_URL;?>/admin/images/delete.png">
                    <h3 class="komodo-modal-title">Are you sure you want to delete it?</h3>
                    <p>This action cannot be undone</p>    

                    <div class="komodo-btn-wrap">
                        <button type="button" class="komodo-btn komodo-btn-dark"  komodo-close-modal>Cancel</button>
                        <button type="button" class="komodo-btn multi-seed-keyword-delete">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

