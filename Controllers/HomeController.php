<?php

    namespace Controllers;

    use Models\Movie as Movie;
    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\PurchaseDAO as PurchaseDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use Models\Genre as Genre;

    class HomeController
    {
        private $movieDao;
        private $genreDao;
        private $purchaseDao;
        private $cinemaDao;

        public function __construct(){
            $this->movieDao = new MovieDAO();
            $this->genreDao = new GenreDAO();
            $this->purchaseDao = new PurchaseDAO();
            $this->cinemaDao = new CinemaDAO();
        }

        public function index($message = "")
        {
            if(!isset($_SESSION["loggedUser"])){
                $this->showLoginView();
            }
            else{
                $this->showHomeView();
            }
        }   
        
        public function showLoginView()
        {
            require_once(VIEWS_PATH."login.php");
        }

        public function showRegisterView()
        {
            require_once(VIEWS_PATH."register.php");
        }

        private function generateMovieArray($cap){
            $list = array();

            for ($i=0; $i < $cap; $i++) { 
                $movie = new Movie();
                $movie->setID($i);
                $movie->setTitle("Titulo ".$i);
                $movie->setImage("https://www.hola.com/imagenes/estar-bien/20180925130054/consejos-para-cuidar-a-un-gatito-recien-nacido-cs/0-601-526/cuidardgatito-t.jpg");
                $movie->setDescription("Descripcion ".$i);
                $movie->setGenres(array("gnere ".$i."1","gnere ".$i."2","gnere ".$i."3"));

                array_push($list, $movie);
            }

            return $list;
        }

        public function showHomeView(){
            $genreList = $this->genreDao->getAll();
            $movieList = $this->movieDao->getAll();

            require_once(VIEWS_PATH."home.php");
        }

        public function showRevenue(){
            $genreList = $this->genreDao->getAll();
            $movieList = $this->movieDao->getAll();
            $cinemaList = $this->cinemaDao->getAll();
            require_once(VIEWS_PATH."adm-revenue-details.php");
        }

        public function showRevenueCinema($idCinema){
            $revenue = $this->purchaseDao->getRevenueByCinema($idCinema);
            $cinema = $this->cinemaDao->getCinema($idCinema);
            require_once(VIEWS_PATH."adm-list-revenue-by-cinema.php");
        }

        public function showRevenueMovie($idMovie){
            $revenue = $this->purchaseDao->getRevenueByMovie($idMovie);
            $movie = $this->movieDao->getMovie($idMovie);
            require_once(VIEWS_PATH."adm-list-revenue-by-movie.php");
        }

        public function showRevenueGenre($idGenre){
            $genre = new Genre();
            $genre = $this->genreDao->getGenre($idGenre);
            $revenue = $this->purchaseDao->getRevenueByGenre($idGenre);
            $movieList = $this->movieDao->getByGenre($idGenre);
            require_once(VIEWS_PATH."adm-list-revenue-by-genre.php");
        }

        public function showRevenueDate($date){
            $revenue = $this->purchaseDao->getRevenueByDate($date);
            require_once(VIEWS_PATH."adm-list-revenue-by-genre.php");
        }

    }

?>