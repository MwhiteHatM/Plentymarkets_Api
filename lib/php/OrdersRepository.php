<?php


class OrdersRepository {
     
    private $ordersTable = "orders";    // orders table 
    private $itemsTable = "items";   // items table 




    public function addOrders($pm_id, $object) {
        //connection with database
        @require("db.inc.php");
        $stmt = $conn->prepare("INSERT INTO " . $this->ordersTable . " (pm_id, object) VALUES (:pm_id, :object)");
        $stmt->bindParam(':pm_id', $pm_id);
        $stmt->bindParam(':object', $object);
        @$result = $stmt->execute();        //$result = our statment
        //close connection with DB safly
        $this->conn = null;
        // this function will return $result value
        return $result;
    }
    
    public function addItems ($order_id, $item_id , $name) {
        //connection with database
        @require("db.inc.php");
        $stmt = $conn->prepare("INSERT INTO " . $this->itemsTable . " (order_id, item_id, name) VALUES (:order_id, :item_id, :name)");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':item_id', $item_id);
        $stmt->bindParam(':name', $name);
        @$result = $stmt->execute();        //$result = our statment
        //close connection with DB safly
        $this->conn = null;
        // this function will return $result value
        return $result;
    }


    public function dropCreateTable () {
        
        @require("db.inc.php");
        
        // drop orders, items tables  
        $dropTables = $conn->prepare("DROP TABLE IF EXISTS {$this->itemsTable} , {$this->ordersTable}");
        $resultDropTables = $dropTables->execute();
        // create orders table 
        $createOrdersTable = $conn->prepare("CREATE TABLE IF NOT EXISTS {$this->ordersTable} (pm_id INT NOT NULL UNIQUE, object LONGTEXT, PRIMARY KEY (pm_id))");
        $resultCreate = $createOrdersTable->execute();
        // create items table 
        $createOrdersTable = $conn->prepare("CREATE TABLE IF NOT EXISTS {$this->itemsTable} (id INT NOT NULL AUTO_INCREMENT, order_id int, item_id INT Not Null, name TEXT ,PRIMARY KEY (id), FOREIGN KEY (order_id) REFERENCES orders(pm_id) )");
        $resultCreate = $createOrdersTable->execute();
        //close connection
        $this->conn = null;  
        
    }

}

?>