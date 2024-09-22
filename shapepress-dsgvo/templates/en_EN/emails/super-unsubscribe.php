<tbody>
	<tr>
		<td align="center" valign="top"><table border="0" cellpadding="0"
				cellspacing="0" width="600" id="template_container"
				style="box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1) !important; background-color: #fdfdfd; border: 1px solid #dcdcdc; border-radius: 3px !important;">
				<tbody>
					<tr>
						<td align="center" valign="top">
							<!-- Header -->
							<table border="0" cellpadding="0" cellspacing="0" width="600"
								id="template_header"
								style="background-color: #ccc; border-radius: 3px 3px 0 0 !important; color: #202020; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: &amp; quot;Helvetica Neue&amp;quot;, Helvetica, Roboto, Arial, sans-serif;">
								<tbody>
									<tr>
										<td id="header_wrapper"
											style="padding: 36px 48px; display: block;">
											<h1
												style="color: #202020; font-family: &amp; quot; Helvetica Neue&amp;quot; , Helvetica , Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #202020;">
												<a target='_blank' href="[CLIENTS.WEBSITE]"
													style='color: #202020'>{{website}}</a><br> <?php echo esc_html(isset($title) ? $title : __('Delete request','shapepress-dsgvo')); ?>
											</h1>
										</td>
									</tr>
								</tbody>
							</table> <!-- End Header -->
						</td>
					</tr>
					<tr>
						<td align="center" valign="top">
							<!-- Body -->
							<table border="0" cellpadding="0" cellspacing="0" width="600"
								id="template_body">
								<tbody>
									<tr>
										<td valign="top" id="body_content"
											style="background-color: #fdfdfd;">
											<!-- Content -->
											<table border="0" cellpadding="20" cellspacing="0"
												width="100%">
												<tbody>
													<tr>
														<td valign="top" style="padding: 48px 48px 0;">
															<div id="body_content_inner"
																style="color: #4d4c53; font-family: &amp; quot; Helvetica Neue&amp;quot; , Helvetica , Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: left;">

                                                                <?php if( !empty( $content ) ) : echo esc_html($content); else : ?>
																<p style="margin: 0 0 16px;"><?php _e('We have received your delete request.', 'shapepress-dsgvo'); ?></p>
																<p style="margin: 0 0 16px;"><?php _e('If you confirm the following link, all your data stored at
																	{{website}} gets deleted.', 'shapepress-dsgvo'); ?></p>
																<h2
																	style="color: #202020; display: block; font-family: &amp; quot; Helvetica Neue&amp;quot; , Helvetica , Roboto, Arial, sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 0 0 18px; text-align: center;">
																	<a style="color: #ffc600" target='_blank'
																		href="{{confirm_link}}"><?php _e('Confirm Delete', 'shapepress-dsgvo'); ?></a>
																</h2>
																<p style="margin: 0 0 16px;"><?php _e("If you don't want do delete your data just ignore this email.", 'shapepress-dsgvo'); ?></p>
                                                                <?php endif; ?>
															</div>
														</td>
													</tr>
												</tbody>
											</table> <!-- End Content -->
										</td>
									</tr>
								</tbody>
							</table> <!-- End Body -->
						</td>
					</tr>
					<tr>
						<td align="center" valign="top">
							<!-- Footer -->
							<table border="0" cellpadding="10" cellspacing="0" width="600"
								id="template_footer">
								<tbody>
									<tr>
										<td valign="top"
											style="padding: 0; -webkit-border-radius: 6px;">
											<table border="0" cellpadding="10" cellspacing="0"
												width="100%">
												<tbody>
													<tr>
														<td colspan="2" valign="middle" id="credit"
															style="padding: 0 48px 48px 48px; -webkit-border-radius: 6px; border: 0; color: #ffdd66; font-family: Arial; font-size: 12px; line-height: 125%; text-align: center;">
															<div class="wgm-wrap-email-appendixes"
																style="text-align: left; color: #737373; font-size: 14px; line-height: 150%;">
																<div style="float: left; width: 100%;">
																	<h3
																		style="color: #202020; display: block; font-family: &amp; quot; Helvetica Neue&amp;quot; , Helvetica , Roboto, Arial, sans-serif; font-size: 14px; font-weight: bold; line-height: 130%; margin: 16px 0 8px; text-align: center;"><?php _e('Sent from', 'shapepress-dsgvo'); ?> {{home_url}}</h3>
																</div>
																<div style="float: left; width: 100%;">
																	<h3
																		style="color: #202020; display: block; font-family: &amp; quot; Helvetica Neue&amp;quot; , Helvetica , Roboto, Arial, sans-serif; font-size: 14px; font-weight: bold; line-height: 130%; margin: 16px 0 8px; text-align: center;"><?php _e('Contact', 'shapepress-dsgvo'); ?>
																		{{admin_email}}</h3>

																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
							</table> <!-- End Footer -->
						</td>
					</tr>
				</tbody>
			</table></td>
	</tr>
</tbody>
