<?php

    namespace DAO;

    use DAO\ICardDAO as ICardDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Card as Card;

    class CardDAO implements ICardDAO 
    {
        private $connection;
        private $tableName = "Cards";

        public function add($card)
        {
            try {
                $query = "INSERT INTO ".$this->tableName." (number, type) VALUES (:number, :type)";

                $parameters["number"] =  $card->getNumber();
                $parameters["type"] =  $card->getType();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::Query);

                return $this->connection->GetLastIdInsert();
            } catch(Exception $exception) {
                echo "Is not posible to add the card";
            }
        }

        public function getCard($id)
        {
            try {
                $query = "SELECT * FROM ".$this->tableName." WHERE id_card = :id";

                $parameters["id"] = $id;

                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::Query);

                foreach($result as $row) 
                {
                    $card = new Card();
                    $card->setId($row["id_card"]);
                    $card->setNumber($row["number"]);
                    $card->setType($row["type"]);
                }

                return $card;
            } catch(Exception $exception) {
                echo "Is not posible to get the card";
            }
        }

        public function remove($id)
        {            
            try {
                $query = "DELETE FROM ".$tableName." WHERE id_card = :id";

                $parameters["id"] =  $id;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::Query);
            } catch(Exception $exception) {
                echo "Is not posible to remove the card";
            }
        }

    }

?>