
<!-- Save Keyword Screen Start -->
<div class="komodo-main-wrapper komodo-fullwidth">
    <div class="komodo-page-title">
        <h2>Saved Keywords</h2>
        <p>Gain Insights with Comprehensive Competition Data</p>
    </div>
    <div class="komodo-container">
        <div class="komodo-page-title">  
        </div>
        <div class="google-planner-activty-saveData">
            <form class="form">
                <div class="komodo-fixed-height-tablee">
                <table id="GooglaPlannerData" class="display komodo-custom-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="manage-column">S.N</th>
                            <th class="manage-column">Favorite</th>
                            <th class="manage-column">Keyword </th>
                            <th class="manage-column">High CPC</th>
                            <th class="manage-column">Low CPC</th>
                            <th class="manage-column">Avg Monthly Searches</th>
                            <th class="manage-column">Competition Value</th>
                            <th class="manage-column">Google Exact Result</th>
                            <th class="manage-column">Action</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>S.N</th>
                            <th>Favorite</th>
                            <th>Keyword</th>
                            <th>High CPC</th>
                            <th>Low CPC</th>
                            <th>Avg Monthly Searches</th>
                            <th>Competition Value</th>
                            <th>Google Exact Result</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>

                    <tbody>
                            <?php                          
                            $viewHtmlactivity = "";
                            $i=1;
                            $count = 0;	
                            foreach ($competitionData as $key => $value) {
                                $response = json_decode($value['cc_data'],true);
                                $monthlyVolumes = "";
                                foreach ($response['monthly_search_volumes'] as $key => $avMonth) {
                                    
                                    $monthlyVolumes .=  '<span class="komodo-mnth-text">' . ($avMonth['month']) . ' ' . ($avMonth['year']) . ' <b>' . ($avMonth['Searches']) . '</b></span>';
                                }
                            
                                if($response['competition_value']=="LOW"){
                                    $classname = "komodo-budget isLow";
                                }else if($response['competition_value']=="MEDIUM"){
                                    $classname = "komodo-budget isMedium";
                                }else if($response['competition_value']=="HIGH"){
                                    $classname = "komodo-budget isHigh";
                                }else{
                                    $classname = "komodo-budget isNA";
                                }
                                $num= $response['avg_monthly_searches'];

                                $favrateCheck = isset($value['Favorite']) && $value['Favorite']=="1" ? "#ff0000" : "#c7c7c6";
                                $favrateClass = isset($value['Favorite']) && $value['Favorite']=="1" ? "notfavrateIcon" : "favrateIcon";
                                $viewHtmlactivity .= '<tr>	
                                <td>'.$i.'</td>
                                <td><svg data-id="'.$value['cc_id'].'" class="'.$favrateClass.'" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0" viewBox="0 0 511.987 511" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path fill="'.$favrateCheck.'" d="M510.652 185.902a27.158 27.158 0 0 0-23.425-18.71l-147.774-13.419-58.433-136.77C276.71 6.98 266.898.494 255.996.494s-20.715 6.487-25.023 16.534l-58.434 136.746-147.797 13.418A27.208 27.208 0 0 0 1.34 185.902c-3.371 10.368-.258 21.739 7.957 28.907l111.7 97.96-32.938 145.09c-2.41 10.668 1.73 21.696 10.582 28.094 4.757 3.438 10.324 5.188 15.937 5.188 4.84 0 9.64-1.305 13.95-3.883l127.468-76.184 127.422 76.184c9.324 5.61 21.078 5.097 29.91-1.305a27.223 27.223 0 0 0 10.582-28.094l-32.937-145.09 111.699-97.94a27.224 27.224 0 0 0 7.98-28.927zm0 0" opacity="1" data-original="#ffc107" class=""></path></g></svg></td>
                                <td><span class="komodo-table-title">'.$response['keyword'].'</span><a href="javascript:;" komodo-open-modal="funnelModal" g-post-name="'.$response['keyword'].'" class="clickBtn komodo-link-title" komodo-open-modal="generatePostModal">Generate Post</a></td>
                                <td><span class="komodo-high-cpc">'.($response["High CPC"]).'</span></td>
                                <td><span class="komodo-high-low">'.($response["Low CPC"]).'</span></td>
                                <td>'.$response['avg_monthly_searches'].'</td>
                                
                                <td>
                                    <span class="'.$classname.'">
                                        '.$response['competition_value'].'
                                    </span>									
                                </td>
                                <td><form class="form"><input hidden name="exw" value="'.$response['keyword'].'"><button type="button"  exw="'.$response['keyword'].'" komodo-open-modal="CheckExactResult"class="komodo-btn exact-result-check" value="Check Activity">Check Exact Result</button></form></td>
                                <td><a href="javascript:void(0);" class="deletesaveData" data-id="'.$value['cc_id'].'"><svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clipPath="url(#clip0_3038_3710)">
                                <path d="M14.375 3.3125C14.375 2.79474 13.9553 2.375 13.4375 2.375H11.0775C10.6826 1.2546 9.62547 0.503809 8.43751 0.5H6.56251C5.37455 0.503809 4.31743 1.2546 3.92251 2.375H1.5625C1.04474 2.375 0.625 2.79474 0.625 3.3125C0.625 3.83026 1.04474 4.25 1.5625 4.25H1.87501V12.0625C1.87501 13.961 3.41403 15.5 5.3125 15.5H9.68749C11.586 15.5 13.125 13.961 13.125 12.0625V4.25H13.4375C13.9553 4.25 14.375 3.83026 14.375 3.3125ZM11.25 12.0625C11.25 12.9254 10.5505 13.625 9.68752 13.625H5.3125C4.44956 13.625 3.75001 12.9254 3.75001 12.0625V4.25H11.25V12.0625Z" fill="#FF4A4A"/>
                                <path d="M5.9375 11.75C6.45526 11.75 6.875 11.3303 6.875 10.8125V7.0625C6.875 6.54474 6.45526 6.125 5.9375 6.125C5.41974 6.125 5 6.54474 5 7.0625V10.8125C5 11.3303 5.41974 11.75 5.9375 11.75Z" fill="#FF4A4A"/>
                                <path d="M9.0625 11.75C9.58026 11.75 10 11.3303 10 10.8125V7.0625C10 6.54474 9.58026 6.125 9.0625 6.125C8.54474 6.125 8.125 6.54474 8.125 7.0625V10.8125C8.125 11.3303 8.54474 11.75 9.0625 11.75Z" fill="#FF4A4A"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_3038_3710">
                                <rect width="15" height="15" fill="white" transform="translate(0 0.5)"/>
                                </clipPath>
                                </defs>
                                </svg>
                                </a></rtd>
                                </tr>';
                                $i++;
                                $count++;
                            }
                            echo $viewHtmlactivity;

                            function format_num($num, $precision = 2) {
                                if ($num >= 1000 && $num < 1000000) {
                                $n_format = number_format($num/1000, $precision).'K';
                                } else if ($num >= 1000000 && $num < 1000000000) {
                                $n_format = number_format($num/1000000, $precision).'M';
                                } else if ($num >= 1000000000) {
                                $n_format =$num/1000000000 .'B';
                                } else {
                                $n_format = $num;
                                }
                                return $n_format;
                            }

                        ?>
                        
                        
                    </tbody>
                </table>
                </div>               
            </form>
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
<!-- Delete popup -->
<div id="deletePopup" class="komodo-delete-modal komodo-custom-modal">
    <div class="komodo-custom-modal-dialog">
        <div class="komodo-custom-modal-content">
            <div class="komodo-custom-modal-inner">
                <span class="komodo-close-modal" komodo-close-modal>X</span>
            </div>
            <div class="komodo-custom-modal-body">
                <div class="komodo-delete-modal-body">
                    <img src="<?=KOMODO_BLOGS_URL;?>/admin/images/delete.png">
                    <h3 class="komodo-modal-title">Delete</h3>
                    <p>Are you sure you want to delete it? This action cannot be undone</p>
                    <div class="komodo-btn-wrap">
                        <button type="button"  class="komodo-btn komodo-btn-dark" komodo-close-modal>Cancel</button>
                        <button type="button" class="komodo-btn Confirm-delete">Confirm</button>
                    </div>
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
<!-- Modal -->
<div id="funnelModal" class="komodo-custom-modal">
    <div class="komodo-custom-modal-dialog">
        <div class="komodo-custom-modal-content">
            <div class="komodo-custom-modal-inner">
                <h3 class="komodo-modal-title">Post Name - <span class="google-post-name Generating-post-name"></span></h3>
                <p><span class="suggestionPromptHead">Suggested  Prompt :-</span> <span>Prepare a 2500-word blog post on the topic <span class="google-post-name suggestionPrompt"></span> The article should be well structured with headings and subheadings, effectively organizing the content. The keyword <span class="google-post-name suggestionPrompt"></span> should be mentioned between 63 and 100 times throughout the article, achieving a keyword density of around 2.5%. Ensure the keyword is naturally integrated into various places in the content, including the title, introductory paragraph, and throughout the body of the text to avoid repetition and maintain a smooth flow.</span></p>
              
                <span class="komodo-close-modal" komodo-close-modal>X</span>
            </div>
            <div class="komodo-custom-modal-body">
                <form class="form" method="post">
                    <div class="komodo-input">
                        <input type="text" name="google-genarate-post-content-query" class="komodo-input google-genarate-post-content regular-text require" placeholder="Please Enter Prompt">
                    </div>
                    <a href="javascript:void(0);" action="OepenAiGeneratePost" id="google-genarate-post" class="komodo-btn google-genarate-post">Create Post</a>
                </form>
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