<?php

if (! function_exists('sp_dsgvo_CSRF_TOKEN')) {

    function sp_dsgvo_CSRF_TOKEN()
    {
        $user = wp_get_current_user();

        if ($user instanceof WP_User && $user->ID) {
            return get_user_meta($user->ID, 'sp_dsgvo_CSRF_token', TRUE);
        }
    }
}

if (! function_exists('pageContainsString')) {

    function pageContainsString($pageID, $string)
    {
        if (get_post_status($pageID) === FALSE) {
            return FALSE;
        }

        return (strpos(get_post($pageID)->post_content, $string) !== FALSE);
    }
}


if (! function_exists('isBlogEdition')) {

    function isBlogEdition()
    {
        $license = SPDSGVOSettings::get('dsgvo_licence');
        if ($license === '' || strlen($license) < 2) return false;
        
        return substr( $license, 0, 2 ) === "PB";
    }
}

if (! function_exists('isPremiumEdition')) {
    
    function isPremiumEdition()
    {
        $license = SPDSGVOSettings::get('dsgvo_licence');
        if ($license === '' || strlen($license) < 2) return false;
        
        return substr( $license, 0, 2 ) === "PR" // 
                || substr( $license, 0, 2 ) === "PP" //  plus
                || substr( $license, 0, 2 ) === "PD" // dev
                || substr( $license, 0, 2 ) === "PU" // dev
                || substr( $license, 0, 4 ) === "DEMO";
    }
}

if (! function_exists('isLicenceValid')) {

    function isLicenceValid()
    {
        $licenseKey = SPDSGVOSettings::get('dsgvo_licence');
        $licenseStatus = SPDSGVOSettings::get('licence_status');
        $licenseActivated = SPDSGVOSettings::get('license_activated');
        
        if ($licenseKey === '') return false;
        
        if (isBlogEdition())
        {
            return hasValidLicenseStatus($licenseStatus, $licenseActivated);
        } else
        {
            if (isUnlimitedLicense($licenseKey))
            {
                return hasValidLicenseStatus($licenseStatus, $licenseActivated);
            } else
            {
                return hasValidLicenseStatus($licenseStatus, $licenseActivated) 
                    && (new DateTime()) <= (new DateTime(SPDSGVOSettings::get('licence_valid_to')));
            }
        }
       
    }
}

if (! function_exists('isValidBlogEdition')) {
    
    function isValidBlogEdition()
    {
        return isLicenceValid() && isBlogEdition();
    }
}

if (! function_exists('isValidPremiumEdition')) {
    
    function isValidPremiumEdition()
    {
        return isLicenceValid() && isPremiumEdition();
    }
}

if (! function_exists('isUnlimitedLicense')) {
    
    function isUnlimitedLicense($license)
    {
        if ($license === '' || strlen($license) < 2) return false;
        
        return substr( $license, 0, 6 ) === "PR_XX_" //
        || substr( $license, 0, 6 ) === "PP_XX" //  plus
        || substr( $license, 0, 6 ) === "PD_XX" // dev
        || substr( $license, 0, 3 ) === "PB_";  // blog
    }
}

if (! function_exists('hasValidLicenseStatus')) {
    
    function hasValidLicenseStatus($licenseStatus, $licenseActivated)
    {
        if ($licenseStatus === '' || strlen($licenseStatus) < 2) {
            
            return  SPDSGVOSettings::get('licence_details_fetched_new') === '0'; // true if not fetched, otherwise false
        }
        
        if ($licenseActivated === '0') return false;
        
        if (strtolower($licenseStatus) === 'returned') return false;
        if (strtolower($licenseStatus) === 'expired') return false;
        
        return true;
    }
}

if (! function_exists('licenseIsGoingToRunningOut')) {
    
    function licenseIsGoingToRunningOut()
    {
        $licenseKey = SPDSGVOSettings::get('dsgvo_licence');
        if (isUnlimitedLicense($licenseKey)) return false;
        
        $licenseValidtoDate = SPDSGVOSettings::get('licence_valid_to');
        
        return isPremiumEdition() && (new DateTime($licenseValidtoDate)) <= (new DateTime('today +14 days'));
    }
}

