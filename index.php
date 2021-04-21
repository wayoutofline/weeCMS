<?php
/**
 * WeeCMS
 *
 * @version 1.0
 * @author Peter Oberlaender (peteee) aka W00L | Way out of Line
 * @link http://wayoutofline.net
 * @license http://opensource.org/licenses/MIT MIT License
 */

// load php-login class
require_once("classes/Login.php");
// the login object will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();


// C M S here
require_once('classes/Pages.php');
$page = new Pages();
$page_id = @$_GET['page_id'];

// Token security...
$_form_token = md5(uniqid(rand(), TRUE));
define("FORMTOKEN", $_form_token);

//$_form_token = FORMTOKEN;
$_SESSION['form_token'] = $_form_token;
$_SESSION['form_token_time'] = time();


include('views/_header.php');

// show the registration form
if (isset($_GET['register']) && ! $login->isRegistrationSuccessful() &&
  (ALLOW_USER_REGISTRATION || (ALLOW_ADMIN_TO_REGISTER_NEW_USER && $_SESSION['user_access_level'] == 255))) {
  include('views/register.php');

// show the request-a-password-reset or type-your-new-password form
} else if (isset($_GET['password_reset']) && ! $login->isPasswordResetSuccessful()) {
  if (isset($_REQUEST['user_name']) && isset($_REQUEST['verification_code']) && $login->isPasswordResetLinkValid()) {
    // reset link is correct: ask for the new password
    include("views/password_reset.php");
  } else {
    // no data from a password-reset-mail has been provided,
    // we show the request-a-password-reset form
    include('views/password_reset_request.php');
  }

// show the edit form to modify username, email or password
} else if (isset($_GET['edit']) && $login->isUserLoggedIn()) {
    include('views/edit.php');
} else if (isset($_GET['edit-page']) && $login->isUserLoggedIn()) {

  // if(isset($_SESSION['user_id'])) //&& $_SESSION['user_id'] == 1
    include("views/editpage.php");
  // else
  //   header("location: /");
    //include("views/logged_in.php");

} else if (isset($_GET['new-page']) && $login->isUserLoggedIn()) {
    include('views/newpage.php');
// the user is logged in, we show informations about the current user
} else if ($login->isUserLoggedIn()) {
  include('views/logged_in.php');
} else if (isset($_GET['cms']) && !$login->isUserLoggedIn()) {
  include('views/cms.php');
// the user is not logged in, we show the login form
} else {
  // uncomment if you need a global login protection...
  //include('views/login.php');
}

include('views/_footer.php');
