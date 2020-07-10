<?php

	namespace Controllers;

	use Models\Movie as Movie;
	use DAO\MovieDAO as MovieDAO;
	use DAO\GenreDAO as GenreDAO;

	class MovieController {

		private $movieDao;

		public function __construct() {
			$this->movieDao = new MovieDAO();
			$this->genreDao = new GenreDAO();
		}

		public function index($message = "") {
			$genreList = $this->genreDao->getAll();
            $movieList = $this->movieDao->getAll();
			require_once(VIEWS_PATH."home.php");
		}

		public function showAddView($page = 1) {
			$this->movieDao = new MovieDAO();
			$movieApi = $this->getMoviesApi($page);
			$movieList = array();
			foreach($movieApi as $movie) {
				$id = $movie->getId();
				$isAdd = $this->movieDao->isAdd($id);
				if($isAdd==null){
					array_push($movieList, $movie);
				}
			}
			$page=$page;
			require_once(VIEWS_PATH."adm-add-movies.php");
		}

		public function showListView() {
			$genreList = $this->genreDao->getAll();
			$movieList = $this->movieDao->getAll();
			require_once(VIEWS_PATH."home.php");
		}

		public function showListByGenre($idGenre = 5) {
			$genreList = $this->genreDao->getAll();
			$movieList = $this->movieDao->getByGenre($idGenre);
			require_once(VIEWS_PATH."home.php");
		}
		
		
		public function showListNewest() {
			$genreList = $this->genreDao->getAll();
			$movieList = $this->movieDao->getAllOrderByNewest();
			require_once(VIEWS_PATH."home.php");
		}
		
		public function showListOldest() {
			$genreList = $this->genreDao->getAll();
			$movieList = $this->movieDao->getAllOrderByOldest();
			require_once(VIEWS_PATH."home.php");
		}

		public function add($id, $page) {
			$movie = $this->getMovieApi($id, $page);
			$this->movieDao->add($movie);
			$this->showAddView();
		}

		public function delete($id) {
				$this->movieDao->delete($id);
				$this->showListView();
		}

		public function update($id, $title, $picture, $description, $director, $genre, $rated) {
				$updatedMovie = new Movie();
				$updatedMovie->setTitle($title);
				$updatedMovie->setPicture($picture);
				$updatedMovie->setDescription($description);
				$updatedMovie->setGenre($genre);
				$updatedMovie->setRated($rated);

				$this->movieDao->update($updatedMovie);
		}
		
		public function getMoviesApi($page) {
            $movieList = array();
            $movieList = $this->getMovies("https://api.themoviedb.org/3/movie/now_playing?page=".$page."&language=es-Ar&api_key=67444f3a821e034257c84d1ecec36395");
			return $movieList;
        }

		public function getMovieApi($id, $page) {
			$curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.themoviedb.org/3/movie/now_playing?page=".$page."&language=es-Ar&api_key=67444f3a821e034257c84d1ecec36395",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "{}",
            ));

            $response = curl_exec($curl);
	   
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            }

			$movieDao = new MovieDAO();
			$this->genreDao = new GenreDAO();
			$movieList = array();

            $arrayToDecode = ($response) ? json_decode($response, true) : array();
			$movie = new Movie();
			foreach($arrayToDecode["results"] as $row)
            {
				if($row["id"]==$id) {
					$movie->setId($row["id"]);
					$movie->setTitle($row["title"]);
					if($row["poster_path"] != NULL) {
						$posterPath = "https://image.tmdb.org/t/p/w500".$row["poster_path"];
					}else{
						$posterPath = FRONT_ROOT.IMG_PATH."noImage.jpg";
					}
					$movie->setImage($posterPath);
					$movie->setDescription($row["overview"]);
					$genres = array();
					foreach ($row["genre_ids"] as $row) {
						$genre = $this->genreDao->getGenre($row);
						array_push($genres, $genre);
					}
					$movie->setGenres($genres); 
					return $movie;
				}
			}
            return $movie;
		}

        private function getMovies($url) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "{}",
            ));

            $response = curl_exec($curl);
	   
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            }

			$movieDao = new MovieDAO();
			$this->genreDao = new GenreDAO();
			$movieList = array();

            $arrayToDecode = ($response) ? json_decode($response, true) : array();
			
			foreach($arrayToDecode["results"] as $row)
            {
                $movie = new Movie();
                $movie->setId($row["id"]);
                $movie->setTitle($row["title"]);
                if($row["poster_path"] != NULL) {
                    $posterPath = "https://image.tmdb.org/t/p/w500".$row["poster_path"];
                }else{
                    $posterPath = FRONT_ROOT.IMG_PATH."noImage.jpg";
				}
				$movie->setImage($posterPath);
                $movie->setDescription($row["overview"]);
				$genres = array();
				foreach ($row["genre_ids"] as $row) {
					$genre = $this->genreDao->getGenre($row);
					array_push($genres, $genre);
				 }
				 $movie->setGenres($genres); 

                array_push($movieList, $movie);
			}
			
            return $movieList;
		}
		
	}

?>