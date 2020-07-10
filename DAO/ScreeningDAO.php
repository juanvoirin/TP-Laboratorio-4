<?php
    namespace DAO;

    use DAO\ISCreeningDAO as ISCreeningDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Screening as Screening;
    use DAO\MovieDAO as MovieDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\PurchaseDAO as PurchaseDAO;
    
    class ScreeningDAO implements ISCreeningDAO {
        private $connection;
        private $tableName = "Screenings";
        private $movieDao;
        private $cinemaDao;
        private $purchaseDao;

        public function add(Screening $screening) {
            try {
                $condicion = true;
                $screeningList = $this->getAll();
                foreach($screeningList as $row) {
                    if($row->getDate() == $screening->getDate()) {
                        $condicion = false;
                    }
                }
                if($condicion) {
                    $query = "INSERT ".$this->tableName." (id_movie, id_cinema, screening_date, screening_hour) VALUES (:id_movie, :id_cinema, :screening_date, :screening_hour)";
                    $parameters["id_movie"] =  $screening->getMovie()->getId();
                    $parameters["id_cinema"] = $screening->getCinema()->getId();
                    $parameters["screening_date"] = $screening->getDate();
                    $parameters["screening_hour"] = $screening->getTime();

                    $this->connection = Connection::GetInstance();
                    $this->connection->ExecuteNonQuery($query, $parameters, QueryType::Query);
                    return 1;
                } else {
                    return 0;
                }
            } catch(Exception $exception) {
                echo "Is not posible to add the screening";
            }
        }

        public function getByMovie($idMovie) {
            $query = "SELECT * FROM ".$this->tableName." WHERE id_movie = :idMovie";
            $parameters["idMovie"] = $idMovie;
            return $this->getScreenings($query, $parameters);
        }

        public function getAll() {
            $query = "SELECT * FROM ".$this->tableName;
            return $this->getScreenings($query);
        }

        public function getScreening(int $id) {
            try {
                $query = "SELECT * FROM ".$this->tableName." WHERE id_screening = :id_screening";
                $parameters["id_screening"] = $id;
                $screenings = $this->getScreenings($query, $parameters);
                return array_pop($screenings);
            } catch(Exception $exception) {
                echo "Is not posible to get the screening";
            }
        }

        public function deleteMovie($id) {

        }

        public function getRemainingSeats($idScreening) {
            try {
                $query = "SELECT C.capacity-(SELECT SUM(P.quantity) FROM Purchases P WHERE P.id_screening = S.id_screening) FROM Screenings S INNER JOIN Cinemas C ON S.id_cinema = C.id_cinema WHERE S.id_screening = :idScreening";
                $parameters["idScreening"] =  $idScreening;
            
                $result = $this->connection->Execute($query, $parameters, QueryType::Query);
                
                $remainingSeats = 0;
                foreach($result as $row) {
                    $remainingSeats = $row;
                }
                return array_pop($remainingSeats);
            } catch(Exception $exception) {
                echo "Is not posible to add the screening";
            }
        }

        public function getQuantityPurchases($idScreening) {
            try {
                $query = "SELECT SUM(P.quantity) as Quantity FROM Purchases P WHERE P.id_screening = :idScreening";
                $parameters["idScreening"] = $idScreening;

                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query, $parameters, QueryType::Query);

                $quantitySold = 0;
                foreach($result as $row) {
                    $quantitySold = $row['Quantity'];
                }
                return $quantitySold;
            } catch(Exception $exception) {
                echo "Is not posible to get quantity purchases";
            }
        }

        private function getScreenings($query, $parameters = array()) {
            try {
                $screeningList = array();
                $this->movieDao = new MovieDAO();
                $this->cinemaDao = new CinemaDAO();

                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query, $parameters, QueryType::Query);

                foreach($result as $row)
                {
                    $screening = new Screening();
                    $screening->setId($row["id_screening"]);
                    $idMovie = $row["id_movie"];
                    $screening->setMovie($this->movieDao->getMovie($idMovie));
                    $idCinema = $row["id_cinema"];
                    $screening->setCinema($this->cinemaDao->getCinema($idCinema));
                    $screening->setDate($row["screening_date"]);
                    $screening->setTime($row["screening_hour"]);

                    array_push($screeningList, $screening);
                }
                return $screeningList;
            } catch(Exception $exception) {
                echo "Is not posible to get the screenings";
            }
        }

    }
?>