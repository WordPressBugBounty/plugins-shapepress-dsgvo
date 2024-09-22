<?php
$isPremium = isValidPremiumEdition();
$isBlog = isValidBlogEdition();
$hasValidLicense = isValidPremiumEdition() || isValidBlogEdition();

?>

<div class="card-columns">

    <!-- sar general -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Common Settings', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
                <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOAdminSubjectAccessRequestAction::getActionName()); ?>">
                <input type="hidden" name="subform" value="common-settings" />
                <?php wp_nonce_field(esc_attr(SPDSGVOAdminSubjectAccessRequestAction::getActionName()) . '-nonce'); ?>

                <div class="form-group">
                    <label for="sar_cron"><?php _e('Automatic processing', 'shapepress-dsgvo') ?></label>
                    <?php $sarCron = SPDSGVOSettings::get('sar_cron'); ?>
                    <select class="form-control" name="sar_cron" id="sar_cron">
                            <option value="0" <?php echo esc_attr(selected($sarCron === '0')) ?>><?php _e('none', 'shapepress-dsgvo') ?></option>
                            <option value="1" <?php echo esc_attr(selected($sarCron === '1')) ?>>
                                1 <?php _e('day', 'shapepress-dsgvo') ?></option>
                            <option value="2" <?php echo esc_attr(selected($sarCron === '2')) ?>>
                                2 <?php _e('days', 'shapepress-dsgvo') ?></option>
                            <option value="3" <?php echo esc_attr(selected($sarCron === '3')) ?>>
                                3 <?php _e('days', 'shapepress-dsgvo') ?></option>
                            <option value="7" <?php echo esc_attr(selected($sarCron === '4')) ?>>
                                1 <?php _e('weeks', 'shapepress-dsgvo') ?></option>
                        </select>

                    <small class="form-text text-muted"><?php _e('Requests will be automatically processed after the set time and sent to the user.', 'shapepress-dsgvo') ?></small>
                </div>

                <?php
                spDsgvoWriteInput('textarea', '', 'sar_dsgvo_accepted_text', SPDSGVOSettings::get('sar_dsgvo_accepted_text'),
                    __('GDPR consent text', 'shapepress-dsgvo'),
                    '',
                    __('The text which gets displayed during a SAR request.', 'shapepress-dsgvo'));
                ?>

                <div class="form-group">
                    <?php $sarPage = SPDSGVOSettings::get('sar_page'); ?>
                    <label for="sar_page"><?php _e('SAR request page', 'shapepress-dsgvo') ?></label>
                    <select class="form-control" name="sar_page" id="sar_page">
                        <option value="0"><?php _e('Select', 'shapepress-dsgvo'); ?></option>
                        <?php foreach (get_pages(array('number' => 0)) as $key => $page): ?>
                            <option <?php echo esc_attr(selected($sarPage == $page->ID)) ?> value="<?php echo esc_attr($page->ID); ?>">
                                <?php echo esc_html($page->post_title); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-text text-muted"><?php _e('Specifies the page on which users have the option to request their data extract.', 'shapepress-dsgvo') ?></small>


                </div>
                <div class="form-group">
                    <?php if ($sarPage == '0'): ?>
                        <small><?php _e('Create a page that uses the shortcode <code>[sar_form]</code>.', 'shapepress-dsgvo') ?>
                            <a class="btn btn-secondary btn-block"
                               href="<?php echo esc_url(SPDSGVOCreatePageAction::url(array('sar' => '1'))); ?>"><?php _e('Create page', 'shapepress-dsgvo') ?></a>
                        </small>
                    <?php elseif (!pageContainsString($sarPage, 'sar_form')): ?>
                        <small><?php _e('Attention: The shortcode <code>[sar_form]</code> was not found on the page you selected.', 'shapepress-dsgvo') ?>
                            <a class="btn btn-secondary btn-block"
                               href="<?php echo esc_url(get_edit_post_link($sarPage)); ?>"><?php _e('Edit page', 'shapepress-dsgvo') ?></a>
                        </small>
                    <?php else: ?>
                        <a class="btn btn-secondary btn-block"
                           href="<?php echo esc_url(get_edit_post_link($sarPage)); ?>"><?php _e('Edit page', 'shapepress-dsgvo') ?></a>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>

            </form>
        </div>
    </div>

    <!-- notifaction settings -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Email settings', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
                <input type="hidden" name="action"
                       value="<?php echo esc_attr(SPDSGVOAdminSubjectAccessRequestAction::getActionName()); ?>">
                <input type="hidden" name="subform" value="notification-settings" />
                <?php wp_nonce_field(esc_attr(SPDSGVOAdminSubjectAccessRequestAction::getActionName()) . '-nonce'); ?>

                <div class="position-relative">
                    <?php spDsgvoWritePremiumOverlayIfInvalid($hasValidLicense); ?>

                    <?php
                    spDsgvoWriteInput('switch', '', 'sar_email_notification', SPDSGVOSettings::get('sar_email_notification'),
                        __('Email for new application', 'shapepress-dsgvo'),
                        '',
                        __('If enabled a notification by email gets send to the email of the admin.', 'shapepress-dsgvo'));
                    ?>

                    <small class="form-text text-muted mb-1"><?php _e('Following you can configure the title and the content of the email which will be sent to the request, including his data. If you leave this field empty, the defaults will be used.', 'shapepress-dsgvo')?></small>
                    <?php


                    $title = !empty(SPDSGVOSettings::get('sar_email_title')) ? SPDSGVOSettings::get('sar_email_title') : __('Your data extraction request', 'shapepress-dsgvo');
                    $content = !empty(SPDSGVOSettings::get('sar_email_content')) ? SPDSGVOSettings::get('sar_email_content') : '';
                    ?>

                    <?php
                    spDsgvoWriteInput('text', '', 'sar_email_title', $title,
                        __('Title of the email', 'shapepress-dsgvo'),
                        '',
                        '');
                    ?>



                    <div class="form-group">
                        <label><?php _e('Content of the email', 'shapepress-dsgvo')?></label>
                        <?php wp_editor($content, 'sar_email_content',
                            array('textarea_rows' => '10', 'drag_drop_upload' => 'false', 'teeny' => true, 'media_buttons' => false)); ?>
                        <small class="form-text text-muted"><?php _e('Specify the email body. Use {{breakdown}} for data summary, {{count}} for amount of data, {{zip_link}} for URL to the data download.','shapepress-dsgvo');?></small>
                    </div>

                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card col-12">
    <div class="card-header">
        <h4 class="card-title"><?php _e('Subject Access Requests', 'shapepress-dsgvo') ?></h4>
        <small class="card-subtitle text-muted"><?php _e('This feature allows users to request a digest of all data stored by you. <br> All data in your database is checked for confidential data and sent to the User by email.', 'shapepress-dsgvo') ?></small>
    </div>
    <div class="card-body">
        <?php $pending = SPDSGVOSubjectAccessRequest::finder('pending'); ?>
        <table class="table table-hover table-striped " cellspacing="0">
            <thead>
            <tr>
                <th id="request_id" class="manage-column column-request_id"
                    scope="col" style="width: 10%"><?php _e('ID', 'shapepress-dsgvo') ?></th>
                <th id="email" class="manage-column column-email" scope="col"
                    style="width: 20%"><?php _e('Email', 'shapepress-dsgvo') ?></th>
                <th id="first_name" class="manage-column column-first_name"
                    scope="col" style="width: 15%"><?php _e('First name', 'shapepress-dsgvo') ?></th>
                <th id="last_name" class="manage-column column-last_name" scope="col"
                    style="width: 15%"><?php _e('Last name', 'shapepress-dsgvo') ?></th>
                <th id="dsgvo_accepted" class="manage-column column-dsgvo_accepted" scope="col"
                    style="width: 15%"><?php _e('GDPR approval', 'shapepress-dsgvo') ?></th>
                <th id="process" class="manage-column column-process" scope="col"
                    style="width: 15%"><?php _e('Run', 'shapepress-dsgvo') ?></th>
                <!-- i592995 -->
                <th id="dismiss" class="manage-column column-dismiss" scope="col"
                    style="width: 15%"><?php _e('Dismiss', 'shapepress-dsgvo') ?></th>
                <!-- i592995 -->
            </tr>
            </thead>

            <tbody>
            <?php if (count($pending) !== 0): ?>
                <?php foreach ($pending as $key => $pendingRequest): ?>

                    <tr class="<?php echo esc_attr(($key % 2 == 0) ? 'alternate' : ''); ?>">
                        <td class="column-request-id">
                            <?php echo esc_html($pendingRequest->ID); ?>
                        </td>
                        <td class="column-email"><strong><?php echo esc_html($pendingRequest->email); ?></strong>
                        </td>
                        <td class="column-integrations">
                            <?php echo esc_html($pendingRequest->first_name); ?>
                        </td>
                        <td class="column-auto-deleting-on">
                            <?php echo esc_html($pendingRequest->last_name); ?>
                        </td>
                        <td class="column-auto-deleting-on">
                            <?php echo esc_html($pendingRequest->dsgvo_accepted === '1' ? __('Yes', 'shapepress-dsgvo') : __('No', 'shapepress-dsgvo')); ?>
                        </td>
                        <td class="column-unsubscribe-user"><a class="btn btn-outline-primary"
                                                               href="<?php echo wp_nonce_url(SPDSGVOAdminSubjectAccessRequestAction::url(array('process' => $pendingRequest->ID)),
                                                                   SPDSGVOAdminSubjectAccessRequestAction::getActionName() . '-nonce') ?>"><?php _e('Run', 'shapepress-dsgvo'); ?></a>
                        </td>
                        <!-- i592995 -->
                        <td class="column-dismiss">
                            <svg class="unsubscribe-dismiss" width="10" height="10"
                                 data-id="<?php echo esc_attr($pendingRequest->ID); ?>" data-nonce="<?php echo wp_create_nonce(SPDSGVODismissUnsubscribeAction::getActionName() . '-nonce'); ?>">
                                <line x1="0" y1="0" x2="10" y2="10"/>
                                <line x1="0" y1="10" x2="10" y2="0"/>
                            </svg>
                        </td>
                        <!-- i592995 -->
                    </tr>

                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td class="column-slug" colspan="5"><?php _e('No open requests', 'shapepress-dsgvo') ?></td>
                    <td class="column-default"></td>
                    <td class="column-reason"></td>
                </tr>
            <?php endif; ?>
            </tbody>

            <tfoot>
            <tr>
                <th class="manage-column column-request_id" scope="col"><?php _e('ID', 'shapepress-dsgvo') ?></th>
                <th class="manage-column column-email" scope="col"><?php _e('Email', 'shapepress-dsgvo') ?></th>
                <th class="manage-column column-first_name" scope="col"><?php _e('First name', 'shapepress-dsgvo') ?></th>
                <th class="manage-column column-last_name" scope="col"><?php _e('Last name', 'shapepress-dsgvo') ?></th>
                <th class="manage-column column-dsgvo_accepted"
                    scope="col"><?php _e('GDPR approval', 'shapepress-dsgvo') ?></th>
                <th class="manage-column column-process" scope="col"><?php _e('Run', 'shapepress-dsgvo') ?></th>
                <!-- i592995 -->
                <th class="manage-column column-dismiss" scope="col"><?php _e('Dismiss', 'shapepress-dsgvo') ?></th>
                <!-- i592995 -->
            </tr>
            </tfoot>
        </table>

        <?php if (count($pending) !== 0): ?>
            <p>
                <a class="button-primary"
                   href="<?php echo wp_nonce_url(SPDSGVOAdminSubjectAccessRequestAction::url(array('all' => '1')),
                       SPDSGVOAdminSubjectAccessRequestAction::getActionName() . '-nonce') ?>"><?php _e('Run all', 'shapepress-dsgvo') ?></a>
            </p>
        <?php endif; ?>
    </div>
