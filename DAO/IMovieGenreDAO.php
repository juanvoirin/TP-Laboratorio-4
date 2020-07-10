<?php

    namespace DAO;

    interface IMovieGenreDAO 
    {
        function add(int $movieId, int $genreId);
        function remove(int $movieId);
        function getGenres(int $movieId);
    }

?>