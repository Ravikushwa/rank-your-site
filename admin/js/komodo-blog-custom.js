(function($) {
    $(document).ready(function() {

        /**
         * Prevent Default on focus
         */ 
        $('#komodo-focuskeyword').on('focus', function(event) {
			event.preventDefault();
		});

		var numItems = $('.komodo-err').length;
		var totalpercent = 0;
		if(numItems != 0){
			minusepercent = 100/17;
			
			totalpercent = 100 - (minusepercent*numItems);
		}else{
			totalpercent = 100;
		}
        exclass = 'has-low-rank';
        if(Math.round(totalpercent) < 40 ){
            var exclass = 'has-low-rank';
        }
        if(Math.round(totalpercent) > 40 && Math.round(totalpercent) < 80){
            var exclass = 'has-mid-rank';
        }
        if(Math.round(totalpercent) > 80){
            var exclass = 'has-high-rank';
        }
        rys_update_focuskeywordpercent();
		
        //Header button gutenberg
        function addBackButton() {
            if ($('.editor-header__settings').length > 0 && $('#gutenberg-back-button').length === 0) {
                // Create and append the Back Button to the header
                var backButton = $('<button id="gutenberg-back-button" class="rys_btn_head components-button is-primary '+exclass+'"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="17" height="17"x="0" y="0" viewBox="0 0 512 512" ><g><path d="M441 172c-8.284 0-15 6.716-15 15v250c0 8.284 6.716 15 15 15h50c8.284 0 15-6.716 15-15V187c0-8.284-6.716-15-15-15zM321 232c-8.284 0-15 6.716-15 15v190c0 8.284 6.716 15 15 15h50c8.284 0 15-6.716 15-15V247c0-8.284-6.716-15-15-15zM201 172c-8.284 0-15 6.716-15 15v250c0 8.284 6.716 15 15 15h50c8.284 0 15-6.716 15-15V187c0-8.284-6.716-15-15-15zM81 452h50c8.284 0 15-6.716 15-15V327c0-8.284-6.716-15-15-15H81c-8.284 0-15 6.716-15 15v110c0 8.284 6.716 15 15 15z" fill="currentColor" opacity="1" data-original="#000000"/><path d="M496 482H31V15c0-8.284-6.716-15-15-15S1 6.716 1 15v482c0 8.284 6.716 15 15 15h480c8.284 0 15-6.716 15-15s-6.716-15-15-15z" fill="currentColor" opacity="1" data-original="#000000"/><path d="M106 237c22.056 0 40-17.944 40-40a39.741 39.741 0 0 0-4.49-18.379l71.753-83.712A39.813 39.813 0 0 0 226 97a39.767 39.767 0 0 0 22.518-6.961l58.305 38.87A40.032 40.032 0 0 0 306 137c0 22.056 17.944 40 40 40s40-17.944 40-40c0-2.771-.284-5.476-.823-8.09l58.306-38.87A39.768 39.768 0 0 0 466 97c22.056 0 40-17.944 40-40s-17.944-40-40-40-40 17.944-40 40c0 2.771.284 5.477.823 8.091l-58.305 38.87C362.099 99.572 354.345 97 346 97s-16.099 2.572-22.518 6.961l-58.305-38.87c.539-2.614.823-5.32.823-8.091 0-22.056-17.944-40-40-40s-40 17.944-40 40a39.741 39.741 0 0 0 4.49 18.379l-71.753 83.712A39.813 39.813 0 0 0 106 157c-22.056 0-40 17.944-40 40s17.944 40 40 40z" fill="currentColor" opacity="1" data-original="#000000"/></g></svg> <span class="mathpercent">&nbsp;&nbsp;'+Math.round(totalpercent)+'/100</span></button>');
                $('.editor-header__settings').prepend(backButton);

                // Add click event handler to the button
                $('#gutenberg-back-button').on('click', function () {
                    $("body").addClass("seo-slide-open");
                });
            }
        }
        // Initial call to add the button
        addBackButton();

        // Check periodically if the editor is loaded and add the button
        var interval = setInterval(function () {
            if ($('.editor-header__settings').length > 0) {
                addBackButton();
                clearInterval(interval);
            }
        }, 500);


        /**
         * For classic editor
         */
        //Title click
        $('#titlewrap input').on('keyup', function() {
            
            var title = $(this).val();
            var keyword = $('#komodo_focuskeyword').val();
            var basicseo = ($('.komodo-basicseo').text());
            var intbasicseo = ($('.komodo-basicseo').text());
            var titleseo = ($('.komodo-titleseo').text());
            //Top tabs 
            if(basicseo == ""){
                basicseo = 0;
            }
            if(titleseo == ""){
                titleseo = 0;
            }

            //Parameters
            var powerkeyfound = $('.powerkeyfound img').attr('class');
            if(powerkeyfound.indexOf("komodo-err") !== -1){
               var powerkey = false;
            }else{
               var powerkey = true;
            }

            var sagmentfound = $('.sagmentfound img').attr('class');
            if(sagmentfound.indexOf("komodo-err") !== -1){
               var sagmentkey = false;
            }else{
               var sagmentkey = true;
            }

            var begintitle = $('.begintitle img').attr('class');
            if(begintitle.indexOf("komodo-err") !== -1){
               var beginkey = false;
            }else{
               var beginkey = true;
            }

            var containsnumber = $('.containsnumber img').attr('class');
            if(containsnumber.indexOf("komodo-err") !== -1){
               var numberkey = false;
            }else{
               var numberkey = true;
            }

            var basictitle = $('.basictitle img').attr('class');
            if(basictitle.indexOf("komodo-err") !== -1){
               var basictitlekey = false;
            }else{
               var basictitlekey = true;
            }

            if(title === null || title.trim() === "" || keyword === null || keyword.trim() === ""){
                titleseo = 4;
                console.log(basictitlekey);
                if(basictitlekey == true){
                    var intbasicseo = intbasicseo + 1;
                }
                $('label.kb-tab__label[for="cb3"]').addClass("kb-accordian-tab-red");
                $('label.kb-tab__label[for="cb3"]').removeClass("kb-accordian-tab-green");
                $('label.kb-tab__label[for="cb3"]').html('Title Readability <span > Error <b class="komodo-titleseo"> '+titleseo+'</b> </span>');
            
                $('label.kb-tab__label[for="cb1"]').addClass("kb-accordian-tab-red");
                $('label.kb-tab__label[for="cb1"]').removeClass("kb-accordian-tab-green");
                $('label.kb-tab__label[for="cb1"]').html('Basic SEO <span > Error <b class="komodo-basicseo"> '+intbasicseo+'</b></span>');
            
                $('.basictitle img').attr('src', frontendajax.error);
                $('.basictitle img').removeClass('komodo-success');
                $('.basictitle img').addClass('komodo-err');

                $('.begintitle img').attr('src', frontendajax.error);
                $('.begintitle img').removeClass('komodo-success');
                $('.begintitle img').addClass('komodo-err');
            
                $('.containsnumber img').attr('src', frontendajax.error);
                $('.containsnumber img').removeClass('komodo-success');
                $('.containsnumber img').addClass('komodo-err');
            
                $('.powerkeyfound img').attr('src', frontendajax.error);
                $('.powerkeyfound img').removeClass('komodo-success');
                $('.powerkeyfound img').addClass('komodo-err');
            
                $('.sagmentfound img').attr('src', frontendajax.error);
                $('.sagmentfound img').removeClass('komodo-success');
                $('.sagmentfound img').addClass('komodo-err');
            }else{
                $.ajax({
                    type: 'post',
                    url: frontendajax.ajaxurl,
                    data: {
                        'action'            : 'komodo_check_postitle',
                        'title'             : title,
                        'keyword'           : keyword,
                        'basicseo'          : basicseo,
                        'titleseo'          : titleseo,
                        'powerkey'          : powerkey,
                        'sagmentkey'        : sagmentkey,
                        'beginkey'          : beginkey,
                        'basictitlekey'     : basictitlekey,
                        'numberkey'         : numberkey
                    },
                    success: function(response){
                        //console.log(response);
                        var result = JSON.parse(response);
                        if(result.titleseo == 0){
                            $('label.kb-tab__label[for="cb3"]').removeClass("kb-accordian-tab-red");
                            $('label.kb-tab__label[for="cb3"]').addClass("kb-accordian-tab-green");
                            $('label.kb-tab__label[for="cb3"]').html('Title Readability <span > All Good </span>');
                        }else{
                            $('label.kb-tab__label[for="cb3"]').addClass("kb-accordian-tab-red");
                            $('label.kb-tab__label[for="cb3"]').removeClass("kb-accordian-tab-green");
                            $('label.kb-tab__label[for="cb3"]').html('Title Readability <span > Error <b class="komodo-titleseo"> '+result.titleseo+'</b> </span>');
                        }

                        if(result.basicseo == 0){
                            $('label.kb-tab__label[for="cb1"]').removeClass("kb-accordian-tab-red");
                            $('label.kb-tab__label[for="cb1"]').addClass("kb-accordian-tab-green");
                            $('label.kb-tab__label[for="cb1"]').html('Basic SEO <span > All Good </span>');
                        }else{
                            $('label.kb-tab__label[for="cb1"]').addClass("kb-accordian-tab-red");
                            $('label.kb-tab__label[for="cb1"]').removeClass("kb-accordian-tab-green");
                            $('label.kb-tab__label[for="cb1"]').html('Basic SEO <span > Error <b class="komodo-basicseo"> '+result.basicseo+'</b></span>');
                        }

                        if(result.basictitle == 1){
                            $('.basictitle img').attr('src', frontendajax.success);
                            $('.basictitle img').addClass('komodo-success');
                            $('.basictitle img').removeClass('komodo-err');
                        }else{
                            $('.basictitle img').attr('src', frontendajax.error);
                            $('.basictitle img').removeClass('komodo-success');
                            $('.basictitle img').addClass('komodo-err');

                        }
                        if(result.begintitle == 1){
                            $('.begintitle img').attr('src', frontendajax.success);
                            $('.begintitle img').addClass('komodo-success');
                            $('.begintitle img').removeClass('komodo-err');
                        }else{
                            $('.begintitle img').attr('src', frontendajax.error);
                            $('.begintitle img').removeClass('komodo-success');
                            $('.begintitle img').addClass('komodo-err');
                        }
                        if(result.containsnumber == 1){
                            $('.containsnumber img').attr('src', frontendajax.success);
                            $('.containsnumber img').addClass('komodo-success');
                            $('.containsnumber img').removeClass('komodo-err');
                        }else{
                            $('.containsnumber img').attr('src', frontendajax.error);
                            $('.containsnumber img').removeClass('komodo-success');
                            $('.containsnumber img').addClass('komodo-err');
                        }
                        if(result.powerkeyfound == 1){
                            $('.powerkeyfound img').attr('src', frontendajax.success);
                            $('.powerkeyfound img').addClass('komodo-success');
                            $('.powerkeyfound img').removeClass('komodo-err');
                        }else{
                            $('.powerkeyfound img').attr('src', frontendajax.error);
                            $('.powerkeyfound img').removeClass('komodo-success');
                            $('.powerkeyfound img').addClass('komodo-err');
                        }
                        if(result.sagmentfound == 1){
                            $('.sagmentfound img').attr('src', frontendajax.success);
                            $('.sagmentfound img').addClass('komodo-success');
                            $('.sagmentfound img').removeClass('komodo-err');
                        }else{
                            $('.sagmentfound img').attr('src', frontendajax.error);
                            $('.sagmentfound img').removeClass('komodo-success');
                            $('.sagmentfound img').addClass('komodo-err');
                        }
                    }
                })
                rys_update_focuskeywordpercent();
            }
        });

        // Editor click
        $(document).on('tinymce-editor-init', function(e, editor) {
            // Check if the initialized editor is the main content editor
            if (editor.id === 'content') {
                // Bind keyup event handler
                editor.on('keyup', function() {
                    var content = editor.getContent();
                    var keyword = $('#komodo_focuskeyword').val();
                    
                    var postid = $('#post_ID').val();
                    var contentreadability = ($('.komodo-contentreadability').text());
                    let basicseo = ($('.komodo-basicseo').text());
                    var adfinalseo = ($('.komodo-adfinalseo').text());

                    //Top tabs 
                    if(contentreadability == ""){
                        contentreadability = 0;
                    }
                    if(basicseo == ""){
                        basicseo = 0;
                    }
                    if(adfinalseo == ""){
                        adfinalseo = 0;
                    }

                    //Parameters 
                    var basicdesc = $('.basicdesc img').attr('class');
                    if(basicdesc.indexOf("komodo-err") !== -1){
                        var basicdesckey = false;
                    }else{
                        var basicdesckey = true;
                    }

                    var urlfocus = $('.urlfocus img').attr('class');
                    if(urlfocus.indexOf("komodo-err") !== -1){
                        var urlfocuskey = false;
                    }else{
                        var urlfocuskey = true;
                    }

                    var firstfocus = $('.firstfocus img').attr('class');
                    if(firstfocus.indexOf("komodo-err") !== -1){
                        var firstfocuskey = false;
                    }else{
                        var firstfocuskey = true;
                    }

                    var wordCount = $('.wordCount img').attr('class');
                    if(wordCount.indexOf("komodo-err") !== -1){
                        var wordCountkey = false;
                    }else{
                        var wordCountkey = true;
                    }
                    var focuskeyword = $('.focuskeyword img').attr('class');
                    if(focuskeyword.indexOf("komodo-err") !== -1){
                        var focuskey = false;
                    }else{
                        var focuskey = true;
                    }

                    var focusimg = $('.focusimg img').attr('class');
                    if(focusimg.indexOf("komodo-err") !== -1){
                        var focusimgkey = false;
                    }else{
                        var focusimgkey = true;
                    }

                    var keyworddensity = $('.keyworddensity img').attr('class');
                    if(keyworddensity.indexOf("komodo-err") !== -1){
                        var keyworddensitykey = false;
                    }else{
                        var keyworddensitykey = true;
                    }

                    var externallink = $('.externallink img').attr('class');
                    if(externallink.indexOf("komodo-err") !== -1){
                        var externallinkkey = false;
                    }else{
                        var externallinkkey = true;
                    }

                    var paragraph_readability = $('.paragraph_readability img').attr('class');
                    if(paragraph_readability.indexOf("komodo-err") !== -1){
                        var parareadabilitykey = false;
                    }else{
                        var parareadabilitykey = true;
                    }

                    var imgcontain = $('.imgcontain img').attr('class');
                    if(imgcontain.indexOf("komodo-err") !== -1){
                        var imgcontainkey = false;
                    }else{
                        var imgcontainkey = true;
                    }

                    if(content === null || content.trim() === "" || keyword === null || keyword.trim() === ""){
                        //
                        basicseo = 4;
                        adfinalseo = 5;
                        contentreadability = 2;
                        $('label.kb-tab__label[for="cb1"]').addClass("kb-accordian-tab-red");
                        $('label.kb-tab__label[for="cb1"]').removeClass("kb-accordian-tab-green");
                        $('label.kb-tab__label[for="cb1"]').html('Basic SEO <span> Error <b class="komodo-basicseo"> '+basicseo+'</b></span>');
                    
                        $('label.kb-tab__label[for="cb2"]').addClass("kb-accordian-tab-red");
                        $('label.kb-tab__label[for="cb2"]').removeClass("kb-accordian-tab-green");
                        $('label.kb-tab__label[for="cb2"]').html('Additional <span> Error <b class="komodo-adfinalseo"> '+adfinalseo+'</b> </span>');
                    
                        $('label.kb-tab__label[for="cb4"]').addClass("kb-accordian-tab-red");
                        $('label.kb-tab__label[for="cb4"]').removeClass("kb-accordian-tab-green");
                        $('label.kb-tab__label[for="cb4"]').html('Content Readability <span> Error <b class="komodo-contentreadability"> '+contentreadability+'</b> </span>');
                    
                        $('.basicdesc img').attr('src', frontendajax.error);
                        $('.basicdesc img').removeClass('komodo-success');
                        $('.basicdesc img').addClass('komodo-err');
                    
                        $('.firstfocus img').attr('src', frontendajax.error);
                        $('.firstfocus img').removeClass('komodo-success');
                        $('.firstfocus img').addClass('komodo-err');
                    
                        $('.focuskeyword img').attr('src', frontendajax.error);
                        $('.focuskeyword img').removeClass('komodo-success');
                        $('.focuskeyword img').addClass('komodo-err');
                    
                        $('.focusimg img').attr('src', frontendajax.error);
                        $('.focusimg img').removeClass('komodo-success');
                        $('.focusimg img').addClass('komodo-err');
                    
                        $('.imgcontain img').attr('src', frontendajax.error);
                        $('.imgcontain img').removeClass('komodo-success');
                        $('.imgcontain img').addClass('komodo-err');
                    
                        $('.keyworddensity img').attr('src', frontendajax.error);
                        $('.keyworddensity img').removeClass('komodo-success');
                        $('.keyworddensity img').addClass('komodo-err');
                    
                        $('.paragraph_readability img').attr('src', frontendajax.error);
                        $('.paragraph_readability img').removeClass('komodo-success');
                        $('.paragraph_readability img').addClass('komodo-err');
                    
                        $('.externallink img').attr('src', frontendajax.error);
                        $('.externallink img').removeClass('komodo-success');
                        $('.externallink img').addClass('komodo-err');
                    
                        $('.wordCount img').attr('src', frontendajax.error);
                        $('.wordCount img').removeClass('komodo-success');
                        $('.wordCount img').addClass('komodo-err');
                    }else{
                        $.ajax({
                            type: 'post',
                            url: frontendajax.ajaxurl,
                            data: {
                                'action'            : 'komodo_check_postcontent',
                                'postid'            : postid,
                                'content'           : content,
                                'keyword'           : keyword,
                                'contentreadability': contentreadability,
                                'basicseo'          : basicseo,
                                'adfinalseo'        : adfinalseo,
                                'basicdesckey'      : basicdesckey,
                                'urlfocuskey'       : urlfocuskey,
                                'firstfocuskey'     : firstfocuskey,
                                'wordCountkey'      : wordCountkey,
                                'focuskey'          : focuskey,
                                'focusimgkey'       : focusimgkey,
                                'keyworddensitykey' : keyworddensitykey,
                                'externallinkkey'   : externallinkkey,
                                'parareadabilitykey': parareadabilitykey,
                                'imgcontainkey'     : imgcontainkey
                            },
                            success: function(response){
                                if(response == 'null'){
                                    //console.log("test");
                                }else{
                                    var result = JSON.parse(response);
									//console.log(result);
                                    if(result.basicseo == 0){
                                        $('label.kb-tab__label.cb1').removeClass("kb-accordian-tab-red");
                                        $('label.kb-tab__label.cb1').addClass("kb-accordian-tab-green");
                                        $('label.kb-tab__label.cb1').html('Basic SEO <span> All Good </span>');
                                    }else{
                                        $('label.kb-tab__label.cb1').addClass("kb-accordian-tab-red");
                                        $('label.kb-tab__label.cb1').removeClass("kb-accordian-tab-green");
                                        $('label.kb-tab__label.cb1').html('Basic SEO <span> Error <b class="komodo-basicseo"> '+result.basicseo+'</b></span>');
                                    }
            
                                    if(result.adfinalseo == 0){
                                        $('label.kb-tab__label.cb2').removeClass("kb-accordian-tab-red");
                                        $('label.kb-tab__label.cb2').addClass("kb-accordian-tab-green");
                                        $('label.kb-tab__label.cb2').html('Additional <span > All Good </span>');
                                    }else{
                                        $('label.kb-tab__label.cb2').addClass("kb-accordian-tab-red");
                                        $('label.kb-tab__label.cb2').removeClass("kb-accordian-tab-green");
                                        $('label.kb-tab__label.cb2').html('Additional <span> Error <b class="komodo-adfinalseo"> '+result.adfinalseo+'</b> </span>');
                                    }
            
                                    if(result.contentreadability == 0){
                                        $('label.kb-tab__label.cb4').removeClass("kb-accordian-tab-red");
                                        $('label.kb-tab__label.cb4').addClass("kb-accordian-tab-green");
                                        $('label.kb-tab__label.cb4').html('Content Readability <span > All Good </span>');
                                    }else{
                                        $('label.kb-tab__label.cb4').addClass("kb-accordian-tab-red");
                                        $('label.kb-tab__label.cb4').removeClass("kb-accordian-tab-green");
                                        $('label.kb-tab__label.cb4').html('Content Readability <span> Error <b class="komodo-contentreadability"> '+result.contentreadability+'</b> </span>');
                                    }
                
                                    if(result.basicdesc == 1){
                                        $('.basicdesc img').attr('src', frontendajax.success);
                                        $('.basicdesc img').addClass('komodo-success');
                                        $('.basicdesc img').removeClass('komodo-err');
                                    }else{
                                        $('.basicdesc img').attr('src', frontendajax.error);
                                        $('.basicdesc img').removeClass('komodo-success');
                                        $('.basicdesc img').addClass('komodo-err');
                                    }
                                    if(result.firstfocus == 1){
                                        $('.firstfocus img').attr('src', frontendajax.success);
                                        $('.firstfocus img').addClass('komodo-success');
                                        $('.firstfocus img').removeClass('komodo-err');
                                    }else{
                                        $('.firstfocus img').attr('src', frontendajax.error);
                                        $('.firstfocus img').removeClass('komodo-success');
                                        $('.firstfocus img').addClass('komodo-err');
                                    }
                                    if(result.focus == 1){
                                        $('.focuskeyword img').attr('src', frontendajax.success);
                                        $('.focuskeyword img').addClass('komodo-success');
                                        $('.focuskeyword img').removeClass('komodo-err');
                                    }else{
                                        $('.focuskeyword img').attr('src', frontendajax.error);
                                        $('.focuskeyword img').removeClass('komodo-success');
                                        $('.focuskeyword img').addClass('komodo-err');
                                    }
                                    if(result.focusimg == 1){
                                        $('.focusimg img').attr('src', frontendajax.success);
                                        $('.focusimg img').addClass('komodo-success');
                                        $('.focusimg img').removeClass('komodo-err');
                                    }else{
                                        $('.focusimg img').attr('src', frontendajax.error);
                                        $('.focusimg img').removeClass('komodo-success');
                                        $('.focusimg img').addClass('komodo-err');
                                    }
                                    if(result.imgcontain == 1){
                                        $('.imgcontain img').attr('src', frontendajax.success);
                                        $('.imgcontain img').addClass('komodo-success');
                                        $('.imgcontain img').removeClass('komodo-err');
                                    }else{
                                        $('.imgcontain img').attr('src', frontendajax.error);
                                        $('.imgcontain img').removeClass('komodo-success');
                                        $('.imgcontain img').addClass('komodo-err');
                                    }
                                    if(result.keyworddensity == 1){
                                        $('.keyworddensity img').attr('src', frontendajax.success);
                                        $('.keyworddensity img').addClass('komodo-success');
                                        $('.keyworddensity img').removeClass('komodo-err');
                                    }else{
                                        $('.keyworddensity img').attr('src', frontendajax.error);
                                        $('.keyworddensity img').removeClass('komodo-success');
                                        $('.keyworddensity img').addClass('komodo-err');
                                    }
                                    if(result.paragraph_readability == 1){
                                        $('.paragraph_readability img').attr('src', frontendajax.success);
                                        $('.paragraph_readability img').addClass('komodo-success');
                                        $('.paragraph_readability img').removeClass('komodo-err');
                                    }else{
                                        $('.paragraph_readability img').attr('src', frontendajax.error);
                                        $('.paragraph_readability img').removeClass('komodo-success');
                                        $('.paragraph_readability img').addClass('komodo-err');
                                    }
                                    if(result.externallinkfound == 1){
                                        $('.externallink img').attr('src', frontendajax.success);
                                        $('.externallink img').addClass('komodo-success');
                                        $('.externallink img').removeClass('komodo-err');
                                    }else{
                                        $('.externallink img').attr('src', frontendajax.error);
                                        $('.externallink img').removeClass('komodo-success');
                                        $('.externallink img').addClass('komodo-err');
                                    }
                                    if(result.urlfocus == 1){
                                        $('.urlfocus img').attr('src', frontendajax.success);
                                        $('.urlfocus img').addClass('komodo-success');
                                        $('.urlfocus img').removeClass('komodo-err');
                                    }else{
                                        $('.urlfocus img').attr('src', frontendajax.error);
                                        $('.urlfocus img').removeClass('komodo-success');
                                        $('.urlfocus img').addClass('komodo-err');
                                    }
                                    if(result.wordCountvar == 1){
                                        $('.wordCount img').attr('src', frontendajax.success);
                                        $('.wordCount img').addClass('komodo-success');
                                        $('.wordCount img').removeClass('komodo-err');
                                    }else{
                                        $('.wordCount img').attr('src', frontendajax.error);
                                        $('.wordCount img').removeClass('komodo-success');
                                        $('.wordCount img').addClass('komodo-err');
                                    }
                                    if(result.worddesc != null){
                                        $('.contentofwordcount').html(result.worddesc);
                                    }
                                    if(result.keywordtext != null){
                                        $('.contentofkeyword').html(result.keywordtext);
                                    }
                                }
                            }
                        })
                        rys_update_focuskeywordpercent();
                    }
                });
            }
        });
        
        

        /**
         * For gutenberg editor
         */
        
        $(document).on('keydown', function(e) {
            if ($('.edit-post-visual-editor').length) {
                gutenberg_seo_filter_title();
                gutenberg_seo_filter_content();
            }
        });
        
        if (typeof wp !== 'undefined' && wp.data && wp.data.select('core/editor')) {
            
            var editorCheck = function() {
                if (typeof wp !== 'undefined' && wp.data) {
                    //const { subscribe } = wp.data;
                }
                wp.data.subscribe(() => {
                    gutenberg_seo_filter_title();
                    gutenberg_seo_filter_content();
                    
                });
            }
            
            $(document).on('keypress', editorCheck, function(){
                //const { subscribe } = wp.data;
                gutenberg_seo_filter_title();
                gutenberg_seo_filter_content();
            });
            
        }
        
        /**
         * Seo Slide 
         */
        $(document).on('click','.komodo-seo-btn',function(e){
            $("body").addClass("seo-slide-open");
        });
        $(document).on('click','.seo-modal-cls-btn',function(e){
            $("body").removeClass("seo-slide-open");
        });
    });

    //Change working of input type 
	const inputField = document.getElementById('komodo-focuskeyword');
	const tagList = document.getElementById('komodo-list');
    const hiddenField = document.getElementById('komodo_focuskeyword');

	inputField.addEventListener('keypress', function(event) {
		if (event.key === 'Enter' || event.keyCode === 13) {
			event.preventDefault();
			const tagText = inputField.value.trim();
			if (tagText !== '') {
				addTag(tagText);
				inputField.value = '';
			}
            //////////////////
            rys_update_focuskeywordpercent();

            if (typeof wp !== 'undefined' && wp.data && wp.data.select('core/editor')) {
                // Gutenberg editor is active
                console.log('Gutenberg editor is active');
            } else {
                seo_filter_content();
                seo_filter_title();
            }
		}
	});


	function addTag(tagText) {
		const tagItem = document.createElement('div');
        
		tagItem.textContent = tagText;
		tagItem.classList.add('tag-item');
		const removeButton = document.createElement('span');
		removeButton.textContent = 'x';
		removeButton.classList.add('tag-remove');
		removeButton.addEventListener('click', function() {
			tagItem.remove();
            updateHiddenField();
		});
		tagItem.appendChild(removeButton);
		tagList.appendChild(tagItem);
        updateHiddenField();
	}

    function updateHiddenField() {
        const tags = Array.from(
            tagList.getElementsByClassName('tag-item'),
        ).map(tag => tag.textContent);
        
        const updatedArray = tags.map(str => {
            if (str.endsWith('x')) {
              return str.slice(0, -1);
            }
            return str;
          });
        
        hiddenField.value = updatedArray.join(',');
    }

	$('.head').click(function(){
		$(this).toggleClass('active');
		$(this).parent().find('.arrow').toggleClass('arrow-animate');
		$(this).parent().find('.content').slideToggle(280);
	});

    $(document).on('click', '.tag-remove', function(){
        $(this).closest('div.tag-item').remove();
        $(this).closest('div.tag-item-db').remove();
        updateHiddenField();

        //show error on hide
        filter_zero();
    });

    function filter_zero(){
        $('label.kb-tab__label[for="cb1"]').addClass("kb-accordian-tab-red");
        $('label.kb-tab__label[for="cb1"]').removeClass("kb-accordian-tab-green");
        $('label.kb-tab__label[for="cb1"]').html('Basic SEO <span> Error <b class="komodo-basicseo"> 6</b></span>');
    
        $('label.kb-tab__label[for="cb2"]').addClass("kb-accordian-tab-red");
        $('label.kb-tab__label[for="cb2"]').removeClass("kb-accordian-tab-green");
        $('label.kb-tab__label[for="cb2"]').html('Additional <span> Error <b class="komodo-adfinalseo"> 5</b> </span>');
    
        $('label.kb-tab__label[for="cb3"]').addClass("kb-accordian-tab-red");
        $('label.kb-tab__label[for="cb3"]').removeClass("kb-accordian-tab-green");
        $('label.kb-tab__label[for="cb3"]').html('Title Readability <span> Error <b class="komodo-titleseo"> 4</b> </span>');

        $('label.kb-tab__label[for="cb4"]').addClass("kb-accordian-tab-red");
        $('label.kb-tab__label[for="cb4"]').removeClass("kb-accordian-tab-green");
        $('label.kb-tab__label[for="cb4"]').html('Content Readability <span> Error <b class="komodo-contentreadability"> 2</b> </span>');
    
        $('.basicdesc img').attr('src', frontendajax.error);
        $('.basicdesc img').removeClass('komodo-success');
        $('.basicdesc img').addClass('komodo-err');
    
        $('.firstfocus img').attr('src', frontendajax.error);
        $('.firstfocus img').removeClass('komodo-success');
        $('.firstfocus img').addClass('komodo-err');
    
        $('.focuskeyword img').attr('src', frontendajax.error);
        $('.focuskeyword img').removeClass('komodo-success');
        $('.focuskeyword img').addClass('komodo-err');
    
        $('.focusimg img').attr('src', frontendajax.error);
        $('.focusimg img').removeClass('komodo-success');
        $('.focusimg img').addClass('komodo-err');
    
        $('.imgcontain img').attr('src', frontendajax.error);
        $('.imgcontain img').removeClass('komodo-success');
        $('.imgcontain img').addClass('komodo-err');
    
        $('.keyworddensity img').attr('src', frontendajax.error);
        $('.keyworddensity img').removeClass('komodo-success');
        $('.keyworddensity img').addClass('komodo-err');
    
        $('.paragraph_readability img').attr('src', frontendajax.error);
        $('.paragraph_readability img').removeClass('komodo-success');
        $('.paragraph_readability img').addClass('komodo-err');
    
        $('.externallink img').attr('src', frontendajax.error);
        $('.externallink img').removeClass('komodo-success');
        $('.externallink img').addClass('komodo-err');
    
        $('.wordCount img').attr('src', frontendajax.error);
        $('.wordCount img').removeClass('komodo-success');
        $('.wordCount img').addClass('komodo-err');

        //title
        $('.basictitle img').attr('src', frontendajax.error);
        $('.basictitle img').removeClass('komodo-success');
        $('.basictitle img').addClass('komodo-err');

        $('.begintitle img').attr('src', frontendajax.error);
        $('.begintitle img').removeClass('komodo-success');
        $('.begintitle img').addClass('komodo-err');
    
        $('.containsnumber img').attr('src', frontendajax.error);
        $('.containsnumber img').removeClass('komodo-success');
        $('.containsnumber img').addClass('komodo-err');
    
        $('.powerkeyfound img').attr('src', frontendajax.error);
        $('.powerkeyfound img').removeClass('komodo-success');
        $('.powerkeyfound img').addClass('komodo-err');
    
        $('.sagmentfound img').attr('src', frontendajax.error);
        $('.sagmentfound img').removeClass('komodo-success');
        $('.sagmentfound img').addClass('komodo-err');

        $('.urlfocus img').attr('src', frontendajax.error);
        $('.urlfocus img').removeClass('komodo-success');
        $('.urlfocus img').addClass('komodo-err');
    }

    function seo_filter_content(){
        var content = tinymce.activeEditor.getContent();
        var keyword = $('#komodo_focuskeyword').val();
        var postid = $('#post_ID').val();
        var contentreadability = ($('.komodo-contentreadability').text());
        let basicseo = ($('.komodo-basicseo').text());
        var adfinalseo = ($('.komodo-adfinalseo').text());

        //Top tabs 
        if(contentreadability == ""){
            contentreadability = 0;
        }
        if(basicseo == ""){
            basicseo = 0;
        }
        if(adfinalseo == ""){
            adfinalseo = 0;
        }

        //Parameters 
        var basicdesc = $('.basicdesc img').attr('class');
        if(basicdesc.indexOf("komodo-err") !== -1){
            var basicdesckey = false;
        }else{
            var basicdesckey = true;
        }

        var urlfocus = $('.urlfocus img').attr('class');
        if(urlfocus.indexOf("komodo-err") !== -1){
            var urlfocuskey = false;
        }else{
            var urlfocuskey = true;
        }

        var firstfocus = $('.firstfocus img').attr('class');
        if(firstfocus.indexOf("komodo-err") !== -1){
            var firstfocuskey = false;
        }else{
            var firstfocuskey = true;
        }

        var wordCount = $('.wordCount img').attr('class');
        if(wordCount.indexOf("komodo-err") !== -1){
            var wordCountkey = false;
        }else{
            var wordCountkey = true;
        }

        var focuskeyword = $('.focuskeyword img').attr('class');
        if(focuskeyword.indexOf("komodo-err") !== -1){
            var focuskey = false;
        }else{
            var focuskey = true;
        }

        var focusimg = $('.focusimg img').attr('class');
        if(focusimg.indexOf("komodo-err") !== -1){
            var focusimgkey = false;
        }else{
            var focusimgkey = true;
        }

        var keyworddensity = $('.keyworddensity img').attr('class');
        if(keyworddensity.indexOf("komodo-err") !== -1){
            var keyworddensitykey = false;
        }else{
            var keyworddensitykey = true;
        }

        var externallink = $('.externallink img').attr('class');
        if(externallink.indexOf("komodo-err") !== -1){
            var externallinkkey = false;
        }else{
            var externallinkkey = true;
        }

        var paragraph_readability = $('.paragraph_readability img').attr('class');
        if(paragraph_readability.indexOf("komodo-err") !== -1){
            var parareadabilitykey = false;
        }else{
            var parareadabilitykey = true;
        }

        var imgcontain = $('.imgcontain img').attr('class');
        if(imgcontain.indexOf("komodo-err") !== -1){
            var imgcontainkey = false;
        }else{
            var imgcontainkey = true;
        }

        if(content === null || content.trim() === "" || keyword === null || keyword.trim() === ""){
            //
            basicseo = 5;
            adfinalseo = 5;
            contentreadability = 2;
            $('label.kb-tab__label[for="cb1"]').addClass("kb-accordian-tab-red");
            $('label.kb-tab__label[for="cb1"]').removeClass("kb-accordian-tab-green");
            $('label.kb-tab__label[for="cb1"]').html('Basic SEO <span> Error <b class="komodo-basicseo"> '+basicseo+'</b></span>');
        
            $('label.kb-tab__label[for="cb2"]').addClass("kb-accordian-tab-red");
            $('label.kb-tab__label[for="cb2"]').removeClass("kb-accordian-tab-green");
            $('label.kb-tab__label[for="cb2"]').html('Additional <span> Error <b class="komodo-adfinalseo"> '+adfinalseo+'</b> </span>');
        
            $('label.kb-tab__label[for="cb4"]').addClass("kb-accordian-tab-red");
            $('label.kb-tab__label[for="cb4"]').removeClass("kb-accordian-tab-green");
            $('label.kb-tab__label[for="cb4"]').html('Content Readability <span> Error <b class="komodo-contentreadability"> '+contentreadability+'</b> </span>');
        
            $('.basicdesc img').attr('src', frontendajax.error);
            $('.basicdesc img').removeClass('komodo-success');
            $('.basicdesc img').addClass('komodo-err');
        
            $('.firstfocus img').attr('src', frontendajax.error);
            $('.firstfocus img').removeClass('komodo-success');
            $('.firstfocus img').addClass('komodo-err');
        
            $('.focuskeyword img').attr('src', frontendajax.error);
            $('.focuskeyword img').removeClass('komodo-success');
            $('.focuskeyword img').addClass('komodo-err');
        
            $('.focusimg img').attr('src', frontendajax.error);
            $('.focusimg img').removeClass('komodo-success');
            $('.focusimg img').addClass('komodo-err');
        
            $('.imgcontain img').attr('src', frontendajax.error);
            $('.imgcontain img').removeClass('komodo-success');
            $('.imgcontain img').addClass('komodo-err');
        
            $('.keyworddensity img').attr('src', frontendajax.error);
            $('.keyworddensity img').removeClass('komodo-success');
            $('.keyworddensity img').addClass('komodo-err');
        
            $('.paragraph_readability img').attr('src', frontendajax.error);
            $('.paragraph_readability img').removeClass('komodo-success');
            $('.paragraph_readability img').addClass('komodo-err');
        
            $('.externallink img').attr('src', frontendajax.error);
            $('.externallink img').removeClass('komodo-success');
            $('.externallink img').addClass('komodo-err');
        
            $('.wordCount img').attr('src', frontendajax.error);
            $('.wordCount img').removeClass('komodo-success');
            $('.wordCount img').addClass('komodo-err');
			
			
        }else{
            $.ajax({
                type: 'post',
                url: frontendajax.ajaxurl,
                data: {
                    'action'            : 'komodo_check_postcontent',
                    'postid'            : postid,
                    'content'           : content,
                    'keyword'           : keyword,
                    'contentreadability': contentreadability,
                    'basicseo'          : basicseo,
                    'adfinalseo'        : adfinalseo,
                    'basicdesckey'      : basicdesckey,
                    'urlfocuskey'       : urlfocuskey,
                    'firstfocuskey'     : firstfocuskey,
                    'wordCountkey'      : wordCountkey,
                    'focuskey'          : focuskey,
                    'focusimgkey'       : focusimgkey,
                    'keyworddensitykey' : keyworddensitykey,
                    'externallinkkey'   : externallinkkey,
                    'parareadabilitykey': parareadabilitykey,
                    'imgcontainkey'     : imgcontainkey
                },
                success: function(response){
                    if(response == 'null'){
                        //console.log("test");
                    }else{
                        var result = JSON.parse(response);
                        if(result.basicseo == 0){
                            $('label.kb-tab__label[for="cb1]').removeClass("kb-accordian-tab-red");
                            $('label.kb-tab__label[for="cb1]').addClass("kb-accordian-tab-green");
                            $('label.kb-tab__label[for="cb1]'). html('Basic SEO <span > All Good </span>');
                        }else{
                            $('label.kb-tab__label[for="cb1"]').addClass("kb-accordian-tab-red");
                            $('label.kb-tab__label[for="cb1"]').removeClass("kb-accordian-tab-green");
                            $('label.kb-tab__label[for="cb1"]').html('Basic SEO <span> Error <b class="komodo-basicseo"> '+result.basicseo+'</b></span>');
                        }

                        if(result.adfinalseo == 0){
                            $('label.kb-tab__label[for="cb2"]').removeClass("kb-accordian-tab-red");
                            $('label.kb-tab__label[for="cb2"]').addClass("kb-accordian-tab-green");
                            $('label.kb-tab__label[for="cb2"]').html('Additional <span > All Good </span>');
                        }else{
                            $('label.kb-tab__label[for="cb2"]').addClass("kb-accordian-tab-red");
                            $('label.kb-tab__label[for="cb2"]').removeClass("kb-accordian-tab-green");
                            $('label.kb-tab__label[for="cb2"]').html('Additional <span> Error <b class="komodo-adfinalseo"> '+result.adfinalseo+'</b> </span>');
                        }

                        if(result.contentreadability == 0){
                            $('label.kb-tab__label[for="cb4"]').removeClass("kb-accordian-tab-red");
                            $('label.kb-tab__label[for="cb4"]').addClass("kb-accordian-tab-green");
                            $('label.kb-tab__label[for="cb4"]').html('Content Readability <span > All Good </span>');
                        }else{
                            $('label.kb-tab__label[for="cb4"]').addClass("kb-accordian-tab-red");
                            $('label.kb-tab__label[for="cb4"]').removeClass("kb-accordian-tab-green");
                            $('label.kb-tab__label[for="cb4"]').html('Content Readability <span> Error <b class="komodo-contentreadability"> '+result.contentreadability+'</b> </span>');
                        }
    
                        if(result.basicdesc == 1){
                            $('.basicdesc img').attr('src', frontendajax.success);
                            $('.basicdesc img').addClass('komodo-success');
                            $('.basicdesc img').removeClass('komodo-err');
                        }else{
                            $('.basicdesc img').attr('src', frontendajax.error);
                            $('.basicdesc img').removeClass('komodo-success');
                            $('.basicdesc img').addClass('komodo-err');
                        }
                        if(result.firstfocus == 1){
                            $('.firstfocus img').attr('src', frontendajax.success);
                            $('.firstfocus img').addClass('komodo-success');
                            $('.firstfocus img').removeClass('komodo-err');
                        }else{
                            $('.firstfocus img').attr('src', frontendajax.error);
                            $('.firstfocus img').removeClass('komodo-success');
                            $('.firstfocus img').addClass('komodo-err');
                        }
                        if(result.focus == 1){
                            $('.focuskeyword img').attr('src', frontendajax.success);
                            $('.focuskeyword img').addClass('komodo-success');
                            $('.focuskeyword img').removeClass('komodo-err');
                        }else{
                            $('.focuskeyword img').attr('src', frontendajax.error);
                            $('.focuskeyword img').removeClass('komodo-success');
                            $('.focuskeyword img').addClass('komodo-err');
                        }
                        if(result.focusimg == 1){
                            $('.focusimg img').attr('src', frontendajax.success);
                            $('.focusimg img').addClass('komodo-success');
                            $('.focusimg img').removeClass('komodo-err');
                        }else{
                            $('.focusimg img').attr('src', frontendajax.error);
                            $('.focusimg img').removeClass('komodo-success');
                            $('.focusimg img').addClass('komodo-err');
                        }
                        if(result.imgcontain == 1){
                            $('.imgcontain img').attr('src', frontendajax.success);
                            $('.imgcontain img').addClass('komodo-success');
                            $('.imgcontain img').removeClass('komodo-err');
                        }else{
                            $('.imgcontain img').attr('src', frontendajax.error);
                            $('.imgcontain img').removeClass('komodo-success');
                            $('.imgcontain img').addClass('komodo-err');
                        }
                        if(result.keyworddensity == 1){
                            $('.keyworddensity img').attr('src', frontendajax.success);
                            $('.keyworddensity img').addClass('komodo-success');
                            $('.keyworddensity img').removeClass('komodo-err');
                        }else{
                            $('.keyworddensity img').attr('src', frontendajax.error);
                            $('.keyworddensity img').removeClass('komodo-success');
                            $('.keyworddensity img').addClass('komodo-err');
                        }
                        if(result.paragraph_readability == 1){
                            $('.paragraph_readability img').attr('src', frontendajax.success);
                            $('.paragraph_readability img').addClass('komodo-success');
                            $('.paragraph_readability img').removeClass('komodo-err');
                        }else{
                            $('.paragraph_readability img').attr('src', frontendajax.error);
                            $('.paragraph_readability img').removeClass('komodo-success');
                            $('.paragraph_readability img').addClass('komodo-err');
                        }
                        if(result.externallinkfound == 1){
                            $('.externallink img').attr('src', frontendajax.success);
                            $('.externallink img').addClass('komodo-success');
                            $('.externallink img').removeClass('komodo-err');
                        }else{
                            $('.externallink img').attr('src', frontendajax.error);
                            $('.externallink img').removeClass('komodo-success');
                            $('.externallink img').addClass('komodo-err');
                        }
                        if(result.urlfocus == 1){
                            $('.urlfocus img').attr('src', frontendajax.success);
                            $('.urlfocus img').addClass('komodo-success');
                            $('.urlfocus img').removeClass('komodo-err');
                        }else{
                            $('.urlfocus img').attr('src', frontendajax.error);
                            $('.urlfocus img').removeClass('komodo-success');
                            $('.urlfocus img').addClass('komodo-err');
                        }
                        if(result.wordCountvar == 1){
                            $('.wordCount img').attr('src', frontendajax.success);
                            $('.wordCount img').addClass('komodo-success');
                            $('.wordCount img').removeClass('komodo-err');
                        }else{
                            $('.wordCount img').attr('src', frontendajax.error);
                            $('.wordCount img').removeClass('komodo-success');
                            $('.wordCount img').addClass('komodo-err');
                        }
                    }
                }
            })
            rys_update_focuskeywordpercent();
        }
    }

    function seo_filter_title(){
        var title = $('#title').val();

        var keyword = $('#komodo_focuskeyword').val();
        var basicseo = ($('.komodo-basicseo').text());
        var intbasicseo = ($('.komodo-basicseo').text());
        var titleseo = ($('.komodo-titleseo').text());
        //Top tabs 
        if(basicseo == ""){
            basicseo = 0;
        }
        if(titleseo == ""){
            titleseo = 0;
        }

        //Parameters
        var powerkeyfound = $('.powerkeyfound img').attr('class');
        if(powerkeyfound.indexOf("komodo-err") !== -1){
            var powerkey = false;
        }else{
            var powerkey = true;
        }

        var sagmentfound = $('.sagmentfound img').attr('class');
        if(sagmentfound.indexOf("komodo-err") !== -1){
            var sagmentkey = false;
        }else{
            var sagmentkey = true;
        }

        var begintitle = $('.begintitle img').attr('class');
        if(begintitle.indexOf("komodo-err") !== -1){
            var beginkey = false;
        }else{
            var beginkey = true;
        }

        var containsnumber = $('.containsnumber img').attr('class');
        if(containsnumber.indexOf("komodo-err") !== -1){
            var numberkey = false;
        }else{
            var numberkey = true;
        }

        var basictitle = $('.basictitle img').attr('class');
        if(basictitle.indexOf("komodo-err") !== -1){
            var basictitlekey = false;
        }else{
            var basictitlekey = true;
        }

        if(title === null || title.trim() === "" || keyword === null || keyword.trim() === ""){
            titleseo = 4;
            //console.log(basictitlekey);
            if(basictitlekey == true){
                var intbasicseo = intbasicseo + 1;
            }
            $('label.kb-tab__label[for="cb3"]').addClass("kb-accordian-tab-red");
            $('label.kb-tab__label[for="cb3"]').removeClass("kb-accordian-tab-green");
            $('label.kb-tab__label[for="cb3"]').html('Title Readability <span > Error <b class="komodo-titleseo"> '+titleseo+'</b> </span>');
        
            $('label.kb-tab__label[for="cb1"]').addClass("kb-accordian-tab-red");
            $('label.kb-tab__label[for="cb1"]').removeClass("kb-accordian-tab-green");
            $('label.kb-tab__label[for="cb1"]').html('Basic SEO <span > Error <b class="komodo-basicseo"> '+intbasicseo+'</b></span>');
        
            $('.basictitle img').attr('src', frontendajax.error);
            $('.basictitle img').removeClass('komodo-success');
            $('.basictitle img').addClass('komodo-err');

            $('.begintitle img').attr('src', frontendajax.error);
            $('.begintitle img').removeClass('komodo-success');
            $('.begintitle img').addClass('komodo-err');
        
            $('.containsnumber img').attr('src', frontendajax.error);
            $('.containsnumber img').removeClass('komodo-success');
            $('.containsnumber img').addClass('komodo-err');
        
            $('.powerkeyfound img').attr('src', frontendajax.error);
            $('.powerkeyfound img').removeClass('komodo-success');
            $('.powerkeyfound img').addClass('komodo-err');
        
            $('.sagmentfound img').attr('src', frontendajax.error);
            $('.sagmentfound img').removeClass('komodo-success');
            $('.sagmentfound img').addClass('komodo-err');
        }else{
            $.ajax({
                type: 'post',
                url: frontendajax.ajaxurl,
                data: {
                    'action'            : 'komodo_check_postitle',
                    'title'             : title,
                    'keyword'           : keyword,
                    'basicseo'          : basicseo,
                    'titleseo'          : titleseo,
                    'powerkey'          : powerkey,
                    'sagmentkey'        : sagmentkey,
                    'beginkey'          : beginkey,
                    'basictitlekey'     : basictitlekey,
                    'numberkey'         : numberkey
                },
                success: function(response){
                    //console.log(response);
                    var result = JSON.parse(response);
                    if(result.titleseo == 0){
                        $('label.kb-tab__label[for="cb3"]').removeClass("kb-accordian-tab-red");
                        $('label.kb-tab__label[for="cb3"]').addClass("kb-accordian-tab-green");
                        $('label.kb-tab__label[for="cb3"]').html('Title Readability <span > All Good </span>');
                    }else{
                        $('label.kb-tab__label[for="cb3"]').addClass("kb-accordian-tab-red");
                        $('label.kb-tab__label[for="cb3"]').removeClass("kb-accordian-tab-green");
                        $('label.kb-tab__label[for="cb3"]').html('Title Readability <span > Error <b class="komodo-titleseo"> '+result.titleseo+'</b> </span>');
                    }

                    if(result.basicseo == 0){
                        $('label.kb-tab__label[for="cb1"]').removeClass("kb-accordian-tab-red");
                        $('label.kb-tab__label[for="cb1"]').addClass("kb-accordian-tab-green");
                        $('label.kb-tab__label[for="cb1"]').html('Basic SEO <span > All Good </span>');
                    }else{
                        $('label.kb-tab__label[for="cb1"]').addClass("kb-accordian-tab-red");
                        $('label.kb-tab__label[for="cb1"]').removeClass("kb-accordian-tab-green");
                        $('label.kb-tab__label[for="cb1"]').html('Basic SEO <span > Error <b class="komodo-basicseo"> '+result.basicseo+'</b></span>');
                    }

                    if(result.basictitle == 1){
                        $('.basictitle img').attr('src', frontendajax.success);
                        $('.basictitle img').addClass('komodo-success');
                        $('.basictitle img').removeClass('komodo-err');
                    }else{
                        $('.basictitle img').attr('src', frontendajax.error);
                        $('.basictitle img').removeClass('komodo-success');
                        $('.basictitle img').addClass('komodo-err');

                    }
                    if(result.begintitle == 1){
                        $('.begintitle img').attr('src', frontendajax.success);
                        $('.begintitle img').addClass('komodo-success');
                        $('.begintitle img').removeClass('komodo-err');
                    }else{
                        $('.begintitle img').attr('src', frontendajax.error);
                        $('.begintitle img').removeClass('komodo-success');
                        $('.begintitle img').addClass('komodo-err');
                    }
                    if(result.containsnumber == 1){
                        $('.containsnumber img').attr('src', frontendajax.success);
                        $('.containsnumber img').addClass('komodo-success');
                        $('.containsnumber img').removeClass('komodo-err');
                    }else{
                        $('.containsnumber img').attr('src', frontendajax.error);
                        $('.containsnumber img').removeClass('komodo-success');
                        $('.containsnumber img').addClass('komodo-err');
                    }
                    if(result.powerkeyfound == 1){
                        $('.powerkeyfound img').attr('src', frontendajax.success);
                        $('.powerkeyfound img').addClass('komodo-success');
                        $('.powerkeyfound img').removeClass('komodo-err');
                    }else{
                        $('.powerkeyfound img').attr('src', frontendajax.error);
                        $('.powerkeyfound img').removeClass('komodo-success');
                        $('.powerkeyfound img').addClass('komodo-err');
                    }
                    if(result.sagmentfound == 1){
                        $('.sagmentfound img').attr('src', frontendajax.success);
                        $('.sagmentfound img').addClass('komodo-success');
                        $('.sagmentfound img').removeClass('komodo-err');
                    }else{
                        $('.sagmentfound img').attr('src', frontendajax.error);
                        $('.sagmentfound img').removeClass('komodo-success');
                        $('.sagmentfound img').addClass('komodo-err');
                    }
                }
            })
            rys_update_focuskeywordpercent();
        }
    }

    function safeTrim(value) {
        return typeof value === 'string' ? value.trim() : '';
    }

    function gutenberg_seo_filter_title(){
        const postTitle = wp.data.select('core/editor').getEditedPostAttribute('title');
        
        var title = postTitle;
        var keyword = $('#komodo_focuskeyword').val();
        var basicseo = ($('.komodo-basicseo').text());
        var intbasicseo = ($('.komodo-basicseo').text());
        var titleseo = ($('.komodo-titleseo').text());
        //Top tabs 
        if(basicseo == ""){
            basicseo = 0;
        }
        if(titleseo == ""){
            titleseo = 0;
        }

        //Parameters
        var powerkeyfound = $('.powerkeyfound img').attr('class');
        if(powerkeyfound.indexOf("komodo-err") !== -1){
            var powerkey = false;
        }else{
            var powerkey = true;
        }

        var sagmentfound = $('.sagmentfound img').attr('class');
        if(sagmentfound.indexOf("komodo-err") !== -1){
            var sagmentkey = false;
        }else{
            var sagmentkey = true;
        }

        var begintitle = $('.begintitle img').attr('class');
        if(begintitle.indexOf("komodo-err") !== -1){
            var beginkey = false;
        }else{
            var beginkey = true;
        }

        var containsnumber = $('.containsnumber img').attr('class');
        if(containsnumber.indexOf("komodo-err") !== -1){
            var numberkey = false;
        }else{
            var numberkey = true;
        }

        var basictitle = $('.basictitle img').attr('class');
        if(basictitle.indexOf("komodo-err") !== -1){
            var basictitlekey = false;
        }else{
            var basictitlekey = true;
        }
        if (title && typeof title === 'string' || keyword && typeof keyword === 'string') {
            if(title === null || safeTrim(title) === "" || keyword === null || safeTrim(keyword) === ""){
                titleseo = 4;
                if(basictitlekey == true){
                    var intbasicseo = intbasicseo + 1;
                }
                $('label.kb-tab__label[for="cb3"]').addClass("kb-accordian-tab-red");
                $('label.kb-tab__label[for="cb3"]').removeClass("kb-accordian-tab-green");
                $('label.kb-tab__label[for="cb3"]').html('Title Readability <span > Error <b class="komodo-titleseo"> '+titleseo+'</b> </span>');
            
                $('label.kb-tab__label[for="cb1"]').addClass("kb-accordian-tab-red");
                $('label.kb-tab__label[for="cb1"]').removeClass("kb-accordian-tab-green");
                $('label.kb-tab__label[for="cb1"]').html('Basic SEO <span > Error <b class="komodo-basicseo"> '+intbasicseo+'</b></span>');
            
                $('.basictitle img').attr('src', frontendajax.error);
                $('.basictitle img').removeClass('komodo-success');
                $('.basictitle img').addClass('komodo-err');

                $('.begintitle img').attr('src', frontendajax.error);
                $('.begintitle img').removeClass('komodo-success');
                $('.begintitle img').addClass('komodo-err');
            
                $('.containsnumber img').attr('src', frontendajax.error);
                $('.containsnumber img').removeClass('komodo-success');
                $('.containsnumber img').addClass('komodo-err');
            
                $('.powerkeyfound img').attr('src', frontendajax.error);
                $('.powerkeyfound img').removeClass('komodo-success');
                $('.powerkeyfound img').addClass('komodo-err');
            
                $('.sagmentfound img').attr('src', frontendajax.error);
                $('.sagmentfound img').removeClass('komodo-success');
                $('.sagmentfound img').addClass('komodo-err');
            }else{
                $.ajax({
                    type: 'post',
                    url: frontendajax.ajaxurl,
                    data: {
                        'action'            : 'komodo_check_postitle',
                        'title'             : title,
                        'keyword'           : keyword,
                        'basicseo'          : basicseo,
                        'titleseo'          : titleseo,
                        'powerkey'          : powerkey,
                        'sagmentkey'        : sagmentkey,
                        'beginkey'          : beginkey,
                        'basictitlekey'     : basictitlekey,
                        'numberkey'         : numberkey
                    },
                    success: function(response){
                        var result = JSON.parse(response);
                        //console.log(result);
                        if(result.titleseo == 0){
                            $('label.kb-tab__label[for="cb3"]').removeClass("kb-accordian-tab-red");
                            $('label.kb-tab__label[for="cb3"]').addClass("kb-accordian-tab-green");
                            $('label.kb-tab__label[for="cb3"]').html('Title Readability <span > All Good </span>');
                        }else{
                            $('label.kb-tab__label[for="cb3"]').addClass("kb-accordian-tab-red");
                            $('label.kb-tab__label[for="cb3"]').removeClass("kb-accordian-tab-green");
                            $('label.kb-tab__label[for="cb3"]').html('Title Readability <span > Error <b class="komodo-titleseo"> '+result.titleseo+'</b> </span>');
                        }

                        if(result.basicseo == 0){
                            $('label.kb-tab__label[for="cb1"]').removeClass("kb-accordian-tab-red");
                            $('label.kb-tab__label[for="cb1"]').addClass("kb-accordian-tab-green");
                            $('label.kb-tab__label[for="cb1"]').html('Basic SEO <span > All Good </span>');
                        }else{
                            $('label.kb-tab__label[for="cb1"]').addClass("kb-accordian-tab-red");
                            $('label.kb-tab__label[for="cb1"]').removeClass("kb-accordian-tab-green");
                            $('label.kb-tab__label[for="cb1"]').html('Basic SEO <span > Error <b class="komodo-basicseo"> '+result.basicseo+'</b></span>');
                        }

                        if(result.basictitle == 1){
                            $('.basictitle img').attr('src', frontendajax.success);
                            $('.basictitle img').addClass('komodo-success');
                            $('.basictitle img').removeClass('komodo-err');
                        }else{
                            $('.basictitle img').attr('src', frontendajax.error);
                            $('.basictitle img').removeClass('komodo-success');
                            $('.basictitle img').addClass('komodo-err');

                        }
                        if(result.begintitle == 1){
                            $('.begintitle img').attr('src', frontendajax.success);
                            $('.begintitle img').addClass('komodo-success');
                            $('.begintitle img').removeClass('komodo-err');
                        }else{
                            $('.begintitle img').attr('src', frontendajax.error);
                            $('.begintitle img').removeClass('komodo-success');
                            $('.begintitle img').addClass('komodo-err');
                        }
                        if(result.containsnumber == 1){
                            $('.containsnumber img').attr('src', frontendajax.success);
                            $('.containsnumber img').addClass('komodo-success');
                            $('.containsnumber img').removeClass('komodo-err');
                        }else{
                            $('.containsnumber img').attr('src', frontendajax.error);
                            $('.containsnumber img').removeClass('komodo-success');
                            $('.containsnumber img').addClass('komodo-err');
                        }
                        if(result.powerkeyfound == 1){
                            $('.powerkeyfound img').attr('src', frontendajax.success);
                            $('.powerkeyfound img').addClass('komodo-success');
                            $('.powerkeyfound img').removeClass('komodo-err');
                        }else{
                            $('.powerkeyfound img').attr('src', frontendajax.error);
                            $('.powerkeyfound img').removeClass('komodo-success');
                            $('.powerkeyfound img').addClass('komodo-err');
                        }
                        if(result.sagmentfound == 1){
                            $('.sagmentfound img').attr('src', frontendajax.success);
                            $('.sagmentfound img').addClass('komodo-success');
                            $('.sagmentfound img').removeClass('komodo-err');
                        }else{
                            $('.sagmentfound img').attr('src', frontendajax.error);
                            $('.sagmentfound img').removeClass('komodo-success');
                            $('.sagmentfound img').addClass('komodo-err');
                        }
                    }
                })
                rys_update_focuskeywordpercent();
            }
        }
    }

    function gutenberg_seo_filter_content(){
        var content = wp.data.select('core/editor').getEditedPostContent();
        //console.log(content);
        var keyword = $('#komodo_focuskeyword').val();
        var postid = $('#post_ID').val();
        var contentreadability = $('.komodo-contentreadability').text();
        let basicseo = $('.komodo-basicseo').text();
        var adfinalseo = $('.komodo-adfinalseo').text();
        //console.log(basicseo);
        //Top tabs 
        if(contentreadability == ""){
            contentreadability = 0;
        }
        if(basicseo == ""){
            basicseo = 0;
        }
        if(adfinalseo == ""){
            adfinalseo = 0;
        }

        //Parameters 
        var basicdesc = $('.basicdesc img').attr('class');
        if(basicdesc.indexOf("komodo-err") !== -1){
            var basicdesckey = false;
        }else{
            var basicdesckey = true;
        }

        var urlfocus = $('.urlfocus img').attr('class');
        if(urlfocus.indexOf("komodo-err") !== -1){
            var urlfocuskey = false;
        }else{
            var urlfocuskey = true;
        }

        var firstfocus = $('.firstfocus img').attr('class');
        if(firstfocus.indexOf("komodo-err") !== -1){
            var firstfocuskey = false;
        }else{
            var firstfocuskey = true;
        }

        var wordCount = $('.wordCount img').attr('class');
        if(wordCount.indexOf("komodo-err") !== -1){
            var wordCountkey = false;
        }else{
            var wordCountkey = true;
        }
		
        var focuskeyword = $('.focuskeyword img').attr('class');
        if(focuskeyword.indexOf("komodo-err") !== -1){
            var focuskey = false;
        }else{
            var focuskey = true;
        }

        var focusimg = $('.focusimg img').attr('class');
        if(focusimg.indexOf("komodo-err") !== -1){
            var focusimgkey = false;
        }else{
            var focusimgkey = true;
        }

        var keyworddensity = $('.keyworddensity img').attr('class');
        if(keyworddensity.indexOf("komodo-err") !== -1){
            var keyworddensitykey = false;
        }else{
            var keyworddensitykey = true;
        }

        var externallink = $('.externallink img').attr('class');
        if(externallink.indexOf("komodo-err") !== -1){
            var externallinkkey = false;
        }else{
            var externallinkkey = true;
        }

        var paragraph_readability = $('.paragraph_readability img').attr('class');
        if(paragraph_readability.indexOf("komodo-err") !== -1){
            var parareadabilitykey = false;
        }else{
            var parareadabilitykey = true;
        }

        var imgcontain = $('.imgcontain img').attr('class');
        if(imgcontain.indexOf("komodo-err") !== -1){
            var imgcontainkey = false;
        }else{
            var imgcontainkey = true;
        }

        if(content === null || safeTrim(content) === "" || keyword === null || safeTrim(keyword) === ""){
            //
            basicseo = 5;
            adfinalseo = 5;
            contentreadability = 2;
            $('label.kb-tab__label[for="cb1"]').addClass("kb-accordian-tab-red");
            $('label.kb-tab__label[for="cb1"]').removeClass("kb-accordian-tab-green");
            $('label.kb-tab__label[for="cb1"]').html('Basic SEO <span> Error <b class="komodo-basicseo"> '+basicseo+'</b></span>');
        
            $('label.kb-tab__label[for="cb2"]').addClass("kb-accordian-tab-red");
            $('label.kb-tab__label[for="cb2"]').removeClass("kb-accordian-tab-green");
            $('label.kb-tab__label[for="cb2"]').html('Additional <span> Error <b class="komodo-adfinalseo"> '+adfinalseo+'</b> </span>');
        
            $('label.kb-tab__label[for="cb4"]').addClass("kb-accordian-tab-red");
            $('label.kb-tab__label[for="cb4"]').removeClass("kb-accordian-tab-green");
            $('label.kb-tab__label[for="cb4"]').html('Content Readability <span> Error <b class="komodo-contentreadability"> '+contentreadability+'</b> </span>');
        
            $('.basicdesc img').attr('src', frontendajax.error);
            $('.basicdesc img').removeClass('komodo-success');
            $('.basicdesc img').addClass('komodo-err');
        
            $('.firstfocus img').attr('src', frontendajax.error);
            $('.firstfocus img').removeClass('komodo-success');
            $('.firstfocus img').addClass('komodo-err');
        
            $('.focuskeyword img').attr('src', frontendajax.error);
            $('.focuskeyword img').removeClass('komodo-success');
            $('.focuskeyword img').addClass('komodo-err');
        
            $('.focusimg img').attr('src', frontendajax.error);
            $('.focusimg img').removeClass('komodo-success');
            $('.focusimg img').addClass('komodo-err');
        
            $('.imgcontain img').attr('src', frontendajax.error);
            $('.imgcontain img').removeClass('komodo-success');
            $('.imgcontain img').addClass('komodo-err');
        
            $('.keyworddensity img').attr('src', frontendajax.error);
            $('.keyworddensity img').removeClass('komodo-success');
            $('.keyworddensity img').addClass('komodo-err');
        
            $('.paragraph_readability img').attr('src', frontendajax.error);
            $('.paragraph_readability img').removeClass('komodo-success');
            $('.paragraph_readability img').addClass('komodo-err');
        
            $('.externallink img').attr('src', frontendajax.error);
            $('.externallink img').removeClass('komodo-success');
            $('.externallink img').addClass('komodo-err');
        
            $('.wordCount img').attr('src', frontendajax.error);
            $('.wordCount img').removeClass('komodo-success');
            $('.wordCount img').addClass('komodo-err');
        }else{
            $.ajax({
                type: 'post',
                url: frontendajax.ajaxurl,
                data: {
                    'action'            : 'komodo_check_postcontent',
                    'postid'            : postid,
                    'content'           : content,
                    'keyword'           : keyword,
                    'contentreadability': contentreadability,
                    'basicseo'          : basicseo,
                    'adfinalseo'        : adfinalseo,
                    'basicdesckey'      : basicdesckey,
                    'urlfocuskey'       : urlfocuskey,
                    'firstfocuskey'     : firstfocuskey,
                    'wordCountkey'      : wordCountkey,
                    'focuskey'          : focuskey,
                    'focusimgkey'       : focusimgkey,
                    'keyworddensitykey' : keyworddensitykey,
                    'externallinkkey'   : externallinkkey,
                    'parareadabilitykey': parareadabilitykey,
                    'imgcontainkey'     : imgcontainkey
                },
                success: function(response){
                    if(response == 'null'){
                        //console.log("test");
                    }else{
                        var result = JSON.parse(response);
                        //console.log(result);
                        if(result.basicseo == 0){
                            $('label.kb-tab__label.cb1').removeClass("kb-accordian-tab-red");
                            $('label.kb-tab__label.cb1').addClass("kb-accordian-tab-green");
                            $('label.kb-tab__label.cb1').html('Basic SEO <span> All Good </span>');
                        }else{
                            $('label.kb-tab__label.cb1').addClass("kb-accordian-tab-red");
                            $('label.kb-tab__label.cb1').removeClass("kb-accordian-tab-green");
                            $('label.kb-tab__label.cb1').html('Basic SEO <span> Error <b class="komodo-basicseo"> '+result.basicseo+'</b></span>');
                        }

                        if(result.adfinalseo == 0){
                            $('label.kb-tab__label.cb2').removeClass("kb-accordian-tab-red");
                            $('label.kb-tab__label.cb2').addClass("kb-accordian-tab-green");
                            $('label.kb-tab__label.cb2').html('Additional <span > All Good </span>');
                        }else{
                            $('label.kb-tab__label.cb2').addClass("kb-accordian-tab-red");
                            $('label.kb-tab__label.cb2').removeClass("kb-accordian-tab-green");
                            $('label.kb-tab__label.cb2').html('Additional <span> Error <b class="komodo-adfinalseo"> '+result.adfinalseo+'</b> </span>');
                        }

                        if(result.contentreadability == 0){
                            $('label.kb-tab__label.cb4').removeClass("kb-accordian-tab-red");
                            $('label.kb-tab__label.cb4').addClass("kb-accordian-tab-green");
                            $('label.kb-tab__label.cb4').html('Content Readability <span > All Good </span>');
                        }else{
                            $('label.kb-tab__label.cb4').addClass("kb-accordian-tab-red");
                            $('label.kb-tab__label.cb4').removeClass("kb-accordian-tab-green");
                            $('label.kb-tab__label.cb4').html('Content Readability <span> Error <b class="komodo-contentreadability"> '+result.contentreadability+'</b> </span>');
                        }
    
                        if(result.basicdesc == 1){
                            $('.basicdesc img').attr('src', frontendajax.success);
                            $('.basicdesc img').addClass('komodo-success');
                            $('.basicdesc img').removeClass('komodo-err');
                        }else{
                            $('.basicdesc img').attr('src', frontendajax.error);
                            $('.basicdesc img').removeClass('komodo-success');
                            $('.basicdesc img').addClass('komodo-err');
                        }
                        if(result.firstfocus == 1){
                            $('.firstfocus img').attr('src', frontendajax.success);
                            $('.firstfocus img').addClass('komodo-success');
                            $('.firstfocus img').removeClass('komodo-err');
                        }else{
                            $('.firstfocus img').attr('src', frontendajax.error);
                            $('.firstfocus img').removeClass('komodo-success');
                            $('.firstfocus img').addClass('komodo-err');
                        }
                        if(result.focus == 1){
                            $('.focuskeyword img').attr('src', frontendajax.success);
                            $('.focuskeyword img').addClass('komodo-success');
                            $('.focuskeyword img').removeClass('komodo-err');
                        }else{
                            $('.focuskeyword img').attr('src', frontendajax.error);
                            $('.focuskeyword img').removeClass('komodo-success');
                            $('.focuskeyword img').addClass('komodo-err');
                        }
                        if(result.focusimg == 1){
                            $('.focusimg img').attr('src', frontendajax.success);
                            $('.focusimg img').addClass('komodo-success');
                            $('.focusimg img').removeClass('komodo-err');
                        }else{
                            $('.focusimg img').attr('src', frontendajax.error);
                            $('.focusimg img').removeClass('komodo-success');
                            $('.focusimg img').addClass('komodo-err');
                        }
                        if(result.imgcontain == 1){
                            $('.imgcontain img').attr('src', frontendajax.success);
                            $('.imgcontain img').addClass('komodo-success');
                            $('.imgcontain img').removeClass('komodo-err');
                        }else{
                            $('.imgcontain img').attr('src', frontendajax.error);
                            $('.imgcontain img').removeClass('komodo-success');
                            $('.imgcontain img').addClass('komodo-err');
                        }
                        if(result.keyworddensity == 1){
                            $('.keyworddensity img').attr('src', frontendajax.success);
                            $('.keyworddensity img').addClass('komodo-success');
                            $('.keyworddensity img').removeClass('komodo-err');
                        }else{
                            $('.keyworddensity img').attr('src', frontendajax.error);
                            $('.keyworddensity img').removeClass('komodo-success');
                            $('.keyworddensity img').addClass('komodo-err');
                        }
                        if(result.paragraph_readability == 1){
                            $('.paragraph_readability img').attr('src', frontendajax.success);
                            $('.paragraph_readability img').addClass('komodo-success');
                            $('.paragraph_readability img').removeClass('komodo-err');
                        }else{
                            $('.paragraph_readability img').attr('src', frontendajax.error);
                            $('.paragraph_readability img').removeClass('komodo-success');
                            $('.paragraph_readability img').addClass('komodo-err');
                        }
                        if(result.externallinkfound == 1){
                            $('.externallink img').attr('src', frontendajax.success);
                            $('.externallink img').addClass('komodo-success');
                            $('.externallink img').removeClass('komodo-err');
                        }else{
                            $('.externallink img').attr('src', frontendajax.error);
                            $('.externallink img').removeClass('komodo-success');
                            $('.externallink img').addClass('komodo-err');
                        }
                        if(result.urlfocus == 1){
                            $('.urlfocus img').attr('src', frontendajax.success);
                            $('.urlfocus img').addClass('komodo-success');
                            $('.urlfocus img').removeClass('komodo-err');
                        }else{
                            $('.urlfocus img').attr('src', frontendajax.error);
                            $('.urlfocus img').removeClass('komodo-success');
                            $('.urlfocus img').addClass('komodo-err');
                        }
                        if(result.wordCountvar == 1){
                            $('.wordCount img').attr('src', frontendajax.success);
                            $('.wordCount img').addClass('komodo-success');
                            $('.wordCount img').removeClass('komodo-err');
                        }else{
                            $('.wordCount img').attr('src', frontendajax.error);
                            $('.wordCount img').removeClass('komodo-success');
                            $('.wordCount img').addClass('komodo-err');
                        }
						if(result.worddesc != null){
                            $('.contentofwordcount').html(result.worddesc);
                        }
						if(result.keywordtext != null){
                            $('.contentofkeyword').html(result.keywordtext);
                        }
                    }
                }
            })
            rys_update_focuskeywordpercent();
        }
    }

    function rys_update_focuskeywordpercent(){
        // Update button data
        var numItems = $('.komodo-err').length;
		var totalpercent = 0;
		if(numItems != 0){
			minusepercent = 100/17;
			
			totalpercent = 100 - (minusepercent*numItems);
		}else{
			totalpercent = 100;
		}
        exclass = 'has-low-rank';
        if(Math.round(totalpercent) < 40 ){
            var exclass = 'has-low-rank';
        }
        if(Math.round(totalpercent) > 40 && Math.round(totalpercent) < 80){
            var exclass = 'has-mid-rank';
        }
        if(Math.round(totalpercent) > 80){
            var exclass = 'has-high-rank';
        }
        var backButton = Math.round(totalpercent)+'/100';

        $('.mathpercent').text(backButton);

        var element = $('.rys_btn_head'); // Replace with a more specific selector if necessary

        // Get all classes of the div element
        const classes = (element.attr('class') || '').split(/\s+/);
        
        // Loop through each class and check if it starts with 'has'
        $.each(classes, function(index, className) {
            if (className.startsWith('has')) {
                element.removeClass(className); // Remove the class starting with 'has'
            }
        });
        $('.rys_btn_head').addClass(exclass);

        // Save Button Data
        const id = frontendajax.postid;
        var tagl = $('#komodo_focuskeyword').val();
        var tagl = $('#komodo_focuskeyword').val();
        var percent = $('.mathpercent').text();
            // Perform AJAX request
            jQuery.ajax({
            type: 'POST', // Use 'POST' method
            url: frontendajax.ajaxurl, // Ensure this URL is set correctly
            data: {
                action: 'komodo_save_metadata', // Action hook for WordPress
                taglist: tagl, // Ensure tagList is defined, default to empty array if not
                postid: id, // Post ID
                percent:percent
            },
            success: function(response) {
                //console.log('Success:', response); // Log the response
            },
            error: function(xhr, status, error) {
                //console.error('AJAX Error:', error); // Log any errors
            }
        });
    }

})(jQuery);