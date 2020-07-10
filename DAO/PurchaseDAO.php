<?php

    namespace DAO;

    use DAO\IPurchaseDAO as IPurchaseDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Purchase as Purchase;
    use DAO\ScreeningDAO as ScreeningDAO;
    use DAO\UserDAO as UserDAO;
    use DAO\CardDAO as CardDAO;

    class PurchaseDAO implements IPurchaseDAO {

        private $connection;
        private $tableName = "Purchases";
        private $userDao;
        private $screeningDao;

        public function add(Purchase $purchase) {
            try {
                $query = "INSERT INTO ".$this->tableName." (id_user, id_screening, price, id_card, quantity) VALUES (:id_user, :id_screening, :price, :id_card, :quantity)";

                $parameters["id_user"] =  $purchase->getUser()->getId();
                $parameters["id_screening"] = $purchase->getScreening()->getId();
                $parameters["price"] = $purchase->getPrice();
                $parameters["id_card"] = $purchase->getCard()->getId();
                $parameters["quantity"] = $purchase->getQuantity();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::Query);

                return $this->connection->GetLastIdInsert();
            } catch(Exception $exception) {
                echo "Is not posible to add the purchase";
            }
        }

        public function getAll() {
            $query = "SELECT * FROM ".$this->tableName." WHERE id_user = :idUser";
            $parameters["idUser"] = $_SESSION["loggedUser"];

            return $this->getPurchases($query, $parameters);
        }

        public function getByGenre($idGenre) {
            $query = "SELECT * FROM ".$this->tableName." P LEFT JOIN Screenings S ON P.id_screening = S.id_screening LEFT JOIN MovieGenre MG ON S.id_movie = MG.id_movie WHERE MG.id_genre = :idGenre AND id_user = :idUser";
            $parameters["idGenre"] = $idGenre;
            $parameters["idUser"] = $_SESSION["loggedUser"];

            return $this->getPurchases($query, $parameters);
        }

        public function getAllOrderByNewest() {
            $query = "SELECT * FROM ".$this->tableName." P INNER JOIN Screenings S ON P.id_screening = S.id_screening WHERE id_user = :idUser ORDER BY S.screening_date DESC";
            $parameters["idUser"] = $_SESSION["loggedUser"];

            return $this->getPurchases($query,$parameters);
        }

        public function getAllOrderByOldest() {
            $query = "SELECT * FROM ".$this->tableName." P INNER JOIN Screenings S ON P.id_screening = S.id_screening WHERE id_user = :idUser ORDER BY S.screening_date ASC";
            $parameters["idUser"] = $_SESSION["loggedUser"];
            
            return $this->getPurchases($query,$parameters);
        }

        public function remove($id) {  
            try {          
                $query = "DELETE FROM ".$tableName." WHERE id = id";

                $parameters["id"] =  $id;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::Query);
            } catch(Exception $exception) {
                echo "Is not posible to remove the purchase";
            }
        }

        public function getRevenueByCinema($idCinema) {
            try {
                $query = "SELECT SUM(P.quantity) as quantity FROM ".$this->tableName." P INNER JOIN Screenings S ON P.id_screening = S.id_screening INNER JOIN Cinemas C ON S.id_cinema = C.id_cinema WHERE C.id_cinema = :id_cinema";
                $parameters["id_cinema"] = $idCinema;
                
                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::Query);

                $rta = array();

                foreach($result as $row)
                    $aux = $row["quantity"];
                    array_push($rta, $aux);

                return array_pop($rta);
            } catch(Exception $exception) {
                echo "Is not posible to get the revenue by cinema";
            }
        }

        public function getRevenueByMovie($idMovie) {
            try {
                $query = "SELECT SUM(P.quantity) as quantity, SUM(P.price) as price FROM ".$this->tableName." P INNER JOIN Screenings S ON P.id_screening = S.id_screening INNER JOIN Movies M ON S.id_movie = M.id_movie WHERE M.id_movie = :id_movie";
                $parameters["id_movie"] = $idMovie;
                
                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::Query);

                $rta = array();

                foreach($result as $row)
                    $aux["quantity"] = $row["quantity"];
                    $aux["revenue"] = $row["price"];
                    array_push($rta, $aux);

                return array_pop($rta);
            } catch(Exception $exception) {
                echo "Is not posible to get the revenue by movie";
            }
        }

        public function getRevenueByGenre($idGenre) {
            try {
                $query = "SELECT SUM(P.quantity) as quantity, SUM(P.price) as price FROM ".$this->tableName." P INNER JOIN Screenings S ON P.id_screening = S.id_screening INNER JOIN Movies M ON S.id_movie = M.id_movie INNER JOIN MovieGenre MG ON M.id_movie = MG.id_movie WHERE MG.id_genre = :id_genre";
                $parameters["id_genre"] = $idGenre;
                
                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::Query);

                $rta = array();

                foreach($result as $row)
                    $aux["quantity"] = $row["quantity"];
                    $aux["revenue"] = $row["price"];
                    array_push($rta, $aux);

                return array_pop($rta);
            } catch(Exception $exception) {
                echo "Is not posible to get the revenue by genre";
            }
        }

        public function getRevenueByDate($date) {
            try {
                $query = "SELECT SUM(P.quantity) as quantity, SUM(P.price) as price FROM ".$this->tableName." P INNER JOIN Screenings S ON P.id_screening = S.id_screening S.screening_date = :screening_date";
                $parameters["screening_date"] = $date;
                
                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::Query);

                $rta = array();

                foreach($result as $row)
                    $aux["quantity"] = $row["quantity"];
                    $aux["revenue"] = $row["price"];
                    array_push($rta, $aux);

                return array_pop($rta);
            } catch(Exception $exception) {
                echo "Is not posible to get the revenue by date";
            }
        }

        private function getPurchases($query, $parameters = array()) {
            try {
                $this->userDao = new UserDAO();
                $this->screeningDao = new ScreeningDAO();
                $this->cardDao = new CardDAO();

                $purchaseList = array();
                
                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::Query);

                foreach($result as $row) {
                    $purchase = new Purchase();
                    $purchase->setId($row["id_purchase"]);
                    $idUser = $row["id_user"];
                    $purchase->setUser($this->userDao->getUser($idUser));
                    $idScreening = $row["id_screening"];
                    $purchase->setScreening($this->screeningDao->getScreening($idScreening));
                    $idCard = $row["id_card"];
                    $purchase->setCard($this->cardDao->getCard($idCard));
                    $purchase->setPrice($row["price"]);
                    $purchase->setQuantity($row["quantity"]);

                    array_push($purchaseList, $purchase);
                }

                return $purchaseList;
            } catch(Exception $exception) {
                echo "Is not posible to get the purchases";
            }
        }


    }

?>