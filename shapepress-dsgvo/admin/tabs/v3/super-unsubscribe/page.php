<?php
$isPremium = isValidPremiumEdition();
$isBlog = isValidBlogEdition();
$hasValidLicense = isValidPremiumEdition() || isValidBlogEdition();

?>

<div class="card-columns">

    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Common Settings', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
                <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOSuperUnsubscribeAction::getActionName()); ?>"> <input
                        type="hidden" name="CSRF" value="<?php echo esc_attr(sp_dsgvo_CSRF_TOKEN()) ?>">
                <input type="hidden" name="subform" value="common-settings" />
                <?php wp_nonce_field(esc_attr(SPDSGVOSuperUnsubscribeAction::getActionName()) . '-nonce'); ?>

                <?php
                spDsgvoWriteInput('switch', '', 'unsubscribe_auto_delete', SPDSGVOSettings::get('unsubscribe_auto_delete'),
                    __('Automatic processing on request', 'shapepress-dsgvo'),
                    '',
                    __('If enabled, delete requests are performed immediately.', 'shapepress-dsgvo'));
                ?>

                <div class="form-group">
                    <label for="sar_cron"><?php _e('After period', 'shapepress-dsgvo') ?></label>
                    <?php $suAutoDelTime = SPDSGVOSettings::get('su_auto_del_time'); ?>
                    <select class="form-control" name="su_auto_del_time"  id="su_auto_del_time">
                        <option value="0" <?php echo esc_attr(selected($suAutoDelTime === '0')) ?>><?php _e('none', 'shapepress-dsgvo') ?></option>
                        <option value="1m" <?php echo esc_attr(selected($suAutoDelTime === '1m')) ?>>
                            1 <?php _e('month', 'shapepress-dsgvo') ?></option>
                        <option value="3m" <?php echo esc_attr(selected($suAutoDelTime === '3m')) ?>>
                            3 <?php _e('months', 'shapepress-dsgvo') ?></option>
                        <option value="6m" <?php echo esc_attr(selected($suAutoDelTime === '6m')) ?>>
                            6 <?php _e('months', 'shapepress-dsgvo') ?></option>
                        <option value="1y" <?php echo esc_attr(selected($suAutoDelTime === '1y')) ?>>
                            1 <?php _e('year', 'shapepress-dsgvo') ?></option>
                        <option value="6y" <?php echo esc_attr(selected($suAutoDelTime === '6y')) ?>>
                            6 <?php _e('years', 'shapepress-dsgvo') ?></option>
                        <option value="7y" <?php echo esc_attr(selected($suAutoDelTime === '7y')) ?>>
                            7 <?php _e('years', 'shapepress-dsgvo') ?></option>
                    </select>

                    <small class="form-text text-muted"><?php _e('Data is automatically deleted after the set time. Ensures the maximum retention time.', 'shapepress-dsgvo') ?></small>
                </div>

                <?php
                spDsgvoWriteInput('textarea', '', 'su_dsgvo_accepted_text', SPDSGVOSettings::get('su_dsgvo_accepted_text'),
                    __('Text on new application', 'shapepress-dsgvo'),
                    '',
                    __('The text which gets displayed during a delete request.', 'shapepress-dsgvo'));
                ?>

                <div class="form-group">
                    <?php $suPage = SPDSGVOSettings::get('super_unsubscribe_page');
                    if (isset($suPage) == false) $suPage = 0;
                    ?>
                    <label for="super_unsubscribe_page"><?php _e('Delete request page', 'shapepress-dsgvo') ?></label>
                    <select class="form-control" name="super_unsubscribe_page" id="super_unsubscribe_page">
                        <option value="0"><?php _e('Select', 'shapepress-dsgvo'); ?></option>
                        <?php foreach (get_pages(array('number' => 0)) as $key => $page): ?>
                            <option <?php echo esc_attr(selected($suPage == $page->ID)) ?> value="<?php echo esc_attr($page->ID); ?>">
                                <?php echo esc_html($page->post_title); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-text text-muted"><?php _e('Specifies the page on which users have the option to delete their data.', 'shapepress-dsgvo') ?></small>
                </div>
                <div class="form-group">
                    <?php if ($suPage == '0'): ?>
                        <small><?php _e('Create a page that uses the shortcode <code>[unsubscribe_form]</code>.', 'shapepress-dsgvo') ?>
                            <a class="btn btn-secondary btn-block"
                               href="<?php echo esc_url(SPDSGVOCreatePageAction::url(array('super_unsubscribe_page' => '1'))) ?>"><?php _e('Create page', 'shapepress-dsgvo') ?></a>
                        </small>
                    <?php elseif (!pageContainsString($suPage, 'unsubscribe_form')): ?>
                        <small><?php _e('Attention: The shortcode <code>[unsubscribe_form]</code> that should be on the selected page was not found. Thus, the user has no opportunity to ask a deletion request.', 'shapepress-dsgvo') ?>
                            <a class="btn btn-secondary btn-block"
                               href="<?php echo esc_url(get_edit_post_link($suPage)) ?>"><?php _e('Edit page', 'shapepress-dsgvo') ?></a>
                        </small>
                    <?php else: ?>
                        <a class="btn btn-secondary btn-block"
                           href="<?php echo esc_url(get_edit_post_link($suPage)) ?>"><?php _e('Edit page', 'shapepress-dsgvo') ?></a>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>

            </form>

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Integrations', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
                <input type="hidden" name="action"
                       value="<?php echo esc_attr(SPDSGVOSuperUnsubscribeAction::getActionName()); ?>">
                <input type="hidden" name="subform" value="integration-settings" />
                <?php wp_nonce_field(esc_attr(SPDSGVOSuperUnsubscribeAction::getActionName()) . '-nonce'); ?>

                <div class="position-relative">
                <?php spDsgvoWritePremiumOverlayIfInvalid($hasValidLicense); ?>

                <div class="form-group">
                    <label for="su_woo_data_action"><?php _e('WooCommerce Data', 'shapepress-dsgvo') ?></label>
                        <?php $wooDataAction = SPDSGVOSettings::get('su_woo_data_action'); ?>
                        <select class="form-control" name="su_woo_data_action" id="su_woo_data_action">
                            <option value="ignore" <?php echo esc_attr(selected($wooDataAction === 'ignore')) ?>><?php _e('No action', 'shapepress-dsgvo') ?></option>
                            <option value="pseudo" <?php echo esc_attr(selected($wooDataAction === 'pseudo')) ?>><?php _e('Pseudonymise', 'shapepress-dsgvo') ?></option>
                            <option value="del" <?php echo esc_attr(selected($wooDataAction === 'del')) ?>><?php _e('Delete', 'shapepress-dsgvo') ?></option>
                        </select>
                    <small class="form-text text-muted"><?php _e('Specifies what should happen to personal data of orders.', 'shapepress-dsgvo') ?></small>
                </div>

                <div class="form-group">
                    <label for="su_bbpress_data_action"><?php _e('bbPress Data', 'shapepress-dsgvo') ?></label>
                    <?php $bbPDataAction = SPDSGVOSettings::get('su_bbpress_data_action'); ?>
                    <select class="form-control" name="su_bbpress_data_action" id="su_bbpress_data_action">
                        <option value="ignore" <?php echo esc_attr(selected($bbPDataAction === 'ignore')) ?>><?php _e('No action', 'shapepress-dsgvo') ?></option>
                        <option value="pseudo" <?php echo esc_attr(selected($bbPDataAction === 'pseudo')) ?>><?php _e('Pseudonymise', 'shapepress-dsgvo') ?></option>
                        <option value="del" <?php echo esc_attr(selected($bbPDataAction === 'del')) ?>><?php _e('Delete', 'shapepress-dsgvo') ?></option>
                    </select>
                    <small class="form-text text-muted"><?php _e('Specifies what should happen with forum entries.', 'shapepress-dsgvo') ?></small>
                </div>

                <div class="form-group">
                    <label for="su_buddypress_data_action"><?php _e('buddyPress Data', 'shapepress-dsgvo') ?></label>
                    <?php $buddyPressDataAction = SPDSGVOSettings::get('su_buddypress_data_action'); ?>
                    <select class="form-control" name="su_buddypress_data_action" id="su_buddypress_data_action">
                        <option value="ignore" <?php echo esc_attr(selected($buddyPressDataAction === 'ignore')) ?>><?php _e('No action', 'shapepress-dsgvo') ?></option>
                        <option value="pseudo" <?php echo esc_attr(selected($buddyPressDataAction === 'pseudo')) ?>><?php _e('Pseudonymise', 'shapepress-dsgvo') ?></option>
                        <option value="del" <?php echo esc_attr(selected($buddyPressDataAction === 'del')) ?>><?php _e('Delete', 'shapepress-dsgvo') ?></option>
                    </select>
                    <small class="form-text text-muted"><?php _e('Specifies what should happen with forum entries.', 'shapepress-dsgvo') ?></small>
                </div>

                <div class="form-group">
                    <label for="su_cf7_data_action"><?php _e('CF7/Flamingo Data', 'shapepress-dsgvo') ?></label>
                    <?php $cf7DataAction = SPDSGVOSettings::get('su_cf7_data_action'); ?>
                    <select class="form-control" name="su_cf7_data_action" id="su_cf7_data_action">
                        <option value="ignore" <?php echo esc_attr(selected($cf7DataAction === 'ignore')) ?>><?php _e('No action', 'shapepress-dsgvo') ?></option>
                        <option value="pseudo" <?php echo esc_attr(selected($cf7DataAction === 'pseudo')) ?>><?php _e('Pseudonymise', 'shapepress-dsgvo') ?></option>
                        <option value="del" <?php echo esc_attr(selected($cf7DataAction === 'del')) ?>><?php _e('Delete', 'shapepress-dsgvo') ?></option>
                    </select>
                    <small class="form-text text-muted"><?php _e('Specifies what to do with contact entries and messages.', 'shapepress-dsgvo') ?></small>
                </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                    </div>
            </div>

            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Notification settings', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
                <input type="hidden" name="action"
                       value="<?php echo esc_attr(SPDSGVOSuperUnsubscribeAction::getActionName()); ?>">
                <input type="hidden" name="subform" value="notification-settings" />
                <?php wp_nonce_field(esc_attr(SPDSGVOSuperUnsubscribeAction::getActionName()) . '-nonce'); ?>

                <div class="position-relative">
                    <?php spDsgvoWritePremiumOverlayIfInvalid($hasValidLicense); ?>

                    <?php
                    spDsgvoWriteInput('switch', '', 'su_email_notification', SPDSGVOSettings::get('su_email_notification'),
                        __('Email for new application', 'shapepress-dsgvo'),
                        '',
                        __('If enabled a notification by email gets send to the email of the admin.', 'shapepress-dsgvo'));
                    ?>

                    <?php

                    wp_enqueue_editor();

                    $title = !empty(SPDSGVOSettings::get('su_email_title')) ? SPDSGVOSettings::get('su_email_title') : __('Confirmation of delete request', 'shapepress-dsgvo');
                    $content = !empty(SPDSGVOSettings::get('su_email_content')) ? SPDSGVOSettings::get('su_email_content') : '';
                    ?>

                    <?php
                    spDsgvoWriteInput('text', '', 'su_email_title', $title,
                        __('Title of the email', 'shapepress-dsgvo'),
                        '',
                        '');
                    ?>

                    <?php
                    spDsgvoWriteInput('textarea', '', 'su_email_content', $content,
                        __('Content of the email', 'shapepress-dsgvo'),
                        '',
                        __('Specify the delete request email body. Use {{confirm_link}} for confirmation URL. If you leave this field empty, the defaults will be used.','shapepress-dsgvo'));
                    ?>

                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$statuses = array(
    'pending',
    'done'
);
if (isset($_GET['status']) && in_array($_GET['status'], $statuses)) {
    $status = sanitize_text_field($_GET['status']);
} else {
    $status = 'pending';
}
?>

