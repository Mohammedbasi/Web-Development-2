<?php


class Auth
{
    private $db;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    public function register($username, $email, $password, $role = 'student')
    {
        $user = new User($username, $email, $password, $role);

        try {
            if ($user->register()) {
                return true;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return false;
    }

    public function login($username, $password)
    {
        $user = new User();

        if ($user->login($username, $password)) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user->getId();
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['role'] = $user->getRole();
            $_SESSION['logged_in'] = true;
            $_SESSION['last_activity'] = time();


            $this->setSecureCookieParams();
            return true;
        }

        return false;
    }

    public function logout()
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header("Location: login.php");
        exit();
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            if (isset($_SESSION['last_activity'])) {
                $session_timeout = 1800; // 30 m

                if (time() - $_SESSION['last_activity'] > $session_timeout) {
                    // logout
                    return false;
                }

                $_SESSION['last_activity'] = time();
            }
            return true;
        }
        return false;
    }

    public function generateCSRFToken()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public function validateCSRFToken($token)
    {
        if (!empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
            return true;
        }
        return false;
    }

    private function setSecureCookieParams()
    {
        $secure = true;
        $httponly = true;
        $samesite = 'Strict';

        if (PHP_VERSION_ID > 70300) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'domain' => $_SERVER['HTTP_HOST'],
                'secure' => $secure,
                'httponly' => $httponly,
                'samesite' => $samesite,
            ]);
        } else {
            session_set_cookie_params(
                0,
                '/; samesite=' . $samesite,
                $_SERVER['HTTP_HOST'],
                $secure,
                $httponly
            );
        }
    }

    public function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            header("Location: auth/login.php");
            exit();
        }
    }

    public function requireAdmin(){
        $this->requireLogin();

        if(!$this->isAdmin()){
            header("Location: unauthorized.php");
            exit();
        }
    }

    public function requireTeacher(){
        $this->requireLogin();

        if(!$this->isTeacher() && !$this->isAdmin()){
            header("Location: unauthorized.php");
            exit();
        }
    }

    public function hasRole($role)
    {
        if ($this->isLoggedIn() && isset($_SESSION['role'])) {
            return $_SESSION['role'] === $role;
        }

        return false;
    }

    public function isAdmin(){
        return $this->hasRole('admin');
    }

    public function isTeacher(){
        return $this->hasRole('teacher');
    }

    public function isStudent(){
        return $this->hasRole('student');
    }


}
