
<!--Main Wrapper-->
<div class="komodo-main-wrapper komodo-dashboard-page">
	<div class="komodo-container komodos-authentication-box">
		<div class="komodo-header">
			<div class="komodo-logo">
				<img src="<?= esc_url(plugins_url('rank-your-site/admin/images/logo.png')) ?>" alt="" />
			</div>
		</div>
		<div class="komodo-row">
				<div class="komodo-content">
					<div class="komodo-head">
						<h2><?= esc_html__('Welcome to RankYourSite','rank-your-site'); ?></h2>
						<p>You are securing access with advanced identity verification. Enter the license key below to connect to your account. After the License Key connection, you will continue with Rank Your Sites options.</p>
					</div>
					<div class="komodo_generalsetting_wrapper komodo-form-wrapper">
						<form action="" method="post" class="form_authensetting_submit">
							<div class="komodo-input">        
                                <input type="text" name="kb_auth_key" value="<?php echo esc_attr($auth_key); ?>" data-error="Please Enter Auth Key " placeholder="Please Enter Authentication Key" required>   
							</div>
							<div class="komodo-btn-wrapper">
								<?php 
								$authkey = get_option('kb_auth_key');
								if(!empty($auth_key)){
									?>
									<input type="button" name="kb_auth_disconnect" action="kb_auth_user" value="Disconnect" class="komodo-btn kb_Authentication_key">
									<?php
								}else{ ?>
								<input type="button" name="kb_auth_key" action="kb_auth_user"  value="Connect" class="komodo-btn kb_Authentication_key">
								<?php } ?>
							</div>							
							<p class="komodo-input-note"><?php echo esc_html__(' User will get this license key on their Members Area dashboard under download option.','rank-your-site'); ?><a href="https://rankyoursites.net/" target="_blank">Click Here</a></p>
							<p class="komodo-input-note"><?php echo esc_html__('This is the Rank Your Sites plugin documentation','rank-your-site'); ?><a href="https://rankyoursites.net/documentations/" target="_blank">Click Here</a></p>
						</form> 
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
        <h4>Loading...</h4>
    </div>
</div>