<div class="card col-12">
    <div class="card-header">
        <h4 class="card-title"><?php _e('Delete Requests', 'shapepress-dsgvo') ?></h4>
        <small class="card-subtitle text-muted"><?php _e('Here you will find all deletion requests that users have made on their site. With a click on "delete now " you delete all stored data of the user on their side including Plugins.', 'shapepress-dsgvo') ?></small>
    </div>
    <div class="card-body">
        <?php $confirmed = SPDSGVOUnsubscriber::finder('status', array('status' => $status)); ?>
        <ul class="subsubsub">
            <li>
                <a
                        href="<?php echo esc_url(SPDSGVO::adminURL(array('tab' => 'super-unsubscribe', 'status' => 'pending'))) ?>"
                        class="<?php echo esc_attr(($status === 'pending') ? 'current' : ''); ?>" aria-current="page">
                    <?php _e('Pending', 'shapepress-dsgvo') ?>
                </a>
            </li>
            <li>
                <a
                        href="<?php echo esc_url(SPDSGVO::adminURL(array('tab' => 'super-unsubscribe', 'status' => 'done'))) ?>"
                        class="<?php echo esc_attr(($status === 'done') ? 'current' : ''); ?>" aria-current="page">
                    <?php _e('Done', 'shapepress-dsgvo') ?>
                </a>
            </li>
        </ul>
        <table class="table table-striped table-hover" cellspacing="0">
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
                <th id="status" class="manage-column column-status" scope="col"
                    style="width: 15%"><?php _e('State', 'shapepress-dsgvo') ?></th>
                <th id="process" class="manage-column column-process" scope="col"
                    style="width: 15%"><?php _e('Delete now', 'shapepress-dsgvo') ?></th>
                <!-- .i592995 -->
                <th id="dismiss" class="manage-column column-dismiss" scope="col"
                    style="width: 15%"><?php _e('Dismiss', 'shapepress-dsgvo') ?></th>
                <!-- .i592995 -->
            </tr>
            </thead>

            <tbody>
            <?php if (count($confirmed) !== 0): ?>
                <?php foreach ($confirmed as $key => $confirmedRequest): ?>

                    <tr class="<?php echo esc_attr(($key % 2 == 0) ? 'alternate' : '') ?>">
                        <td class="column-request-id">
                            <span class="wpk-services-table-name"><?php _e('ID', 'shapepress-dsgvo') ?></span>
                            <?php echo esc_html($confirmedRequest->ID); ?>
                        </td>
                        <td class="column-email">
                            <span class="wpk-services-table-name"><?php _e('Email', 'shapepress-dsgvo') ?></span>
                            <strong><?php echo esc_html($confirmedRequest->email); ?></strong>
                        </td>
                        <td class="column-integrations">
                            <span class="wpk-services-table-name"><?php _e('First name', 'shapepress-dsgvo') ?></span>
                            <?php echo esc_html($confirmedRequest->first_name); ?>
                        </td>
                        <td class="column-auto-deleting-on">
                            <span class="wpk-services-table-name"><?php _e('Last name', 'shapepress-dsgvo') ?></span>
                            <?php echo esc_html($confirmedRequest->last_name); ?>
                        </td>
                        <td class="column-auto-deleting-on">
                            <span class="wpk-services-table-name"><?php _e('GDPR approval', 'shapepress-dsgvo') ?></span>
                            <?php echo esc_html($confirmedRequest->dsgvo_accepted === '1' ? _e('Yes', 'shapepress-dsgvo') : _e('No', 'shapepress-dsgvo')); ?>
                        </td>
                        <td class="column-auto-deleting-on">
                            <span class="wpk-services-table-name"><?php _e('State', 'shapepress-dsgvo') ?></span>
                            <?php echo esc_html(ucfirst($confirmedRequest->status)); ?>
                        </td>
                        <td class="column-unsubscribe-user">
                            <span class="wpk-services-table-name"><?php _e('Delete now', 'shapepress-dsgvo') ?></span>
                            <?php if ($status == 'done'): ?>
                                <a class="button-primary disabled" href="#"><?php _e('Delete', 'shapepress-dsgvo') ?></a>
                            <?php else: ?>
                                <a class="button-primary"
                                   href="<?php echo wp_nonce_url(SPDSGVOSuperUnsubscribeAction::url(array('process' => $confirmedRequest->ID)),
                                       SPDSGVOSuperUnsubscribeAction::getActionName() . '-nonce') ?>"><?php _e('Delete now', 'shapepress-dsgvo') ?></a>
                            <?php endif; ?>
                        </td>
                        <!-- .i592995 -->
                        <td class="column-dismiss">
                            <span class="wpk-services-table-name"><?php _e('Dismiss', 'shapepress-dsgvo') ?></span>
                            <svg class="unsubscribe-dismiss" width="10" height="10"
                                 data-id="<?php echo esc_attr($confirmedRequest->ID); ?>" data-nonce="<?php echo wp_create_nonce(SPDSGVODismissUnsubscribeAction::getActionName() . '-nonce'); ?>">
                                <line x1="0" y1="0" x2="10" y2="10"/>
                                <line x1="0" y1="10" x2="10" y2="0"/>
                            </svg>
                        </td>
                        <!-- .i592995 -->
                    </tr>

                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td class="column-slug" colspan="6">
                        <?php if ($status == 'done'): ?>
                            <?php _e('No requests done', 'shapepress-dsgvo') ?>
                        <?php else: ?>
                            <?php _e('No pending requests', 'shapepress-dsgvo') ?>
                        <?php endif; ?>
                    </td>
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
                <th class="manage-column column-status" scope="col"><?php _e('State', 'shapepress-dsgvo') ?></th>
                <th class="manage-column column-process" scope="col"><?php _e('Delete now', 'shapepress-dsgvo') ?></th>
                <!-- .i592995 -->
                <th class="manage-column column-dismiss" scope="col"><?php _e('Dismiss', 'shapepress-dsgvo') ?></th>
                <!-- .i592995 -->
            </tr>
            </tfoot>
        </table>

        <?php if (isset($pending) && count($pending) !== 0): ?>
            <p>
                <a class="button-primary"
                   href="<?php echo wp_nonce_url(SPDSGVOSuperUnsubscribeAction::url(array('all' => '1')),
                       SPDSGVOSuperUnsubscribeAction::getActionName() . '-nonce') ?>"><?php _e('Delete all', 'shapepress-dsgvo') ?></a>
            </p>
        <?php endif; ?>
    </div>
</div>



<div class="card-columns">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Add entry', 'shapepress-dsgvo') ?></h4>
            <small class="card-subtitle text-danger"><?php _e('ATTENTION: Executing this action deletes the account (except administrators).', 'shapepress-dsgvo') ?></small>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
                <input type="hidden" name="action"
                       value="<?php echo esc_attr(SPDSGVOSuperUnsubscribeFormAction::getActionName()); ?>"> <input
                        type="hidden" name="is_admin" value="1"> <br>
                <?php wp_nonce_field(esc_attr(SPDSGVOSuperUnsubscribeFormAction::getActionName()) . '-nonce'); ?>

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
                    __('Run without user confirmation', 'shapepress-dsgvo'),
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