</div>

<div class="card-columns">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Add entry', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
                <input type="hidden" name="action"
                       value="<?php echo esc_attr(SPDSGVOSubjectAccessRequestAction::getActionName()); ?>"> <input
                        type="hidden" name="is_admin" value="1"> <br>
                <?php wp_nonce_field(esc_attr(SPDSGVOSubjectAccessRequestAction::getActionName()) . '-nonce'); ?>

                <?php
                spDsgvoWriteInput('text', '', 'email', '',
                    __('Email', 'shapepress-dsgvo'),
                    '',
                    '');
                ?>

                <?php
                spDsgvoWriteInput('text', '', 'first_name', '',
                    __('First name', 'shapepress-dsgvo'),
                    '',
                    '');
                ?>

                <?php
                spDsgvoWriteInput('text', '', 'last_name', '',
                    __('Last name', 'shapepress-dsgvo'),
                    '',
                    '');
                ?>

                <?php
                spDsgvoWriteInput('switch', '', 'dsgvo_checkbox', '',
                    __('GDPR confirmation', 'shapepress-dsgvo'),
                    '',
                    '');
                ?>

                <?php
                spDsgvoWriteInput('switch', '', 'process_now', '',
                    __('Run now', 'shapepress-dsgvo'),
                    '',
                    '');
                ?>
                <?php
                spDsgvoWriteInput('switch', '', 'display_email', '',
                    __('Show email', 'shapepress-dsgvo'),
                    '',
                    '');
                ?>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php echo esc_attr_e('Add entry', 'shapepress-dsgvo');?>">
                </div>
            </form>
        </div>
    </div>
</div>
