<?php
// Turn off all error reporting
#error_reporting(0);

/**
 * Handles the user pages
 * @author P3t3333
 * @link http://www.wayoutofline.net
 * @license http://opensource.org/licenses/MIT MIT License
 */
class Pages {
  /**
   * @var object $db_connection The database connection
   */
  private $db_connection            = null;
  /**
   * @var bool success state of posts
   */
  //public  $posts_successful  = false;
  /**
   * @var bool success state of verification
   */
  //public  $verification_successful  = false;

  /**
   * @var array collection of error messages
   */
  public  $errors                   = array();

  /**
   * @var array collection of success / neutral messages
   */
  public  $messages                 = array();

  /**
   * @var page id
   */
  public $id;

  /**
   * @var Page title
   */
  public $title;
  public $title_de;

  /**
   * @var Page content
   */
  public $content;
  public $content_de;

  /**
   * SEO Stuff
   */
  public $keywords;
  public $keywords_de;
  public $description;
  public $description_de;

  /**
   * @var User level required to view the page
   */
  public $user_level;

  public $page_link;
  public $page_titles = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct() {
      @session_start();
      //require_once('config/config.php');

      if(!isset($_GET['logout'])) {
        $token_age = time() - $_SESSION['form_token_time'];
        $token_expire = 60*10;//10min
      }

      $page_id = @$_GET['page_id'];
      if (is_null($page_id)) {
        // assume it's home page
        $page_id = 1;
      }
      $this->getPageData($page_id);

     if ((isset($_SESSION['form_token']) && isset($_POST['form_token'])) && $_POST['form_token'] == $_SESSION['form_token'] && ($token_age <= $token_expire)) {
        if (isset($_POST["submit_new_page"])) {
          $page_title           = $_POST['page_title'];
          $page_content         = $_POST['page_content'];
          $page_title_de        = $_POST['page_title_de'];
          $page_content_de      = $_POST['page_content_de'];
          $page_keywords        = $_POST['page_keywords'];
          $page_description     = $_POST['page_description'];
          $page_keywords_de     = $_POST['page_keywords_de'];
          $page_description_de  = $_POST['page_description_de'];
          $page_user_level      = $_POST['page_user_level'];
          // Check content and title are not empty
          if($page_title == '' && $page_title_de == '') {
            $this->errors[] = MESSAGE_PAGETITLE_EMPTY;
            //die ("Page_title empty!");
          } elseif ($page_content == '' && $page_content_de == '') {
            //die ("Page_content empty!");
            $this->errors[] = MESSAGE_PAGECONTENT_EMPTY;
          } else
            $this->newPage(
              $_POST['page_title'],
              $_POST['page_content'],
              $_POST['page_title_de'],
              $_POST['page_content_de'],
              $_POST['page_keywords'],
              $_POST['page_description'],
              $_POST['page_keywords_de'],
              $_POST['page_description_de'],
              $_POST['page_user_level']);
        }

        if (isset($_POST["submit_page_change"])) {
          $page_title           = $_POST['page_title'];
          $page_content         = $_POST['page_content'];
          $page_title_de        = $_POST['page_title_de'];
          $page_content_de      = $_POST['page_content_de'];
          $page_keywords        = $_POST['page_keywords'];
          $page_description     = $_POST['page_description'];
          $page_keywords_de     = $_POST['page_keywords_de'];
          $page_description_de  = $_POST['page_description_de'];
          $page_user_level      = $_POST['page_user_level'];
          // Check content and title are not empty
          if($page_title == '' && $page_title_de == '') {
            $this->errors[] = MESSAGE_PAGETITLE_EMPTY;
            //die ("Page_title empty!");
          } elseif ($page_content == '' && $page_content_de == '') {
            //die ("Page_content empty!");
            $this->errors[] = MESSAGE_PAGECONTENT_EMPTY;
          } else
              $this->editPage(
                $_POST['page_title'],
                $_POST['page_content'],
                $_POST['page_title_de'],
                $_POST['page_content_de'],
                $_POST['page_keywords'],
                $_POST['page_description'],
                $_POST['page_keywords_de'],
                $_POST['page_description_de'],
                $_POST['page_user_level'],
                $_POST['page_id']);
        }
        if (isset($_POST["submit_delthispage"])) {
          if($_POST['del_pid'] != 1)
            $this->deletePage($_POST['del_pid']);
        }
     } else if ((isset($_SESSION['form_token']) && isset($_POST['form_token'])) && $_POST['form_token'] == $_SESSION['form_token'])
       $this->errors[] = "Page expired due to inactivity. Please try again.";
    }

