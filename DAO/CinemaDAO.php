<?php

    namespace DAO;

    use DAO\ICinemaDAO as ICinemaDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Cinema as Cinema;

    class CinemaDAO implements ICinemaDAO 
    {
        private $connection;
        private $tableName = "Cinemas";

        public function add($cinema)
        {
            try {
                $query = "INSERT INTO ".$this->tableName." (name, capacity, address, price) VALUES (:name, :capacity, :address, :price)";

                $parameters["name"] =  $cinema->getName();
                $parameters["capacity"] = $cinema->getCapacity();
                $parameters["address"] = $cinema->getAddress();
                $parameters["price"] = $cinema->getPrice();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::Query);
            } catch(Exception $exception) {
                echo "Is not posible to add the cinema";
            }
        }

        public function getAll()
        {
            try {
                $cinemaList = array();

                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, array(), QueryType::Query);

                foreach($result as $row)
                {
                    $cinema = new Cinema();
                    $cinema->setId($row["id_cinema"]);
                    $cinema->setName($row["name"]);
                    $cinema->setCapacity($row["capacity"]);
                    $cinema->setAddress($row["address"]);
                    $cinema->setPrice($row["price"]);

                    array_push($cinemaList, $cinema);
                }

                return $cinemaList;
            } catch(Exception $exception) {
                echo "Is not posible to list the cinemas";
            }
        }

        public function getCinema(int $id)
        {
            try {
                $query = "SELECT * FROM ".$this->tableName." WHERE id_cinema = :id_cinema";

                $parameters["id_cinema"] = $id;

                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::Query);

                foreach($result as $row)
                {
                    $cinema = new cinema();
                    $cinema->setId($row["id_cinema"]);
                    $cinema->setName($row["name"]);
                    $cinema->setCapacity($row["capacity"]);
                    $cinema->setAddress($row["address"]);
                    $cinema->setPrice($row["price"]);
                }

                return $cinema;
            } catch(Exception $exception) {
                echo "Is not posible to get the cinema";
            }
        }

        public function getCinemaByName($name)
        {
            try {
                $query = "SELECT * FROM ".$this->tableName." WHERE name = :name";

                $parameters["name"] = $name;

                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::Query);

                $cinema = new cinema();

                foreach($result as $row)
                {
                    $cinema->setId($row["id_cinema"]);
                    $cinema->setName($row["name"]);
                    $cinema->setCapacity($row["capacity"]);
                    $cinema->setAddress($row["address"]);
                    $cinema->setPrice($row["price"]);
                }

                return $cinema;
            } catch(Exception $exception) {
                echo "Is not posible to get the cinema by name";
            }
        }

        public function remove($id)
        {        
            try {
                $query = "DELETE FROM ".$this->tableName." WHERE id_cinema = :id";

                $parameters["id"] =  $id;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::Query);
            } catch(Exception $exception) {
                echo "Is not posible to remove the cinema";
            }
        }

        public function isUsed($id) {
            try {
                $query = "SELECT count(C.id_cinema) FROM ".$this->tableName." C RIGHT JOIN Screenings S ON C.id_cinema=S.id_cinema WHERE C.id_cinema = :idCinema GROUP BY C.id_cinema";

                $parameters["idCinema"] = $id;

                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::Query);

                $count=0;
                foreach($result as $row)
                {
                    $count = $row;
                }
                return $count;
            } catch(Exception $exception) {
                echo "Is not posible to check if the cinema is used";
            }
        }

    }

?>