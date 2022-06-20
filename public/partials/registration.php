<?php
global $compRegAlerts;
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
<style>
    h1.page-title {
        text-align: center;
        color: #fff;
    }
</style>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="comp_form_wrapper">
  <div class="comp_form_container">
    <div class="title_container">
      <h2>Registration Form</h2>
      <?php
      $success = null;
      if(empty($compRegAlerts)){
        $compRegAlerts = get_transient( 'user_created_success' );
        if(!empty($compRegAlerts)){
          $success = true;
        }
      }
      
      if(!empty($compRegAlerts)){
        ?>
        <div class="comp_errors <?php echo (($success) ? 'success' : '') ?>"><i class="fas fa-exclamation-circle"></i>
          <p><?php echo $compRegAlerts ?></p>
        </div>
        <?php
      }
      ?>
    </div>
    <div class="comp_row">
      <div class="form-wrapper">
        <form id="comp__registration_form" method="post" enctype="multipart/form-data">

          <div id="name_row" class="comp_row">
            <div class="col_half">
              <div class="input_field"> <span><i class="fas fa-user-tag"></i></span>
                <input type="text" required name="comp_first_name" placeholder="first name" value="<?php echo ((isset($_POST['comp_first_name'])) ? $_POST['comp_first_name'] : '') ?>" />
              </div>
            </div>
            <div class="col_half">
              <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                <input type="text" name="comp_last_name" placeholder="last name" value="<?php echo ((isset($_POST['comp_last_name'])) ? $_POST['comp_last_name'] : '') ?>" />
              </div>
            </div>
          </div>

          <div class="input_field noned" id="team_row"> <span><i class="fas fa-graduation-cap"></i></span>
            <input type="text" name="school_team_name" placeholder="school team name" value="<?php echo ((isset($_POST['school_team_name'])) ? $_POST['school_team_name'] : '') ?>">
          </div>

          <div class="input_field"> <span><i aria-hidden="true" class="fa fa-envelope"></i></span>
            <input type="email" required oninvalid="setCustomValidity('You must have to add your email.')" oninput="setCustomValidity('')" name="comp_reg_email" placeholder="Email" value="<?php echo ((isset($_POST['comp_reg_email'])) ? $_POST['comp_reg_email'] : '') ?>" />
          </div>

          <div class="input_field"> <span><i class="fas fa-key"></i></span>
            <input type="password" required oninvalid="setCustomValidity('You must have to add a password.')" oninput="setCustomValidity('')" name="comp_password" placeholder="password" value="<?php echo ((isset($_POST['comp_password'])) ? $_POST['comp_password'] : '') ?>" />
          </div>

          <div class="input_field"> <span><i class="fas fa-key"></i></span>
            <input type="password" required oninvalid="setCustomValidity('Type your confirm password.')" name="comp_conf_password" placeholder="confirm password"/>
          </div>
          
          <div class="input_field select_option"> <span><i class="fas fa-users"></i></span>
            <select id="role_select" name="comp_role">
              <?php $selected = ((isset($_POST['comp_role'])) ? $_POST['comp_role'] : '') ?>
              <option <?php echo (($selected == 'student') ? 'selected': '') ?> value="student">Student</option>
              <option <?php echo (($selected == 'school') ? 'selected': '') ?> value="school">School</option>
            </select>
            <div class="select_arrow"></div>
          </div>
          
          <?php wp_nonce_field( 'comp_nonce', 'comp_reg_nonce' ) ?>
          <input class="button" type="submit" name="comp_registration" value="Register" />
        </form>
      </div>
    </div>
  </div>
</div>