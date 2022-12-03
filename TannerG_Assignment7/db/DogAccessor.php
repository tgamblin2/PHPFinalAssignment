<?php
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/tgamb/TannerG_Assignment7';
require_once 'ConnectionManager.php';
require_once ($projectRoot . '/entity/Dog.php');

class DogAccessor {

    private $getByIDStatementString = "select * from AVAILABLEDOGS where dogID = :dogID";
    private $deleteStatementString = "delete from AVAILABLEDOGS where dogID = :dogID";
    private $insertStatementString = "insert INTO AVAILABLEDOGS values (:dogID, :dogName, :dogAge, :dogBreed, :trained)";
    private $updateStatementString = "update AVAILABLEDOGS set dogName = :dogName, dogAge = :dogAge, dogBreed = :dogBreed, trained = :trained where dogID = :dogID";
    private $conn = NULL;
    private $getByIDStatement = NULL;
    private $deleteStatement = NULL;
    private $insertStatement = NULL;
    private $updateStatement = NULL;

    // Constructor will throw exception if there is a problem with ConnectionManager,
    // or with the prepared statements.
    public function __construct() {
        $cm = new ConnectionManager();

        $this->conn = $cm->connect_db();
        if (is_null($this->conn)) {
            throw new Exception("no connection");
        }
        $this->getByIDStatement = $this->conn->prepare($this->getByIDStatementString);
        if (is_null($this->getByIDStatement)) {
            throw new Exception("bad statement: '" . $this->getAllStatementString . "'");
        }

        $this->deleteStatement = $this->conn->prepare($this->deleteStatementString);
        if (is_null($this->deleteStatement)) {
            throw new Exception("bad statement: '" . $this->deleteStatementString . "'");
        }

        $this->insertStatement = $this->conn->prepare($this->insertStatementString);
        if (is_null($this->insertStatement)) {
            throw new Exception("bad statement: '" . $this->getAllStatementString . "'");
        }

        $this->updateStatement = $this->conn->prepare($this->updateStatementString);
        if (is_null($this->updateStatement)) {
            throw new Exception("bad statement: '" . $this->updateStatementString . "'");
        }
    }

    /**
     * Gets dog items by executing a SQL "select" statement. An empty array
     * is returned if there are no results, or if the query contains an error.
     * 
     * @param String $selectString a valid SQL "select" statement
     * @return array Dog objects
     */
    private function getItemsByQuery($selectString) {
        $result = [];

        try {
            $stmt = $this->conn->prepare($selectString);
            $stmt->execute();
            $dbresults = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dbresults as $r) {
                $dogID = $r['dogID'];
                $dogName = $r['dogName'];
                $dogAge = $r['dogAge'];
                $dogBreed = $r['dogBreed'];
                $trained = $r['trained'];
                $obj = new Dog($dogID, $dogName, $dogAge, $dogBreed, $trained);
                array_push($result, $obj);
            }
        }
        catch (Exception $e) {
            $result = [];
        }
        finally {
            if (!is_null($stmt)) {
                $stmt->closeCursor();
            }
        }

        return $result;
    }

    /**
     * Gets all dogs.
     * 
     * @return array Dog objects, possibly empty
     */
    public function getAllItems() {
        return $this->getItemsByQuery("select * from AVAILABLEDOGS");
    }

    /**
     * Gets the dog with the specified ID.
     * 
     * @param Integer $dogID the ID of the dog to retrieve 
     * @return the Dog object with the specified ID, or NULL if not found
     */
    private function getItemByID($dogID) {
        $result = NULL;

        try {
            $this->getByIDStatement->bindParam(":dogID", $dogID);
            $this->getByIDStatement->execute();
            $dbresults = $this->getByIDStatement->fetch(PDO::FETCH_ASSOC); // not fetchAll

            if ($dbresults) {
                $dogID = $dbresults['dogID'];
                $dogName = $dbresults['dogName'];
                $dogAge = $dbresults['dogAge'];
                $dogBreed = $dbresults['dogBreed'];
                $trained = $dbresults['trained'];
                $result = new Dog($dogID, $dogName, $dogAge, $dogBreed, $trained);
            }
        }
        catch (Exception $e) {
            $result = NULL;
        }
        finally {
            if (!is_null($this->getByIDStatement)) {
                $this->getByIDStatement->closeCursor();
            }
        }

        return $result;
    }

    /**
     * Deletes a dog.
     * @param Dog $dog a dog whose ID is EQUAL TO the ID of the dog to delete
     * @return boolean indicates whether the item was deleted
     */
    public function deleteItem($dog) {
        $success = false;

        $dogID = $dog->getDogID(); // only the ID is needed

        try {
            $this->deleteStatement->bindParam(":dogID", $dogID);
            $success = $this->deleteStatement->execute(); // this doesn't mean what you think it means
            $rc = $this->deleteStatement->rowCount();
        }
        catch (PDOException $e) {
            $success = false;
        }
        finally {
            if (!is_null($this->deleteStatement)) {
                $this->deleteStatement->closeCursor();
            }
            return $success;
        }
    }

    /**
     * Inserts a dog into the database.
     * 
     * @param DogItem $item an object of type DogItem
     * @return boolean indicates if the item was inserted
     */
    public function addItem($item) {
        $success = false;

        $dogID = $item->getDogID();
        $dogName = $item->getDogName();
        $dogAge = $item->getDogAge();
        $dogBreed = $item->getDogBreed();
        $trained = $item->getTrained();

        try {
            $this->insertStatement->bindParam(":dogID", $dogID);
            $this->insertStatement->bindParam(":dogName", $dogName);
            $this->insertStatement->bindParam(":dogAge", $dogAge);
            $this->insertStatement->bindParam(":dogBreed", $dogBreed);
            $train = $trained == true ? 1 : 0;
            $this->insertStatement->bindParam(":trained", $train);
            $success = $this->insertStatement->execute();// this doesn't mean what you think it means
        }
        catch (PDOException $e) {
            $success = false;
        }
        finally {
            if (!is_null($this->insertStatement)) {
                $this->insertStatement->closeCursor();
            }
            return $success;
        }
    }

    /**
     * Updates a dog in the database.
     * 
     * @param Dog $item an object of type Dog, the new values to replace the database's current values
     * @return boolean indicates if the item was updated
     */
    public function updateItem($item) {
        $success = false;

        $dogID = $item->getDogID();
        $dogName = $item->getDogName();
        $dogAge = $item->getDogAge();
        $dogBreed = $item->getDogBreed();
        $trained = $item->getTrained();

        try {
            $this->updateStatement->bindParam(":dogID", $dogID);
            $this->updateStatement->bindParam(":dogName", $dogName);
            $this->updateStatement->bindParam(":dogAge", $dogAge);
            $this->updateStatement->bindParam(":dogBreed", $dogBreed);
            $train = $trained == true ? 1 : 0;
            $this->updateStatement->bindParam(":trained", $train);
            $success = $this->updateStatement->execute();// this doesn't mean what you think it means
        }
        catch (PDOException $e) {
            $success = false;
        }
        finally {
            if (!is_null($this->updateStatement)) {
                $this->updateStatement->closeCursor();
            }
            return $success;
        }
    }

}
// end class DogAccessor