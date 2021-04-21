<?php
    // if(isset($_SESSION['user_id'])) {
    //   if($_SESSION['user_id'] == 1 && isset($page) &&
    //     (isset($_SESSION['user_access_level']) && $_SESSION['user_access_level']== 9)) {
    //     if (!preg_match("/edit-page/i", $actual_link) && ($page_id != 1)) {
    //       // display stuff when NOT in edit mode...
    //     }
    //   }
    // }
    if(!isset($editMode)) { //&& $page_id!=1
      if(isset($_COOKIE['LANG']) && (string)$_COOKIE['LANG']=='de') {
        if(isset($page)) echo '<h1>'.$page->getTitleDE().'</h1>';
      } else {
        if(isset($page)) echo '<h1>'.$page->getTitle().'</h1>';
      }
    }
    if(!isset($editMode)) {
      if(isset($_COOKIE['LANG']) && (string)$_COOKIE['LANG']=='de') {
        if(isset($page)) echo $page->getContentDE();
      } else {
        if(isset($page)) echo $page->getContent();
      }
    }
?>

          <br />
        </div>
        <?php if($donotshow) : ?>

        <div class="large-3 medium-4 cell" data-sticky-container>
          <div class="sticky" data-sticky data-top-anchor="wee-cms-main:top" data-btm-anchor="footer:top">

            <?php if($login->isUserLoggedIn()) :?>

            <div class="callout">
              <fieldset style="font-size:0.8em">
              <legend><?php echo WORDING_EDIT_USER_DATA; ?></legend>
              <p><?php echo WORDING_YOU_ARE_LOGGED_IN_AS . '<b>' . $_SESSION['user_name']; ?></b><br />(<?=$_SESSION['user_email']?>)</p><hr/>

              <!-- <p>$_SESSION['user_id'] = <?php echo $_SESSION['user_id']; ?></p>
              <p>$_SESSION['user_name'] = <?php echo $_SESSION['user_name']; ?></p>
              <p>$_SESSION['user_email'] = <?php echo $_SESSION['user_email']; ?></p>
              <p>$_SESSION['user_access_level'] = <?php echo $_SESSION['user_access_level']; ?></p>
              <p>$_SESSION['user_logged_in'] = <?php echo $_SESSION['user_logged_in']; ?></p><hr/> -->

              <p><?php echo WORDING_PROFILE_PICTURE . '<br/><img src="' . $login->getGravatarImageUrl() ; ?>" /></p>
              </fieldset><br/>
              <a href="?logout"><?php echo WORDING_LOGOUT; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="?edit"><?php echo WORDING_EDIT_USER_DATA; ?></a>
              <?php
                //echo (ALLOW_ADMIN_TO_REGISTER_NEW_USER && $_SESSION['user_access_level'] == 9 ? '<br/><a href="?register">'. WORDING_REGISTER_NEW_ACCOUNT .'</a>' : '');
              ?>

            </div>

            <?php endif;
            if(isset($page) && ((isset($_SESSION['user_access_level']) && $_SESSION['user_access_level']==9))) {
                 print('
             <br />
             <h2><strong>CMS</strong></h2>
             <a href="'.$slash.'?edit-page&page_id='.$page->getId().'" class="radius button warning">Edit page</a>
             <a href="'.$slash.'?new-page" class="radius button success">New page</a>
             <form method="post" action="" id="ajax-contact-form-39873245">
               <input type="hidden" name="form_token" value="'.$_form_token.'" />
               <input type="hidden" name="del_pid" value="'.$page->getId().'">
               <input style="width:220px" class="radius button alert" type="submit" value="Delete page" name="submit_delthispage" onClick="return confirm(\'Are you sure you want to delete this page?\')"/>
             </form>
               ');
               $i = 0;
               echo('Pages:<br /><ul>');
               foreach($page->getPage_links()[0] as $page_link) {
                 print '<li><a href="'.$slash.'index.php?page_id='. $page_link . '">Page ' . $page_link .' | '. $page->getPage_links()[1][$i] .'</a></li>';
                 $i++;
               }
               echo('</ul><br />');
            }
            ?>

          </div>
        </div>

        <?php endif; ?>

      </div>

    </div>
    <br / >

    <footer id="footer">
      <div class="grid-x grid-padding-x">
        <div class="large-12 cell">
          <p>
            <br />
            <span>Copyright © 2017 <strong>WeeCMS</strong>
          </p>
          <!-- <p style="color:#000">Made with<a title="Linux" style="text-decoration:none"/><img width="14" style="margin-left: -8px;" alt="By Larry Ewing, Simon Budig, Garrett LeSage [Copyrighted free use or CC0], via Wikimedia Commons" src="/img/Tux.svg.png"/></a> &amp; <span style="font-size:20px;color:#F00">&#9829;</span> -->
          <a href="?language=de">de</a>
          <a href="?language=en">en</a>
          <!-- <a href="?language=fr">fr</a> -->
          <!-- <a href="<?=DIR?>?language=ru">ru</a>  -->
          </p><br />

        </div>
      </div>
    </footer>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.min.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>
