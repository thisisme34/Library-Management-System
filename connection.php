<?php
class Connection
{
    protected $connection;

    function setConnection()
    {
        try {
            $db_server = "localhost:3307";
            $db_user = "root";
            $db_pass = "";
            $db_name = "library_management";
            $this->connection = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

            if (!$this->connection) {
                throw new mysqli_sql_exception("Could not connect");
            }
        } catch (mysqli_sql_exception $ex) {
            echo $ex->getMessage();
        }
    }

    function getConnection()
    {
        return $this->connection;
    }
}
?>
