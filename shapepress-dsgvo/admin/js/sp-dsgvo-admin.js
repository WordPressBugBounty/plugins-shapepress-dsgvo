var spDsgvoActiveAdminSubmenu = '';

(function($){

	$(document).ready(function(){

	    /************************
		* Settings
		*************************/
		$('.btn-settings').click(function(){
			if($(this).attr('data-state') == 'closed'){
				$('.btn-settings-show').show();
				$(this).attr('data-state', 'open');
				$(this).find('.state').html('Hide');
			}else{
				$('.btn-settings-show').hide();
				$(this).attr('data-state', 'closed');
				$(this).find('.state').html('Show');
			}
		});


		/************************
		* SAR
		*************************/
		$('#process_now').change(function(){
			var checkbox = document.getElementById('process_now');
			if(checkbox){
				if(checkbox.checked){
					$('#display_email').closest('tr').show();
				}else{
					$('#display_email').closest('tr').hide();
				}
			}
		});

		$('.cbChecklist').on('change', function () {
            var input = $(this).next('span');
            if (this.checked) {
                $(input).css('textDecoration', 'line-through');
            } else {
                $(input).css('textDecoration', 'none');
            }
            $('#checklist-form').submit();
        });


		$('.unsubscribe-dismiss').on('click tap', function() {
			var $this = $(this),
				id = $this.attr('data-id'),
			    wpnonce = $this.attr('data-nonce');

			if(confirm(args.dismiss_confirm)) {
				$this.parent().parent().fadeOut(500);
				$.post( args.ajaxurl, {
	                action: 'admin-dismiss-unsubscribe',
	                id: id,
					_wpnonce: wpnonce
	            },
	            function( data ) {
	            } );
			}
		});
		/* i592995 */

		$(".sp-dsgvo-admin-notice a").click(function(e) {
			e.preventDefault();
		});

		$('.google-gdpr-refresh-notice').on('click tap', function() {
			
			$.post( args.ajaxurl, {
                action: 'notice-action',
                id: 'google-gdpr-refresh-notice'
            });
			
		});

		$('.license-invalid-notice').on('click tap', function() {
			
			$.post( args.ajaxurl, {
                action: 'notice-action',
                id: 'license-invalid-notice'
            });
			
		});
		
		$('.privacy-policy-texts-outdated-notice').on('click tap', function() {
			
			$.post( args.ajaxurl, {
                action: 'notice-action',
                id: 'privacy-policy-texts-outdated-notice'
            });
			
		});

		$('.update-check-settings-notice').on('click tap', function() {

			$.post( args.ajaxurl, {
				action: 'notice-action',
				id: 'update-check-settings-notice'
			});

		});

		$('.privacy-policy-texts-refresh-link').on('click tap', function() {

			$('#progress-pp-texts-reload').show();
			$('#btn-refresh-pp-texts').hide();
			$.post( args.ajaxurl, {
				action: 'update-privacy-policy-texts-action',
				id: ''
			}, function (data) {
				location.reload();
			});

		});

		$('.license-revoke-notice').on('click tap', function() {

			$.post( args.ajaxurl, {
				action: 'notice-action',
				id: 'license-revoke-notice'
			});

		});

		$('.update-notice-version-310').on('click tap', function(event) {

			var clicked = $(event.target);
			if (clicked.is('.notice-dismiss') == false) return;

			$.post( args.ajaxurl, {
				action: 'notice-action',
				id: 'update-notice-version-310'
			});

		});

		$('.feature-notice-webinars').on('click tap', function(event) {

			var clicked = $(event.target);
			if (clicked.is('.notice-dismiss') == false) return;

			$.post( args.ajaxurl, {
				action: 'notice-action',
				id: 'feature-notice-webinars'
			});

		});

		$('.update-notice-securityleak0921').on('click tap', function(event) {

			var clicked = $(event.target);
			if (clicked.is('.notice-dismiss') == false) return;

			$.post( args.ajaxurl, {
				action: 'notice-action',
				id: 'update-notice-securityleak0921'
			});

		});
		
		/* p912419 */
		var DeclineCheckbox = document.getElementById('decline_button_allowed');
		$(DeclineCheckbox).on('change', function(){
			if(DeclineCheckbox){
				if(DeclineCheckbox.checked){
					$('#decline_button_text_color').closest('tr').show();
					$('#decline_button_bg_color').closest('tr').show();
				}else{
					$('#decline_button_text_color').closest('tr').hide();
					$('#decline_button_bg_color').closest('tr').hide();
				}
			}
		});
		$(DeclineCheckbox).trigger('change');

		// Advanced Cookie Settings
		var AdvancedDeclineCheckbox = document.getElementById('cn_activate_advanced_settings_btn');
		$(AdvancedDeclineCheckbox).on('change', function(){
			if(AdvancedDeclineCheckbox){
				if(AdvancedDeclineCheckbox.checked){
					$('.cn_advanced_cookie_info').show();
				}else{
					$('.cn_advanced_cookie_info').hide();
					$('#cn_advanced_cookie_settings_textarea').prop('checked', false);
					$('#cn_advanced_cookie_settings_textarea').trigger('change');
				}
			}
		});
		$(AdvancedDeclineCheckbox).trigger('change');


		// backend cookie selector
		var CookieViewSelector = $('#cookie_style');
		var CookieImg = $('img[class*="cookie-style-admin-show--"]');
		$(CookieViewSelector).on('change', function(){
			var val = $(this).val();
			var CurrentImg = $('img[class*="cookie-style-admin-show--' + val +'"]');
			$(CookieImg).hide();
			$(CurrentImg).show();

			if (val == '00')
			{
				$('.cn-customize-standard-notice-container').show();
			} else
			{
				$('.cn-customize-standard-notice-container').hide();
			}
		});
		$(CookieViewSelector).trigger('change');

		/* end p912419 */
		if($('#su_email_content').length > 0 ) {
			wp.editor.initialize( 'su_email_content' );
		}
		if($('#sar_email_content').length > 0) {
			wp.editor.initialize( 'sar_email_content' );
		}

		function spDsgvoMarkActiveAdminSubmenu(activeSlug)
		{
			$('a[href^="admin.php?page=sp-dsgvo&tab=info"]').css('color','#28a745');
			$('a[href^="admin.php?page=sp-dsgvo&tab=info"]').css('font-weight','500');

			$('a[href^="admin.php?page=sp-dsgvo&tab=webinars"]').css('color','#299ccd');
			$('a[href^="admin.php?page=sp-dsgvo&tab=webinars"]').css('font-weight','500');

			if(document.URL.indexOf("admin.php?page=sp-dsgvo") < 0){
				return;
			}

			//alert(activeSlug);
			$('a[href*="admin.php?page=sp-dsgvo"]').each(function() {
				$(this).parent().removeClass('current');
			});
			if(activeSlug == 'common-settings')
			{
				$('a[href$="admin.php?page=sp-dsgvo"]').parent().addClass('current');
			} else {
				$('a[href^="admin.php?page=sp-dsgvo&tab=' + activeSlug + '"]').parent().addClass('current');
			}
		}
		
		spDsgvoMarkActiveAdminSubmenu(spDsgvoActiveAdminSubmenu);

		// ***** page operator ****
		$("#page_operator_type").on('change', function(){
			var val = $(this).val();

			$('.page-operator-type-container').hide();
			$('.label-operator-type').hide();
			var label = 'corporate';
			if (val != '') label = 'oneman-private';
			switch (val) {
				case 'private': break;
				case 'one-man': break;
				case 'corporation': break;
				case 'society': break;
				case 'corp-public-law': break;
				case 'corp-private-law': break;
			}
			$('.page-operator-type-container-'+val).show();
			$('.label-operator-type-'+val).show();

		});

		$("#spdsgvo_company_info_countrycode").on('change', function(){
			var val = $(this).val();

			if (val)
			{
				$('.page-operator-container-us').show();
			} else
			{
				$('.page-operator-container-us').hide();
			}

		});


		$("input[name='operator_pp_responsibility_type']").change(function() {

			$(".container-pp-responsibility").removeClass('spdsgvo-d-block').addClass('spdsgvo-d-none');
			$(".container-dso-contact").removeClass('spdsgvo-d-block').addClass('spdsgvo-d-none');

			let val = $("input[name=operator_pp_responsibility_type]:checked").val();

			let visibleDsoTypeContainerId = '';
			switch (val) {
				case 'internal': visibleDsoTypeContainerId = 'container-pp-responsibility-internal'; break;
				case 'external': visibleDsoTypeContainerId = 'container-pp-responsibility-external';break;
				case 'none': visibleDsoTypeContainerId = 'container-pp-responsibility-none';break;
				default: visibleDsoTypeContainerId = '';
			}

			if (visibleDsoTypeContainerId != '') $('#'+visibleDsoTypeContainerId).addClass('spdsgvo-d-block');



		});

		$("input[name='operator_pp_responsibility_contact']").change(function() {

			$(".container-dso-contact").removeClass('spdsgvo-d-block').addClass('spdsgvo-d-none');

			let val = $("input[name=operator_pp_responsibility_contact]:checked").val();

			let visibleDsoContactContainerId = '';

			switch (val) {
				case 'internal': visibleDsoContactContainerId = 'container-dso-contact-internal'; break;
				case 'external': visibleDsoContactContainerId = 'container-dso-contact-external'; break;
				case 'no': visibleDsoContactContainerId = ''; break; // nothing to do here
				default: visibleDsoContactContainerId = '';
			}

			if (visibleDsoContactContainerId != '') $('#'+visibleDsoContactContainerId).addClass('spdsgvo-d-block');
		});

		// page basics
		$("#page_basics_hosting_provider_other").change(function() {

			if($("#page_basics_hosting_provider_other").is(':checked'))
				$("#container-other-provider").show();  // checked
			else
				$("#container-other-provider").hide();  // unchecked
		});

		$("#page_basics_use_logfiles").change(function() {

			if($("#page_basics_use_logfiles").is(':checked'))
				$("#container-logfiles-life").show();  // checked
			else
				$("#container-logfiles-life").hide();  // unchecked
		});

		$("#page_basics_use_cdn").change(function() {

			if($("#page_basics_use_cdn").is(':checked'))
				$("#container-basics-use-cdn").show();  // checked
			else
				$("#container-basics-use-cdn").hide();  // unchecked
		});

		$("#page_basics_cdn_provider_other").change(function() {

			if($("#page_basics_cdn_provider_other").is(':checked'))
				$("#container-other-cdn").show();  // checked
			else
				$("#container-other-cdn").hide();  // unchecked
		});

		$("#page_basics_use_payment_provider").change(function() {

			if($("#page_basics_use_payment_provider").is(':checked'))
				$("#container-basics-use-payment-provider").show();  // checked
			else
				$("#container-basics-use-payment-provider").hide();  // unchecked
		});

		$("#page_basics_font_provider_google-fonts").change(function() {

			if($("#page_basics_font_provider_google-fonts").is(':checked'))
				$("#container-block-google-fonts").show();  // checked
			else
				$("#container-block-google-fonts").hide();  // unchecked
		});

		$("#page_basics_forms_comments").change(function() {

			if($("#page_basics_forms_comments").is(':checked'))
				$(".container-basics-forms_comments").show();  // checked
			else
				$(".container-basics-forms_comments").hide();  // unchecked
		});

		$("#page_basics_security_provider_other").change(function() {

			if($("#page_basics_security_provider_other").is(':checked'))
				$("#container-other-security").show();  // checked
			else
				$("#container-other-security").hide();  // unchecked
		});

		$("#page_basics_use_newsletter_provider").change(function() {

			if($("#page_basics_use_newsletter_provider").is(':checked'))
				$("#container-basics-use-newsletter").show();  // checked
			else
				$("#container-basics-use-newsletter").hide();  // unchecked
		});

		$("#page_basics_newsletter_other").change(function() {

			if($("#page_basics_newsletter_other").is(':checked'))
				$("#container-other-newsletter").show();  // checked
			else
				$("#container-other-newsletter").hide();  // unchecked
		});

		$('#btnIncreaseCookieVersion').on('click tap', function (event) {

			$('#cookie_version').val((new Date()).getTime());
		});

		$(".implementation-mode").on('change', function(){
			var val = $(this).val();

			if (val == 'by-agency')
			{
				$(this).closest('.integration-container').find('.meta-agency').parent().show();

			} else
			{
				$(this).closest('.integration-container').find('.meta-agency').parent().hide();
			}

		});

		$("#embed_placeholder_text_color").change(function() {

			var val = $(this).val();
			$(".sp-dsgvo-blocked-embedding-placeholder").css('color',val);
		});

		$("#embed_placeholder_border_color_button").change(function() {

			var val = $(this).val();
			$(".sp-dsgvo-blocked-embedding-button-enable").css('border-color',val);
		});

		$("#embed_placeholder_border_size_button").change(function() {

			var val = $(this).val();
			$(".sp-dsgvo-blocked-embedding-button-enable").css('border-width',val);
		});

		/*
		$(function() {
			$('.color-field').wpColorPicker();
		});
		*/
	});
})( jQuery );