if (! function_exists('getExtensionProductUrl')) {
    
    function getExtensionProductUrl()
    {
        $license = SPDSGVOSettings::get('dsgvo_licence');
        if ($license === '' || strlen($license) < 2) return '';
        
        $baseUrl = SPDSGVOConstants::LEGAL_WEB_BASE_URL;
        $newUrl = $baseUrl;


        if (SPDSGVOLanguageTools::getInstance()->getCurrentLanguageCode() === 'de_DE')
        {
        
            switch (substr( $license, 0, 2 ))
            {
                case 'PR': $newUrl .='/shop/verlaengerung/wp-dsgvo-tools-premium-verlaengerung/'; break;
                case 'PP': $newUrl .='/shop/verlaengerung/wp-dsgvo-tools-premium-plus-new-verlaengerung/'; break;
                case 'PD': $newUrl .='/shop/verlaengerung/wp-dsgvo-tools-premium-ultra-verlaengerung/'; break;
                case 'PU': $newUrl .='/shop/verlaengerung/wp-dsgvo-tools-premium-developer-verlaengerung/'; break;
                default: return '';
            }
        } else 
        {
            switch (substr( $license, 0, 2 ))
            {
                case 'PR': $newUrl .='/en/shop/renewal/wp-dsgvo-tools-premium-renewal/'; break;
                case 'PP': $newUrl .='/en/shop/renewal/wp-dsgvo-tools-premium-plus-renewal/'; break;
                case 'PU': $newUrl .='/en/shop/renewal/wp-dsgvo-tools-premium-ultra-renewal/'; break;
                case 'PD': $newUrl .='/en/shop/renewal/wp-dsgvo-tools-premium-developer-renewal/'; break;
                default: return '';
            }
        }
        
        $newUrl .= "?lic=".$license;
        return $newUrl;
    }
}

if (! function_exists('createLog')) {

    function createLog($content)
    {
        return SPDSGVOLog::insert($content);
    }
}

if (! function_exists('convDeChars')) {

    function convDeChars($content)
    {
        $content = str_replace('Ã¤', 'ä', $content);
        $content = str_replace('Ã„', 'Ä', $content);
        $content = str_replace('Ã¼', 'ü', $content);
        $content = str_replace('Ãœ', 'Ü', $content);
        $content = str_replace('Ã¶', 'ö', $content);
        $content = str_replace('Ã–', 'Ö', $content);
        $content = str_replace('ÃŸ', 'ß', $content);
        $content = str_replace('ÃŸ', 'ß', $content);

        $content = str_replace('ä', '&auml;', $content);
        $content = str_replace('Ä', '&Auml;', $content);
        $content = str_replace('ü', '&uuml;', $content);
        $content = str_replace('Ü', '&Uuml;', $content);
        $content = str_replace('ö', '&ouml;', $content);
        $content = str_replace('Ö', '&Ouml;', $content);
        $content = str_replace('ß', '&szlig;', $content);
        $content = str_replace('ß', '$szlig;', $content);

        return $content;
    }
}

if (! function_exists('saveUnserializeCookie')) {
    
    function saveUnserializeCookie($cookieContent)
    {
        if (true )
        {
            return json_decode(stripslashes($cookieContent), true); //unserialize(stripslashes($cookieContent));
        }
        else {
         return null;
        }
    }
}

if (! function_exists('spDsgvoRemoveScriptTagsFromString')) {
    function spDsgvoRemoveScriptTagsFromString($input)
    {
        $result=  preg_replace('#<script[^>]*>([^<]+)</script>#', '$1', $input);
        $result = preg_replace('/<!--(.|\s)*?-->/', '', $result);
        $result = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $result);
        return $result;
    }
}

/**
 * Recursive sanitation for an array
 * @param $array
 * @return mixed
 */
if (! function_exists('spDsgvo_recursive_sanitize_text_field')) {
	function spDsgvo_recursive_sanitize_text_field( $array ) {
		foreach ( $array as $key => &$value ) {
			if ( is_array( $value ) ) {
				$value = spDsgvo_recursive_sanitize_text_field( $value );
			} else {
				$value = sanitize_text_field( $value );
			}
		}

		return $array;
	}
}

