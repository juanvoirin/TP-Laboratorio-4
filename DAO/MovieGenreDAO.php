<?php
    namespace DAO;

    use DAO\IMovieGenreDAO as IMovieGenreDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use DAO\GenreDAO as GenreDAO;

    class MovieGenreDAO implements IMovieGenreDAO {
        private $connection;
        private $tableName = "MovieGenre";
        private $genreDao;

        public function add(int $movieId, int $genreId) {
            try {
                $query = "INSERT INTO ".$this->tableName." (id_movie, id_genre) VALUES (:idMovie, :idGenre)";
                $parameters["idMovie"] =  $movieId;
                $parameters["idGenre"] = $genreId;
                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::Query);
            } catch(Exception $exception) {
                echo "Is not posible to add the movie-genre";
            }
        }

        public function remove(int $movieId) {
            try {        
                $query = "DELETE FROM ".$this->tableName." WHERE id = :id";
                $parameters["id"] =  $id;
                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::Query);
            } catch(Exception $exception) {
                echo "Is not posible to remove the movie-genre";
            }
        }

        public function getGenres(int $movieId) {
            try {
                $genres = array();
                $query = "SELECT * FROM ".$this->tableName." WHERE id_movie = :id_movie";
                $this->connection = Connection::GetInstance();
                $parameters["id_movie"] = $movieId;
        
                $result = $this->connection->Execute($query, $parameters, QueryType::Query);
                $this->genreDao = new GenreDAO();
                foreach($result as $row)
                {    
                    $genre = $this->genreDao->getGenre($row["id_genre"]);
                    array_push($genres, $genre);
                }
                return $genres;
            } catch(Exception $exception) {
                echo "Is not posible to get the genres for a movie";
            }
        }

    }
?>