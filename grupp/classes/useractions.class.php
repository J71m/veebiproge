<?php
    class UserActions{

        protected $_PDO;

        function __construct(PDO $PDO){
            $this->_PDO = $PDO;
        }

        public function login($email, $password)
        {
            $user = $this->_checkCredentials($email, $password);
            if ($user) {
                $user = $user; // for accessing it later
                $_SESSION['user_id'] = $user['id'];
                return $user['id'];
            }
            return false;
        }

        protected function _checkCredentials($email, $password)
        {
            $stmt = $this->_PDO->prepare('SELECT id, email, password FROM user_group WHERE email=? LIMIT 1');
            $stmt->execute(array($email));
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $submitted_pass = hash("sha512", $password);
                if ($submitted_pass == $user['password']) {
                    return $user;
                }
            }
            return false;
        }

        public function getUser()
        {
            return $user;
        }

        public function registerUser($email, $password, $username, $firstname, $lastname, $gender, $bio, $picture){
            $sql=mysql_query("SELECT username FROM user_group WHERE username='$username'");
            if(mysql_num_rows($sql)>=1){
               echo"Username already exists";
            }else{

            $hashed_pass = hash("sha512", $password);
            $stmt = $this->_PDO->prepare("INSERT INTO user_group (username, firstname, lastname, gender, password, email, bio, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if ( false===$stmt ){
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $stmt->execute(array($username, $firstname, $lastname, $gender, $hashed_pass ,$email, $bio, $picture));
            if ( false===$stmt ){
                die('execute() failed: ' . htmlspecialchars($mysqli->error));
            }
            }
        }

        public function changeProfile($id, $firstname, $lastname, $gender, $biography){
            $stmt = $this->_PDO->prepare("UPDATE user_group SET firstname='$firstname', lastname='$lastname', gender=$gender, bio='$biography' WHERE id=$id");
            if ( false===$stmt ){
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $stmt->execute(array($firstname, $lastname, $gender, $biography));
            if ( false===$stmt ){
                die('execute() failed: ' . htmlspecialchars($mysqli->error));
            }
        }
		
		public function deletePhoto($id, $photo_id){
            $stmt = $this->_PDO->prepare("UPDATE pic_group SET deleted=NOW() WHERE userid=$id AND id=$photo_id");
            if ( false===$stmt ){
                die('prepare() failed: ' . htmlspecialchars($mysqli->error));
            }
            $stmt->execute(array());
            if ( false===$stmt ){
                die('execute() failed: ' . htmlspecialchars($mysqli->error));
            }
        }
        }
