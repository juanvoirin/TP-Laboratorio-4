<?php

	namespace Controllers;

	use Models\User as User;
	use Models\Movie as Movie;
	use DAO\UserDAO as UserDAO;
    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;

	class UserController {

		private $userDao;
        private $movieDao;
        private $genreDao;

		public function index($message = "")
        {
            require_once(VIEWS_PATH."login.php");
		}
		
		public function showListView() {
            $this->movieDao = new MovieDAO();
            $this->genreDao = new GenreDAO();
            
            $genreList = $this->genreDao->getAll();
            $movieList = $this->movieDao->getAll();
            require_once(VIEWS_PATH."home.php");
		}
		
		public function login($email, $pass) {
            $this->userDao = new UserDAO();
			$user = $this->userDao->getByEmail($email);

            if(($user != null) && ($user->getPass() === $pass))
            {
                $_SESSION["loggedUser"] = $user->getId();
                $_SESSION["userName"] = $user->getName();
                $_SESSION["isAdmin"] = $user->getIsAdmin();
                $this->showListView();
            }
            else
                $this->index("Usuario y/o Contraseña incorrectos");
		}

        public function logout() {
            session_destroy();

            $this->index();
        }

		public function add($name, $email, $pass) {
            $this->userDao = new UserDAO();
            $user = new User();
            $user->setName($name);
            $user->setEmail($email);
            $user->setPass($pass);
            $user->setIsAdmin(false);

            $this->userDao->add($user);
            $this->showListView();
		}

		public function delete($id) {
            $this->userDao = new UserDAO();
			$this->userDao->delete($id);
			$this->ShowListView();
		}

	}

?>