<?php
    namespace DAO;

    use DAO\IUserDAO as IUserDAO;
    use DAO\Connection as Connection;
    use DAO\QueryType as QueryType;
    use Models\User as User;

    class UserDAO implements IUserDAO  {
        private $connection;
        private $tableName = "Users";

        public function getByEmail($email) {
            try {
                $user = null;
                $query = "SELECT * FROM ".$this->tableName." WHERE email = :email";
                $parameters["email"] = $email;

                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters, QueryType::Query);

                foreach($results as $row)
                {
                    $user = new User();
                    $user->setId($row["id_user"]);
                    $user->setPass($row["pass"]);
                    $user->setEmail($row["email"]);
                    $user->setIsAdmin($row["is_admin"]);
                    $user->setName($row["name"]);
                }
                return $user;
            } catch(Exception $exception) {
                echo "Is not posible to get the user by email";
            }
        }  

        public function add(User $user) {
            try {
                $query = "INSERT INTO ".$this->tableName." (name, pass, email, is_admin) VALUES (:name, :pass, :email, :is_admin)";

                $parameters["name"] =  $user->getName();
                $parameters["pass"] = $user->getPass();
                $parameters["email"] = $user->getEmail();
                $parameters["is_admin"] = false;

                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters, QueryType::Query);
            } catch(Exception $exception) {
                echo "Is not posible to add the user";
            }
        }

        public function getUser(int $id) {
            try {
                $query = "SELECT * FROM ".$this->tableName." WHERE id_user = :id_user";
                $parameters["id_user"] = $id;

                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query, $parameters, QueryType::Query);

                foreach($result as $row)
                {
                    $user = new User();
                    $user->setId($row["id_user"]);
                    $user->setName($row["name"]);
                    $user->setPass($row["pass"]);
                    $user->setEmail($row["email"]);
                    $user->setIsAdmin($row["is_admin"]);
                }
                return $user;
            } catch(Exception $exception) {
                echo "Is not posible to get the user by id";
            }
        }

    }
?>