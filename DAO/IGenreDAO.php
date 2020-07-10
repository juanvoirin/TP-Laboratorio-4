<?php

    namespace DAO;

    interface IGenreDAO 
    {
        function add(int $id_genre, int $name);
        function remove(int $movieId);
        function getGenre(int $id);
        function getAll();
    }

?>