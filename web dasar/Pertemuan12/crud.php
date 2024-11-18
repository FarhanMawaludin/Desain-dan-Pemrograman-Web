<?php
require_once 'database.php';
class Crud{
    private $db;
    public function __construct(){
        $this->db = new Database();
    }
    public function create($jabatan,$keterangan){
        $query = "INSERT INTO jabatan (jabatan, keterangan) VALUES ('$jabatan', '$keterangan')";
        $result = $this->db->conn->query($query);
        return $result;
    }
        public function read(){
            $query = "SELECT * FROM jabatan";
            $result = $this->db->conn->query($query);
            
            $data = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $data[] = $row; 
                }
            }
            return $data;
        }
        public function readById(){
            $id = $_GET['id'];
            $query = "SELECT * FROM jabatan WHERE id = $id";
            $result = $this->db->conn->query($query);
            
           if ($result->num_rows == 1) {
            return $row = $result->fetch_assoc();
           }
           else{
            return null;
           }
        }
        public function update($id,$jabatan,$keterangan){
            $query = "UPDATE jabatan SET jabatan = '$jabatan', keterangan = '$keterangan' WHERE id = $id";
            $result = $this->db->conn->query($query);
            return $result;
        }
        public function delete($id){
            $query = "DELETE FROM jabatan WHERE id = $id";
            $result = $this->db->conn->query($query);
            return $result;
        }

    }


?>