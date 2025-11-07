<?php
    require_once 'connect.php';

    abstract class PresetMessage {
        const SUCCESS = "สำเร็จ";
        const ERROR = "พบข้อผิดพลาด";
        const WARNING = "คำเตือน";

        const AUTH_WRONG = "ERROR 01 : Wrong username or password";
        const AUTH_INVALID_EMAIL_TOKEN = "ERROR 06 : That email confirmation token is invalid, is that expired?";
        const AUTH_INVALID_RESET_PASSWORD_TOKEN = "ERROR 07 : That reset password token is invalid, is that expired?";
        
        const USER_NOT_FOUND = "ERROR 10 : User not found";
        const USER_ERROR = "ERROR 19 : Found conflict user";

        const FILE_IO = "ERROR 20 : Cannot performing File IO";
        const FILE_UPLOAD_NOT_FOUND = "ERROR 21 : Cannot locate the uploaded file";
        const FILE_DUPLICATE = "ERROR 22 : Duplicate file/folder name";

        const DATABASE_ESTABLISH = "ERROR 40 : Cannot established with the database";
        const DATABASE_QUERY = "ERROR 41 : Cannot query with the database";
        const DATABASE_ERROR = "ERROR 49 : Unexpected internal database error";

        const UNEXPECTED_ERROR = "ERROR 50 : Unexpected internal error";

        const SESSION_INVALID = "ERROR 60 : Session is invalid";
        
        const PERMISSION_REQUIRE = "ERROR 90 : You do not have enough permission";
        const PERMISSION_ERROR = "ERROR 99 : Found conflict permission";
    }

    abstract class Role {
        const ADMIN = "admin";
        const USER = "user";
        const GUEST = "guest";
        const ROLES = array(Role::ADMIN, Role::USER, Role::GUEST);
    }

    class SweetAlert {
        const SUCCESS = "success";
        const ERROR = "error";
        const WARNING = "warning";

        protected $title, $message, $type;
        
        public function show() {
            echo "<script>swal({title:\"$this->title\",text:\"$this->message\",icon:\"$this->type\"});</script>";
            unset($_SESSION['SweetAlert']); //Self destruct itself
        }
        public function __construct(String $title, String $message = null, String $type = SweetAlert::SUCCESS) {
            $this->title = $title;
            $this->message = $message;
            $this->type = $type;
            $_SESSION['SweetAlert'] = $this;
        }
    }

    class PostCategory {
        const uncategorized = "uncategorized";

        const ABOUT = "about";
        const NEWS = "announcement";

        const CATEGORIES = array(PostCategory::uncategorized,
                                PostCategory::ABOUT,
                                PostCategory::NEWS,
                            );
    }

    class User {
        protected $id, $email, $role, $name;
        public $profile;

        public function getID() {
            return $this->id;
        }
        public function setID(int $id) {
            $this->id = $id;
        }

        public function getName() {
            return $this->name;
        }
        public function setName(String $name) {
            $this->name = $name;
        }

        public function getEmail() {
            return $this->email;
        }
        public function setEmail(String $email) {
            $this->email = $email;
        }

        public function getRole() {
            return $this->role;
        }
        public function setRole(String $role) {
            $this->role = $role;
        }
        
        public function getProfile() {
            if (empty($this->profile) || !file_exists($this->profile)) return "../static/asset/user.svg";
            return $this->profile;
        }
        public function setProfile(String $url) {
            $this->profile = $url;
        }

        public function isAdmin() {
            return ($this->role == "admin");
        }

        public function __construct(int $id) {
            $this->id = $id;
            $data = getUserData($id);
            if (!empty($data)) {
                $this->name = $data['name'];
                $this->profile = $data["profilePic"];
                $this->email = $data['email'];
                $this->role = $data['role'];
            } else {
                $this->id = -1;
            }
        }
    }

    class Post {
        protected $id, $title, $article, $properties;

        public function getID() {
            return $this->id;
        }

        public function getTitle() {
            return $this->title;
        }
        public function setTitle(String $title) {
            $this->title = $title;
        }
        
        public function getArticle() {
            return $this->article;
        }
        public function setArticle(String $article) {
            $this->article = $article;
        }

        public function properties() {
            return $this->properties;
        }
        public function getProperty(String $key) {
            if (empty($this->properties) || $this->properties==null) return null;
            return array_key_exists($key, $this->properties) ? $this->properties[$key] : null;
        }
        public function setProperty($key, $val) {
            $this->properties[$key] = $val;
        }

        public function __construct(int $id) {
            $this->id = $id;
            if ($id > 0) {
                $post = getPostData($id);
                if ($post != null) {
                    $this->title = $post['title'];
                    $this->article = $post['article'];
                    $this->properties = json_decode($post['property'], true);
                } else {
                    $this->id = -1;
                }
            } else if (!isset($_SESSION['currentActiveUser'])) {
                $this->id = -1;
            } else {
                $this->title = null;
                $this->article = null;
                $this->properties = array(
                    "author" => $_SESSION['currentActiveUser']->getID(),
                    "category" => "uncategorized",
                    "upload_time" => time(),
                    "hide" => false,
                    "pin" => false,
                    "cover" => null,
                    "tags" => null,
                    "allowDelete" => true
                );
            }
        }
    }

    /*
    class Newsletter {
        protected $id, $file, $properties;

        public function getID() {
            return $this->id;
        }

        public function getFile() {
            return $this->file;
        }
        public function setFile(String $file) {
            $this->file = $file;
        }

        public function properties() {
            return $this->properties;
        }
        public function getProperty(String $key) {
            if (empty($this->properties) || $this->properties==null) return null;
            return array_key_exists($key, $this->properties) ? $this->properties[$key] : null;
        }
        public function setProperty($key, $val) {
            $this->properties[$key] = $val;
        }

        public function __construct(int $id) {
            $this->id = $id;
            if ($id != -1) {
                $newsletter = getNewsletterData($id);
                if ($newsletter != null) {
                    $this->file = $newsletter['file'];
                    $this->properties = json_decode($newsletter['properties'], true);
                } else {
                    $this->id = -1;
                }
            } else if (!isset($_SESSION['currentActiveUser'])) {
                $this->id = -1;
            } else {
                $properties = array(
                    "title" => "",
                    "cover" => "../static/asset/header_16x9.png",
                    "author" => $_SESSION['currentActiveUser']->getID(),
                    "update" => time(),
                    "hide" => false,
                    "pin" => false
                );
            }
        }
    }
    */

?>