<?php
/**
 * Created by Compa for the CompaApp project
 * Date: 16/09/2016
 */
 
 class Groups
 {
     public $GroupId;
     public $SchoolId;
     public $SchoolShortName;
     public $Day;
     public $Hour;
     public $Latitude;
     public $Longitude;
     public $Address;
     public $IsActive;
     public $Where;

     public function GetGroups()
     {
         global $DB;
         $stmt = $DB->prepare("SELECT g.GroupId, g.SchoolId, g.Day, g.Hour, g.latitude, g.Longitude,
         g.Address, g.IsActive, g.Where, s.ShortName
         FROM groups as g INNER JOIN schools as s
         ON g.SchoolId = s.SchoolId;");

         $stmt->setFetchMode(PDO::FETCH_CLASS, 'Groups');
         $stmt->execute();
         return $stmt->fetchAll();
     }

     public function AddGroup()
     {
         global $DB;
         $sql = "INSERT INTO `groups` (`SchoolId`, `Day`, `Hour`, `Latitude`, `Longitude`, `Address`, `IsActive`, `Where`) 
         VALUES (?, ?, ?, ?, ?, ?, ?)";
         
         try{
             $stmt = $DB->prepare($sql);
             $stmt->execute(array($this->SchoolId, $this->Day, $this->Hour, $this->Latitude, $this->Longitude, $this->Address, $this->IsActive, $this->Where));
             $this->GroupId = $DB->lastInsertId();
             return TRUE;

         }catch(PDOException $ex)
         {
             throw $ex;
         }

     }

     public function UpdateGroup()
     {
         global $DB;
         $sql = "UPDATE `groups` SET `SchoolId`= ?, `Day`= ?, `Hour`= ?, `Latitude`= ?, `Longitude`= ?, `Address`= ?, `IsActive`= ?, `Where`= ? WHERE `GroupId`= ?";

         try{
             $stmt = $DB->prepare($sql);
             $stmt->execute(array($this->SchoolId, $this->Day, $this->Hour, $this->Latitude, $this->Longitude, $this->Address, $this->IsActive, $this->Where, $this->GroupId));
             return TRUE;

         }catch(PDOException $ex)
         {
             throw $ex;
         }
     }

     public function GetByGroupId($GroupId)
    {
        global $DB;
        $sql = "SELECT * FROM `groups` WHERE GroupId = ?";
        $stmt = $DB->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Groups');
        $stmt->execute(array($GroupId));
        $result = $stmt->fetch(PDO::FETCH_CLASS);
        //echo print_r($result);
        //echo print_r($stmt->fetchColumn());

        if($result)
        {
            return $result;
        }
        else
        {
            return NULL;
        }
    }

    function GetNearestGroups($lat, $long, $dist)
    {
        global $DB;
        $sql = "SELECT g.*, s.SchoolShortName, s.Name as SchoolName, SQRT( POW(111 * (Latitude - ?), 2) +
        POW(111 * (? - Longitude) * COS(Latitude / 57.3), 2)) AS Distance
        FROM groups as g
        INNER JOIN schools as s on s.SchoolId = g.SchoolId 
        HAVING distance < ? ORDER BY distance";
        

        $stmt = $DB->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Groups');
        $stmt->execute(array($lat, $long, $dist));
        return $stmt->fetchAll();
        
    }

    

 }