    /**
     * Checks if database connection is opened and open it if not
     */
    private function databaseConnection() {
        // connection already opened
        if ($this->db_connection != null) {
            return true;
        } else {
            // create a database connection, using the constants from config/config.php
            try {
                // Generate a database connection, using the PDO connector
                // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
                // Also important: We include the charset, as leaving it out seems to be a security issue:
                // @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
                // "Adding the charset to the DSN is very important for security reasons,
                // most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
                $this->db_connection = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
                return true;
            // If an error is catched, database connection failed
            } catch (PDOException $e) {
                $this->errors[] = MESSAGE_DATABASE_ERROR;
                return false;
            }
        }
    }

    private function getPageData($page_id) {
      /////////////////// SELECT ///////////////////////////////////////////////////////////////////////////
      if ($this->databaseConnection()) {
        //ORDER BY id ASC
        $Cmnd = "SELECT *
          FROM uICxZ0_WeeCMS_pages
          WHERE id= :page_id
          LIMIT 1
          ";
        $stmt = $this->db_connection->prepare($Cmnd);
        $stmt->execute(
          array(
            ':page_id' => $page_id
          )
        );
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
      $thispage = 0;
      foreach($rs as $rsult) {
        $thispage = $rsult["id"];

        // Result found, fill vars
        $this->id         = $page_id;
        $this->title      = $rsult["title"];
        $this->content    = $rsult["content"];

        $this->title_de      = $rsult["title_de"];
        $this->content_de    = $rsult["content_de"];

        $this->keywords       = $rsult["keywords"];
        $this->description    = $rsult["description"];

        $this->keywords_de        = $rsult["keywords_de"];
        $this->description_de     = $rsult["description_de"];

        $this->user_level = $rsult["access_level"];

      }
      if ($thispage == 0) {
        // No page found, show a 404 error
        header ("Location: 404.php");
      }
    }

    /**
     * Returns $id.
     * @see Page::$id
     */
    public function getId()
    {
    return $this->id;
    }

    /**
     * Returns $title.
     * @see Page::$title
     */
    public function getTitle() {
      //if ($this->id != '1')
        return $this->title;
    }
    public function getTitleDE() {
      //if ($this->id != '1')
        return $this->title_de;
    }
    /**
     * Returns $content.
     * @see Page::$content
     */
    public function getContent() {
      //if ($this->id != '1')
        return $this->content;
    }
    public function getContentDE() {
      //if ($this->id != '1')
        return $this->content_de;
    }

    public function getDescription() {return $this->description;}
    public function getKeywords() {return $this->keywords;}
    public function getDescriptionDE() {return $this->description_de;}
    public function getKeywordsDE() {return $this->keywords_de;}

    /**
     * Returns $user_level.
     * @see Page::$user_level
     */
    public function getUser_level() {
    return $this->user_level;
    }

    public function getPage_links() {
      if ($this->databaseConnection()) {
        $Cmnd = "SELECT id, title
          FROM uICxZ0_WeeCMS_pages
          ORDER BY id ASC
          ";
        $stmt = $this->db_connection->prepare($Cmnd);
        $stmt->execute();
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
      $thispage = 0;
      foreach($rs as $rsult) {
        $page_link[] = $rsult["id"];
        $page_titles[] = $rsult["title"];
      }
      return array($page_link, $page_titles);
    }

  /**
   * Adds a new page to the database table
   * @return object Query result
   * @param string $page_title
   * @param string $page_content
   * @param string $page_user_level
   * @param to be continued... lazy man!
   */
  private function newPage (
    $page_title,
    $page_content,
    $page_title_de,
    $page_content_de,
    $page_keywords,
    $page_description,
    $page_keywords_de,
    $page_description_de,
    $page_user_level
    ) {
    if ($this->databaseConnection() && ((isset($_SESSION['user_access_level']) && $_SESSION['user_access_level']==9)) && (isset($_SESSION['user_id']) )) { //&& $_SESSION['user_id']==1
      $Cmnd = "INSERT INTO uICxZ0_WeeCMS_pages (
        title, content, title_de, content_de, keywords, description, keywords_de, description_de, access_level
      )
      VALUES(:tit, :cntnt, :tit_de, :cntnt_de, :keyw, :desc, :keyw_de, :desc_de, :a_l)";
      $stmt = $this->db_connection->prepare($Cmnd);
      $stmt->execute(
        array(
          ':tit' => $page_title,
          ':cntnt' => $page_content,
          ':tit_de' => $page_title_de,
          ':cntnt_de' => $page_content_de,
          ':keyw' => $page_keywords,
          ':desc' => $page_description,
          ':keyw_de' => $page_keywords_de,
          ':desc_de' => $page_description_de,
          ':a_l' => $page_user_level
        )
      );
      $this->messages[] = WORDING_PAGE_SUCCESSFULLY_ADDED;
    } else {
      $this->errors[] = MESSAGE_PAGE_ERROR;
    }
  }

  /**
   * Saves edited page details
   * @return object Query result
   * @param string $page_title
   * @param string $page_content
   * @param string $page_user_level
   * @param to be continued... lazy man!
   */
  private function editPage (
    $page_title,
    $page_content,
    $page_title_de,
    $page_content_de,
    $page_keywords,
    $page_description,
    $page_keywords_de,
    $page_description_de,
    $page_user_level,
    $page_id) {
    if ($this->databaseConnection() && ((isset($_SESSION['user_access_level']) && $_SESSION['user_access_level']==9)) && (isset($_SESSION['user_id']) )) { //&& $_SESSION['user_id']==1
      $Cmnd = "
        UPDATE uICxZ0_WeeCMS_pages
        SET title = :tit,
         content = :cntnt,
         title_de = :tit_de,
         content_de = :cntnt_de,
         keywords = :keyw,
         description = :desc,
         keywords_de = :keyw_de,
         description_de = :desc_de,
         access_level = :a_l
        WHERE id =:page_id
      ";
      $stmt = $this->db_connection->prepare($Cmnd);
      $stmt->execute(
        array(
          ':tit' => $page_title,
          ':cntnt' => $page_content,
          ':tit_de' => $page_title_de,
          ':cntnt_de' => $page_content_de,
          ':keyw' => $page_keywords,
          ':desc' => $page_description,
          ':keyw_de' => $page_keywords_de,
          ':desc_de' => $page_description_de,
          ':a_l' => $page_user_level,
          ':page_id' => $page_id
        )
      );
      $this->messages[] = WORDING_PAGE_SUCCESSFULLY_EDITED;
      $this->messages[] = ' <a href="index.php?page_id='.$page_id.'">view changes</a>';
    }
  }

  /**
   * Deletes page record
   * @return bool whether the removal was successfull or not
   * @param int $page_id
   */
  public function deletePage ($page_id) {
    if ($this->databaseConnection() && ((isset($_SESSION['user_access_level']) && $_SESSION['user_access_level']==9)) && (isset($_SESSION['user_id']) ) && $page_id != 1) { //&& $_SESSION['user_id']==1
      $query_delete_post = $this->db_connection->prepare('DELETE FROM uICxZ0_WeeCMS_pages WHERE id= :id LIMIT 1');
      $query_delete_post->bindValue(':id', $page_id, PDO::PARAM_INT);
      $query_delete_post->execute();
      $this->messages[] = WORDING_PAGE_SUCCESSFULLY_DELETED;
    } else {
      $this->errors[] = MESSAGE_PAGE_ERROR;
    }
  }

}
