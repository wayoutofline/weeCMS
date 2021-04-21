<?php
// Page not submitted. Echo the form
if (!isset($_POST['submit_page_change']) &&
    (isset($_SESSION['user_access_level']) && $_SESSION['user_access_level']== 9) &&
    (isset($_SESSION['user_id']) )//&& $_SESSION['user_id'] == 1
  ) {
	?>

	<script type="text/javascript" src="js/nicEdit.js"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
      new nicEditor({fullPanel : true, maxHeight : 500}).panelInstance('area2');
      new nicEditor({fullPanel : true, maxHeight : 500}).panelInstance('area3');
    });
    //bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  </script>

  <?php //echo $_SERVER['PHP_SELF']; ?>
  <div class="forms">
    <form method="post" action="index.php">
      <input type="hidden" name="form_token" value="<?=$_form_token;?>" />
      <input type="hidden" name="page_id" value="<?php echo $page->getId() ?>" />
      <strong>Page title:</strong><br />
      <input type="text" name="page_title" value="<?php echo $page->getTitle() ?>"><br /><br />
      <strong>Page content:</strong><br />
      <textarea rows="10" cols="50" id="area2" name="page_content" style="width: 100%;" wrap="physical"><?php echo $page->getContent() ?></textarea><br /><br />
      <br />
      <strong>Page title DE:</strong><br />
      <input type="text" name="page_title_de" value="<?php echo $page->getTitleDE() ?>"><br /><br />
      <strong>Page content DE:</strong><br />
      <textarea rows="10" cols="50" id="area3" name="page_content_de" style="width: 100%;" wrap="physical"><?php echo $page->getContentDE() ?></textarea><br /><br />
      <br />
      <strong>Keywords:</strong><br />
      <input type="text" name="page_keywords" value="<?php echo $page->getKeywords() ?>"><br /><br />
      <strong>Description:</strong><br />
      <textarea rows="2" cols="50" name="page_description" style="width:245px;height:30px" wrap="physical"><?php echo $page->getDescription() ?></textarea><br /><br />
      <br />
      <strong>Keywords DE:</strong><br />
      <input type="text" name="page_keywords_de" value="<?php echo $page->getKeywordsDE() ?>"><br /><br />
      <strong>Description DE:</strong><br />
      <textarea rows="2" cols="50" name="page_description_de" style="width:245px;height:30px" wrap="physical"><?php echo $page->getDescriptionDE() ?></textarea><br /><br />
      <br />
      <strong>Page access:</strong><br />
      <select name="page_user_level">
        <option value="<?php echo $page->getUser_level () ?>"><?php echo $page->getUser_level () ?></option>
        <option value="0">0+ (Everybody)</option>
        <option value="1">1+ (Registered users)</option>
        <option value="5">5+ (Editors)</option>
        <option value="9">9+ (Administrators)</option>
      </select>
      <br /><br />
      <input class="radius button" type="submit" value="Save page!" name="submit_page_change" />
    </form>
  </div>
<?php
}

$editMode = true;

?>
