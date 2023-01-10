<?php

Class Auto {
    private $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }
    public function GetAuto()
    {
        $this->db->query('SELECT auto.Type, auto.Kenteken, kilometerstand.Id
                          From auto 
                          INNER JOIN kilometerstand on auto.Id = kilometerstand.AutoId
                          ');
        $result = $this->db->resultSet();
        return $result;
    }

    public function addKmStand()
    {
        $sql = "INSERT INTO kilometerstand(Id, KmStand) 
                VALUES                    (:Id, :KmStand)";
        $this->db->query($sql);
        $this->db->bind(':Id', $_POST('Id'), PDO::PARAM_INT);
        $this->db->bind(':KmStand', $_POST('KmStand'), PDO::PARAM_INT);
        return $this->db->execute();
    }
}