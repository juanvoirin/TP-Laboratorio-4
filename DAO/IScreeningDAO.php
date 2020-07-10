<?php

    namespace DAO;
    
    use Models\Screening as Screening;

    interface IScreeningDAO 
    {
        function add(Screening $screening);
        function getAll();
        function getByMovie($idMovie);
        function getScreening(int $id);
        function deleteMovie($idMovie);
    }

?>