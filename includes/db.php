<?php
if (!class_exists('PDO_DB')) {
    class PDO_DB
    {
        public function __construct($db_name, $db_user, $db_pass, $db_charset, $db_host = 'localhost')
        {
            $dsn = "mysql:host=$db_host;dbname=$db_name";
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            );

            $this->conn = new PDO($dsn, $db_user, $db_pass, $options);
        }


        public function is_present($query, array $params = array())
        {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            if ($stmt->rowCount()) {
                return true;
            }
            return false;
        }
    

    public function query($query)
    {
        $stmt = $this->conn->query($query);
			// returns records
        while ($row = $stmt->fetch()) {
            $results[] = $row;
        }

        return $results;
    }

    public function get($query, $params = array())
    {
        if (empty($params)) {
            return $this->query($query);
        }

        if (!$stmt = $this->conn->prepare($query)) {
            return false;
        }

        if($stmt->execute($params)){

            while ($row = $stmt->fetch()) {
                $results[] = $row;
            }

            if (!empty($results)) {

                if(count($results) == 1){
                    $results = $results[0];
                    return $results;
                }

                return $results;

            }
            
            // Execute returns a boolean, which is useful perticularly for queries that return no data.
            return true;
        }
        return false;
    }

    public function get_row($table, $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$table} WHERE ID = :id");
        $stmt->execute(array('id' => $id));
        $result = $stmt->fetch();

        return $result;
    }
    }
}

$db = new PDO_DB(db_name, db_username, db_password, "utf-8", db_adress);




