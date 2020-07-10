<?php
    namespace DAO;

    use DAO\IMovieDAO as IMovieDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\Movie as Movie;
    use DAO\MovieGenreDAO as MovieGenreDAO;

    class MovieDAO implements IMovieDAO  {

        private $connection;
        private $tableName = "Movies";
        private $movieGenreDao;

        public function add(Movie $movie) {
            try {
                $this->movieGenreDao = new MovieGenreDAO();
                $query = "INSERT ".$this->tableName." (id_movie, title, image, description) VALUES (:id_movie, :title, :image, :description)";
                $parameters["id_movie"] =  $movie->getId();
                $parameters["title"] = $movie->getTitle();
                $parameters["image"] = $movie->getImage();
                $parameters["description"] = $movie->getDescription();
                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::Query);
                foreach($movie->getGenres() as $genre) {
                    $this->movieGenreDao->add($movie->getId(), $genre->getId());
                }
            } catch(Exception $exception) {
                    echo "Is not posible to add the movie";
            }
        }

        public function getAll() {
            $query = "SELECT * FROM ".$this->tableName." M WHERE (SELECT S.id_movie FROM Screenings S WHERE S.id_movie = M.id_movie AND S.screening_date >= CURDATE() GROUP BY S.id_movie) IS NOT NULL";
            
            return $this->getMovies($query);
        }

        public function getAllMovies() {
            $query = "SELECT * FROM ".$this->tableName;
            
            return $this->getMovies($query);
        }

        public function getAllOrderByNewest() {
            $query = "SELECT * FROM ".$this->tableName." M WHERE (SELECT S.id_movie FROM Screenings S WHERE S.id_movie = M.id_movie AND S.screening_date >= CURDATE() GROUP BY S.id_movie) IS NOT NULL ORDER BY M.title DESC ";
            
            return $this->getMovies($query);
        }

        public function getAllOrderByOldest() {
            $query = "SELECT * FROM ".$this->tableName." M WHERE (SELECT S.id_movie FROM Screenings S WHERE S.id_movie = M.id_movie AND S.screening_date >= CURDATE() GROUP BY S.id_movie) IS NOT NULL ORDER BY M.title ASC";
            
            return  $this->getMovies($query);
        }

        public function getByGenre($genreId) {
            $query = "SELECT * FROM ".$this->tableName." M 
            WHERE (SELECT S.id_movie FROM Screenings S WHERE S.id_movie = M.id_movie AND S.screening_date >= CURDATE() GROUP BY S.id_movie) IS NOT NULL 
            AND (SELECT MG.id_movie FROM MovieGenre MG WHERE MG.id_movie = M.id_movie AND MG.id_genre = :idGenre GROUP BY MG.id_movie) IS NOT NULL
            ORDER BY M.title ASC";
            $parameters["idGenre"]=$genreId;

            return $this->getMovies($query, $parameters);
        }

        public function getMovie(int $id) {
            $query = "SELECT * FROM ".$this->tableName." WHERE id_movie = :id_movie";
            $parameters["id_movie"] = $id;

            $movie = $this->getMovies($query, $parameters);
            return array_pop($movie);
        }

        public function getMovieByTitle($title) {
            try {
                $query = "SELECT * FROM ".$this->tableName." WHERE title = :title";
                $parameters["title"] = $title;

                $movie = $this->getMovies($query, $parameters);
                return array_pop($movie);
            } catch(Exception $exception) {
                echo "Is not posible to add the movie";
            }
        }

        public function remove($id) {    
            try {        
                $query = "DELETE FROM ".$this->tableName." WHERE id = :id";
                $parameters["id"] =  $id;
                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::Query);
                $this->movieGenreDao = new MovieGenreDAO();
                $this->$movieGenreDao->remove($movie->getId()); 
            } catch(Exception $exception) {
                echo "Is not posible to add the movie";
            }             
        } 

        public function isAdd($id) {
            try {
                $query =  "SELECT id_movie FROM ".$this->tableName." WHERE id_movie = :id";
                $parameters["id"] = $id;
                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::Query);
                $count = 0;
                foreach($result as $row) {
                    $count = $row["id_movie"];
                }
                return $count;
            } catch(Exception $exception) {
                echo "Is not posible to add the movie";
            }
        }

        private function getMovies($query, $parameters = array()) {
            try {
                $movieList = array();
                $this->movieGenreDao = new MovieGenreDAO();
                $this->connection = Connection::GetInstance();

                $result = $this->connection->Execute($query, $parameters, QueryType::Query);
                foreach($result as $row)
                {
                    $movie = new Movie();
                    $movie->setId($row["id_movie"]);
                    $movie->setTitle($row["title"]);
                    $movie->setImage($row["image"]);
                    $movie->setDescription($row["description"]);
                    $genres = $this->movieGenreDao->getGenres($row["id_movie"]);
                    $movie->setGenres($genres);
                    array_push($movieList, $movie);
                }
                return $movieList;
            } catch(Exception $exception) {
                echo "Is not posible to add the movie";
            }
        }

    }
?>