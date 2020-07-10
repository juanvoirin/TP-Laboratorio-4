<?php

    namespace DAO;
    
    use Models\Cinema as Cinema;

    interface ICinemaDAO 
    {
        function add(Cinema $cinema);
        function getAll();
        function getCinema(int $id);
        function remove($id);
        function isUsed($id);
    }

?>