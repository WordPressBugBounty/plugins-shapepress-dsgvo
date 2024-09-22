<?php
$image_path = SPDSGVO::pluginURI('');
?>
<style>

                  /* p912419
cookie notice view */

	/* global settings for cookie styles */
	div[class*='cookie-style-'] {
		justify-content: center;
		align-items: center;
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
	}

	/* cookie style 01 */
	.cookie-style-01 {
		justify-content: left !important;
		min-height: 170px;
		padding: 0 15%;
		background-color: #ffffff !important;
		color: #323640 !important;
	}

	.cookie-style-01 .cookie-notice-container {
		text-align: left;
	}

	.cookie-style-01 .cookie-notice-container #cn-notice-text {
		display: block;
		margin: 25px 0 40px 0;
	}

	.cookie-style-01 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
		padding: 10px 30px;
		border: 2px solid #CAD7D7;
		border-radius: 6px;
        background-color: #22C7A9 !important;
        color: #ffffff !important;
        box-shadow: 1px 5px 10px #585656;
		box-sizing: border-box;
	}

	.cookie-style-01 .cookie-notice-container #cn-buttons-container #cn-btn-settings::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/cog-light.svg);
		background-position: center;
		background-size: 12px;
		height: 12px;
		width: 12px;
        vertical-align: middle;
        margin-right: 1px;
	}


	/* cookie style 02 */
	.cookie-style-02 {
		justify-content: left !important;
		min-height: 170px;
		padding: 0 15%;
		background-color: #323640 !important;
		color: #ffffff !important;
	}

	.cookie-style-02 .cookie-notice-container {
		text-align: left;
	}

	.cookie-style-02 .cookie-notice-container #cn-notice-text {
		display: block;
		margin: 25px 0 40px 0;
	}

	.cookie-style-02 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
		padding: 10px 30px;
        border: unset;
        border-radius: 6px;
        background-color: #495CCB !important;
		color: #ffffff !important;
	}

	.cookie-style-02 .cookie-notice-container #cn-buttons-container #cn-btn-settings::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/cog-light-white.svg);
		background-position: center;
		background-size: 12px;
		height: 12px;
		width: 12px;
        vertical-align: middle;
        margin-right: 1px;
	}

	/* cookie style 03 */
	.cookie-style-03 {
		justify-content: left !important;
		height: 120px !important;
		padding: 0 10%;
		background-color: #ffffff !important;
		color: #323640 !important;
	}

	.cookie-style-03 .cookie-notice-container {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.cn_cookie_icon_03 {
		max-width: 100px;
	}

	.cookie-style-03-text {
		flex-direction: column;
		align-items: baseline !important;
	}


	.cookie-style-03 .cookie-notice-container #cn-notice-text {
		text-align: left;
        margin-left: 20px;
        margin-right: 20px;
	}

	.cookie-style-03 .cookie-notice-container #cn-buttons-container {

	}

	.cookie-style-03 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
		padding: 10px 30px;
        border: unset;
        background-image: linear-gradient(104deg, #F6B019 , #F35D14);
        color: #ffffff !important;
		border-radius: 6px;
	}

	.cookie-style-03 .cookie-notice-container #cn-buttons-container #cn-btn-settings::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/cog-light-white.svg);
		background-position: center;
		background-size: 11px;
		height: 11px;
		width: 11px;
		margin-right: 5px;
	}

	/* cookie style 04 */
	.cookie-style-04 {
		justify-content: left !important;
		height: 100px !important;
		padding: 0 5%;
		background-color: #ffffff !important;
		color: #323640 !important;
	}

	.cookie-style-04 .cookie-notice-container {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}


	.cookie-style-04 .cookie-notice-container #cn-notice-text {
		text-align: left;
	}

	.cn_cookie_icon_04 {
		max-width: 90px;
		border-radius: 50%;
		margin-bottom: 5px;
        float:left;
	}

	.cookie-style-04 .cookie-notice-container #cn-buttons-container {
		display: flex;
	}

	.cookie-style-04 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
		padding: 16px 30px;
		border: 1px solid #323640;
		border-radius: 36px;
		background-color: #ffffff !important;
		color: #323640 !important;
		order: 1;
	}

	.cookie-style-04 .cookie-notice-container #cn-buttons-container #cn-btn-settings::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/cog-light.svg);
		background-position: center;
		background-size: 11px;
		height: 11px;
		width: 11px;
		margin-right: 5px;
	}

	/* cookie style 05 */
	.cookie-style-05 {
		justify-content: left !important;
		min-height: 120px;
		padding: 0 5%;
		background-color: #ffffff !important;
		color: #030E57 !important;
	}

	.cn_cookie_icon_05 {
		width: 80px;
	}

	.cookie-style-05 .cookie-notice-container {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.cookie-style-05 .cookie-notice-container .cookie-style-03-text {
		margin-left: 45px;
	}

	.cookie-style-05 .cookie-notice-container h3{
		color: #030E57;
		margin: 0 0 15px 0;
	}

	.cookie-style-05 .cookie-notice-container #cn-buttons-container {

	}

	.cookie-style-05 .cookie-notice-container #cn-buttons-container .button.wp-default {
		padding: 18px 30px;
		background-color: #030E57 !important;
		color: #ffffff !important;
		border: unset;
		border-radius: 36px;
		box-shadow: 1px 5px 15px #323640;
	}

	.cookie-style-05 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
		border-radius: 36px;
		background-color: #ffffff !important;
		color: #030E57 !important;
		box-shadow: 1px 5px 15px #000000;
	}

	.cookie-style-05 .cookie-notice-container #cn-buttons-container #cn-btn-settings::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/cog-solid-blblue.svg);
		background-position: center;
		background-size: 11px;
		height: 11px;
		width: 11px;
		margin-right: 5px;
	}

	/* cookie style 06 */

	.cookie-style-06 {
		justify-content: space-around !important;
		min-height: 90px;
		padding: 0 5%;
		background-color: #ffffff !important;
		color: #323640 !important;
	}

	.cookie-style-06 .cookie-notice-container {
		display: flex;
		justify-content: space-around;
		align-items: center;
	}

	.cookie-style-06 .cookie-notice-container h3 {
		color: #323640;
		margin: 0;
	}

	.cookie-style-06 .cookie-notice-container #cn-buttons-container #cn-btn-settings::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/cog-light-white.svg);
		background-position: center;
		background-size: 14px;
		height: 14px;
		width: 14px;
		margin-right: 3px;
        vertical-align: middle;
	}

	.cookie-style-06 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
		padding: 13px 16px 12px 16px;
        background-color: #22C7A9 !important;
        color: #ffffff !important;
        border: unset;
        border-radius: 6px;
        box-shadow: 1px 5px 15px #000000;
	}


	/* cookie style 07 */

	.cookie-style-07 {
		justify-content: space-around !important;
		min-height: 120px;
		padding: 0 10%;
		background-color: rgba(255,255,255,0.3) !important;
		color: #ffffff !important;
	}

	.cookie-style-07::before {
		content: "";
		position: absolute;
		width : 100%;
		height: 100%;
		background: inherit;
		z-index: -1;
		filter: blur(10px);
		-moz-filter: blur(10px);
		-webkit-filter: blur(10px);
		-o-filter: blur(10px);
	}

	.cookie-style-07 .cookie-notice-container {
		display: flex;
		justify-content: space-around;
		align-items: center;
	}

	.cookie-style-07 .cookie-notice-container .cookie-style-03-text {
		margin-left: 3%;
		margin-right: 3%;
		text-align: left;
	}

	.cookie-style-07 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
        padding: 15px 30px;
        background-color: #ffffff !important;
        color: #000000 !important;
        border: unset;
        border-radius: 30px;
        box-shadow: 1px 5px 15px #000000;
        text-transform: uppercase;
	}

	.cookie-style-07 .cookie-notice-container #cn-buttons-container #cn-btn-settings::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/cog-solid-grey.svg);
		background-position: center;
		background-size: 15px;
		height: 15px;
		width: 15px;
		margin-right: 3px;
        vertical-align: middle;
	}

	.cookie-style-07 .cookie-notice-container #cn-buttons-container {
		display: flex;
	}

	.cn_cookie_icon_07 {
		width: 100px;
	}

	/* cookie style 08 */
	.cookie-style-08 {
		justify-content: left !important;
		height: 120px !important;
		padding: 0 10%;
		background-image: linear-gradient(263deg, #58AFFF , #297DFB) !important;
		color: #ffffff !important;
	}

	.cookie-style-08 .cookie-notice-container {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.cn_cookie_icon_08 {
		max-width: 120px;
		margin-right: 41px;
	}

	.cookie-style-08 .cookie-notice-container h3{
		margin-top: 0;
	}

	.cookie-style-08 .cookie-notice-container #cn-notice-text {
		text-align: left;
	}

	.cookie-style-08 .cookie-notice-container #cn-buttons-container {
		display: flex;
	}

	.cookie-style-08 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
		padding: 16px 30px;
		border: 2px solid #ffffff;
		border-image-slice: 20;
		border-radius: 6px;
		background-color: inherit !important;
		color: #ffffff !important;
	}

	.cookie-style-08 .cookie-notice-container #cn-buttons-container #cn-btn-settings::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/cog-light-white.svg);
		background-position: center;
        background-size: 15px;
        height: 15px;
        width: 15px;
		margin-right: 5px;
        vertical-align: middle;
	}

	/* cookie style 09 */
	.cookie-style-09 {
		justify-content: left !important;
		height: 120px !important;
		padding: 0 10%;
		background-color: #66B8F8 !important;
		color: #ffffff !important;
	}

	.cookie-style-09 .cookie-notice-container {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.cn_cookie_icon_09 {
		max-width: 100px;
		margin-right: 40px;
	}

	.cookie-style-09 .cookie-style-03-text {

	}

	.cookie-style-09 .cookie-notice-container h3 {
		margin-top: 0;
	}

	.cookie-style-09 .cookie-notice-container #cn-notice-text {
		text-align: center;
	}

	.cookie-style-09 .cookie-notice-container #cn-buttons-container {
		display: flex;
	}

	.cookie-style-09 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
		padding: 16px 30px;
		border: 2px solid #ffffff;
		border-radius: 36px;
		background-color: inherit !important;
		color: #ffffff !important;
	}

	.cookie-style-09 .cookie-notice-container #cn-buttons-container #cn-btn-settings::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/cog-solid-white.svg);
		background-position: center;
		background-size: 15px;
		height: 15px;
		width: 15px;
		margin-right: 3px;
	}

	/* cookie style 09 */
	.cookie-style-10 {
		justify-content: left !important;
		height: 100px !important;
		padding: 0 10%;
		background-color: #495CCB !important;
		color: #ffffff !important;
	}

	.cookie-style-10 .cookie-notice-container {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.cookie-style-10 .cookie-notice-container h3 {
		margin: 0;
		white-space: nowrap;
	}

	.cookie-style-10 .cookie-notice-container #cn-notice-text {
		text-align: left;
		margin: 0 5%;
	}

	.cookie-style-10 .cookie-notice-container #cn-buttons-container {
		display: flex;
	}

	.cookie-style-10 .cookie-notice-container #cn-buttons-container .button.wp-default {
		padding: 12px 38px;
		background-color: #ffffff;
		color: #495CCB !important;
		border: unset;
		border-radius: 36px;
	}

	.cookie-style-10 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
		padding: 11px 35px;
		border: 1px solid #ffffff;
		border-radius: 36px;
		background-color: inherit !important;
		color: #ffffff !important;
	}

	.cookie-style-10 .cookie-notice-container #cn-buttons-container #cn-btn-settings::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/cog-solid-white.svg);
		background-position: center;
		background-size: 11px;
		height: 11px;
		width: 11px;
		margin-right: 5px;
	}

	/* cookie style 11 */
	.cookie-style-11 {
		justify-content: left !important;
		height: 90px !important;
		padding: 0 10%;
		background-color: #22C7A9 !important;
		color: #ffffff !important;
	}

	.cookie-style-11 .cookie-notice-container {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.cn_cookie_icon_11 {
		width: 40px;
		margin-right: 30px;
	}

	.cookie-style-11 .cookie-notice-container h3 {
		margin: 0;
		white-space: nowrap;
		font-size: 14px;
		margin-right: 5px;
	}

	.cookie-style-11 .cookie-notice-container #cn-buttons-container {
		display: flex;
		margin-left: auto;
	}

	.cookie-style-11 .cookie-notice-container #cn-buttons-container .button.wp-default {
		padding: 11px 22px;
		color: #22C7A9 !important;
		border: unset;
		border-radius: 36px;
	}

	.cookie-style-11 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
		padding: 11px 17px;
		border: 2px solid #ffffff;
		border-radius: 36px;
		background-color: inherit !important;
		color: #ffffff !important;
	}

	.cookie-style-11 .cookie-notice-container #cn-buttons-container #cn-btn-settings::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/cog-solid-white.svg);
		background-position: center;
		background-size: 11px;
		height: 11px;
		width: 11px;
		margin-right: 5px;
	}

	/* cookie style 12 */

	.cookie-style-12 {
		justify-content: space-around !important;
		min-height: 90px;
		padding: 0 5%;
		background-color: #323640 !important;
		color: #FFFFFF !important;
	}

	.cookie-style-12 .cookie-notice-container {
		display: flex;
		align-items: center;
	}

	.cookie-style-12 .cookie-notice-container #cn-buttons-container {
		display: flex;
		margin-left: auto;
	}

	.cookie-style-12 .cookie-notice-container h3 {
		margin: 0;
		white-space: nowrap;
		margin-right: 3%;
	}

	.cookie-style-12 .cookie-notice-container #cn-buttons-container .button.wp-default {
		padding: 13px 16px 12px 16px;
		background-color: #2586FF !important;
		color: #ffffff !important;
		border: unset;
		border-radius: 6px;
		box-shadow: 1px 5px 15px #000000;
	}

	.cookie-style-12 .cookie-notice-container #cn-buttons-container #cn-accept-cookie::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/check-light-white.svg);
		background-position: center;
		background-size: 10px;
		height: 10px;
		width: 10px;
		margin-right: 5px;
	}

	.cookie-style-12 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
		padding: 13px 16px 12px 16px;
		background-color: #2586FF !important;
		color: #FFFFFF !important;
        border: unset;
        border-radius: 6px;
        box-shadow: 1px 5px 10px #000000;
	}

	.cookie-style-12 .cookie-notice-container #cn-buttons-container #cn-btn-settings::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/cog-solid-white.svg);
		background-position: center;
		background-size: 15px;
		height: 15px;
		width: 15px;
		margin-right: 5px;
        vertical-align: middle;
	}

	/* cookie style 13 */

	.cookie-style-13 {
		min-height: 130px;
		padding: 0 5%;
		background :#323640 url(<?php esc_url($image_path) ?>/public/images/cookie-icons/pattern-cookie2x.png) no-repeat center !important;
		background-position: center;
		color: #FFFFFF !important;
	}

	.cookie-style-13 .cookie-notice-container {
		display: flex;
		align-items: center;
	}

	.cookie-style-13 #cn-buttons-container {
		margin-left: auto;
		align-self: flex-end;
	}

	.cookie-style-13 .cookie-notice-container h3 {
		margin: 0;
		white-space: nowrap;
		margin-bottom: 3%;
	}

	.cookie-style-13 .cookie-notice-container #cn-buttons-container .button.wp-default {
		padding: 13px 16px 12px 16px;
		background-color: #22C7A9 !important;
		color: #ffffff !important;
		border-radius: 36px;
		border: unset;
		box-shadow: 1px 5px 15px #000000;
	}

	.cookie-style-13 .cookie-notice-container #cn-buttons-container #cn-accept-cookie::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/check-light-white.svg);
		background-position: center;
		background-size: 10px;
		height: 10px;
		width: 10px;
		margin-right: 5px;
	}

	.cookie-style-13 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
		padding: 13px 16px 12px 16px;
		border: 2px solid #ffffff;
		background-color: unset !important;
		color: #FFFFFF !important;
		border-radius: 36px;
		box-shadow: unset;
	}

	.cookie-style-13 .cookie-notice-container #cn-buttons-container #cn-btn-settings::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/cog-solid-white.svg);
		background-position: center;
		background-size: 11px;
		height: 11px;
		width: 11px;
		margin-right: 5px;
	}

	/* cookie view 14 */
	.cookie-style-14 {
		min-height: 330px;
		padding: 0 5%;
		background :#323640;
		color: #FFFFFF !important;
	}

	.cookie-style-14 .cookie-notice-container {
		display: block;
		align-items: center;
	}

	.cn_cookie_icon_14 {
		width: 40px;
		margin-right: 30px;
	}

	.cookie-style-14 #cn-buttons-container {
		display: flex;
		margin-top: 40px;
	}

	.cookie-style-14 #cn-notice-text {
		text-align: left;
	}

	.cookie-style-14 .cookie-notice-container h3 {
		margin: 0;
		white-space: nowrap;
		margin-bottom: 1%;
	}

	.cookie-style-14 .cookie-notice-container #cn-buttons-container .button.wp-default:first-of-type {
		margin-left: 0;
	}

	.cookie-style-14 .cookie-notice-container #cn-buttons-container .button.wp-default {
		padding: 18px 30px;
		background-color: #22C7A9 !important;
		color: #ffffff !important;
		border-radius: 6px;
		border: unset;
		box-shadow: 1px 5px 15px #585656;
	}

	.cookie-style-14 .cookie-notice-container #cn-buttons-container #cn-accept-cookie::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/check-light-white.svg);
		background-position: center;
		background-size: 10px;
		height: 10px;
		width: 10px;
		margin-right: 5px;
	}

	.cookie-style-14 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
		padding: 18px 30px;
		border: 1px solid #ffffff;
		background-color: unset !important;
		color: #FFFFFF !important;
		border-radius: 6px;
		box-shadow: 1px 5px 15px #585656;
	}

	.cookie-style-14 .cookie-notice-container #cn-buttons-container #cn-btn-settings::before {
		display: inline-block;
		content: ' ';
		background-image: url(<?php esc_url($image_path) ?>/public/images/cookie-icons/cog-light-white.svg);
		background-position: center;
		background-size: 11px;
		height: 11px;
		width: 11px;
		margin-right: 5px;
	}

	/*	Tablet for cookie views  */
	@media only screen and (min-width: 469px) and (max-width: 1025px) {
		/* cookie view 03 */

        /* cookie view 03 */
        .cookie-style-03 {
            height: 160px !important;
            padding: 0 10px;
        }

		.cookie-style-03 .cookie-notice-container {
			position: relative;

		}

		.cn_cookie_icon_03 {
			max-width: 90px;
			margin-right: 0;
			right: 0;
            float: left;
            vertical-align: middle;
		}

		.cookie-style-03 .cookie-notice-container #cn-buttons-container {
			justify-content: space-evenly;
		}

		/* cookie view 04 */
		.cookie-style-04 {
			height: auto !important;
		}

		.cookie-style-04 .cookie-notice-container {
			position: relative;
			display: block;
		}

		.cookie-style-04 .cookie-notice-container img{

		}

		.cookie-style-04 .cookie-notice-container #cn-buttons-container {
			display: block;
			margin: 15px 0;
		}

		/* cookie view 05 */
		.cookie-style-05 {
			height: auto !important;
		}

		.cookie-style-05 .cookie-notice-container {
			display: block;
		}

		.cn_cookie_icon_05 {

		}

		.cookie-style-05 .cookie-notice-container .cookie-style-03-text {
			margin-left: 0;
		}

		.cookie-style-05 .cookie-notice-container #cn-buttons-container {
			margin-top: 0px;
		}

		/* cookie view 06 */
		.cookie-style-06 {
			height: auto !important;
		}

		.cookie-style-06 .cookie-notice-container {
			display: block;
		}

		.cookie-style-06 .cookie-notice-container #cn-buttons-container {
			margin: 20px 0;
		}

		/* cookie view 07 */
		.cookie-style-07 {
			height: auto !important;
		}

		.cookie-style-07 .cookie-notice-container {
			display: block;
		}

		.cn_cookie_icon_07 {

		}

		.cookie-style-07 .cookie-notice-container .cookie-style-03-text {
			margin-left: 10px;
			margin-right: 10px;
		}

		.cookie-style-07 .cookie-notice-container .cookie-style-03-text h3 {
			margin-bottom: 0;
		}

		.cookie-style-07 .cookie-notice-container #cn-buttons-container {
			display: block;

		}

		.cookie-style-07 .cookie-style-03-text {
			align-items: center !important;
		}

		/* cookie view 08 */
		.cookie-style-08 {
			height: auto !important;
		}

		.cookie-style-08 .cookie-notice-container {
			display: block;
		}

		.cn_cookie_icon_08 {

		}

		.cookie-style-08 .cookie-notice-container #cn-buttons-container {
			display: block;
			margin: 20px 0;
		}

		/* cookie view 09 */
		.cookie-style-09 {
			height: auto !important;
		}

		.cookie-style-09 .cookie-notice-container {
			display: block;
		}

		.cn_cookie_icon_09 {

		}

		.cookie-style-09 .cookie-notice-container #cn-buttons-container {
			display: block;
			margin: 20px 0;
		}

		/* cookie view 10 */
		.cookie-style-10 {
			height: auto !important;
		}

		.cookie-style-10 .cookie-notice-container {
			display: block;
		}

		.cookie-style-10 .cookie-notice-container #cn-notice-text {
			text-align: left;
			margin: 0;
		}

		.cookie-style-10 .cookie-notice-container #cn-buttons-container {
			display: block;
			margin: 20px 0;
		}

		/* cookie view 11 */
		.cookie-style-11 {
			height: auto !important;
		}

		.cookie-style-11 .cookie-notice-container {
			display: block;
		}

		.cn_cookie_icon_11 {

		}

		.cookie-style-11 .cookie-notice-container h3 {
			margin-right: 0;
		}

		.cookie-style-11 .cookie-notice-container #cn-buttons-container {
			display: block;
			margin: 20px 0;
		}

			/* cookie view 12 */
			.cookie-style-12 {
				height: auto !important;
			}

			.cookie-style-12 .cookie-notice-container {
				display: block;
			}


			.cookie-style-12 .cookie-notice-container #cn-notice-text {
				text-align: center;
				margin: 0;
			}

			.cookie-style-12 .cookie-notice-container #cn-buttons-container {
				display: block;
				margin: 20px 0;
			}

			/* cookie view 13 */
			.cookie-style-13 .cookie-notice-container {
				display: block;
			}

			.cookie-style-13 .cookie-notice-container #cn-buttons-container {
				display: block;
				margin: 20px 0;
			}

			/* cookie view 14 */
			.cn_cookie_icon_14 {
				margin-right: 0;
			}

	}

	/*	Mobile for cookie views  */
	@media only screen and (max-width: 468px) {
		/* cookie view 01 */
		.cookie-style-01 {
			padding: 0;
		}

		.cookie-style-01 .cookie-notice-container #cn-buttons-container .button.wp-default {
			padding: 9px 15px;
		}

		.cookie-style-01 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
			padding: 7px 15px;
		}

		.cookie-style-01 .cookie-notice-container {
			text-align: center;
		}

		/* cookie view 02 */
		.cookie-style-02 {
			padding: 0;
		}

		.cookie-style-02 .cookie-notice-container #cn-buttons-container .button.wp-default {
			padding: 9px 15px;
		}

		.cookie-style-02 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
			padding: 7px 15px;
		}

		.cookie-style-02 .cookie-notice-container {
			text-align: center;
		}

		/* cookie view 03 */
		.cookie-style-03 {
			padding: 0;
            height: 150px !important;
		}

		.cookie-style-03 .cookie-notice-container #cn-buttons-container .button.wp-default {
			padding: 9px 15px;
		}

		.cookie-style-03 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
			padding: 7px 15px;
			border-image-slice: 1;
			border-radius: 0;
		}

		.cookie-style-03 .cookie-notice-container {
			display: flex;
		}

		.cn_cookie_icon_03 {
			max-width: 40px;
			margin-right: 0;
            float: left;
		}

		.cookie-style-03-text {
			align-items: center !important;

		}

		.cookie-style-03-text h3 {
			margin: 0;
		}

		.cookie-style-03 .cookie-notice-container #cn-notice-text {
			text-align: center;
            margin: 0;
		}

		.cookie-style-03 .cookie-notice-container #cn-buttons-container {
			display: block;
		}

		/* cookie view 04 */
		.cookie-style-04 {
			height: auto !important;
			padding: 0 0 0 0;
		}

		.cookie-style-04 .cookie-notice-container {
			display: block;
		}

		.cn_cookie_icon_04 {
			max-width: 75px;
			margin-bottom: 0;
		}

		.cookie-style-04 .cookie-notice-container #cn-notice-text {
			text-align: center;
		}

		.cookie-style-04 .cookie-notice-container #cn-buttons-container {
			display: block;
		}

		.cookie-style-04 .cookie-notice-container #cn-buttons-container .button.wp-default {
			padding: 9px 15px;
		}

		.cookie-style-04 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
			padding: 7px 15px;
		}

		/* cookie view 05 */
		.cookie-style-05 {
			height: auto !important;
			padding: 0 0 5% 0;
		}

		.cookie-style-05 .cookie-notice-container {
			display: block;
		}

		.cn_cookie_icon_05 {
			max-width: 75px;
			margin-bottom: 0;
		}

		.cookie-style-05 .cookie-notice-container .cookie-style-03-text {
			margin-left: 0;
		}

		.cookie-style-05 .cookie-notice-container #cn-buttons-container {
			margin-top: 10px;
		}

		.cookie-style-05 .cookie-notice-container #cn-buttons-container .button.wp-default {
			padding: 9px 15px;
		}

		.cookie-style-05 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
			padding: 9px 15px;
		}

		/* cookie view 06 */
		.cookie-style-06 {
			height: auto !important;
			padding: 0 0 0 0;
		}

		.cookie-style-06 .cookie-notice-container {
			display: block;
		}

		.cookie-style-06 .cookie-notice-container #cn-buttons-container {
			margin-top: 10px;
		}

		.cookie-style-06 .cookie-notice-container #cn-buttons-container .button.wp-default {
			padding: 9px 15px;
		}

		.cookie-style-06 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
			padding: 9px 15px;
		}

		/* cookie view 07 */
		.cookie-style-07 {
			padding: 0;
		}

		.cookie-style-07 .cookie-notice-container {
			display: block;
		}

		.cookie-style-07 .cookie-notice-container #cn-notice-text {
			text-align: center;
		}

		.cn_cookie_icon_07 {
			max-width: 75px;
			margin-bottom: 0;
		}

		.cookie-style-07 .cookie-notice-container #cn-buttons-container {
			display: block;
			margin-top: 10px;
		}

		.cookie-style-07 .cookie-notice-container #cn-buttons-container .button.wp-default {
			padding: 9px 15px;
		}

		.cookie-style-07 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
			padding: 9px 15px;
		}

		/* cookie view 08 */
		.cookie-style-08 {
			height: auto !important;
			padding: 0;
		}

		.cookie-style-08 .cookie-notice-container {
			display: block;
		}

		.cn_cookie_icon_08 {
			max-width: 75px;
			margin-bottom: 0;
			margin-right: 0;
		}

		.cookie-style-08 .cookie-notice-container #cn-notice-text {
			text-align: center;
		}

		.cookie-style-08 .cookie-notice-container #cn-buttons-container {
			display: block;
			margin-top: 10px;
		}

		.cookie-style-08 .cookie-notice-container #cn-buttons-container .button.wp-default {
			padding: 9px 15px;
		}

		.cookie-style-08 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
			padding: 7px 15px;
		}

		/* cookie view 09 */
		.cookie-style-09 {
			height: auto !important;
			padding: 0;
		}

		.cookie-style-09 .cookie-notice-container {
			display: block;
		}

		.cn_cookie_icon_09 {
			max-width: 75px;
			margin-bottom: 0;
			margin-right: 0;
		}

		.cookie-style-09 .cookie-notice-container #cn-notice-text {
			text-align: center;
		}

		.cookie-style-09 .cookie-notice-container #cn-buttons-container {
			display: block;
			margin-top: 10px;
		}

		.cookie-style-09 .cookie-notice-container #cn-buttons-container .button.wp-default {
			padding: 9px 15px;
		}

		.cookie-style-09 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
			padding: 7px 15px;
		}

		/* cookie view 10 */
		.cookie-style-10 {
			height: auto !important;
			padding: 0;
		}

		.cookie-style-10 .cookie-notice-container {
			display: block;
		}

		.cookie-style-10 .cookie-notice-container #cn-buttons-container {
			display: block;
			margin-top: 10px;
		}

		.cookie-style-10 .cookie-notice-container #cn-buttons-container .button.wp-default {
			padding: 9px 15px;
		}

		.cookie-style-10 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
			padding: 7px 15px;
		}

		/* cookie view 11 */
		.cookie-style-11 {
			height: auto !important;
			padding: 0;
		}

		.cookie-style-11 .cookie-notice-container {
			display: block;
		}

		.cookie-style-11 .cookie-notice-container #cn-buttons-container {
			display: block;
			margin-top: 10px;
		}

		.cn_cookie_icon_11 {
			margin-right: 0;
		}

		.cookie-style-11 .cookie-notice-container #cn-buttons-container .button.wp-default {
			padding: 9px 15px;
		}

		.cookie-style-11 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
			padding: 7px 15px;
		}

		/* cookie view 12 */
		.cookie-style-12 {
			height: auto !important;
			padding: 0;
		}

		.cookie-style-12 .cookie-notice-container {
			display: block;
		}

        .cookie-style-12 .cookie-notice-container #cn-notice-text {
            text-align: left;
            margin: 0;
        }
		.cookie-style-12 .cookie-notice-container #cn-buttons-container {
			display: block;
			margin-top: 10px;
			margin-bottom: 10px;
		}

		/* cookie view 13 */
		.cookie-style-13 {
			height: auto !important;
			padding: 0;
		}

		.cookie-style-13 .cookie-notice-container {
			display: block;
		}

		.cookie-style-13 .cookie-notice-container #cn-buttons-container {
			display: block;
			margin-top: 10px;
		}

		.cookie-style-13 .cookie-notice-container #cn-buttons-container .button.wp-default {
			padding: 9px 15px;
		}

		.cookie-style-13 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
			padding: 7px 15px;
		}

		/* cookie view 14 */
		.cookie-style-14 {
			height: auto !important;
			padding: 0;
			min-height: unset;
		}

		.cn_cookie_icon_14 {
			margin-right: 0;
		}

		.cookie-style-14 #cn-notice-text {
			text-align: center;
		}

		.cookie-style-14 #cn-buttons-container {
			display: block;
		}

		.cookie-style-14 .cookie-notice-container #cn-buttons-container .button.wp-default {
			padding: 9px 15px;
		}

		.cookie-style-14 .cookie-notice-container #cn-buttons-container #cn-btn-settings {
			padding: 8px 15px;
		}

	}
</style>