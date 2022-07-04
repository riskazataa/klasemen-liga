<?php

class Mysql {

    public $connectionString;
    public $dataSet;
    
    protected $databaseName;
    protected $hostName;
    protected $userName;
    protected $passCode;

    function __construct() {
        $this->connectionString = NULL;
        $this->dataSet = NULL;

        $this->databaseName = 'db_klasemen_sepakbola';
        $this->hostName = 'localhost';
        $this->userName = 'root';
        $this->passCode = '';
    }
  
    function dbConnect() {
        $this->databaseName = (empty($this->databaseName)) ? 'db_klasemen_sepakbola' : $this->databaseName;
        $this->hostName = (empty($this->hostName)) ?'localhost' : $this->hostName;
        $this->userName = (empty($this->userName)) ?'root' : $this->userName;
        $this->passCode = (empty($this->passCode)) ?'' : $this->passCode;
        $this->connectionString = mysqli_connect($this->hostName,$this->userName,$this->passCode, $this->databaseName) or die(mysqli_connect_error());
        return $this->connectionString;
    }

    function query($query) {
        $this->dataSet = mysqli_query($this->connectionString, $query);
        return $this->dataSet;
    }
}
?>
