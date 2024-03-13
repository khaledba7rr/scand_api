<?php
namespace models\dbcontext;

use mysqli;

class ProductsDbContext {
    private $_host = "sql.freedb.tech";
    private $_user = "freedb_khaledbahr";
    private $_password = "JKCGm8!s398y&rU";
    private $_database = "freedb_scandi_prod";
    
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->_host, $this->_user, $this->_password, $this->_database);

        if($this->conn->connect_error)
        {
            die ("<h1>Database connection failed ! <h1>");
        }

        return $this->conn;
    }
    

}


