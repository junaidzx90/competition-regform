<?php
global $comploginAlerts;
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Comp_Form
 * @subpackage Comp_Form/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="comp_form_wrapper">
    <div class="comp_form_container">
        <div class="title_container">
            <h2>Login Form</h2>
            <?php
            if(!empty($comploginAlerts)){
                ?>
                <div class="comp_errors"><i class="fas fa-exclamation-circle"></i>
                <p><?php echo $comploginAlerts ?></p>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="comp_row">
            <div class="form-wrapper">
                <form id="comp__login_form" method="post" enctype="multipart/form-data">
                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-envelope"></i></span>
                        <input type="text" name="comp_login_email" placeholder="Email OR Username" />
                    </div>
                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-key"></i></span>
                        <input type="password" name="comp_login_password" placeholder="Password" />
                    </div>
                    <div class="input_field checkbox_option">
                        <input type="checkbox" name="comp_login_remember" id="cb1">
                        <label for="cb1">Remember me</label>
                    </div>
                    <?php wp_nonce_field( 'comp_nonce', 'comp_login_nonce' ) ?>
                    <input class="button" type="submit" name="comp_login" value="Login" />
                </form>
            </div>
        </div>
    </div>
</div>