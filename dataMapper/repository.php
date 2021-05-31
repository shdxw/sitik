<?php
interface PhoneRepository {
    public function save(Phone $phone);
    public function remove(Phone $phone);
    public function getById($id);
    public function all();
    public function getByField($fieldValue);
}

class PostgrePhoneRepository implements PhoneRepository {

    protected $pdo;

    public function __construct(PDO $db)
    {
        $this->pdo = $db;
    }

    public function save(Phone $phone)
    {
        $stmt = $this->pdo->prepare("INSERT INTO phone (num, naming, imei) values(?,?,?)");
        $stmt->bindParam(1, $phone->num, PDO::PARAM_INT);
        $stmt->bindParam(2, $phone->naming, PDO::PARAM_STR, 12);
        $stmt->bindParam(3, $phone->imei, PDO::PARAM_INT, 12);
        return $stmt->execute();
    }

    public function remove(Phone $phone)
    {
        $stmt = $this->pdo->prepare("Delete from phone where num = ?, naming = ?, imei = ? ");
        $stmt->bindParam(1, $phone->num, PDO::PARAM_INT);
        $stmt->bindParam(2, $phone->naming, PDO::PARAM_STR, 12);
        $stmt->bindParam(3, $phone->imei, PDO::PARAM_INT, 12);
        return $stmt->execute();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("Select * from phone where id = ? ");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return new Phone($row['num'],$row['naming'],$row['imei']);
    }

    public function all()
    {
        $stmt = $this->pdo->query("SELECT num,naming,imei FROM phone");
        $tableList = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tableList[] = array('num'=>$row['num'], 'naming'=>$row['naming'], 'imei'=>$row['imei']);
        }
        return $tableList;
    }

    public function getByField($fieldValue)
    {
        $stmt = $this->pdo->prepare("Select ? from phone ");
        $stmt->bindParam(1, $fieldValue, PDO::PARAM_INT);
        $stmt->execute();
        $tableList = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tableList[] = array('num'=>$row['num'], 'naming'=>$row['naming'], 'imei'=>$row['imei']);
        }
        return $tableList;
    }
}