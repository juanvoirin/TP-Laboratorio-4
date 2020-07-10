<?php

    namespace DAO;

    use Models\Movie as Movie;

    interface IMovieDAO 
    {
        function add(Movie $movie);
        function getAll();
        function getAllOrderByNewest();
        function getAllOrderByOldest();
        function getByGenre($genreId);
        function getMovie(int $id);
        function remove($id);
        function isAdd($id);
    }

?>