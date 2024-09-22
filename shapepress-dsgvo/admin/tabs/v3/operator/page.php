<?php
$isPremium = isValidPremiumEdition();
$isBlog = isValidBlogEdition();
$hasValidLicense = isValidPremiumEdition() || isValidBlogEdition();

?>

<div class="card-columns">

    <form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
        <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOOperatorAction::getActionName()); ?>">
        <?php wp_nonce_field(esc_attr(SPDSGVOOperatorAction::getActionName()) . '-nonce'); ?>
        <!-- operator person details-->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php _e('Wordpress Page/Blog Operator', 'shapepress-dsgvo') ?></h4>
            </div>
            <div class="card-body">
                <div class="form">
                    <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOOperatorAction::getActionName()); ?>">
                    <?php wp_nonce_field(esc_attr(SPDSGVOOperatorAction::getActionName()) . '-nonce'); ?>

                    <div class="form-group">
                        <?php $operatorType = SPDSGVOSettings::get('page_operator_type');?>
                        <label for="page_operator_type"><?php _e('Page operator type', 'shapepress-dsgvo') ?></label>
                        <select class="form-control" id="page_operator_type" name="page_operator_type">
                            <option value="private" <?php if ($operatorType == 'private') {
                                echo 'selected';
                            } ?>><?php _e('Private citizen', 'shapepress-dsgvo') ?></option>
                            <option value="one-man" <?php if ($operatorType == 'one-man') {
                                echo 'selected';
                            } ?>><?php _e('One-man business', 'shapepress-dsgvo') ?></option>
                            <option value="corporation" <?php if ($operatorType == 'corporation') {
                                echo 'selected';
                            } ?>><?php _e('Corporation', 'shapepress-dsgvo') ?></option>
                            <option value="society" <?php if ($operatorType == 'society') {
                                echo 'selected';
                            } ?>><?php _e('Society', 'shapepress-dsgvo') ?></option>
                            <option value="corp-public-law" <?php if ($operatorType == 'corp-public-law') {
                                echo 'selected';
                            } ?>><?php _e('Corporation under public law', 'shapepress-dsgvo') ?></option>
                            <option value="corp-public-law" <?php if ($operatorType == 'corp-private-law') {
                                echo 'selected';
                            } ?>><?php _e('Corporation under private law', 'shapepress-dsgvo') ?></option>

                        </select>
                    </div>

                    <div class="page-operator-type-container page-operator-type-container-corporation <?php echo esc_attr($operatorType == 'corporation' ? 'spdsgvo-d-block' : 'spdsgvo-d-none');?>">
                    <?php
                    // in case corperate
                    spDsgvoWriteInput('text', '', 'page_operator_corporate_name', SPDSGVOSettings::get('page_operator_corporate_name'),
                        __('Company + legal form', 'shapepress-dsgvo'),
                        '',
                        __('The name of the company including the legal form.', 'shapepress-dsgvo'));
                    ?>

                    <?php
                    spDsgvoWriteInput('text', '', 'page_operator_corporate_ceo', SPDSGVOSettings::get('page_operator_corporate_ceo'),
                        __('Executive director', 'shapepress-dsgvo'),
                        '',
                        '');
                    ?>

                    <?php
                    spDsgvoWriteInput('text', '', 'spdsgvo_company_chairmen', SPDSGVOSettings::get('spdsgvo_company_chairmen'),
                        __('Shareholder', 'shapepress-dsgvo'),
                        '',
                        '');
                    ?>
                    </div>

                    <div class="page-operator-type-container page-operator-type-container-one-man <?php echo esc_attr($operatorType == 'one-man' ? 'spdsgvo-d-block' : 'spdsgvo-d-none');?>">
                    <?php
                    // in case of one-man
                    spDsgvoWriteInput('text', '', 'page_operator_company_law_person', SPDSGVOSettings::get('page_operator_company_law_person'),
                        __('Full Name of the company owner', 'shapepress-dsgvo'),
                        '',
                        __('The name of person who legally represents the company including all titles if wished.', 'shapepress-dsgvo'));
                    ?>

                    <?php
                    // in case of one-man
                    spDsgvoWriteInput('text', '', 'page_operator_company_name', SPDSGVOSettings::get('page_operator_company_name'),
                        __('Business name', 'shapepress-dsgvo'),
                        '',
                        __('The name of the company.', 'shapepress-dsgvo'));
                    ?>
                    </div>

                    <div class="page-operator-type-container page-operator-type-container-private <?php echo esc_attr($operatorType == 'private' ? 'spdsgvo-d-block' : 'spdsgvo-d-none');?>">
                    <?php
                    // in case of private
                    spDsgvoWriteInput('text', '', 'page_operator_operator_name', SPDSGVOSettings::get('page_operator_operator_name'),
                        __('First and last name', 'shapepress-dsgvo'),
                        '',
                        '');
                    ?>
                    </div>

                    <div class="page-operator-type-container page-operator-type-container-society <?php echo esc_attr($operatorType == 'society' ? 'spdsgvo-d-block' : 'spdsgvo-d-none');?>">
                        <?php

                        spDsgvoWriteInput('text', '', 'page_operator_society_name', SPDSGVOSettings::get('page_operator_society_name'),
                            __('Society name', 'shapepress-dsgvo'),
                            '',
                            __('The full name of the society.', 'shapepress-dsgvo'));
                        ?>
                        <?php

                        spDsgvoWriteInput('text', '', 'page_operator_society_board', SPDSGVOSettings::get('page_operator_society_board'),
                            __('Simplifying board', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>
                        <?php

                        spDsgvoWriteInput('text', '', 'page_operator_society_number', SPDSGVOSettings::get('page_operator_society_number'),
                            __('Society number', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>
                    </div>

                    <div class="page-operator-type-container page-operator-type-container-corp-public-law <?php echo esc_attr($operatorType == 'corp-public-law' || $operatorType == 'corp-private-law'  ? 'spdsgvo-d-block' : 'spdsgvo-d-none');?>">

                        <?php
                        // in case of corp-public-law
                        spDsgvoWriteInput('text', '', 'page_operator_corp_public_law_name', SPDSGVOSettings::get('page_operator_corp_public_law_name'),
                            __('Public corporation name', 'shapepress-dsgvo'),
                            '',
                            __('The full name of the public corporation.', 'shapepress-dsgvo'));
                        ?>

                        <?php

                        spDsgvoWriteInput('text', '', 'page_operator_corp_public_law_supervisor', SPDSGVOSettings::get('page_operator_corp_public_law_supervisor'),
                            __('Supervisory authority', 'shapepress-dsgvo'),
                            '',
                            __('The full name of the supervisory authority.', 'shapepress-dsgvo'));
                        ?>

                        <?php

                        spDsgvoWriteInput('text', '', 'page_operator_corp_public_law_representative', SPDSGVOSettings::get('page_operator_corp_public_law_representative'),
                            __('Representative person', 'shapepress-dsgvo'),
                            '',
                            __('The full name of the representative person.', 'shapepress-dsgvo'));
                        ?>

                    </div>

                    <div class="form-group">
                        <?php
                        $selectedCountry = SPDSGVOSettings::get('spdsgvo_company_info_countrycode');
                        $countryList = SPDSGVOConstants::getCountries();
                        ?>
                        <div class="label-operator-type label-operator-type-private <?php echo esc_attr($operatorType == 'private' ? 'spdsgvo-d-block' : 'spdsgvo-d-none');  ?>">
                            <label for="spdsgvo_company_info_countrycode"><?php _e('Place of residence', 'shapepress-dsgvo') ?></label>
                        </div>
                        <div class="label-operator-type label-operator-type-one-man <?php echo esc_attr($operatorType == 'one-man' ? 'spdsgvo-d-block' : 'spdsgvo-d-none');  ?>">
                            <label for="spdsgvo_company_info_countrycode"><?php _e('Registered business address', 'shapepress-dsgvo') ?></label>
                        </div>
                        <div class="label-operator-type label-operator-type-society <?php echo esc_attr($operatorType == 'society' ? 'spdsgvo-d-block' : 'spdsgvo-d-none');  ?>">
                            <label for="spdsgvo_company_info_countrycode"><?php _e('Club seat', 'shapepress-dsgvo') ?></label>
                        </div>
                        <div class="label-operator-type label-operator-type-corporation <?php echo esc_attr($operatorType == 'corporation' ? 'spdsgvo-d-block' : 'spdsgvo-d-none');  ?>">
                            <label for="spdsgvo_company_info_countrycode"><?php _e('Registered business address', 'shapepress-dsgvo') ?></label>
                        </div>

                        <select name="spdsgvo_company_info_countrycode" id="spdsgvo_company_info_countrycode" class="form-control">
                        <?php foreach ($countryList as $key => $name) :?>
                            <option value="<?php echo esc_attr($key)?>" <?php selected($selectedCountry, $key); ?>><?php echo esc_html($name); ?></option>
                        <?php endforeach; ?>
                        </select>
                        <small class="form-text text-muted"><?php _e('Important: This setting defines the legal basis of all the texts which WP DSGVO Tools (GDPR) provides. Setting a wrong country risks to be not confirm with the GDPR.', 'shapepress-dsgvo') ?></small>
                    </div>

                    <?php
                    spDsgvoWriteInput('text', '', 'spdsgvo_company_info_street', SPDSGVOSettings::get('spdsgvo_company_info_street'),
                        __('Street', 'shapepress-dsgvo'),
                        '',
                        '');
                    ?>

                    <?php
                    spDsgvoWriteInput('text', '', 'spdsgvo_company_info_zip', SPDSGVOSettings::get('spdsgvo_company_info_zip'),
                        __('ZIP code', 'shapepress-dsgvo'),
                        '',
                        '');
                    ?>

                    <?php
                    spDsgvoWriteInput('text', '', 'spdsgvo_company_info_loc', SPDSGVOSettings::get('spdsgvo_company_info_loc'),
                        __('Location', 'shapepress-dsgvo'),
                        '',
                        '');
                    ?>



                    <?php
                    spDsgvoWriteInput('text', '', 'spdsgvo_company_info_phone', SPDSGVOSettings::get('spdsgvo_company_info_phone'),
                        __('Phone', 'shapepress-dsgvo'),
                        '',
                        '');
                    ?>

                    <?php
                    spDsgvoWriteInput('text', '', 'spdsgvo_company_info_email', SPDSGVOSettings::get('spdsgvo_company_info_email'),
                        __('Email', 'shapepress-dsgvo'),
                        '',
                        '');
                    ?>

                    <!-- US privacy shield -->

                   <div class="page-operator-container-us <?php echo esc_attr($selectedCountry == 'US' ? 'spdsgvo-d-block' : 'spdsgvo-d-none');?>"">
                       <?php

                       spDsgvoWriteInput('switch', '', 'page_operator_privacy_shield', SPDSGVOSettings::get('page_operator_privacy_shield'),
                           __('Privacy Shield', 'shapepress-dsgvo'),
                           '',
                           __('Enable, if you/your business is privacy shield certified.','shapepress-dsgvo'));

                       ?>
                   </div>

                <div class="page-operator-type-container page-operator-type-container-one-man page-operator-type-container-corporation page-operator-type-container-society <?php echo esc_attr($operatorType != 'private' ? 'spdsgvo-d-block' : 'spdsgvo-d-none');?>">
                    <?php
                    spDsgvoWriteInput('text', '', 'spdsgvo_company_fn_nr', SPDSGVOSettings::get('spdsgvo_company_fn_nr'),
                        __('Commercial book no.', 'shapepress-dsgvo'),
                        '',
                        '');
                    ?>

                    <?php
                    spDsgvoWriteInput('text', '', 'spdsgvo_company_law_loc', SPDSGVOSettings::get('spdsgvo_company_law_loc'),
                        __('§11 Place of Jurisdiction', 'shapepress-dsgvo'),
                        '',
                        '');
                    ?>

                    <?php
                    spDsgvoWriteInput('text', '', 'spdsgvo_company_uid_nr', SPDSGVOSettings::get('spdsgvo_company_uid_nr'),
                        __('VAT No.:', 'shapepress-dsgvo'),
                        '',
                        '');
                    ?>

                    <?php
                    /*
                    spDsgvoWriteInput('text', '', 'spdsgvo_company_law_person', SPDSGVOSettings::get('spdsgvo_company_law_person'),
                        __('Legal representatives', 'shapepress-dsgvo'),
                        '',
                        __('The person who legally represents the company.', 'shapepress-dsgvo'));
                    */
                    ?>
                </div>




                <?php
                    spDsgvoWriteInput('text', '', 'spdsgvo_company_resp_content', SPDSGVOSettings::get('spdsgvo_company_resp_content'),
                        __('Responsible for content', 'shapepress-dsgvo'),
                        '',
                        __('The person who is responsible for the content of this website.', 'shapepress-dsgvo'));
                    ?>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                    </div>

                </div>
            </div>
        </div>

        <!-- dso -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php _e('Privacy Policy Basics', 'shapepress-dsgvo') ?></h4>
            </div>
            <div class="card-body">
                <div class="form">
                    <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOOperatorAction::getActionName()) ?>">
                    <?php wp_nonce_field(esc_attr(SPDSGVOOperatorAction::getActionName()) . '-nonce'); ?>

                    <div class="form-group">
                        <?php $operator_pp_responsibility_type = SPDSGVOSettings::get('operator_pp_responsibility_type'); ?>
                        <label><?php _e('Do you have a data security officer?', 'shapepress-dsgvo') ?></label>
                        <?php
                        spDsgvoWriteInput('radio', 'operator_pp_responsibility_type_intern', 'operator_pp_responsibility_type',
                            $operator_pp_responsibility_type,
                            __('Yes, internal', 'shapepress-dsgvo'),
                            '',
                            '', false, '', 'internal');
                        ?>
                        <?php
                        spDsgvoWriteInput('radio', 'operator_pp_responsibility_type_extern', 'operator_pp_responsibility_type',
                            $operator_pp_responsibility_type,
                            __('Yes, external', 'shapepress-dsgvo'),
                            '',
                            '', false, '', 'external');
                        ?>
                        <?php
                        spDsgvoWriteInput('radio', 'operator_pp_responsibility_type_none', 'operator_pp_responsibility_type',
                            $operator_pp_responsibility_type,
                            __('No, we do not have', 'shapepress-dsgvo'),
                            '',
                            '', false, '', 'none');
                        ?>
                        <small class="form-text text-muted"><?php _e('Specifies if your company has an inhouse data security officer, an external person or no responsible person.', 'shapepress-dsgvo') ?></small>
                    </div>

                    <div id="container-pp-responsibility-internal" class="container-pp-responsibility <?php echo esc_attr($operator_pp_responsibility_type == 'internal' ? 'spdsgvo-d-block' : 'spdsgvo-d-none');?>">

                        <label><?php _e('Internal data security officer', 'shapepress-dsgvo') ?></label>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_intern_name', SPDSGVOSettings::get('operator_pp_dso_intern_name'),
                            __('Name', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_intern_phone', SPDSGVOSettings::get('operator_pp_dso_intern_phone'),
                            __('Phone', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_intern_email', SPDSGVOSettings::get('operator_pp_dso_intern_email'),
                            __('Email', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                    </div>

                    <div id="container-pp-responsibility-external"
                         class="form-group container-pp-responsibility <?php echo esc_attr($operator_pp_responsibility_type == 'external' ? 'spdsgvo-d-block' : 'spdsgvo-d-none');?>">

                        <label><?php _e('External data security officer', 'shapepress-dsgvo') ?></label>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_external_company', SPDSGVOSettings::get('operator_pp_dso_external_company'),
                            __('Company name', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_external_name', SPDSGVOSettings::get('operator_pp_dso_external_name'),
                            __('Name', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_external_street', SPDSGVOSettings::get('operator_pp_dso_external_street'),
                            __('Street', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_external_zip', SPDSGVOSettings::get('operator_pp_dso_external_zip'),
                            __('ZIP code', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_external_loc', SPDSGVOSettings::get('operator_pp_dso_external_loc'),
                            __('Location', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <div class="form-group">
                            <?php
                            $selectedCountry = SPDSGVOSettings::get('operator_pp_dso_external_countrycode');
                            ?>
                            <label for="operator_pp_dso_external_countrycode"><?php _e('Country:', 'shapepress-dsgvo') ?></label>
                            <select name="operator_pp_dso_external_countrycode" id="operator_pp_dso_external_countrycode" class="form-control">
                                <option value="AT" <?php selected($selectedCountry, 'AT'); ?>><?php _e('Austria', 'shapepress-dsgvo') ?></option>
                                <option value="DE" <?php selected($selectedCountry, 'DE'); ?>><?php _e('Germany', 'shapepress-dsgvo') ?></option>
                            </select>
                        </div>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_external_phone', SPDSGVOSettings::get('operator_pp_dso_external_phone'),
                            __('Phone', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_external_email', SPDSGVOSettings::get('operator_pp_dso_external_email'),
                            __('Email', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                    </div>

                    <div id="container-pp-responsibility-none"
                         class="form-group container-pp-responsibility  <?php echo esc_attr($operator_pp_responsibility_type == 'none' ? 'spdsgvo-d-block' : 'spdsgvo-d-none')?>">

                        <?php $operator_pp_responsibility_contact = SPDSGVOSettings::get('operator_pp_responsibility_contact'); ?>
                        <label><?php _e('Does your company has responsible person for privacy issues?', 'shapepress-dsgvo') ?></label>
                        <?php
                        spDsgvoWriteInput('radio', 'operator_pp_responsibility_contact_intern', 'operator_pp_responsibility_contact',
                            $operator_pp_responsibility_contact,
                            __('Yes, internal', 'shapepress-dsgvo'),
                            '',
                            '', false, '', 'internal');
                        ?>
                        <?php
                        spDsgvoWriteInput('radio', 'operator_pp_responsibility_contact_extern', 'operator_pp_responsibility_contact',
                            $operator_pp_responsibility_contact,
                            __('Yes, external', 'shapepress-dsgvo'),
                            '',
                            '', false, '', 'external');
                        ?>
                        <?php
                        spDsgvoWriteInput('radio', 'operator_pp_responsibility_contact_none', 'operator_pp_responsibility_contact',
                            $operator_pp_responsibility_contact,
                            __('No, we do not have', 'shapepress-dsgvo'),
                            '',
                            '', false, '', 'no');
                        ?>
                        <small class="form-text text-muted"><?php _e('Specifies if your company has responsible person for privacy issues .', 'shapepress-dsgvo') ?></small>

                    </div>

                    <div id="container-dso-contact-internal"
                         class="container-dso-contact <?php echo esc_attr($operator_pp_responsibility_type == 'none' && $operator_pp_responsibility_contact == 'internal' ? 'spdsgvo-d-block' : 'spdsgvo-d-none');?>">

                        <label><?php _e('Internal contact for privacy issues', 'shapepress-dsgvo') ?></label>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_contact_intern_name', SPDSGVOSettings::get('operator_pp_dso_contact_intern_name'),
                            __('Name', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_contact_intern_phone', SPDSGVOSettings::get('operator_pp_dso_contact_intern_phone'),
                            __('Phone', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_contact_intern_email', SPDSGVOSettings::get('operator_pp_dso_contact_intern_email'),
                            __('Email', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                    </div>

                    <div id="container-dso-contact-external"
                         class="container-dso-contact <?php echo esc_attr($operator_pp_responsibility_type == 'none' && $operator_pp_responsibility_contact == 'external' ? 'spdsgvo-d-block' : 'spdsgvo-d-none');?>">

                        <label><?php _e('External contact for privacy issues', 'shapepress-dsgvo') ?></label>


                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_contact_external_company', SPDSGVOSettings::get('operator_pp_dso_contact_external_company'),
                            __('Company/First- and lastname', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_contact_external_name', SPDSGVOSettings::get('operator_pp_dso_contact_external_name'),
                            __('Name', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_contact_external_street', SPDSGVOSettings::get('operator_pp_dso_contact_external_street'),
                            __('Street', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_contact_external_zip', SPDSGVOSettings::get('operator_pp_dso_contact_external_zip'),
                            __('ZIP code', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_contact_external_loc', SPDSGVOSettings::get('operator_pp_dso_contact_external_loc'),
                            __('Location', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <div class="form-group">
                            <?php
                            $selectedCountry = SPDSGVOSettings::get('operator_pp_dso_contact_external_countrycode');
                            ?>
                            <label for="operator_pp_dso_contact_external_countrycode"><?php _e('Country:', 'shapepress-dsgvo') ?></label>
                            <select name="operator_pp_dso_contact_external_countrycode" id="operator_pp_dso_contact_external_countrycode" class="form-control">
                                <option value="AT" <?php selected($selectedCountry, 'AT'); ?>><?php _e('Austria', 'shapepress-dsgvo') ?></option>
                                <option value="DE" <?php selected($selectedCountry, 'DE'); ?>><?php _e('Germany', 'shapepress-dsgvo') ?></option>
                            </select>
                        </div>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_contact_external_phone', SPDSGVOSettings::get('operator_pp_dso_contact_external_phone'),
                            __('Phone', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                        <?php
                        spDsgvoWriteInput('text', '', 'operator_pp_dso_contact_external_email', SPDSGVOSettings::get('operator_pp_dso_contact_external_email'),
                            __('Email', 'shapepress-dsgvo'),
                            '',
                            '');
                        ?>

                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                    </div>
                </div>
            </div>
        </div>

    </form>
    <!-- imprint -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php _e('Imprint settings', 'shapepress-dsgvo') ?></h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo esc_url(admin_url('/admin-ajax.php')); ?>">
                <input type="hidden" name="action" value="<?php echo esc_attr(SPDSGVOImprintAction::getActionName()); ?>">
                <?php wp_nonce_field(esc_attr(SPDSGVOImprintAction::getActionName()) . '-nonce'); ?>
                <input type="hidden" name="subform" value="imprint-settings">

                <div class="form-group">
                    <?php $imprintPage = SPDSGVOSettings::get('imprint_page'); ?>
                    <label for="imprint_page"><?php _e('Imprint page', 'shapepress-dsgvo') ?></label>
                    <select class="form-control" name="imprint_page" id="imprint_page">
                        <option value="0"><?php _e('Select', 'shapepress-dsgvo'); ?></option>
                        <?php foreach (get_pages(array('number' => 0)) as $key => $page): ?>
                            <option <?php echo selected($imprintPage == $page->ID) ?> value="<?php echo esc_attr($page->ID) ?>">
                                <?php echo esc_html($page->post_title); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <?php if ($imprintPage == '0'): ?>
                        <small><?php _e('Create a page that uses the shortcode <code>[imprint]</code>.', 'shapepress-dsgvo') ?>
                            <a class="btn btn-secondary btn-block"
                               href="<?php echo esc_url(SPDSGVOCreatePageAction::url(array('imprint_page' => '1'))); ?>"><?php _e('Create page', 'shapepress-dsgvo') ?></a>
                        </small>
                    <?php elseif (!pageContainsString($imprintPage, 'imprint')): ?>
                        <small><?php _e('Attention: The shortcode <code>[imprint]</code> was not found on the page you selected.', 'shapepress-dsgvo') ?>
                            <a class="btn btn-secondary btn-block"
                               href="<?php echo esc_url(get_edit_post_link($imprintPage)) ?>"><?php _e('Edit page', 'shapepress-dsgvo') ?></a>
                        </small>
                    <?php else: ?>
                        <small class="form-text text-muted"><?php _e('The page can also by edited and text could be extended by the editing the selected page with the Wordpress page editor like Gutenberg.','shapepress-dsgvo') ?></small>
                        <a class="btn btn-secondary btn-block"
                           href="<?php echo esc_url(get_edit_post_link($imprintPage)) ?>"><?php _e('Edit page', 'shapepress-dsgvo') ?></a>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Save changes', 'shapepress-dsgvo');?>">
                </div>
            </form>
        </div>
    </div>

</div>