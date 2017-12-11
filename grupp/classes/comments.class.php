<?php

    class Comments{

        protected $_PDO;
        
                function __construct(PDO $PDO){
                    $this->_PDO = $PDO;
                }

                public function addComment($photo_id, $user_id, $comment){
                    $stmt = $this->_PDO->prepare("INSERT INTO comments_group (photo_id, user_id, comment) VALUES ($photo_id, $user_id, '$comment')");
                    if ( false===$stmt ){
                        die('prepare() failed: ' . htmlspecialchars($mysqli->error));
                    }
                    $stmt->execute(array($photo_id, $user_id, $comment));
                    if ( false===$stmt ){
                        die('execute() failed: ' . htmlspecialchars($mysqli->error));
                    }
                }

                public function loadComments($photo){
                    $stmt = $this->_PDO->prepare("SELECT comment, user_id, comment_time FROM comments_group WHERE photo_id=?");
                    if ( false===$stmt ){
                        die('prepare() failed: ' . htmlspecialchars($mysqli->error));
                    }
                    $stmt->execute(array($photo));
                    if ( false===$stmt ){
                        die('execute() failed: ' . htmlspecialchars($mysqli->error));
                    }
                    $result = $stmt->fetchAll();
                    return $result;
                }

    }
    
?>