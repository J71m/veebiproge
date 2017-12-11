<?php

    class UserInfo{

        protected $_userId;
        protected $_PDO;

        function __construct($user_id, PDO $PDO){
            $this->_userId = $user_id;
            $this->_PDO = $PDO;
        }

        public function getEmail(){
            $stmt = $this->_PDO->prepare("SELECT email FROM user_group WHERE id=$this->_userId LIMIT 1"); 
            if ( false===$stmt ){
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $stmt->execute();
            if ( false===$stmt ){
                die('execute() failed: ' . htmlspecialchars($mysqli->error));
            }
            $result = $stmt->fetch();
            $email = $result ["email"];
            return $email;
        }

        public function getUsername(){
            $stmt = $this->_PDO->prepare("SELECT username FROM user_group WHERE id=$this->_userId LIMIT 1"); 
            if ( false===$stmt ){
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $stmt->execute();
            if ( false===$stmt ){
                die('execute() failed: ' . htmlspecialchars($mysqli->error));
            }
            $result = $stmt->fetch();
            $username = $result ["username"];
            return $username;
        }

        public function getUsernameById($id){
            $stmt = $this->_PDO->prepare("SELECT username FROM user_group WHERE id=$id LIMIT 1"); 
            if ( false===$stmt ){
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $stmt->execute();
            if ( false===$stmt ){
                die('execute() failed: ' . htmlspecialchars($mysqli->error));
            }
            $result = $stmt->fetch();
            $username = $result ["username"];
            return $username;
        }

        public function getIdByUsername($username){
            $stmt = $this->_PDO->prepare("SELECT id FROM user_group WHERE username='$username' LIMIT 1"); 
            if ( false===$stmt ){
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $stmt->execute();
            if ( false===$stmt ){
                die('execute() failed: ' . htmlspecialchars($mysqli->error));
            }
            $result = $stmt->fetch();
            $id = $result ["id"];
            return $id;
        }

        public function getAllInfo(){
            $stmt = $this->_PDO->prepare("SELECT * FROM user_group WHERE id=$this->_userId LIMIT 1"); 
            if ( false===$stmt ){
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $stmt->execute();
            if ( false===$stmt ){
                die('execute() failed: ' . htmlspecialchars($mysqli->error));
            }
            $userObject = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $userObject;
        }

        public function getByUsername($username){
            $stmt = $this->_PDO->prepare("SELECT * FROM user_group WHERE username='$username' LIMIT 1"); 
            if ( false===$stmt ){
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $stmt->execute();
            if ( false===$stmt ){
                die('execute() failed: ' . htmlspecialchars($mysqli->error));
            }
            $userObject = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $userObject;
        }

        public function getUserlist(){
            $stmt = $this->_PDO->prepare("SELECT username, firstname, lastname, gender FROM user_group");
            if ( false===$stmt ){
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $stmt->execute();
            if ( false===$stmt ){
                die('execute() failed: ' . htmlspecialchars($mysqli->error));
            }
            $result = $stmt->fetchAll();
            return $result;
        }

        public function getUserPhotos($user_id){
            $stmt = $this->_PDO->prepare("SELECT thumbnail FROM pic_group WHERE userid=$user_id AND deleted IS NULL"); 
            if ( false===$stmt ){
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $stmt->execute();
            if ( false===$stmt ){
                die('execute() failed: ' . htmlspecialchars($mysqli->error));
            }
            $result = $stmt->fetchAll();
            return $result;
        }

        

    }

?>