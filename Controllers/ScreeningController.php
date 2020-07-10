<?php

	namespace Controllers;

	use Models\Screening as Screening;
	use DAO\ScreeningDAO as ScreeningDAO;
	use Models\Movie as Movie;
	use DAO\MovieDAO as MovieDAO;
	use Models\Cinema as Cinema;
	use DAO\CinemaDAO as CinemaDAO; 

	class ScreeningController {

		private $screeningDao; 
		private $movieDao;
		private $cinemaDao;

		public function index($message = ""){
			require_once(VIEWS_PATH."adm-add-screening.php");
		}

		public function showListView(){
			$this->cinemaDao = new CinemaDao();
			$cinemaList = $this->cinemaDao->getAll();
			$this->movieDao = new MovieDao();
			$movieList = $this->movieDao->getAllMovies();
			$this->screeningDao = new screeningDAO();
			$screeningList = $this->screeningDao->getAll();
			$purchasesList = array();
			$count = 0;
			foreach($screeningList as $row)
			{
				$purchasesList[$count] = $this->screeningDao->getQuantityPurchases($row->getId());
				$count++;
			}
			require_once(VIEWS_PATH."adm-list-screening.php");
		}

		public function showScreeningDetails($idMovie, $idScreening = 0) {
			$this->movieDao = new MovieDAO();
			$this->screeningDao = new ScreeningDAO();
			$movie = $this->movieDao->getMovie($idMovie);
			$screeningList = $this->screeningDao->getByMovie($idMovie);
			$remainingSeats = 0;
			$actualScreening = null;
			if ($idScreening !== 0) {
				$actualScreening = $this->screeningDao->getScreening($idScreening);
				$remainingSeats = $this->screeningDao->getRemainingSeats($idScreening);
			}
			require_once(VIEWS_PATH."usr-details-screenings.php");
		}

		public function deleteMovie($idMovie) {
			$this->screeningDao = new ScreeningDAO();
			$this->screeningDao->deleteMovie($idMovie);
			require_once(VIEWS_PATH."home.php");
		}
		
		public function add($cinema, $movie, $date, $time) {
			$this->screeningDao = new ScreeningDAO();
			$this->movieDao = new MovieDao();
			$this->cinemaDao = new CinemaDao();

			$newScreening = new Screening();

			$movieComplete = new Movie();
			$movieComplete = $this->movieDao->getMovieByTitle($movie);
			$newScreening->setMovie($movieComplete);

			$cinemaComplete = new Cinema();
			$cinemaComplete = $this->cinemaDao->getCinemaByName($cinema);
			$newScreening->setCinema($cinemaComplete); 

			$newScreening->setDate($date);
			$newScreening->setTime($time);

			$result = $this->screeningDao->add($newScreening);
			if($result === 0) {
				echo "The screening could not be added because there is already another screening for that movie the same day";
			}
			$this->showListView();
		}

		public function update($id, $idMovie, $idCinema, $date, $time, $remainingSeats) {
			$this->movieDao = new MovieDao();
			$this->cinemaDao = new CinemaDao();
			$this->screeningDao = new ScreeningDAO();

			$updatedScreening = new Screening();
			$updatedScreening->setID($id);

			$movie = new Movie();
			$movie = $this->movieDao->getMovie($idMovie);
			$newScreening->setMovie($movie);

			$cinema = new Cinema();
			$cinema = $this->cinemaDao->getCinema($idCinema);
			$newScreening->setCinema($cinema); 

			$updatedScreening->setDate($date);
			$updatedScreening->setTime($time);
			$updatedScreening->setRemainingSeats($remainingSeats);

			$this->screeningDao->update($updatedScreening);
			$this->showListView();
		}
	}

?>