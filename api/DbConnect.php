<?php
    /**
    * Database Connection
    */
    class DbConnect {
        private $server = 'mysql';
        private $dbname = 'nfpcodb';
        private $user = 'nfpco_user';
        private $pass = 'nfpco_pwd';
        public function connect() {
            try {
                $conn = new PDO('mysql:host=' .$this->server .';port=3306;dbname=' . $this->dbname, $this->user, $this->pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch (\Exception $e) {
                echo "Database Error: " . $e->getMessage();
            }
        }

    }
?>