/* i592995 */
// THIS PART OF THE SCRIPT ADDS UPLOAD IMAGE Buttons

jQuery( document ).ready( function( $ ) {

	function prepareUpload($upload) {
		// Uploading files
		var file_frame;
		var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
		var set_to_post_id = $upload.find('.image-id').val(); // Set this

		$upload.find('#logo_upload_image_button').on('click', function( event ){
			event.preventDefault();
			// If the media frame already exists, reopen it.
			if ( file_frame ) {
				// Set the post ID to what we want
				file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
				// Open frame
				file_frame.open();
				return;
			} else {
				// Set the wp.media post id so the uploader grabs the ID we want when initialised
				wp.media.model.settings.post.id = set_to_post_id;
			}
			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				multiple: false	// Set to true to allow multiple files to be selected
			});
			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
				// We set multiple to false so only get one image from the uploader
				attachment = file_frame.state().get('selection').first().toJSON();
				// Do something with attachment.id and/or attachment.url here
				$upload.find('.image-preview').attr( 'src', attachment.url );
				$upload.find('.image-id').val( attachment.id );
				// Restore the main post ID
				wp.media.model.settings.post.id = wp_media_post_id;
			});
				// Finally, open the modal
				file_frame.open();
		});

		// Restore the main ID when the add media button is pressed
		jQuery( 'a.add_media' ).on( 'click', function() {
			wp.media.model.settings.post.id = wp_media_post_id;
		});
	}

	$('.dsgvo-image-upload').each(function() {
		var $this = $(this);

		prepareUpload($this);
	});

	$('#own_code').on('change', function() {
		var $this = $(this);
		$this.toggleClass('active');

		if($this.hasClass('active')) {
			$('#ga_code').removeAttr('disabled');
			$('#fb_pixel_code').removeAttr('disabled');
		} else {
			$('#ga_code').attr('disabled', 'disabled');
			$('#fb_pixel_code').attr('disabled', 'disabled');
		}
	});

	$('.own-code-toggle').on('change', function() {
		var $this = $(this);


		if($(this).is(':checked')) {
			$(this).parents('.card-body').find('[class*="own-code-text"]').removeAttr('disabled');
		} else {
			$(this).parents('.card-body').find('[class*="own-code-text"]').attr('disabled', 'disabled');
		}
	});

	$.fn.detectFont = function() {
		var fonts = $(this).css('font-family').split(",");
		if ( fonts.length == 1 )
			return fonts[0];

		var element = $(this);
		var detectedFont = null;
		fonts.forEach( function( font ) {
			var clone = element.clone().css({'visibility': 'hidden', 'font-family': font}).appendTo('body');
			if ( element.width() == clone.width() )
				detectedFont = font;
			clone.remove();
		});

		return detectedFont;
	}

});
