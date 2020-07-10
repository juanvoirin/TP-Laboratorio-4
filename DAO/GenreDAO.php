<?php

    namespace DAO;

    use DAO\IGenreDAO as IGenreDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Genre as Genre;

    class GenreDAO implements IGenreDAO 
    {
        private $connection;
        private $tableName = "Genre";

        public function add($idGenre, $name)
        {
                try {   
                $query = "INSERT INTO ".$this->tableName." (id_genre, name) VALUES (:id_genre, :name)";

                $parameters["id_genre"] = $idGenre;
                $parameters["name"] =  $name;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::Query);
            } catch(Exception $exception) {
                echo "Is not posible to add the genre";
            }
        }

        public function getGenre(int $id)
        {
            try {
                $query = "SELECT * FROM ".$this->tableName." WHERE id_genre = :id_genre";

                $parameters["id_genre"] = $id;

                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::Query);

                foreach($result as $row) 
                {
                    $genre = new Genre();
                    $genre->setId($row["id_genre"]);
                    $genre->setName($row["name"]);
                }

                return $genre;
            } catch(Exception $exception) {
                echo "Is not posible to get the genre";
            }
        }

        public function getAll()
        {
            try {
                $genreList = array();

                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, array(), QueryType::Query);

                foreach($result as $row) {
                    $genre = new Genre();
                    $genre->setId($row["id_genre"]);
                    $genre->setName($row["name"]);
                    array_push($genreList, $genre);
                }

                return $genreList;
            } catch(Exception $exception) {
                echo "Is not posible to get the genres";
            }
        }

        public function remove($id)
        {         
            try {   
                $query = "DELETE FROM ".$tableName." WHERE id = :id";

                $parameters["id"] =  $id;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::Query);
            } catch(Exception $exception) {
                echo "Is not posible to remove the genre";
            }
        }

    }

?>