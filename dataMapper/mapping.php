<?php

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

}

class PhoneMapper{
    protected $pdo;

    public function __construct(PDO $db)
    {
        $this->pdo = $db;
    }

    public function save(Phone $phone) : bool {
        $stmt = $this->pdo->prepare("INSERT INTO phone (num, naming, imei) values(?,?,?)");
        $stmt->bindParam(1, $phone->num, PDO::PARAM_INT);
        $stmt->bindParam(2, $phone->naming, PDO::PARAM_STR, 12);
        $stmt->bindParam(3, $phone->imei, PDO::PARAM_INT, 12);
        return $stmt->execute();
    }
    public function remove($phone) {
        $stmt = $this->pdo->prepare("Delete from phone where num = ?, naming = ?, imei = ? ");
        $stmt->bindParam(1, $phone->num, PDO::PARAM_INT);
        $stmt->bindParam(2, $phone->naming, PDO::PARAM_STR, 12);
        $stmt->bindParam(3, $phone->imei, PDO::PARAM_INT, 12);
        return $stmt->execute();
    }
    public function getById($id): Phone
    {
        $stmt = $this->pdo->prepare("Select * from phone where id = ? ");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return new Phone($row['num'],$row['naming'],$row['imei']);
    }
    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT num,naming,imei FROM phone");
        $tableList = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tableList[] = array('num'=>$row['num'], 'naming'=>$row['naming'], 'imei'=>$row['imei']);
        }
        return $tableList;
    }
    public function getByField($fieldValue): array
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