if (! function_exists('spDsgvoWriteInput')) {
    /**
     *
     * write a bootstrap html input code
     *
     * @type            the type if the html input: text, checkbox, toggle
     * @id              the id of the html input
     * @settingsKey     the key of the option which is stored in wp_options
     * @initalValue     the intial value of the input
     * @placeholder     the placeholder of the hmtl input
     * @infoText        a small info text which gets rendered under the input
     * @class           an additional css class
     * @addFormGroup    default true; if the input should get surrounded by a form-group element
     * @cbValue         the value of the checkbox if its set
     * @return      null
     *
     */
    function spDsgvoWriteInput($type, $id, $settingsKey, $initalValue, $label, $placeholder, $infoText, $addFormGroup = true, $class = '', $cbValue = '1', $enabled = true, $visible = true )
    {
        if ($addFormGroup) echo wp_kses_post('<div class="form-group '. ($visible ? '' : 'spdsgvo-d-none') .'">');



        if (empty($id)) $id = $settingsKey;

        $inputType = $type;

        if ($type === 'switch' || $type === 'toggle') {
            $type = 'switch';
            $inputType = 'checkbox';
        } // for bootstrap naming

        if ($type === 'switch' || $type === 'toggle' || $type === 'radio') :
        ?>
            <div class="custom-control custom-<?php echo esc_attr($type);?>">
                <input type="<?php echo esc_attr($inputType); ?>"" class="custom-control-input <?php echo esc_attr($class);?>" id="<?php echo esc_attr($id);?>" name="<?php echo esc_attr($settingsKey);?>"
                       value="<?php echo esc_attr($cbValue);?>" <?php echo esc_attr(checked($initalValue, $cbValue)); ?>
                       <?php echo esc_attr($enabled == false ? 'disabled' : '');?>>

                <?php if(empty($label) == false): ?>
                <label class="custom-control-label" for="<?php echo esc_attr($id)?>"><?php echo wp_kses_post($label); ?></label>
                <?php endif; ?>
            </div>
            <?php if(empty($infoText) == false): ?>
            <small class="form-text text-muted"><?php echo wp_kses_post($infoText); ?></small>
            <?php endif; ?>
        <?php
        endif;

        if ($type === 'text' || $type === 'color') :
            ?>

            <?php if(empty($label) == false): ?>
            <label for="<?php echo esc_attr($id);?>"><?php echo wp_kses_post($label); ?></label>
            <?php endif; ?>
            <input type="<?php echo esc_attr($type)?>" class="form-control <?php echo esc_attr($class)?>" id="<?php echo esc_attr($id)?>" name="<?php echo esc_attr($settingsKey)?>" placeholder="<?php echo esc_attr($placeholder);?>"
                   value="<?php echo esc_attr($initalValue); ?>" <?php echo esc_attr($enabled == false ? 'readonly' : '');?>>
            <?php if(empty($infoText) == false): ?>
            <small class="form-text text-muted"><?php echo wp_kses_post($infoText) ?></small>
            <?php endif; ?>

        <?php
        endif;

        if ($type === 'textarea') :
            ?>

            <?php if(empty($label) == false): ?>
            <label for="<?php echo esc_attr($id)?>"><?php echo wp_kses_post($label); ?></label>
            <?php endif; ?>
            <textarea rows="5" class="form-control <?php echo esc_attr($class);?>" id="<?php echo esc_attr($id);?>" name="<?php echo esc_attr($settingsKey)?>" placeholder="<?php echo esc_attr($placeholder);?>" <?php echo esc_attr($enabled == false ? 'disabled' : '');?>><?php echo esc_textarea($initalValue); ?></textarea>
            <?php if(empty($infoText) == false): ?>
            <small class="form-text text-muted"><?php echo wp_kses_post($infoText) ?></small>
        <?php endif; ?>

        <?php
        endif;

        if ($addFormGroup) echo '</div>';
    }
}

if (! function_exists('spDsgvoWriteSelect')) {
    function spDsgvoWriteSelect($elements, $id, $settingsKey, $initalValue, $label, $placeholder, $infoText, $addFormGroup = true, $class = '' )
    {
        if ($addFormGroup) echo '<div class="form-group">';

        if (empty($id)) $id = $settingsKey;

        ?>

        <label for="<?php echo esc_attr($id);?>"><?php echo esc_html($label); ?></label>
        <select class="form-control <?php echo esc_attr($class);?>" id="<?php echo esc_attr($id);?>" name="<?php echo esc_attr($settingsKey)?>">

            <?php if (empty($placeholder) == false) :?>
            <option value=""><?php echo esc_html($placeholder); ?></option>
            <?php endif;?>

            <?php foreach ($elements as $id => $element) :?>

                <option value="<?php echo esc_attr($id); ?>" <?php echo esc_attr(selected($id == $initalValue)) ?>><?php echo esc_html($element); ?></option>

             <?php endforeach; ?>
            // todo
        </select>
        <small class="form-text text-muted"><?php echo wp_kses_post($infoText) ?></small>
        <?php

        if ($addFormGroup) echo '</div>';
    }
}

if (! function_exists('spDsgvoWritePremiumOverlayIfInvalid')) {
    function spDsgvoWritePremiumOverlayIfInvalid($isValid )
    {
        if ($isValid == false) :
        ?>

        <div class="sp-dsgvo-overlay">
            <div class="sp-dsgvo-overlay-text px-20 py-4 w-60">
                <small>
                    <span style="color: orange">
                        <?php _e('More features with legal web cloud.', 'shapepress-dsgvo') ?>
                    </span>
                </small>
                <br>
                <small>
                    <a href="https://legalweb.io/privacy-cloud/" target="_blank">
                        <?php _e('Click here to learn more.', 'shapepress-dsgvo') ?>
                    </a>
                </small>
            </div>
        </div>

        <?php

        endif;;
    }
}


if (! function_exists('SPDSGVOGetFormatedHtmlTextArray')) {

    function SPDSGVOGetFormatedHtmlTextArray($htmlFormat, $text)
    {
        return array( 'format' => $htmlFormat, 'text' => $text);
    }
}

if (! function_exists('SPDSGVOGetHtmlFromPrivacyPolicyLineItem')) {

    function SPDSGVOGetHtmlFromPrivacyPolicyLineItem($lineItem)
    {
        if ($lineItem['format'] == 'br') {
            return $lineItem['text'] . "<br />";
        } else {
            return "<" . $lineItem['format'] . ">" . $lineItem['text'] . "</" . $lineItem['format'] . ">";
        }

    }
}
