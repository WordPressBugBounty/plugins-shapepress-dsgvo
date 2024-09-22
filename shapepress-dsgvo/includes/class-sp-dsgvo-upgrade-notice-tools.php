<?php

class SPDSGVOUpgradeNoticeTools {

    /**
     * The upgrade notice shown inline.
     *
     * @var string
     */
    protected $upgrade_notice = '';


    /**
     * Show plugin changes on the plugins screen. Code adapted from W3 Total Cache.
     *
     * @param array    $args Unused parameter.
     * @param stdClass $response Plugin update response.
     */
    public function in_plugin_update_message( $args, $response ) {
        $this->new_version            = $response->new_version;
        $this->upgrade_notice         = $this->get_upgrade_notice( $response->url, $response->new_version );

        $current_version_parts = explode( '.', sp_dsgvo_VERSION );
        $new_version_parts     = explode( '.', $this->new_version );

        // If user has already moved to the minor version, we don't need to flag up anything.
        if ( version_compare( $current_version_parts[0] . '.' . $current_version_parts[1], $new_version_parts[0] . '.' . $new_version_parts[1], '=' ) ) {
            return;
        }

        if (empty($this->upgrade_notice ) == false)
        {
            echo wp_kses_post($this->upgrade_notice) ;
        }

    }

    /**
     * Get the upgrade notice from WordPress.org.
     *
     * @param  string $version WooCommerce new version.
     * @return string
     */
    protected function get_upgrade_notice($repoUrl, $version ) {
        $transient_name = 'shapepress-dsgvo_upgrade_notice_' . $version;
        $upgrade_notice = get_transient( $transient_name );
        $upgrade_notice = ''; // dont use for now

        if (empty($upgrade_notice) ) {
            $response = wp_safe_remote_get( 'https://plugins.svn.wordpress.org/shapepress-dsgvo/trunk/README.txt' );

            if ( ! is_wp_error( $response ) && ! empty( $response['body'] ) ) {
                $upgrade_notice = $this->parse_update_notice( $response['body'], $version );
                set_transient( $transient_name, $upgrade_notice, DAY_IN_SECONDS  );
            }
        }
        return $upgrade_notice;
    }

    /**
     * Parse update notice from readme file.
     *
     * @param  string $content WooCommerce readme file content.
     * @param  string $new_version WooCommerce new version.
     * @return string
     */
    private function parse_update_notice( $content, $new_version ) {
        $version_parts     = explode( '.', $new_version );
        $check_for_notices = array(
            $version_parts[0] . '.0', // Major.
            $version_parts[0] . '.0.0', // Major.
            $version_parts[0] . '.' . $version_parts[1], // Minor.
            $version_parts[0] . '.' . $version_parts[1] . '.' . $version_parts[2], // Patch.
        );
        $notice_regexp     = '~==\s*Upgrade Notice\s*==\s*=\s*(.*)\s*=(.*)(=\s*' . preg_quote( $new_version ) . '\s*=|$)~Uis';
        $upgrade_notice    = '';

        foreach ( $check_for_notices as $check_version ) {
            if ( version_compare( sp_dsgvo_VERSION, $check_version, '>' ) ) {
                continue;
            }

            $matches = null;
            if ( preg_match( $notice_regexp, $content, $matches ) ) {
                $notices = (array) preg_split( '~[\r\n]+~', trim( $matches[2] ) );

                if ( version_compare( trim( $matches[1] ), $check_version, '=' ) ) {
                    $upgrade_notice .= '<p class="sp-dsgvo_plugin_upgrade_notice">';

                    foreach ( $notices as $index => $line ) {
                        $upgrade_notice .= preg_replace( '~\[([^\]]*)\]\(([^\)]*)\)~', '<a href="${2}">${1}</a>', $line );
                    }

                    $upgrade_notice .= '</p>';
                }
                //break;
            }
        }
        return $upgrade_notice;
    }
}