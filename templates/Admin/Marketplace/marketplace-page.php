<?php
// Ensure this file is accessed through WordPress


if (!defined('ABSPATH')) {
    exit;
}

// Fetch plugins data using the Installer class
use DVICloudDeploy\Marketplace\Handler\FetchingRemotePluginsDate;

$plugins = FetchingRemotePluginsDate::getData();
?>
<h1></h1>
    <div class="banner">
        <div>
            <h1 class="txt-white">Marketplace</h1>
      
        </div>
     
    </div>
    <div class="marketplace-container">
    >


        <?php
        if (!empty($plugins)) {
            $toDay = new DateTime("now");
         
            echo '<div class="card-grid">';
            foreach ($plugins as $key => $plugin) {
                $plugin = (object)$plugin;
                $last_updated = new DateTime($plugin->last_updated);
                $interval = $last_updated->diff($toDay);
                $status = is_plugin_active($plugin->plugin_info) ? 'active' : 'inactive';
                $plugin_info_file = WP_PLUGIN_DIR . '/' . $plugin->plugin_info;
                

                $update = '';
                $install = '';

                if (!file_exists($plugin_info_file)) {
                    $install = '<button class="plugin-download _btn" data-download-url="' . esc_html($plugin->download_url) . '">
                   <img src="' . esc_url(DVICD_URL . 'assets/marketplace/images/download.svg') . '" alt="download" class="download-icon">
                    install
                    </button>';
                }

                if (file_exists($plugin_info_file)) {

                    $plugin_data =get_plugin_data($plugin_info_file);
                    if (isset($plugin_data['Version']) and version_compare($plugin_data['Version'], $plugin->version, '<')) {
                    $update = '<button class="plugin-update  _btn" data-plugin-path="' . esc_html($plugin->plugin_info) . '" data-slug="' . esc_html($plugin->slug) . '">
                    <img src="' . esc_url(DVICD_URL . 'assets/marketplace/images/update.svg') . '" alt="update" class="update-icon">
                    update
                    </button>';
                }
            }
                echo '<div class="marketplace-card">';
                echo '<div class="card-header">
                    <div class="header-top">
                        <div class="img-container">
                            <img src="' . esc_url($plugin->image_url) . '" alt="' . esc_attr($plugin->name) . '" class="plugin-logo">
                        </div>
                        
                        <button class="_btn" onclick="handleModal(\'' . $key . '\')">
                            <img src="' . esc_url(DVICD_URL . 'assets/marketplace/images/info.svg') . '" alt="info" class="info-icon">
                            </button>
                      
                    </div>
                    <div class="card-content">
                        <h3 class="plugin-title">' . esc_html($plugin->name). (isset($plugin->release_stage) ? " <span style='background: #ffc107;padding: 0 1rem;'>$plugin->release_stage</span>" : "" ). '</h3>
                        <p class="plugin-author">By ' . $plugin->author . '</p>
                       <p class="plugin-description">' . esc_html($plugin->sections['description']) . '</p>
                    </div>
                    </div> ';

                echo '<div class="card-body">';
                echo '
                 <div class="plugin-footer">
                    <div class="btn-container">
                    ' . $install . $update .'
            

                
                </div>
                </div>
             <div class="plugin-info-container" >
                <div class="plugin-info">
                     <div class="pluginupdate">  <span class=""><strong>Updated</strong>:' . $interval->days . ' days ago</span> </div>
                     <div class="pluginv">  <span class=""><strong>version</strong>' . esc_html($plugin->version) . '</span> </div>
                </div>
                <div class="active-plugin" '. disabled( file_exists($plugin_info_file), false, false ) .'">
                    <input type="checkbox" ' . checked($status == 'active', true, false). ' id="' . esc_html($key) . '"  class="toggle-item" value="1" data-plugin_info="' . esc_html($plugin->plugin_info) . '">
                    <label for="' . esc_html($key) . '" data-plugin_info="' . esc_html($plugin->plugin_info) . '" data-plugin_active="' . esc_html($status) . '" class="' . $status . '"></label>
                  </div>
              </div>
                ';
                echo '
                </div>
                </div>';
            }
            echo '</div>';
        } else {
            echo '<p>No plugins available yet.</p>';
        }
        ?>

        <div class="support-section">
            <div class="support-header">
                <h2>Support the Community</h2>
                <p>Our community thrives when we come together to share knowledge, lend support, and foster innovation. </p>
            </div>
            <div class="support-items">
                <div class="support-item">
                    <div class="icon-container">
                        <div class="icon-box">
                            <svg width="23" height="26" viewBox="0 0 23 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.9271 12.2143C14.9271 12.9986 14.3486 13.6414 13.6157 13.6414C12.8957 13.6414 12.3043 12.9986 12.3043 12.2143C12.3043 11.43 12.8829 10.7871 13.6157 10.7871C14.3486 10.7871 14.9271 11.43 14.9271 12.2143ZM8.92286 10.7871C8.19 10.7871 7.61143 11.43 7.61143 12.2143C7.61143 12.9986 8.20286 13.6414 8.92286 13.6414C9.65571 13.6414 10.2343 12.9986 10.2343 12.2143C10.2471 11.43 9.65571 10.7871 8.92286 10.7871ZM22.5 2.64857V25.7143C19.2609 22.8519 20.2968 23.7994 16.5343 20.3014L17.2157 22.68H2.63571C1.18286 22.68 0 21.4971 0 20.0314V2.64857C0 1.18286 1.18286 0 2.63571 0H19.8643C21.3171 0 22.5 1.18286 22.5 2.64857ZM18.8357 14.8371C18.8357 10.6971 16.9843 7.34143 16.9843 7.34143C15.1329 5.95286 13.3714 5.99143 13.3714 5.99143L13.1914 6.19714C15.3771 6.86571 16.3929 7.83 16.3929 7.83C13.3387 6.15611 9.75114 6.15581 6.78857 7.45714C6.31286 7.67571 6.03 7.83 6.03 7.83C6.03 7.83 7.09714 6.81429 9.41143 6.14571L9.28286 5.99143C9.28286 5.99143 7.52143 5.95286 5.67 7.34143C5.67 7.34143 3.81857 10.6971 3.81857 14.8371C3.81857 14.8371 4.89857 16.7014 7.74 16.7914C7.74 16.7914 8.21571 16.2129 8.60143 15.7243C6.96857 15.2357 6.35143 14.2071 6.35143 14.2071C6.54057 14.3395 6.85246 14.5111 6.87857 14.5286C9.04872 15.7439 12.1313 16.142 14.9014 14.9786C15.3514 14.8114 15.8529 14.5671 16.38 14.22C16.38 14.22 15.7371 15.2743 14.0529 15.75C14.4386 16.2386 14.9014 16.7914 14.9014 16.7914C17.7429 16.7014 18.8357 14.8371 18.8357 14.8371Z" fill="white" />
                            </svg>
                        </div>
                    </div>
                    <div class="support-content">
                        <h3>Join our Discord Community</h3>
                        <p>Connect with other developers, share knowledge, and get support.</p>
                        <a href="https://discord.com/invite/kjhta4xQc2" target="_blank" class="support-link">Join Discord</a>
                    </div>
                </div>
                <div class="support-item">
                    <div class="icon-container">
                        <div class="icon-box">
                            <svg width="25" height="17" viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.5207 0H2.47935C1.11217 0 0 1.11212 0 2.47935V13.8866C0 15.2538 1.11217 16.3659 2.47935 16.3659H22.5207C23.8879 16.3659 25 15.2538 25 13.8866V2.47935C25.0001 1.11212 23.8879 0 22.5207 0ZM23.3472 2.47935V13.8866C23.3472 14.017 23.3105 14.136 23.2564 14.2458L17.4135 8.40245L23.3455 2.47043C23.3455 2.47373 23.3472 2.47611 23.3472 2.47935ZM1.6529 13.8865V2.47935C1.6529 2.47611 1.65457 2.47378 1.65457 2.47049L7.58659 8.4025L1.74333 14.2457C1.68963 14.136 1.6529 14.017 1.6529 13.8865ZM12.7551 10.7237C12.6187 10.86 12.3814 10.86 12.245 10.7237L3.17465 1.6529H21.8259L12.7551 10.7237ZM8.75524 9.5712L11.0763 11.8923C11.4569 12.2728 11.9625 12.4823 12.5001 12.4823C13.0375 12.4823 13.5432 12.2728 13.9238 11.8923L16.245 9.5712L21.3863 14.713H3.61335L8.75524 9.5712Z" fill="white" />
                            </svg>
                        </div>
                    </div>
                    <div class="support-content">
                        <h3>Contact the Developer</h3>
                        <p>Have a question? Reach out via email.</p>
                        <a href="mailto:support@developvi.com" class="support-link">Send Email</a>
                    </div>
                </div>
                <div class="support-item">
                    <div class="icon-container">
                        <div class="icon-box">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.6402 17.032C12.3276 17.3327 11.9959 17.6309 11.6452 17.9268L11.7418 17.9107L12.0443 17.857C12.3184 17.8015 12.5896 17.7322 12.8568 17.6494L12.9176 17.6315L13.1091 18.0413L13.3239 18.5031L13.1324 18.5639C12.8334 18.6568 12.53 18.7344 12.2232 18.7966C11.9154 18.8598 11.6022 18.9069 11.2837 18.938C10.9651 18.9684 10.6412 18.9845 10.3137 18.9845C9.98618 18.9845 9.66584 18.9684 9.34728 18.938C9.02873 18.9075 8.71733 18.8592 8.40772 18.7966C8.10558 18.7377 7.80686 18.6624 7.5129 18.5711C7.21845 18.4801 6.92876 18.3744 6.64493 18.2543H6.62166L6.60556 18.2436C6.32637 18.1243 6.05494 17.9924 5.79127 17.8481C5.51746 17.7013 5.25438 17.5402 4.99667 17.3702C4.74835 17.2046 4.50937 17.0253 4.28082 16.8333C4.04279 16.6383 3.8173 16.4325 3.60075 16.2177C3.38589 16.0065 3.18276 15.7836 2.99228 15.5502C2.80105 15.316 2.62186 15.0723 2.45538 14.82C2.27992 14.5653 2.11745 14.3019 1.9686 14.0308C1.9167 13.9359 1.86659 13.8393 1.81827 13.7426H11.3391C11.3547 13.9251 11.3907 14.1052 11.4465 14.2795C11.4626 14.3278 11.4787 14.378 11.4984 14.4263L11.6094 14.6983H10.7969V17.4024C11.3123 16.9729 11.7883 16.5416 12.2286 16.1085C12.3664 16.4164 12.5078 16.7242 12.6492 17.032H12.6402ZM1.07378 11.6577L0 7.33752H1.55341L2.04735 9.97187H2.08135L2.63256 7.33752H4.14122L4.7157 9.9486H4.74791L5.22217 7.33752H6.77378L5.7 11.6595H4.01774L3.40926 9.33297H3.36452L2.75783 11.6595L1.07378 11.6577ZM8.00505 11.6577L6.93306 7.33752H8.48468L8.98041 9.97187H9.01441L9.56562 7.33752H11.0743L11.6488 9.9486H11.681L12.1534 7.33752H13.7068L12.6331 11.6595H10.949L10.3423 9.33297H10.2976L9.6891 11.6595L8.00505 11.6577ZM14.9381 11.6577L13.8661 7.33752H15.4177L15.9135 9.97187H15.9457L16.4987 7.33752H18.0073L18.5818 9.9486H18.6122L19.0865 7.33752H20.6399L19.5661 11.6595H17.8821L17.2754 9.33297H17.2306L16.6222 11.6595L14.9381 11.6577ZM20.8654 20.6936C20.8185 20.7391 20.764 20.7761 20.7043 20.8028C20.6448 20.8291 20.5813 20.8454 20.5164 20.8511C20.4421 20.8571 20.3673 20.8486 20.2963 20.826C20.2254 20.8041 20.1597 20.7682 20.103 20.7204L18.5084 19.3675L17.9715 20.7115C17.927 20.8195 17.8725 20.9232 17.8087 21.0211C17.7495 21.1097 17.6798 21.1908 17.6011 21.2627C17.5315 21.3345 17.4464 21.3895 17.3523 21.4234C17.2582 21.4573 17.1575 21.4693 17.0581 21.4584C16.9587 21.4476 16.863 21.4141 16.7785 21.3607C16.6939 21.3072 16.6227 21.2351 16.5703 21.15C16.5204 21.0799 16.4778 21.0049 16.4432 20.9262C15.4822 18.5246 14.1954 16.13 13.2433 13.7229C13.2144 13.6519 13.2052 13.5743 13.2166 13.4984C13.228 13.4225 13.2596 13.3511 13.3081 13.2916C13.3566 13.2321 13.4202 13.1868 13.4922 13.1603C13.5643 13.1339 13.6421 13.1273 13.7176 13.1413C16.0244 13.569 19.0113 14.5426 21.3575 15.1654C22.0859 15.3569 22.204 15.9994 21.6654 16.4969C21.5802 16.5766 21.4866 16.6468 21.3862 16.7063C20.9728 16.9407 20.554 17.211 20.146 17.4597L21.7334 18.8198C21.7901 18.8699 21.8363 18.9308 21.8694 18.9988V19.0095C21.9004 19.0728 21.9186 19.1415 21.9231 19.2118C21.9271 19.283 21.9192 19.3543 21.8998 19.4229C21.8783 19.4925 21.845 19.5579 21.8014 19.6162C21.5131 19.991 21.2042 20.3495 20.8761 20.69L20.8654 20.6936ZM20.4556 20.1656L21.2233 19.2708C20.8851 18.9791 19.4426 17.8552 19.2851 17.5832C19.2424 17.5085 19.2307 17.42 19.2524 17.3367C19.2742 17.2534 19.3277 17.1819 19.4015 17.1376C19.9026 16.8584 20.5504 16.4683 21.0265 16.1497C21.0862 16.1145 21.1426 16.0738 21.1947 16.028C21.2343 15.9926 21.2692 15.9523 21.2985 15.9081L21.32 15.8669L21.277 15.8419C21.2435 15.8269 21.2088 15.815 21.1732 15.8061L14.0343 13.9073L17.0338 20.665C17.0487 20.6978 17.0661 20.7295 17.0857 20.7598L17.1161 20.7992L17.1537 20.7723C17.1934 20.7369 17.2278 20.6959 17.2557 20.6506C17.2925 20.5942 17.3237 20.5342 17.3488 20.4717C17.5743 19.9205 17.8284 19.1688 18.0915 18.6606L18.1237 18.6158C18.1515 18.583 18.1855 18.556 18.2238 18.5364C18.2621 18.5168 18.3039 18.5049 18.3467 18.5014C18.3896 18.4979 18.4328 18.5029 18.4737 18.5161C18.5147 18.5293 18.5526 18.5504 18.5854 18.5782L20.4627 20.1692L20.4556 20.1656ZM9.00009 17.9322C8.42581 17.4465 7.87912 16.9291 7.36257 16.3824C6.86022 15.8541 6.39838 15.2888 5.98097 14.6911H3.53275C3.63297 14.8254 3.73855 14.9542 3.84772 15.0795C3.98374 15.237 4.12691 15.3909 4.27545 15.5394C4.46992 15.7351 4.67155 15.9176 4.88034 16.0871C5.08973 16.2597 5.30775 16.4216 5.53356 16.5721C5.76098 16.7274 5.99634 16.8707 6.23868 17.0016C6.4773 17.134 6.73143 17.2533 7.00107 17.3595H7.01538H7.02612C7.27846 17.4651 7.53617 17.5599 7.79746 17.6405C8.06312 17.7234 8.33317 17.7915 8.60637 17.8445C8.70659 17.8642 8.8086 17.8821 8.90882 17.8982L9.00009 17.9125V17.9322ZM3.52201 4.29513H6.12235C6.53701 3.70456 6.99017 3.14199 7.4789 2.61108C7.98293 2.0596 8.51454 1.53397 9.07168 1.0362L8.93388 1.05589C8.82113 1.07378 8.71017 1.09347 8.601 1.11673C8.32562 1.172 8.05324 1.24129 7.78493 1.32433C7.51716 1.40666 7.25426 1.50405 6.99749 1.61604C6.73381 1.72819 6.48088 1.8475 6.23868 1.97397C5.99648 2.10044 5.75786 2.24242 5.52282 2.39991C5.29702 2.55041 5.079 2.71228 4.86961 2.8849C4.66022 3.05491 4.45978 3.24283 4.26471 3.43253C4.11617 3.58107 3.973 3.73498 3.83699 3.89246C3.72603 4.01953 3.61865 4.15017 3.51664 4.28618L3.52201 4.29513ZM11.5754 1.04336C12.1588 1.56713 12.6879 2.0897 13.1628 2.61108C13.6515 3.14149 14.1041 3.70411 14.5175 4.29513H17.1125C17.0123 4.1627 16.9067 4.03206 16.7975 3.90678C16.6633 3.75108 16.5184 3.59717 16.368 3.44684C16.1736 3.25237 15.9725 3.06983 15.7649 2.89921C15.5556 2.72645 15.3376 2.56457 15.1117 2.41422C14.8862 2.2627 14.6512 2.12072 14.4066 1.98829C14.162 1.85586 13.9079 1.73535 13.6442 1.62678L13.6281 1.61067C13.374 1.50509 13.1163 1.41024 12.855 1.3297C12.5869 1.24736 12.3144 1.17985 12.0389 1.12747C11.9244 1.10421 11.8116 1.08452 11.7024 1.07378L11.5772 1.0541L11.5754 1.04336ZM8.4113 0.187912C8.71912 0.124678 9.03231 0.077551 9.35086 0.0465306C9.66405 0.0161067 9.99334 0 10.3191 0C10.6448 0 10.9669 0.0161067 11.2873 0.0465306C11.6076 0.0769545 11.9172 0.125275 12.2268 0.187912C12.5289 0.247602 12.8276 0.323473 13.1216 0.415196C13.4179 0.50597 13.7094 0.611694 13.995 0.731962H14.0147L14.0308 0.74091C14.31 0.867378 14.5844 1.0022 14.854 1.14537C15.126 1.29391 15.3909 1.45319 15.645 1.62141C15.893 1.78749 16.132 1.96671 16.3609 2.1583C16.5995 2.35278 16.8256 2.55799 17.0391 2.77394C17.2536 2.98559 17.4567 3.20841 17.6476 3.44148C17.8388 3.67561 18.018 3.91932 18.1845 4.17165C18.3635 4.42578 18.5138 4.68706 18.6606 4.9573C18.7125 5.05215 18.7626 5.14879 18.8109 5.24543H1.80932C1.85943 5.14879 1.90954 5.05036 1.96144 4.95551C2.10819 4.68527 2.26747 4.41862 2.43391 4.17165C2.60034 3.92468 2.77931 3.68129 2.9708 3.45579C3.16229 3.2303 3.37168 2.99049 3.58644 2.77573C3.79855 2.56178 4.02134 2.3587 4.25397 2.16725C4.48883 1.97617 4.73313 1.79698 4.98593 1.63036C5.23827 1.4514 5.50135 1.30107 5.76979 1.15611C6.03824 1.01115 6.33353 0.867975 6.62166 0.746279C6.91381 0.621555 7.21252 0.512823 7.51648 0.420565C7.8107 0.328176 8.10934 0.250529 8.4113 0.187912ZM10.7969 1.63036V4.29513H13.3435C12.9865 3.83444 12.606 3.39241 12.2035 2.9708C11.7776 2.52578 11.3087 2.07717 10.7969 1.62499V1.63036ZM9.84301 17.4024V14.6911H7.15855C7.52851 15.166 7.92715 15.6179 8.35224 16.0441C8.82607 16.5216 9.32362 16.975 9.84301 17.4024ZM9.84301 4.29513V1.63036C9.33118 2.08135 8.86229 2.52995 8.43636 2.97617C8.03405 3.39604 7.65355 3.83627 7.29636 4.29513H9.84301Z" fill="white" />
                            </svg>
                        </div>
                    </div>
                    <div class="support-content">
                        <h3>Visit Developer's Website</h3>
                        <p>Learn more about the developer and their projects.</p>
                        <a href="https://developvi.com/" target="_blank" class="support-link">Visit Website</a>
                    </div>
                </div>
                <div class="support-item">
                    <div class="icon-container">
                        <div class="icon-box">
                            <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.62617 0.169223C2.72895 0.628529 1.04742 2.1293 0.298029 4.03223C0.0403552 4.68658 0.00486338 4.93217 0.000358213 6.09362C-0.00414695 7.24771 0.0307954 7.50956 0.280667 8.19259C0.437688 8.62179 0.757226 9.26075 0.990725 9.61248C1.2273 9.96894 3.42175 12.2743 5.94838 14.8207L10.4817 19.3893L12.0396 17.8346L13.5974 16.2799L13.1539 15.7469C12.0775 14.4532 11.6361 12.7688 11.9633 11.2031C12.3148 9.52117 13.3189 8.13644 14.7297 7.38814C16.4757 6.46206 18.3065 6.47403 20.0344 7.42275C20.4193 7.63417 20.7574 7.78394 20.7856 7.7557C20.9054 7.63604 21.0324 6.81159 21.0333 6.14856C21.0388 2.24006 17.2856 -0.736206 13.4821 0.160651C12.6729 0.351407 11.7194 0.812582 11.0021 1.36012L10.4889 1.75185L9.97578 1.36012C8.41424 0.168233 6.44307 -0.270635 4.62617 0.169223ZM16.0851 7.72119C14.3196 8.21874 12.8771 9.97729 12.7228 11.8201C12.4671 14.8756 15.2954 17.3944 18.2751 16.765C20.7178 16.249 22.322 13.9586 21.9452 11.5248C21.7073 9.98751 20.7556 8.70804 19.327 8.00469C18.6796 7.68603 18.4631 7.63691 17.5875 7.6101C17.0073 7.59241 16.3765 7.639 16.0851 7.72119ZM16.972 9.49996C16.972 9.81027 16.9299 9.88455 16.754 9.88455C16.4495 9.88455 15.8868 10.4237 15.7792 10.8185C15.5729 11.5762 15.9853 12.1508 17.024 12.5531C17.3749 12.6891 17.7328 12.907 17.8195 13.0375C17.9608 13.2505 17.9537 13.2981 17.7492 13.5026C17.4843 13.7675 16.9113 13.7972 16.2983 13.5782L15.8993 13.4357L15.7811 13.821C15.716 14.0328 15.6862 14.2441 15.7149 14.2905C15.7436 14.3369 16.0381 14.4354 16.3695 14.5096C16.9524 14.64 16.972 14.6564 16.972 15.0115C16.972 15.3462 17.0011 15.3787 17.3016 15.3787C17.6042 15.3787 17.6313 15.3476 17.6313 14.9992C17.6313 14.6588 17.6794 14.5983 18.0983 14.4108C18.7235 14.1311 18.9656 13.8333 19.0275 13.2679C19.1036 12.5735 18.753 12.1125 17.8679 11.7432C17.037 11.3965 16.8138 11.1984 16.9108 10.8934C17.0043 10.5986 17.4938 10.4984 18.0756 10.655C18.5987 10.7959 18.7004 10.7377 18.7501 10.2691C18.7833 9.95576 18.7592 9.93455 18.2631 9.83862C17.787 9.74665 17.7411 9.7105 17.7411 9.42656C17.7411 9.14417 17.7055 9.11538 17.3566 9.11538C16.9903 9.11538 16.972 9.13373 16.972 9.49996Z" fill="white" />
                            </svg>
                        </div>
                    </div>
                    <div class="support-content">
                        <h3>Support Us with a Donation</h3>
                        <p>Your contributions help us keep building awesome plugins.</p>
                        <a href="https://www.paypal.com/paypalme/elsherifsoft" target="_blank" class="support-link">Donate Now</a>
                    </div>
                </div>
            </div>
        </div>
 </div> <div class="modalPopUp hidden"></div>
