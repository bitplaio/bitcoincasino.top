<?php
function poka_cr(&$fields, &$errors) {

      // Check args and replace if necessary
      if (!is_array($fields))     $fields = array();
      if (!is_wp_error($errors))  $errors = new WP_Error;

      // Check for form submit
      if (isset($_POST['submit'])) {

        // Get fields from submitted form
        $fields = poka_cr_get_fields();

        // Validate fields and produce errors
        if (poka_cr_validate($fields, $errors)) {

          // If successful, register user
          wp_insert_user($fields);

          // And display a message
          echo '<div class="success"><h5>'.__('Registration complete.','poka').'</h5> '.__('Registration confirmation will be emailed to you in order to login.','poka').'</div>';

            $email_content = '<strong>'.__('Your username: ','poka').'</strong>';
            $email_content .= $fields['user_login'];
            $email_content .= '<br/><strong>'.__('Your password: ','poka').'</strong>';
            $email_content .= $fields['user_pass'];

            $headers = array('Content-Type: text/html; charset=UTF-8');

            wp_mail( $fields['user_email'], __('User registration account','poka'), $email_content, $headers );

          // Clear field data
          $fields = array();
        }
      }

      // Santitize fields
      poka_cr_sanitize($fields);

      // Generate form
      poka_cr_display_form($fields, $errors);
}

function poka_cr_sanitize(&$fields) {
      $fields['user_login']   =  isset($fields['user_login'])  ? sanitize_user($fields['user_login']) : '';
      $fields['user_pass']    =  isset($fields['user_pass'])   ? esc_attr($fields['user_pass']) : '';
      $fields['user_email']   =  isset($fields['user_email'])  ? sanitize_email($fields['user_email']) : '';
      $fields['user_url']     =  isset($fields['user_url'])    ? esc_url($fields['user_url']) : '';
      $fields['first_name']   =  isset($fields['first_name'])  ? sanitize_text_field($fields['first_name']) : '';
      $fields['last_name']    =  isset($fields['last_name'])   ? sanitize_text_field($fields['last_name']) : '';
      $fields['nickname']     =  isset($fields['nickname'])    ? sanitize_text_field($fields['nickname']) : '';
      $fields['description']  =  isset($fields['description']) ? esc_textarea($fields['description']) : '';
}

function poka_cr_display_form($fields = array(), $errors = null) {

      // Check for wp error obj and see if it has any errors
      if (is_wp_error($errors) && count($errors->get_error_messages()) > 0) {

        // Display errors
        ?><ul class="errors"><?php
        foreach ($errors->get_error_messages() as $key => $val) {
          ?><li>
            <?php echo $val; ?>
          </li><?php
        }
        ?></ul><?php
      }

      // Disaply form

      ?><form action="#" method="post">
        <div>
          <label for="user_login"><?php _e('Username','poka'); ?> <strong>*</strong></label>
          <input type="text" name="user_login" value="<?php echo (isset($fields['user_login']) ? $fields['user_login'] : '') ?>">
        </div>

        <div>
          <label for="user_email"><?php _e('Email','poka'); ?> <strong>*</strong></label>
          <input type="text" name="user_email" value="<?php echo (isset($fields['user_email']) ? $fields['user_email'] : '') ?>">
        </div>
        <?php /*
        <div>
          <label for="website">Website</label>
          <input type="text" name="user_url" value="<?php echo (isset($fields['user_url']) ? $fields['user_url'] : '') ?>">
        </div>

        <div>
          <label for="firstname">First Name</label>
          <input type="text" name="first_name" value="<?php echo (isset($fields['first_name']) ? $fields['first_name'] : '') ?>">
        </div>

        <div>
          <label for="website">Last Name</label>
          <input type="text" name="last_name" value="<?php echo (isset($fields['last_name']) ? $fields['last_name'] : '') ?>">
        </div>

        <div>
          <label for="nickname">Nickname</label>
          <input type="text" name="nickname" value="<?php echo (isset($fields['nickname']) ? $fields['nickname'] : '') ?>">
        </div>
        */?>
        <input type="submit" name="submit" value="<?php _e('Register','poka'); ?>">
        </form><?php
}

function poka_cr_get_fields() {
      return array(
        'user_login'   =>  isset($_POST['user_login'])   ?  $_POST['user_login']   :  '',
        'user_pass'    =>  isset($_POST['user_pass'])    ?  $_POST['user_pass']    :  wp_generate_password(),
        'user_email'   =>  isset($_POST['user_email'])   ?  $_POST['user_email']        :  '',
        'user_url'     =>  isset($_POST['user_url'])     ?  $_POST['user_url']     :  '',
        'first_name'   =>  isset($_POST['first_name'])   ?  $_POST['first_name']        :  '',
        'last_name'    =>  isset($_POST['last_name'])    ?  $_POST['last_name']        :  '',
        'nickname'     =>  isset($_POST['nickname'])     ?  $_POST['nickname']     :  '',
        'description'  =>  isset($_POST['description'])  ?  $_POST['description']  :  ''
      );
}

function poka_cr_validate(&$fields, &$errors) {

      // Make sure there is a proper wp error obj
      // If not, make one
      if (!is_wp_error($errors))  $errors = new WP_Error;

      // Validate form data

      if (empty($fields['user_login']) || empty($fields['user_email'])) {
        $errors->add('field', __('Required form field is missing','poka'));
      }

      if (strlen($fields['user_login']) < 4) {
        $errors->add('username_length',  __('Username too short. At least 4 characters is required','poka'));
      }

      if (username_exists($fields['user_login']))
        $errors->add('user_name',  __('Sorry, that username already exists!','poka'));

      if (!validate_username($fields['user_login'])) {
        $errors->add('username_invalid',  __('Sorry, the username you entered is not valid','poka'));
      }

      /*if (strlen($fields['user_pass']) < 5) {
        $errors->add('user_pass', 'Password length must be greater than 5');
      }*/

      if (!is_email($fields['user_email'])) {
        $errors->add('email_invalid',  __('Email is not valid','poka'));
      }

      if (email_exists($fields['user_email'])) {
        $errors->add('email',  __('Email Already in use','poka'));
      }

      if (!empty($fields['user_url'])) {
        if (!filter_var($fields['user_url'], FILTER_VALIDATE_URL)) {
          $errors->add('user_url',  __('Website is not a valid URL','poka'));
        }
      }

      // If errors were produced, fail
      if (count($errors->get_error_messages()) > 0) {
        return false;
      }

      // Else, success!
      return true;
}



///////////////
// SHORTCODE //
///////////////
function poka_cr_cb() {
    $fields = array();
    $errors = new WP_Error();

    // Buffer output
    ob_start();

    // Custom registration, go!
    poka_cr($fields, $errors);

    // Return buffer
    return ob_get_clean();
}
add_shortcode('poka_registration', 'poka_cr_cb');
