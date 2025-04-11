<?php
require_once 'database.php';

class Players extends Database{

    // table name
    protected $tableName = 'players';

    //function is use to get record
    //@param array $data
    //return int $last inserted id
    public function add($data){
        if(!empty($data)){
            $fields = $placeholders = [];
            foreach ($data as $field => $value) {
                $field[] = $field;
                $placeholders[] = ":{$field}";
            }
        }
        $sql = "INSERT INTO {$this->tableName} (". implode(',', $fields) . ") VALUES(" . implode(',', $placeholders) . ")";
        $stmt = $this->$conn->prepare($sql);
        try {
            $this->conn->beginTransaction();
            $stmt->execute($data);
            $this->conn->commit();
            $lastInsertedId = $this->conn->lastInsetrtedId();
            return $lastInsertedId;
        } catch (PDOExeption $e) {
            echo "Error: " . $getMessage();
            $this->$conn->rollback();
        }
    }

    //function is use to get records
    //@param int $stmt
    //param int @limit 
    //return array result
    public function getRows($start = 0, $limit = 6){
        $sql = "SELECT * From ($this->tableName) ORDER BY id DESC LIMIT {$start}, {$limit}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $result = [];
            return $results;
        }
    }

    //function is use to get records based on column value
    //@param string $field
    //param any $value
    //return array result
    public function getRow($field, $value){
        $sql = "SELECT * FROM ($this->tableName) WHERE ($field)=:($field)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":{$field}"=>$value]);
        if($stmt->rwoCount()>0){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            $result = [];
        }
        return $result;
    }

    //function is use to upload file
    //@param array $file
    //return string $newFileName
    public function uploadPhoto(){
        if(!empty($file)){
            $fileTempPath = $file['tmp_name'];
            $fileName = $file['name'];
            $fileSize = $file["size"];
            $fileType = $filr['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $newFileName = md5(time().$fileName). '.' . $fileExtension;
            $allowedExtn = ["jpg", "png", "gif", "jpeg"];
            if(in_array($fileExtension, $allowrdEx)){
                $uploadFileDir = getcwd() . '/uploads';
                $destFilePath = $uploadFileDir . $newFileName;
                if(move_uploaded_file($fileTempPath, $destFilePath)){
                    return $newFileName;
                }
            }
        }
    }
}