<?php
if(isset($_COOKIE['LANG'])) $headlang = (string)$_COOKIE['LANG']; else $headlang = 'en';

if(isset($_COOKIE['LANG']) && (string)$_COOKIE['LANG']=='de') {
  if(isset($page)) $kw = $page->getKeywordsDE(); else $kw = '';
  if(isset($page)) $dsc = $page->getDescriptionDE(); else $dsc = '';
} else {
  if(isset($page)) $kw = $page->getKeywords(); else $kw = '';
  if(isset($page)) $dsc = $page->getDescription(); else $dsc = '';
}

("$_SERVER[HTTP_HOST]" == 'localhost') ? ($slash = "./") : ($slash = "/");
// if("$_SERVER[HTTP_HOST]" == '192.168.1.107') $slash = "./";
// if("$_SERVER[HTTP_HOST]" == '192.168.0.107') $slash = "./";

//$_form_token = $_SESSION['form_token'];

$usa = $_SERVER['HTTP_USER_AGENT'];

$page_id = @$_GET['page_id'];
if (is_null($page_id)) {
  // assume it's home page
  $page_id = 1;
}

?>
<!doctype html>
<html class="no-js" lang="<?=$headlang?>" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!--
      Design & Code by Way out of Line
                                                        `                 ```    `
                                                        d-              .yys/   -d`
      `s`            .+oo+.              :o+-           My+`      `oo/. /N      :M`               `/oo+:`
      .M-   s/   :y +m/- /m/    .h`   /o `-:ds y:    /o Mo-`   `h. .-om-/N``    :M`   o/ `:ssso- .ds- :hy
      .M-   ds   +N hy    od    /M`   +m`   +N ds    yy M:      N/   `m+/Mso    :M`   hs yh-`./m//N`   .d`
      `ms///mo`//yh -ds+: `hy+/odM`   `yy+/od/ -ds/+yh. dy//    /do/+yy`/N`     .No/- hs N/    yy`yy+/
       `:::::..:::`   -::   -:::oN      .::-`    -::-   `:::     `-::.  .:       .::: -  :`    .-  .::
                             -oyh:
                             .-.
    -->
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if(isset($page) && ($page->getId() != 1)) echo 'WeeCMS | '.$page->getTitle(); else echo 'WeeCMS'?></title>
    <meta name="keywords" content="<?php print htmlspecialchars($kw); ?>" />
    <meta name="description" content="<?php print htmlspecialchars($dsc); ?>" />
    <link rel="stylesheet" href="css/foundation.min.css">
    <link rel="stylesheet" href="css/app.css">
  </head>
  <body>

    <div class="top-bar">
      <div class="top-bar-left">
        <ul class="menu">
          <li class="menu-text"><img id="wee-logo" src="img/weeCMS-logo-L.png"></li>
        </ul>
      </div>
      <div class="top-bar-right">
        <ul class="menu">
          <?php
          // show WeeCMS navi ...
          // Or use static html: <li><a href="./">Start</a></li> etc...
          $i = 0;
          foreach($page->getPage_links()[0] as $page_link) {
            // exclude pages like so:
            if($page_link==3 || $page_link==4) {
              // do nothing
            } else {
              print '<li><a href="'.$slash.'index.php?page_id='. $page_link . '">'. $page->getPage_links()[1][$i] .'</a></li>';
            }
            $i++;
          }
          ?>

        </ul>
      </div>
    </div>
    <div class="callout small primary">
      <div class="row column text-center">
        <h1>WeeCMS</h1>
      </div>
    </div>

    <div class="grid-container" id="wee-cms-content">
      <div class="grid-x grid-padding-x">
        <div class="large-12 cell">
          <h2>///</h2>
        </div>
      </div>

      <div class="grid-x grid-padding-x">
        <?php
          $donotshow = false;
          $actual_link = "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
          //$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
          if(
            !preg_match('#edit#i', $actual_link) &&
            !preg_match('#create-table#i', $actual_link) &&
            !preg_match('#tables#i', $actual_link) &&
            !preg_match('#edit-person#i', $actual_link)) {
            $donotshow = ($login->isUserLoggedIn()) ? true : false;
            ?>
        <div class="large-9 medium-8 cell" id="wee-cms-main">
        <?php } else { ?>
        <div class="large-12 medium-12 cell" id="wee-cms-main">
        <?php } ?>

        <?php
        // show potential errors / feedback (from login object)
        // <div class="callout secondary"> via Foundation etc.
        $errHTMLprefix = '<div class="callout symbol_error alert">';
        $msgHTMLprefix = '<div class="callout symbol_message success">';
        $HTMLsuffix = '</div><br />';

        if (isset($login)) {
          foreach ($login->errors as $error) {
            echo $errHTMLprefix.$error.$HTMLsuffix;
          }
          foreach ($login->messages as $message) {
            echo $msgHTMLprefix.$message.$HTMLsuffix;
          }
        }
        if (isset($page)) {
          if ($page->errors) {
            foreach ($page->errors as $error) {
              echo $errHTMLprefix.$error.$HTMLsuffix;
            }
          }
          if ($page->messages) {
            foreach ($page->messages as $message) {
              echo $msgHTMLprefix.$message.$HTMLsuffix;
            }
          }
        }
        ?>
