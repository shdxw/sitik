<?php
$pdo = require 'connect.php';


class Phone
{
    private $num;
    private $naming;
    private $imei;


    /**
     * Phone constructor.
     * @param $num
     * @param $naming
     * @param $imei
     */
    public function __construct($num, $naming, $imei)
    {
        $this->num = $num;
        $this->naming = $naming;
        $this->imei = $imei;
    }

    /**
     * @return mixed
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * @return mixed
     */
    public function getNaming()
    {
        return $this->naming;
    }

    /**
     * @return mixed
     */
    public function getImei()
    {
        return $this->imei;
    }

    public function save($pdo) : bool {
        $stmt = $pdo->prepare("INSERT INTO phone (num, naming, imei) values(?,?,?)");
        $stmt->bindParam(1, $this->num, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->naming, PDO::PARAM_STR, 12);
        $stmt->bindParam(3, $this->imei, PDO::PARAM_INT, 12);
        return $stmt->execute();
    }
    public function remove($pdo) {
        $stmt = $pdo->prepare("Delete from phone where num = ?, naming = ?, imei = ? ");
        $stmt->bindParam(1, $this->num, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->naming, PDO::PARAM_STR, 12);
        $stmt->bindParam(3, $this->imei, PDO::PARAM_INT, 12);
        return $stmt->execute();
    }
    public function getById($pdo,$id): Phone
    {
        $stmt = $pdo->prepare("Select * from phone where id = ? ");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return new Phone($row['num'],$row['naming'],$row['imei']);
    }
    public function all($pdo): array
    {
        $stmt = $pdo->query("SELECT num,naming,imei FROM phone");
        $tableList = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tableList[] = array('num'=>$row['num'], 'naming'=>$row['naming'], 'imei'=>$row['imei']);
        }
        return $tableList;
    }
    public function getByField($fieldValue,$pdo): array
    {
        $stmt = $pdo->prepare("Select ? from phone ");
        $stmt->bindParam(1, $fieldValue, PDO::PARAM_INT);
        $stmt->execute();
        $tableList = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tableList[] = array('num'=>$row['num'], 'naming'=>$row['naming'], 'imei'=>$row['imei']);
        }
        return $tableList;
    }

}