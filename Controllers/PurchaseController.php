<?php
	namespace Controllers;

	use Models\Purchase as Purchase;
	use Models\Card as Card;
	use Models\User as User;
	use Models\Screening as Screening;
	use DAO\PurchaseDAO as PurchaseDAO;
	use DAO\UserDAO as UserDAO;
	use DAO\ScreeningDAO as ScreeningDAO;
	use DAO\GenreDAO as GenreDAO;
	use DAO\MovieDAO as MovieDAO;
	use DAO\CardDAO as CardDAO;
	
	class PurchaseController {

		private $purchaseDao;
		private $userDao;
		private $screeningDao;
		private $cardDao;

		public function index($message = "") {
			$genreDao = new GenreDAO();
			$movieDao = new MovieDAO();
			$genreList = $genreDao->getAll();
            $movieList = $movieDao->getAll();
			require_once(VIEWS_PATH."home.php");
		}

		public function showListView() {
			$this->purchaseDao = new PurchaseDAO();
			$genreDao = new GenreDAO();
			$genreList = $genreDao->getAll();
			$purchaseList = $this->purchaseDao->getAll();
			require_once(VIEWS_PATH."usr-list-purchase.php");
		}
		
		public function showRevenueView() {
			require_once(VIEWS_PATH."adm-revenue-details.php");
		}

		public function showListByGenre($idGenre) {
			$this->purchaseDao = new PurchaseDAO();
			$genreDao = new GenreDAO();
			$genreList = $genreDao->getAll();
			$purchaseList = $this->purchaseDao->getByGenre($idGenre);
			require_once(VIEWS_PATH."usr-list-purchase.php");
		}

		public function showPurchaseConfirmation($quantity, $idScreening) {
			$this->screeningDao = new ScreeningDAO();
			$screening = $this->screeningDao->getScreening($idScreening);
			$price = $screening->getCinema()->getPrice();
			$totalPrice = $quantity*$price;
			$purchase = new Purchase();
			$purchase->setPrice($totalPrice);
			$purchase->setQuantity($quantity);
			$this->userDao = new UserDAO();
			$user = $this->userDao->getUser($_SESSION["loggedUser"]);
			$purchase->setUser($user);
			$purchase->setScreening($screening);
			$this->purchaseDao = new PurchaseDAO();
			require_once(VIEWS_PATH."usr-confirm-purchase.php");
		}

		public function showQRPurchase($quantity, $price, $idScreening, $qr, $cardType, $cardNumber, $dueDate, $securityCode, $ok) {
			if($ok===0) {
				require_once(VIEWS_PATH."home.php");
			} else {
				$card = new Card();
				$card->setNumber($cardNumber);
				$card->setType( $cardType);
				$this->cardDao = new CardDAO();
				$idCard = $this->cardDao->add($card);
				$card->setId($idCard);
				$this->screeningDao = new ScreeningDAO();
				$screening = $this->screeningDao->getScreening($idScreening);
				$purchase = new Purchase();
				$purchase->setPrice($price);
				$purchase->setQuantity($quantity);
				$this->userDao = new UserDAO();
				$user = $this->userDao->getUser($_SESSION["loggedUser"]);
				$purchase->setUser($user);
				$purchase->setScreening($screening);
				$this->cardDao = new CardDAO();
				$card = $this->cardDao->getCard($idCard);
				$purchase->setCard($card);
				$this->purchaseDao = new PurchaseDAO();
				$idPurchase = $this->purchaseDao->add($purchase);
				$purchase->setId($idPurchase);
				$qrInfo = $qr;
				require_once(VIEWS_PATH."qr-purchase.php");
			}
		}

		public function showListNewest() {
			$this->purchaseDao = new PurchaseDAO();
			$purchaseList = $this->purchaseDao->getAllOrderByNewest();
			require_once(VIEWS_PATH."usr-list-purchase.php");
		}
		
		public function showListOldest() {
			$this->purchaseDao = new PurchaseDAO();
			$purchaseList = $this->purchaseDao->getAllOrderByOldest();
			require_once(VIEWS_PATH."usr-list-purchase.php");
		}

		public function add($iduser, $idscreening, $price, $card, $quantity) {
			$this->purchaseDao = new PurchaseDAO();
			$newPurchase = new Purchase();

			$user = new User();
			$user = $this->userDAO->getUser($iduser);
			$newPurchase->setUser($user);

			$screening = new Screening();
			$screening = $this->screeningDao->getScreening($idscreening);
			$newPurchase->setScreening($screening);

			$newPurchase->setPrice($price);
			$newPurchase->setCard($card);
			$newPurchase->setQuantity($quantity);

			$this->purchaseDao->add($newPurchase);
			$this->showListView();
		}

		public function delete($id) {
			$this->purchaseDao = new PurchaseDAO();
			$this->purchaseDao->delete($id);
			$this->index("Purchase deleted. ID = ".$id);
		}

	}

?>