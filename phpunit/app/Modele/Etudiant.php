<?php

namespace App\Modele;

include_once("Connection.php");

class Etudiant {
    
    private $_matricule; 
	private $_nom; 
	private $_prenom; 
	private $_date_naissance;
	private $_lieu_naissance; 
	private $_nationalite;
	private $_email; 
	private $_genre; 
	private $_contact; 
	private $_adresse; 
	private $_photo;
	private $_id_Filiere; 
    
     
    public function __construct($_nom, $_prenom, $_date_naissance,
    $_lieu_naissance, $_nationalite, $_email, $_genre, $_contact, $_adresse, 
    $_photo=null, $_id_Filiere){

        $con = new Connect();
        $con = $con->connector();

        $sql = "SELECT matricule FROM Etudiant";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $i = 0;
        while($row = mysqli_fetch_assoc($result)) {
           $mat[$i] = $row["matricule"];
           $i++;
        }
        } else {
            $this->_matricule = 1;
        }
        mysqli_close($con);

        $this->_matricule = $mat[mysqli_num_rows($result)-1] + 1;
        $this->_nom= $_nom; 
        $this->_prenom = $_prenom ;
        $this->_date_naissance = $_date_naissance;
        $this->_lieu_naissance = $_lieu_naissance ;
        $this->_nationalite = $_nationalite ;
        $this->_email = $_email;
        $this->_genre = $_genre;
        $this->_contact= $_contact;
        $this->_adresse= $_adresse; 
        $this->_photo = $_photo;
        $this->_id_Filiere = $_id_Filiere;
    }


    //Les getters 

    public function getMatricule(){
        return $this->_matricule;
    }

    public function getNom(){
        return $this->_nom;
    }

    public function getPrenom(){
        return $this->_prenom;
    }

    public function getDateNaiss(){
        return $this->_date_naissance;
    }
    public function getLieuNaiss(){
        return $this->_lieu_naissance;
    }
    public function getNationalite(){
        return $this->_nationalite;
    }
    public function getEmail(){
        return $this->_email;
    }
    public function getGenre(){
        return $this->_genre;
    }
    public function getContact(){
        return $this->_contact;
    }
    public function getAdresse(){
        return $this->_adresse;
    }
    public function getPhoto(){
        return $this->_photo;
    }
    public function getIdFiliere(){
        $con = new Connect();
        $con = $con->connector();
        $sql = "SELECT * FROM Filiere WHERE id =".$this->_id_Filiere;
        $result = mysqli_query($con, $sql);
        $lim = mysqli_num_rows($result);
       
        $row = mysqli_fetch_assoc($result);
        if($lim != 0){
            return $row['nom'];
        }else{ 
            return -1;
        }
        
    }
    

    public function lastMatricule(){
        $con = new Connect();
        $con = $con->connector();
    
        $sql = "SELECT matricule FROM Etudiant";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $i = 0;
        while($row = mysqli_fetch_assoc($result)) {
           $mat[$i] = $row["matricule"];
           $i++;
        }
        } else {
          return 1;
        }
          return $mat[mysqli_num_rows($result)-1];
        mysqli_close($con);
    }


    public function inscritEtudiant(){
        $con = new Connect();
        $conn = $con->connector();

        $sql = "INSERT INTO Etudiant VALUES ('$this->_matricule',
        '$this->_nom',
        '$this->_prenom',
        '$this->_date_naissance',
        '$this->_lieu_naissance',
        '$this->_nationalite',
        '$this->_email',
        '$this->_genre',
        '$this->_contact',
        '$this->_adresse', 
        '$this->_photo',
        '$this->_id_Filiere')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Succès de l'enregistrement";
          } else
          {
              echo "Erreur d'enregistrement";
          }
        
       
          mysqli_close($conn);
        
    }

}

function search($matricule, $nom, $prenom){
    $con = new Connect();
    $conn = $con->connector();

    $sql = "SELECT * FROM Etudiant WHERE matricule =". $matricule;
    $result = mysqli_query($conn, $sql);
    
    $lim = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    if(($lim != 0) AND ($row['nom']==$nom) AND ($row['prenom']==$prenom) ){

    $dateNaiss = $row['date_naissance'];
    $LieuNaiss = $row['lieu_naissance'];
    $nationalite= $row['nationalite'];
    $email= $row['email'];
    $genre= $row['genre'];
    $adresse= $row['adresse'];
    $contact = $row['contact'];
    $photo= $row['photo'];
    $idFiliere= $row['id_Filiere'];
    }else{
        $dateNaiss = "none";
        $LieuNaiss = "none";
        $nationalite= "none";
        $email= "none";
        $genre= "none";
        $adresse= "none";
        $contact = "none";
        $photo= "none";
        $idFiliere= "none";
    }

    $obj = new Etudiant($nom, $prenom, $dateNaiss, $LieuNaiss, $nationalite, $email, $genre, $contact,
    $adresse, $photo, $idFiliere);
    
        mysqli_close($conn);
        return $obj;
}

?>
