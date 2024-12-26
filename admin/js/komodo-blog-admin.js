(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 */
	$(function() {
		$('.komodo-preloader').removeClass('komodo-el-hidden');		
		$('a[href="admin.php?page=page-screens"]').closest('li').remove();	
		$('a[href="admin.php?page=top-campaign-traffic"]').closest('li').remove();	
		$('a[href="admin.php?page=event-show"]').closest('li').remove();	
	});
	 /*
	 * When the window is loaded:
	 */
	 $(document).ready(function() {
  
		var table = $('#GooglaPlannerData').DataTable({ 
			  select: false,
			  "columnDefs": [{
				  className: "Name", 
				  "targets":[0],
				  "visible": false,
				  "searchable":false
			  }]
		  });//End of create main table
		
	});
	  $( window ).load(function() {		
		const URL = $('#hmurl').val();		
		setTimeout(function(){
			$('.komodo-preloader').addClass('komodo-el-hidden');
		},2000);

		
		 /**
		* Api Setting Tab
		*/
		$('.komodo-tabs-nav li:first-child').addClass('active');
		$('.komodo-single-tab').hide();
		$('.komodo-single-tab:first').show();
		$('.komodo-tabs-nav li').click(function() {
			$('.komodo-tabs-nav li').removeClass('active');
			$(this).addClass('active');
			$('.komodo-single-tab').hide();
			var activeTab = $(this).find('a').attr('href');
			$(activeTab).fadeIn();
			return false;
		}); 


		// Modal Script 
		$('[komodo-open-modal]').on('click', function(){
			$('body').addClass("komodo-modal-open");
			var id = $(this).attr('komodo-open-modal');
			$('.komodo-custom-modal#'+id).addClass('komodo-active');
		});
		$('[komodo-close-modal]').on('click', function(){
			$('body').removeClass("komodo-modal-open");
			$(this).parents('.komodo-custom-modal').removeClass('komodo-active');
		});
		$('.komodo-custom-modal').on('click', function(e) {
			if(e.target !== this){return};
			$(this).removeClass('komodo-active');
			$('body').removeClass("komodo-modal-open");
		});


		// form validation
		function validate_form(target) {
			var check = 'valid';
			target.find('input , textarea , select').each(function() {
				var email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
				var url = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/;
				var websiteUrl = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
				var image = /\.(jpe?g|gif|png|PNG|SVG|svg|JPE?G)$/;
				var images = /\.(jpe?g|png|PNG|JPE?G)$/;
				var video = /\.(flv|avi|mov|mpg|wmv|m4v|mp4|mp3|wma|3gp)$/;
				var mobile = /((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))/;
				var facebook = /^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/;
				var twitter = /^(https?:\/\/)?(www\.)?twitter.com\/[a-zA-Z0-9(\.\?)?]/;
				var google_plus = /^(https?:\/\/)?(www\.)?plus.google.com\/[a-zA-Z0-9(\.\?)?]/;
				var number = /^[\s()+-]*([0-9][\s()+-]*){1,20}$/;
				var password = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#])[A-Za-z\d$@$!%*?&#]{8,}$/;
				var pdfimage = /\.(pdf|PDF)$/;
				var float_num = /^[-+]?[0-9]+\.[0-9]+$/;
				var youtube = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
				var vimeo = /^.*((http|https)?:\/\/(www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(\d+)(?:|\/\?)).*/;
				var TagReg = /[<>`;&=+/()|^%*+]/g;
				var text_only = /^[a-zA-Z ]*$/g;
	
				var dropbox = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?([a-z0-9]+([\-\.]dropboxusercontent)|dropbox)\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
				var embed = /embed/g;
				var excel = /\.(xlsx)$/;
				if ($(this).hasClass('require')) {
	
					if ((typeof $(this).val() == 'object' && isEmpty($(this).val()) == true) || (typeof $(this).val() != 'object' && $(this).val().trim() == '')) {
						// 1
						ME_alert_message('Some required fields are missing.', 'rys-error');
						$(this).addClass('error').focus();                   
						check = 'novalid';
						return false;
					} else {
						$(this).removeClass('error');                   
						check = 'valid';
					}
				}
	
				if ((typeof $(this).val() == 'object' && isEmpty($(this).val()) == true) || (typeof $(this).val() != 'object' && $(this).val().trim() != '')) {
					var valid = $(this).attr('data-valid');
					if (typeof valid != 'undefined') {
						if (!eval(valid).test($(this).val().trim())) {
							$(this).addClass('error').focus();
							ME_alert_message($(this).attr('data-error'), 'rys-error');						
							check = 'novalid';
							return false;
						} else {
							$(this).removeClass('error');
							check = 'valid';
						}
					}
				}
	
			});
			return check;
		}        		
	
		/**
		 * Plugin Authentication  
		*/
		$(document).on('click','.kb_Authentication_key',function(e){
			e.preventDefault();

			var obj = $(this);
			$('.komodo-preloader').removeClass('komodo-el-hidden');
			var validchk = validate_form(obj.closest('form'));
        	if (validchk == 'valid') {

				var formdata = new FormData(obj.closest('form')[0]);
				formdata.append('action',obj.attr('action'));
				formdata.append('type',obj.val());

				$.ajax({
					method: "POST",
					url: ajaxurl,
					data: formdata,
					processData: false,
					contentType: false,
					success: function(resp) {
						var resp = $.parseJSON(resp);
						console.log(resp);
						$('.komodo-preloader').addClass('komodo-el-hidden');
						if (resp.status == '1') {						
							ME_alert_message(resp.msg, 'rys-success');						
							setTimeout(function(){
								window.location.href = resp.url;
							},1000);							
						}else{							
							ME_alert_message(resp.msg, 'rys-error');
							setTimeout(function(){
								window.location.href = resp.url;
							},1000);
						}
					},
					error: function(xmlhttprequest, textstatus, message) {
						if (textstatus === 'timeout') {
							// toastr.error(ltr_something_msg);
							// $('.edu_preloader').fadeOut();
							ME_alert_message(resp.msg, 'rys-error');
						}
					}
				});
			}
		});

		/**
		 * Seed Key Words Search By Google 
		*/
		
		$(document).on('click','.saved-keyword',function(e){	
			var URL = $(this).parent('.kb-seed-keywords-suggestion').find('.remove-saved-key').attr('site_url');
			var preloader = `<img src="${URL}/wp-content/plugins/rank-your-site/admin/images/keyup.gif">`;
			$('.prelooader').empty();	
			$('.prelooader').append(preloader);
			$('.savedKeyOption').removeClass('active');				
			$('.search-keywords').val($(this).text());
			
			var obj = $(this);			
			var formdata = new FormData();
			formdata.append('action','seed_keywords_serach');		
			formdata.append('seed-keywords',$(this).text());		
			$(this).parent('.savedKeyOption').addClass('active');
			seedKeywordsSearch(obj,formdata);
			
		});	
		$('.google-planner-activity').hide();

		let typingTimer;
		const doneTypingInterval = 2000; // Time in milliseconds

		$('.search-keywords').on('keyup', function(e) {
			e.preventDefault();
			var obj = $(this);
			clearTimeout(typingTimer);
			typingTimer = setTimeout(function(){
				var formdata = new FormData(obj.closest('form')[0]);
				formdata.append('action',atob(obj.attr('action')));		
				seedKeywordsSearch(obj,formdata);

			}, doneTypingInterval);	
		});
		$('.search-keywords').on('keydown', function() {
			clearTimeout(typingTimer);
			var preloader = `<img src="${URL}/wp-content/plugins/rank-your-site/admin/images/keyup.gif">`;
			$('.prelooader').empty();
			$('.prelooader').append(preloader);
			$('#output').text('Typing...');
		});
		// $(document).on('keyup','.search-keywords',function(e){
		// 	e.preventDefault();
		// 	var obj = $(this);
		// 	var inputValue = obj.val();
		// 	var lastChar = inputValue.slice(-1);
		// 	var inputValueWithoutSpaces = inputValue.replace(/\s+/g, '');
		// 	var formdata = new FormData(obj.closest('form')[0]);
		// 	formdata.append('action',atob(obj.attr('action')));		
		// 	seedKeywordsSearch(obj,formdata);

		// 	// Check if the last character is a space, punctuation, or the input is empty
		// 	if(inputValueWithoutSpaces.length === 0){
		// 		return;
		// 	}else 
		// 	if (lastChar === ' ' || lastChar === '.' || lastChar === ',' || lastChar === '!' || lastChar === '?') {
		// 		// $('#output').text('Word completed: ' + inputValue.trim().split(' ').slice(-2, -1));
				
		// 		var formdata = new FormData(obj.closest('form')[0]);
		// 		formdata.append('action',atob(obj.attr('action')));		
		// 		seedKeywordsSearch(obj,formdata);
		// 	} else {
		// 		var preloader = `<img src="${URL}/wp-content/plugins/rank-your-site/admin/images/keyup.gif">`;
		// 		$('.prelooader').empty();
		// 		$('.prelooader').append(preloader);
		// 		$('#output').text('Typing...');
		// 	}			
		// });
		function seedKeywordsSearch(obj,formdata){
			$.ajax({
				method: "POST",
				url: ajaxurl,
				data: formdata,
				processData: false,
				contentType: false,
				success: function(resp) {
					var resp = $.parseJSON(resp);
					
					if(resp.status==1){
						$('.please-wait-text').hide();
						$('.google-planner-activity').show();
						$('.seed-keywords-list-data').empty();
						var  preloader = `<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none" role="img">
											<path d="M1.5 7.75C1.5 9.4076 2.15848 10.9973 3.33058 12.1694C4.50269 13.3415 6.0924 14 7.75 14C9.4076 14 10.9973 13.3415 12.1694 12.1694C13.3415 10.9973 14 9.4076 14 7.75C14 6.0924 13.3415 4.50269 12.1694 3.33058C10.9973 2.15848 9.4076 1.5 7.75 1.5C6.0924 1.5 4.50269 2.15848 3.33058 3.33058C2.15848 4.50269 1.5 6.0924 1.5 7.75V7.75Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
											<path d="M12.814 12.8132L15.5 15.4999" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
										</svg>`;
						$('.prelooader').empty();
						$('.prelooader').append(preloader);
						$('#output').text('');
						let viewHtml ="<div class='komodo-keyword-listing'><span hidden><label for='checkall'>Check All</label><input id='checkall' type='checkbox' value='all' class='kb-seed-keywords-check-all'></span>";
						
						$.each(resp.data, function(index, value) {

							viewHtml += `<label for='seedkeywords_${index}' class="kb-seed-keywords-suggestion">
											<input name='seedkeywords' type='checkbox' id='seedkeywords_${index}' value='${value}'>
											<span>${value}</span>
										</label>`;
						});
						
						viewHtml +="</div>";
						$('.seed-keywords-list-data').append(viewHtml);

					}else{
						$('.google-planner-activity').hide();
						$('.seed-keywords-list-data').empty();
						// ME_alert_message(resp.msg, 'rys-error');
					}
				},
				error: function(xmlhttprequest, textstatus, message) {
					if (textstatus === 'timeout') {							
						ME_alert_message(resp.msg, 'rys-error');
					}
				}
			});
			
		}
		/*seed keyword select count */

		$(document).on('click','.kb-seed-keywords-suggestion',function(){
			var selectedValues = [];
			var checkboxCount = 0;
			$('input[name="seedkeywords"]:checked').each(function() {
				selectedValues.push($(this).val());
				checkboxCount++;
			});
			if(checkboxCount>10){				
				ME_alert_message(`There will be lot of data`, 'rys-error');			
				return false;
			}
		});
		
		$(document).on('click','.kb-seed-keywords-check-all',function(){
			$(this).removeClass('kb-seed-keywords-check-all');
			$(this).addClass('kb-seed-keywords-d-check-all');
			$('input[name="seedkeywords"]').prop('checked', true);
		});
		$(document).on('click','.kb-seed-keywords-d-check-all',function(){
			$(this).addClass('kb-seed-keywords-check-all');
			$(this).removeClass('kb-seed-keywords-d-check-all');
			$('input[name="seedkeywords"]').prop('checked', false);
		});

		$(document).on('click','.komodo-slide-cls-btn',function(e){
			$("body").removeClass("slide-open");
		});

		function formatNumber(number) {
			if (number >= 1000 && number < 1000000) {
				// Convert to thousands and add 'k'
				return (number / 1000).toFixed(1).replace(/\.0$/, '') + 'k';
			} else if (number >= 1000000 && number < 1000000000) {
				// Convert to millions and add 'M'
				return (number / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
			} else if (number >= 1000000000) {
				// Convert to billions and add 'B'
				return (number / 1000000000).toFixed(1).replace(/\.0$/, '') + 'B';
			} else {
				// Return the number as is if it's less than 1000
				return number.toString();
			}
		}

		$(document).on('click','.Check-google-planner-activity',function(e){
			e.preventDefault();		
			
			var obj = $(this);

			var selectedValues = [];
			var checkboxCount = 0;

			$('input[name="seedkeywords"]:checked').each(function() {
				selectedValues.push($(this).val());
				checkboxCount++;
			});

			if(checkboxCount>10){
				ME_alert_message(`There will be lot of data`, 'rys-error');			
				return false;
			}else 
			if(checkboxCount<=0){
				ME_alert_message(`Please select a keyword`, 'rys-error');	
				return false;
			}
			$('.check-activity-keyword').removeClass('check-activity');
			$('.check-activity-keyword').addClass('komodo-preloader')
			$(this).text('Please Wait...');
			$(this).attr('disabled' ,'disabled');
			var girloader = `<svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="30px" height="30px" viewBox="0 0 128 128" xml:space="preserve"><path fill="#ffffff" d="M64.4 16a49 49 0 0 0-50 48 51 51 0 0 0 50 52.2 53 53 0 0 0 54-52c-.7-48-45-55.7-45-55.7s45.3 3.8 49 55.6c.8 32-24.8 59.5-58 60.2-33 .8-61.4-25.7-62-60C1.3 29.8 28.8.6 64.3 0c0 0 8.5 0 8.7 8.4 0 8-8.6 7.6-8.6 7.6z"><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1800ms" repeatCount="indefinite"></animateTransform></path></svg>`;
			$(this).append(girloader);

			var formdata = new FormData();
			formdata.append('action',obj.attr('action'));		
			formdata.append('country',$("#geoTarget").val());		
			formdata.append('seedkeywords',selectedValues);		

			const itemsPerPage = 10;  // Number of items to display per page
			let currentPage = 1;     // Current page number
		
			$.ajax({
				method: "POST",
				url: ajaxurl,
				data: formdata,
				processData: false,
				contentType: false,
				success: function(resps) {					
					var resp = $.parseJSON(resps);
					$('.check-activity-keyword').addClass('check-activity');
					$('.check-activity-keyword').removeClass('komodo-preloader')
					$('.Check-google-planner-activity').empty();
					$('.google-planner-activty').empty();
					$('.selected-keyword-listing').empty();
					$('.Check-google-planner-activity').text('Check Activity');
					$('.Check-google-planner-activity').removeAttr('disabled');
					if(resp.status !=0){
						
						selectedValues.forEach(keyword => {
							$('.selected-keyword-listing').append(`<label class="">								
								<span>${keyword}</span>
							</label>`);
						});
						
						$("body").addClass("slide-open");
						$('.total-count').empty();
						const data ='';
						const itemsPerPage = 3;  // Number of items to display per page
						let currentPage = 1;     // Current page number
						
						var viewHtmlactivity = `<table id='checkGooglePlannerActivity' class='komodo-custom-table googlePlannerData' cellspacing="0" width="100%">`
							viewHtmlactivity += `<thead><tr>`;
							viewHtmlactivity += `<th class='manage-column' c-v="2">S.N</th>`;
							viewHtmlactivity += `<th class='manage-column'><div class="ee-checkbox">
														<input type="checkbox" id="checkAll"> 
														<span><!-- span has design  --></span>													
												</div></th>`;							
							viewHtmlactivity += `<th class='manage-column' c-v="2">Save Keyword</th>`;
							viewHtmlactivity += `<th class='manage-column' c-v="2">Keyword</th>`;
							viewHtmlactivity += `<th class='manage-column' c-v="3">High CPC</th>`;
							viewHtmlactivity += `<th class='manage-column' c-v="4">Low CPC</th>`;
							viewHtmlactivity += `<th class='manage-column' c-v="5">Avg Monthly Searches</th>`;
							viewHtmlactivity += `<th class='manage-column' c-v="6">Competition Value</th>`;
							viewHtmlactivity += `<th class='manage-column' c-v="7">Google Exact Result</th>`;
							viewHtmlactivity += `</thead><tbody>`;
						
						var i =1;	
						var count = 0;			
						resp.data.forEach((item,index) => {
						   
							const monthlyVolumes = item.monthly_search_volumes.map(volume => 
							  `<span class="komodo-mnth-text">${volume.month} ${volume.year}  <b>${formatNumber(volume.Searches)}</b></span>`).join('');						 
							if(item.competition_value=="LOW"){
								var classname = "komodo-budget isLow";
							}else if(item.competition_value=="MEDIUM"){
								var classname = "komodo-budget isMedium";
							}else if(item.competition_value=="HIGH"){
								var classname = "komodo-budget isHigh";
							}else{
								var classname = "komodo-budget isNA";
							}
							  var msv = { msv: monthlyVolumes }; 
						
							viewHtmlactivity += `<tr>		
								<td>${i}</td>						
								<td><div class="ee-checkbox">
										<input class="checkItem" type="checkbox" name="CheckCompetion[]" value="${btoa(unescape(encodeURIComponent( JSON.stringify(item))))}">
										<span><!-- span has design  --></span>
									</div> 
								</td>								
								<td><svg D="${btoa(unescape(encodeURIComponent( JSON.stringify(item))))}" class="favoriteDataAdd" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0" viewBox="0 0 511.987 511" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path fill="#c7c7c6" d="M510.652 185.902a27.158 27.158 0 0 0-23.425-18.71l-147.774-13.419-58.433-136.77C276.71 6.98 266.898.494 255.996.494s-20.715 6.487-25.023 16.534l-58.434 136.746-147.797 13.418A27.208 27.208 0 0 0 1.34 185.902c-3.371 10.368-.258 21.739 7.957 28.907l111.7 97.96-32.938 145.09c-2.41 10.668 1.73 21.696 10.582 28.094 4.757 3.438 10.324 5.188 15.937 5.188 4.84 0 9.64-1.305 13.95-3.883l127.468-76.184 127.422 76.184c9.324 5.61 21.078 5.097 29.91-1.305a27.223 27.223 0 0 0 10.582-28.094l-32.937-145.09 111.699-97.94a27.224 27.224 0 0 0 7.98-28.927zm0 0" opacity="1" data-original="#ffc107" class=""></path></g></svg></td>
								<td><span class="komodo-table-title">${item.keyword}</span></td>
								<td><span class="komodo-high-cpc">${item["High CPC"]}</span></td>
								<td><span class="komodo-high-low">${item["Low CPC"]}</span></td>
								<td>${item.avg_monthly_searches}</td>
								
								<td>
									<span class="${classname}">
										${item.competition_value}
									</span>									
								</td>
								<td>									
									<form class="form">
										<input hidden name="exw" value="${item.keyword}">
										<span class="komodo-budget isNA RemoveRow">Remove</span>
										<button type="button"  exw='${item.keyword}' komodo-open-modal="CheckExactResult"class="komodo-btn exact-result-check" value="Check Activity">Check Exact Result</button>
									</form>
						        </td>								
								  </tr>`;
							i++;
							count++;
						});
							// <td><div class="komodo-month-info">
							// <div class="month-year-data" hidden>
							// 	${monthlyVolumes}
							// </div>
							// <a href="javascript:void(0);" data="" komodo-open-modal="volumesModal" class="modal-btn msv-get-data">View <svg fill="currentColor" version="1.1" width="20" height="20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 20"><g transform="matrix(1.33333 0 0 -1.33333 0 682.667)"><path d="M7.5,499.2c-5,0-7.3,4.8-7.4,5c-0.1,0.2-0.1,0.3,0,0.5c0.1,0.2,2.4,5,7.4,5s7.3-4.8,7.4-5c0.1-0.2,0.1-0.3,0-0.5C14.8,504,12.5,499.2,7.5,499.2z M1.3,504.5c0.5-0.9,2.6-4.1,6.2-4.1s5.7,3.2,6.2,4.1c-0.5,0.9-2.6,4.1-6.2,4.1S1.8,505.4,1.3,504.5z"/><path class="st0" d="M7.5,501.6c-1.6,0-2.9,1.3-2.9,2.9s1.3,2.9,2.9,2.9s2.9-1.3,2.9-2.9S9.1,501.6,7.5,501.6z M7.5,506.3c-1,0-1.8-0.8-1.8-1.8c0-1,0.8-1.8,1.8-1.8s1.8,0.8,1.8,1.8C9.3,505.5,8.5,506.3,7.5,506.3z"/></g></svg></a>
							// </span></td>
						
						$('.total-count').append('('+count+')');
						viewHtmlactivity += `</tbody></table>`;
						$('.google-planner-activty').append(viewHtmlactivity);

						$('#checkGooglePlannerActivity').DataTable({ 
							select: false,
							"columnDefs": [{
								className: "Name", 
								"targets":[0],
								"visible": false,
								"searchable":false
							}]
						});//End of create main table
						$(document).on('change','#checkAll',function() {							
							// Check or uncheck all checkboxes based on the master checkbox state
							$('.checkItem').prop('checked', $(this).prop('checked'));
							// $('.Check-google-planner-createPost').removeClass('komodo-el-hidden');
							$('.Check-google-planner-saveData').removeClass('komodo-el-hidden');
							$('tbody').find('tr').addClass('rys-select-row');
							
							if($('.checkItem:checked').length==0){
								$('tbody').find('tr').removeClass('rys-select-row');
								$('.Check-google-planner-createPost').addClass('komodo-el-hidden');
								$('.Check-google-planner-saveData').addClass('komodo-el-hidden');
							}
						});
					
						// When any individual checkbox is changed
						$(document).on('change','.checkItem',function() {			
							// If all individual checkboxes are checked, check the master checkbox
							if ($('.checkItem:checked').length === $('.checkItem').length) {
								$('#checkAll').prop('checked', true);		
								$(this).parent('.ee-checkbox').parent('td').parent('tr').addClass('rys-select-row');						
							} else {
								// Otherwise, uncheck the master checkbox
								$('#checkAll').prop('checked', false);
								$(this).parent('.ee-checkbox').parent('td').parent('tr').removeClass('rys-select-row');
								
							}
							if($('.checkItem:checked').length==0){
								// $('.Check-google-planner-createPost').addClass('komodo-el-hidden');
								$('.Check-google-planner-saveData').addClass('komodo-el-hidden');
								
							}
							if($('.checkItem:checked').length>0){
								// $('.Check-google-planner-createPost').removeClass('komodo-el-hidden');
								$('.Check-google-planner-saveData').removeClass('komodo-el-hidden');
								
							}
							var parentRow = $(this).closest('tr');
			
							// Check if the checkbox is checked
							if ($(this).is(':checked')) {
								// Add the class to the parent <tr>
								parentRow.addClass('rys-select-row');
							} else {
								// Remove the class from the parent <tr>
								parentRow.removeClass('rys-select-row');
							}
						});

					}else{
						ME_alert_message(resp.msg, 'rys-error');
					}
				},
				error: function(xmlhttprequest, textstatus, message) {
					if (textstatus === 'timeout') {					
						ME_alert_message(resp.msg, 'rys-error');	
					}
				}
			});	
		});

		$(document).on('change','#checkAll',function() {							
			// Check or uncheck all checkboxes based on the master checkbox state
			$('.checkItem').prop('checked', $(this).prop('checked'));
			// $('.Check-google-planner-createPost').removeClass('komodo-el-hidden');
			$('.Check-google-planner-saveData').removeClass('komodo-el-hidden');
			$('tbody').find('tr').addClass('rys-select-row');
			
			if($('.checkItem:checked').length==0){
				$('tbody').find('tr').removeClass('rys-select-row');
				$('.Check-google-planner-createPost').addClass('komodo-el-hidden');
				$('.Check-google-planner-saveData').addClass('komodo-el-hidden');
			}
		});
		// When any individual checkbox is changed
		$(document).on('change','.checkItem',function() {		
			// If all individual checkboxes are checked, check the master checkbox
			if ($('.checkItem:checked').length === $('.checkItem').length) {
				$('#checkAll').prop('checked', true);	
				$(this).parent('.ee-checkbox').parent('td').parent('tr').addClass('rys-select-row');	
			} else {
				// Otherwise, uncheck the master checkbox
				$('#checkAll').prop('checked', false);
				$(this).parent('.ee-checkbox').parent('td').parent('tr').removeClass('rys-select-row');				
								
			}
			if($('.checkItem:checked').length==0){
				// $('.Check-google-planner-createPost').addClass('komodo-el-hidden');
				$('.Check-google-planner-saveData').addClass('komodo-el-hidden');				
				
			}
			if($('.checkItem:checked').length>0){
				// $('.Check-google-planner-createPost').removeClass('komodo-el-hidden');
				$('.Check-google-planner-saveData').removeClass('komodo-el-hidden');
			
			}

			var parentRow = $(this).closest('tr');
			
			// Check if the checkbox is checked
			if ($(this).is(':checked')) {
				// Add the class to the parent <tr>
				parentRow.addClass('rys-select-row');
			} else {
				// Remove the class from the parent <tr>
				parentRow.removeClass('rys-select-row');
			}
		});
		
		$(document).on('click','.RemoveRow',function(){
			$(this).parents('tr').remove();
		});
		$(document).on('click','.exact-result-check', function(){
			var preloader = `<img src="${URL}/wp-content/plugins/rank-your-site/admin/images/keyup.gif">`;
			$('#exact_resultSHow').empty();	
			$('#exact_resultSHow').append(preloader);

	    	var formdata = new FormData($(this).closest('form')[0]);
			formdata.append('action','exactResultShow');		
		     var exactResult = $(this).attr('exw');
		     
		    	$.ajax({
    				method: "POST",
    				url: ajaxurl,
    				data: formdata,
    				processData: false,
				    contentType: false,
    				success: function(resp) {
    				    $('#exact_resultSHow').html('<h2> Keyword : '+exactResult+'</h2><h4>'+resp+'</h4>');
    				}
		    	});
		});
		
		$(document).on('click','.msv-get-data', function(){
			var data = $(this).parents('.komodo-month-info').find('.month-year-data').html();
			$('#komodo-month-info').empty();
			setTimeout(function(){$('#komodo-month-info').append(data);},500);
		});

		$(document).on('click','[komodo-open-modal]', function(){
			$('body').addClass("komodo-modal-open");
			var id = $(this).attr('komodo-open-modal');
			$('.komodo-custom-modal#'+id).addClass('komodo-active');
		});
		$(document).on('click','[komodo-close-modal]', function(){					
			$('body').removeClass("komodo-modal-open");
			$(this).parents('.komodo-custom-modal').removeClass('komodo-active');
		});				
		$(document).on('click','.komodo-custom-modal', function(e){	
			if(e.target !== this){return};
			$(this).removeClass('komodo-active');
			$('body').removeClass("komodo-modal-open");
		});
		$("#search").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#table tbody tr").filter(function() {
			  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
		$(document).on('click','.clickBtn',function(){			
			$('.google-post-name').text('');			
			$('.google-genarate-post-content').val('');			
			$('.google-post-name').text($(this).attr('g-post-name'));
		});		
		$(document).on('click','#google-genarate-post',function(e){
			e.preventDefault();
			var obj = $(this);
			obj.text('Please Wait...!');
			$('.komodo-preloader').removeClass('komodo-el-hidden');
			var formdata = new FormData();
			formdata.append('action',obj.attr('action'));		
			formdata.append('postName',$('.Generating-post-name').text());		
			formdata.append('query',$('.google-genarate-post-content').val());		
			$.ajax({
				method: "POST",
				url: ajaxurl,
				data: formdata,
				processData: false,
				contentType: false,
				success: function(resp) {
					var resp = $.parseJSON(resp);	
					obj.text('Create Post');
					$('.komodo-preloader').addClass('komodo-el-hidden');
				
					if (resp.status == 1) {
						ME_alert_message(resp.msg, 'rys-success');							
						setTimeout(function(){
							window.location.href = resp.EDITURL;
						},1000);							
					}else{
						ME_alert_message(resp.msg, 'rys-error');
						if (resp.status != 2){
    						setTimeout(function(){
    							window.location.reload();
    						},3000);
    					}
					}
				},
				error: function(xmlhttprequest, textstatus, message) {
					if (textstatus === 'timeout') {					
						ME_alert_message(resp.msg, 'rys-error');	
					}
				}
			});						
		});
		
		$(document).on('click','.rys-site-maps-settings',function(e){
			e.preventDefault();
			var obj = $(this);
			obj.text('Please Wait...!');
			$('.komodo-preloader').removeClass('komodo-el-hidden');
			var btn = obj.text();
			var formdata = new FormData(obj.closest('form')[0]);
			formdata.append('action',obj.attr('action'));					
			$.ajax({
				method: "POST",
				url: ajaxurl,
				data: formdata,
				processData: false,
				contentType: false,
				success: function(resp) {
					var resp = $.parseJSON(resp);	
					$('.komodo-preloader').addClass('komodo-el-hidden');
					obj.text(btn);
					if (resp.status == 1) {
						ME_alert_message(resp.msg, 'rys-success');	
						setTimeout(function(){
							window.location.reload();
						},2000);							
					}else{
						ME_alert_message(resp.msg, 'rys-error');	
						setTimeout(function(){
							window.location.reload();
						},2000);
					}
				},
				error: function(xmlhttprequest, textstatus, message) {
					if (textstatus === 'timeout') {					
						ME_alert_message(resp.msg, 'rys-error');	
					}
				}
			});						
		});
		$(document).on('change', '#googletrendsget', function (e) {
			e.preventDefault();
			var obj = $(this);			
			$('.komodo-preloader').removeClass('komodo-el-hidden');
			var formdata = new FormData();
			formdata.append('action','GoogleTrands');			
			formdata.append('country',obj.val());				
			$('#checkAll').prop('checked', false);		
			$('.checkItem').prop('checked', false);		
			$.ajax({
				method: "POST",
				url: ajaxurl,
				data: formdata,
				processData: false,
				contentType: false,
				success: function(resps) {
					var resp = $.parseJSON(resps);	
					$('.komodo-preloader').addClass('komodo-el-hidden');
					$('.komodo-accordion').empty();
					var gtrend = "";
					var i = 1;
					
					resp.forEach(item => {	
						var jsonres = {
							'Title':item["Item Title"],
							'Traffic':item["Approx Traffic"],
							'Link':item["Link"],
							'Date':item["Publication Date"],
							'Picture':item["Picture"],
							'PictureSource':item["Picture Source"],
							'Description':item["Description"],
							'RelatedNews':item['RelatedNews']
						};
					
						var tlt = item['RelatedNews'][0]['News Item Title']; var tsrc = item['RelatedNews'][0]['News Item Source'];		
						var reletedchild = '';
						item['RelatedNews'].forEach(subChild => {	
							reletedchild +=`<a href="${subChild["News Item URL"]}" target="_blank" class="komodo-google-trend-content">
								<img src="${item["Picture"]}" alt="${item["Picture Source"]}" />
								<div class="komodo-post-content">
									<span class="komodo-post-date">${subChild["News Item Source"]} <span><b>.</b></span>${item['Hours Ago']}</span>
									<h4>${subChild['News Item Title']}</h4>
									<p>${subChild['News Item Snippet']}</p>
								</div>
							</a>`
						});
						gtrend += `
							 <div class="komodo-accordian-item">   
								<div class="ee-checkbox">
										<input class="checkItem" type="checkbox" name="trendsPosst[]" value='${btoa(unescape(encodeURIComponent( JSON.stringify(jsonres))))}'>
										<span><!-- span has design  --></span>
									</div>
                                <div class="komodo-accordian-title">
                                    <span class="post-counting"> ${i++}</span>
                                    <div class="komodo-trend-info">
                                        <div class="komodo-treand-title-info">
                                            <a class="komodo-trend-title" href="${item["Link"]}" target="_blank">${item["Item Title"]}</a>
                                        <p> ${item["Description"]}</p>
                                        <span class="komodo-publish-date">${item["Publication Date"]}</span>
                                        <span class="komodo-post-date">                                               
                                                <a href="${item["Link"]}" target="_blank">${tlt}</a>
                                                <span>${tsrc} </span>
                                                <span class="bold-text">${item['Hours Ago']}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="komodo-search-count">
                                        <div class="">
                                            ${item["Approx Traffic"]}
                                            <span>searches</span>
                                        </div>
                                    </div>
                                    <div class="komodo-trend-thumb">
                                        
                                        <img src="${item["Picture"]}" alt="${item["Picture Source"]}" />
                                        <h5>${item["Picture Source"]}</h5>
                                    </div>

                                </div>
                                <div class="komodo-accordian-tab">
                                    <div class="komodo-google-trend-posts">
                                        <h6>Related News</h6>
										${reletedchild}                                     
                                    </div>
                                </div>                                
                            </div>`;						
						

					});
			
					$('.komodo-accordion').append(gtrend);

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

					$('#checkAll').change(function() {
						// Check or uncheck all checkboxes based on the master checkbox state
						$('.checkItem').prop('checked', $(this).prop('checked'));
					});
				
					// When any individual checkbox is changed
					$('.checkItem').change(function() {			
						// If all individual checkboxes are checked, check the master checkbox
						if ($('.checkItem:checked').length === $('.checkItem').length) {
							$('#checkAll').prop('checked', true);							
						} else {
							// Otherwise, uncheck the master checkbox
							$('#checkAll').prop('checked', false);							
						}
					});
				},
				error: function(xmlhttprequest, textstatus, message) {
					if (textstatus === 'timeout') {					
						ME_alert_message(resp.msg, 'rys-error');	
					}
				}
			});	
		});
		
		$(document).on('click', '.trensPostCreate', function (e) {
			e.preventDefault();
			var obj = $(this);		

			var selectedValues = [];
			var checkboxCount = 0;
			
			$('input[name="trendsPosst[]"]:checked').each(function() {
				selectedValues.push($(this).val());
				checkboxCount++;
			});

			if(checkboxCount<=0){
				ME_alert_message(`No selected posts Please select at least one post from the list`, 'rys-error');			
				return false;
			}else 			
			$('.komodo-preloader').removeClass('komodo-el-hidden');
			var formdata = new FormData(obj.closest('form')[0]);
			formdata.append('action','TrendsPostCreate');		
			// formdata.append('checkBoxValue',selectedValues);		
					
			$.ajax({
				method: "POST",
				url: ajaxurl,
				data: formdata,
				processData: false,
				contentType: false,
				success: function(resp) {
					var resp = $.parseJSON(resp);	
					$('.komodo-preloader').addClass('komodo-el-hidden');
					if (resp.status == 1) {
						ME_alert_message(resp.msg, 'rys-success');	
						setTimeout(function(){
							window.location.reload();
						},2000);							
					}else{
						ME_alert_message(resp.msg, 'rys-error');	
						setTimeout(function(){
							window.location.reload();
						},2000);
					}		
				},
				error: function(xmlhttprequest, textstatus, message) {
					if (textstatus === 'timeout') {					
						ME_alert_message(resp.msg, 'rys-error');	
					}
				}
			});	
		});
		$(document).on('click', '.Check-google-planner-createPost,.Check-google-planner-saveData', function (e) {
			e.preventDefault();
			var obj = $(this);		

			var selectedValues = [];
			var checkboxCount = 0;
			$('.komodo-preloader').removeClass('komodo-el-hidden');
			$('input[name="CheckCompetion[]"]:checked').each(function() {
				selectedValues.push($(this).val());
				checkboxCount++;
			});

			if(checkboxCount<=0){
				ME_alert_message(`No selected posts Please select at least one Keywords from the list`, 'rys-error');			
				return false;
			}else 			
			$('.loading-text').text('The post is under construction please wait');
			var formdata = new FormData(obj.closest('form')[0]);
			formdata.append('action',obj.attr('action'));		
			formdata.append('ac-type',obj.attr('ac-type'));		
					
			$.ajax({
				method: "POST",
				url: ajaxurl,
				data: formdata,
				processData: false,
				contentType: false,
				success: function(resp) {
					var resp = $.parseJSON(resp);	
					console.log(resp);
					$('.komodo-preloader').addClass('komodo-el-hidden');
					if (resp.status == 1) {
						ME_alert_message(resp.msg, 'rys-success');	

						if(obj.attr('ac-type')!="saveData"){
							setTimeout(function(){
								window.location.href=resp.EDITURL;
							},2000);							
						}
					}else{
						ME_alert_message(resp.msg, 'rys-error');	
						if (resp.status != 2){
    						setTimeout(function(){
    							window.location.reload();
    						},3000);
    					}
					}		
				},
				error: function(xmlhttprequest, textstatus, message) {
					if (textstatus === 'timeout') {					
						ME_alert_message(resp.msg, 'rys-error');	
					}
				}
			});	
		});
		
		$(document).on('click','.deletesaveData,.Confirm-delete',function(e){
			var dataID = $(this).attr('data-id');	
			const DeleteAction = $(this).attr('action');	
			if($(this).hasClass('deletesaveData')) {
				$('body').addClass("komodo-modal-open");
				$('.komodo-custom-modal#deletePopup').addClass('komodo-active');
				$('.Confirm-delete').attr('data-id',dataID);				
			}else{
				var formdata = new FormData();
				formdata.append('action','compititionDataDelet');		
				formdata.append('ID',$(this).attr('data-id'));	
				$.ajax({
					method: "POST",
					url: ajaxurl,
					data: formdata,
					processData: false,
					contentType: false,
					success: function(resp) {
						var resp = $.parseJSON(resp);						
						if (resp.status == 1) {							
							ME_alert_message(resp.msg, 'rys-success');	
							setTimeout(function(){							
								setTimeout(function(){
									$('body').removeClass("komodo-modal-open");
									$('.komodo-custom-modal#deletePopup').removeClass('komodo-active');
								},800);
								window.location.reload();
							},1000);
						}else{
							ME_alert_message(resp.msg, 'rys-error');	
							setTimeout(function(){
								window.location.reload();
							},2000);
						}		
					},
					error: function(xmlhttprequest, textstatus, message) {
						if (textstatus === 'timeout') {					
							ME_alert_message(resp.msg, 'rys-error');	
						}
					}
				});	
			}
		});
		$(document).on('click','.remove-saved-key,.seed-keyword-delete',function(e){
			var dataID = $(this).attr('data-id');	
			const DeleteAction = $(this).attr('action');	
			
			if($(this).hasClass('remove-saved-key')) {
				$('body').addClass("komodo-modal-open");
				$('.komodo-custom-modal#deletePopup').addClass('komodo-active');
				$('.seed-keyword-delete').attr('data-id',dataID);				
				$('.seed-keyword-delete').attr('cls', $(this).attr('cls'));				
			}else{
				var formdata = new FormData();
				$(this).text('Please Wait...!');
				var ID = $(this).attr('data-id');
				formdata.append('action','seedKeywordDelete');		
				formdata.append('ID',$(this).attr('data-id'));	
				formdata.append('DelType',"single");	
				$.ajax({
					method: "POST",
					url: ajaxurl,
					data: formdata,
					processData: false,
					contentType: false,
					success: function(resp) {
						var resp = $.parseJSON(resp);						
						if (resp.status == 1) {	
							
							ME_alert_message(resp.msg, 'rys-success');	
							setTimeout(function(){							
								setTimeout(function(){
									$('body').removeClass("komodo-modal-open");
									$('.seed-keyword-delete').text('Confirm');									
									$('.komodo-custom-modal#deletePopup').removeClass('komodo-active');									
									$('.remove-tag-'+ID).remove();	
								},800);								
							},1000);
						}else{
							ME_alert_message(resp.msg, 'rys-error');	
							setTimeout(function(){
								window.location.reload();
							},2000);
						}		
					},
					error: function(xmlhttprequest, textstatus, message) {
						if (textstatus === 'timeout') {					
							ME_alert_message(resp.msg, 'rys-error');	
						}
					}
				});	
			}
		});
		
		$(document).on('click','.delete-save-seed-keywords,.multi-seed-keyword-delete',function(e){
	    	var obj = $(this);	
	    
			var formdata = new FormData(obj.closest('form')[0]);
			
			if($(this).hasClass('delete-save-seed-keywords')) {
			    var selectedValues = [];
    			var checkboxCount = 0;
    			obj.text('Confirm');
    			$('input[name="save_seed_keywords[]"]:checked').each(function() {
    				selectedValues.push($(this).val());
    				checkboxCount++;
    			});
    			
				if(checkboxCount<=0){
    				ME_alert_message(`No selected posts Please select at least one post from the list`, 'rys-error');			
    				return false;
    			}
    			
				$('body').addClass("komodo-modal-open");
				$('.komodo-custom-modal#multi-delete-seed-keyword').addClass('komodo-active');
				$('.multi-seed-keyword-delete').attr('data-ids',selectedValues);				
				$('.multi-seed-keyword-delete').attr('cls', obj.attr('cls'));				
			}else{
				var formdata = new FormData();
				obj.text('Please Wait...!');
				var ID = obj.attr('data-ids');
				formdata.append('action','seedKeywordDelete');		
				formdata.append('IDs',ID);	
				formdata.append('DelType',"multi");
				$('.komodo-preloader').removeClass('komodo-el-hidden');
				$.ajax({
					method: "POST",
					url: ajaxurl,
					data: formdata,
					processData: false,
					contentType: false,
					success: function(resp) {
						obj.text('Confirm');
						var resp = $.parseJSON(resp);						
						if (resp.status == 1) {	
							$('.komodo-preloader').addClass('komodo-el-hidden')
							ME_alert_message(resp.msg, 'rys-success');	
							setTimeout(function(){							
								setTimeout(function(){
									 $.each(resp.delID, function(index, id) {
									    $('.remove-tag-'+id).remove();	
                                    });
									$('body').removeClass("komodo-modal-open");
									$('.seed-keyword-delete').text('Confirm');									
									$('.komodo-custom-modal#deletePopup').removeClass('komodo-active');	
								},800);								
							},1000);
						}else{
							ME_alert_message(resp.msg, 'rys-error');	
							setTimeout(function(){
								window.location.reload();
							},2000);
						}		
					},
					error: function(xmlhttprequest, textstatus, message) {
						if (textstatus === 'timeout') {					
							ME_alert_message(resp.msg, 'rys-error');	
						}
					}
				});	
			}
		});
		
		$(document).on('click','.shorting',function(e){
			var columnIndex = $(this).attr('c-v');
			var table = $('#table');
            var tbody = table.find('tbody');
            var rows = tbody.find('tr').toArray();

            var isNumeric = function(n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
            };

            rows.sort(function(a, b) {
                var cellA = $(a).children('td').eq(columnIndex).text();
                var cellB = $(b).children('td').eq(columnIndex).text();

                if (isNumeric(cellA) && isNumeric(cellB)) {
                    return parseFloat(cellA) - parseFloat(cellB);
                } else {
                    return cellA.localeCompare(cellB);
                }
            });

            $.each(rows, function(index, row) {
                tbody.append(row);
            });
		});
		$('#seed_keyword_checkAll').change(function() {
			// Check or uncheck all checkboxes based on the master checkbox state
			$('.seed_keyword_checkItem').prop('checked', $(this).prop('checked'));	

			$('.delete-save-seed-keywords').removeClass('komodo-el-hidden');

			if($('.seed_keyword_checkItem:checked').length==0){				
				$('.delete-save-seed-keywords').addClass('komodo-el-hidden');				
			}
		});
	
		$(document).on('click','.favrateIcon,.notfavrateIcon',function(){
			var favId = $(this).data('id');
			var favType = "";
			if($(this).hasClass('favrateIcon')) {
				$(this).find('path').attr('fill','#ff0000');
				$(this).removeClass('favrateIcon');
				$(this).addClass('notfavrateIcon');
				favType +="add";
			}else if($(this).hasClass('notfavrateIcon')){
				$(this).find('path').attr('fill','#c7c7c6');
				$(this).removeClass('notfavrateIcon');
				$(this).addClass('favrateIcon');
				favType +="Notadd";
			}
			$.ajax({
				method: "POST",
				url: ajaxurl,
				data: {
					id: favId,
					Ftype:favType,
					action:"favoriteDataUpdate"
				},				
				success: function(resp) {
					var resp = $.parseJSON(resp);						
					if (resp.status == 1) {							
						ME_alert_message(resp.msg, 'rys-success');							
					}else{
						ME_alert_message(resp.msg, 'rys-error');						
					}		
				},
				error: function(xmlhttprequest, textstatus, message) {
					if (textstatus === 'timeout') {					
						ME_alert_message(resp.msg, 'rys-error');	
					}
				}
			});	
		});
		$(document).on('click','.favoriteDataAdd,.favrateNotDataAdd',function(){
			var d = $(this).attr('d');
			var id = $(this).attr('id');

			var formdata = new FormData();
			formdata.append('action','favDataAdd');	
			formdata.append('d',d);	
			formdata.append('id',id);	
			var clsName ="";
			if($(this).hasClass('favoriteDataAdd')) {
				$(this).addClass('favrateNotDataAdd addAttr');
				$(this).removeClass('favoriteDataAdd');
				$(this).find('path').attr('fill','#ff0000');			
				clsName +="favrateNotDataAdd.addAttr";
			}else if($(this).hasClass('favrateNotDataAdd')){
				$(this).addClass('favoriteDataAdd removeAttr');
				$(this).removeClass('favrateNotDataAdd');
				$(this).find('path').attr('fill','#c7c7c6');				
				clsName +="removeAttr";
			}
	
			$.ajax({
				method: "POST",
				url: ajaxurl,
				data: formdata,	
				processData: false,
				contentType: false,			
				success: function(resp) {					
					var resp = $.parseJSON(resp);						
					if (resp.status == 1) {	
						$('.'+clsName).attr('id',resp.insId);	
						$('.'+clsName).removeClass('addAttr');	
						ME_alert_message(resp.msg, 'rys-success');							
					}else if (resp.status == 2){
						$('.'+clsName).removeAttr('id');	
						$('.'+clsName).removeClass('removeAttr');
						ME_alert_message(resp.msg, 'rys-success');							
					}else{
						ME_alert_message(resp.msg, 'rys-error');						
					}		
				},
				error: function(xmlhttprequest, textstatus, message) {
					if (textstatus === 'timeout') {					
						ME_alert_message(resp.msg, 'rys-error');	
					}
				}
			});	
		});
		
		// When any individual checkbox is changed
		$('.seed_keyword_checkItem').change(function() {			
			// If all individual checkboxes are checked, check the master checkbox
			if ($('.seed_keyword_checkItem:checked').length === $('.seed_keyword_checkItem').length) {
				$('#seed_keyword_checkAll').prop('checked', true);												
			} else {
				// Otherwise, uncheck the master checkbox
				$('#seed_keyword_checkAll').prop('checked', false);				
			}
			if($('.seed_keyword_checkItem:checked').length==0){
				$('.delete-save-seed-keywords').addClass('komodo-el-hidden');
				$('#seed_keyword_checkAll').prop('checked', false);
			}
			if($('.seed_keyword_checkItem:checked').length>0){
				$('.delete-save-seed-keywords').removeClass('komodo-el-hidden');
				
			}
		});
		
	  });

	 /*
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */


	 /** Alert Function **/
	 function ME_alert_message(msg, msg_status) {
		$('.rys-alert-wrap p').text(msg);
		$('.rys-alert-wrap').addClass(msg_status);

		setTimeout(function() {
			$('.rys-alert-wrap').removeClass(msg_status);
		}, 3500);
	}
	$(document).on('click', '.top-campaigns', function(e){
		var TESurl = $(this).attr('url');
		var appName = $('#rys_appName').val();
		var propertyId = $('#rys_propertyId').val();
		var Locations = $('#rys_Locations').val();
		var topcampaign = $('#topcampaign').val();
				
		var dateRange =$('#dateRangePicker span').text();
       
        var dates = dateRange.split(" - ");
	
		window.open(`${TESurl}/admin.php?page=top-campaign-traffic&appname=${appName}&pro-id=${propertyId}&Locations=${Locations}&startDate=${dates[0]}&endDate=${dates[1]}&dimensions=${topcampaign}`);
	});
	$(document).on('click', '.page-screen', function(e){
		var TESurl = $(this).attr('url');
		var appName = $('#rys_appName').val();
		var propertyId = $('#rys_propertyId').val();
		var Locations = $('#rys_Locations').val();
				
		var dateRange =$('#dateRangePicker span').text();
       
        var dates = dateRange.split(" - ");
		
		window.open(`${TESurl}/admin.php?page=page-screens&appname=${appName}&pro-id=${propertyId}&Locations=${Locations}&startDate=${dates[0]}&endDate=${dates[1]}`);
	});
	$(document).on('click', '.top-event', function(e){
		var TESurl = $(this).attr('url');
		var appName = $('#rys_appName').val();
		var propertyId = $('#rys_propertyId').val();
		var Locations = $('#rys_Locations').val();
				
		var dateRange =$('#dateRangePicker span').text();
       
        var dates = dateRange.split(" - ");

		window.open(`${TESurl}/admin.php?page=event-show&appname=${appName}&pro-id=${propertyId}&Locations=${Locations}&startDate=${dates[0]}&endDate=${dates[1]}`);
	});
	//New code
	$(document).on('click', '.404-redirection-delete', function(e){
		var obj = $(this);
		obj.text('Please Wait...!');
		$.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                'action' : 'komodo_delete_404redirection',
            },
            success: function(response){
                console.log(response);
				var result = $.parseJSON(response);
				if(result.status == true){
					ME_alert_message(result.msg, 'rys-success');	
				}else{
					ME_alert_message(result.msg, 'rys-error');	
				}

				setTimeout(function(){
					window.location.reload();
				},1000);
            }
        })
	});

	$(document).on('click', '.updatealttag_images', function(e){
		var obj = $(this);
		obj.text('Please Wait...!');
		$.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                'action' : 'komodo_updatealttagonimages',
            },
            success: function(response){
                console.log(response);
				var result = $.parseJSON(response);
				if(result.status == true){
					ME_alert_message(result.msg, 'rys-success');	
				}else{
					ME_alert_message(result.msg, 'rys-error');	
				}

				setTimeout(function(){
					window.location.reload();
				},1000);
            }
        })
	});

})( jQuery );
