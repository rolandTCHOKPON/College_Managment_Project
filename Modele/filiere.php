<?php
include_once("Connection.php");
class Filiere
{ 
    private $_id;
    private $_nom;
    private $_nbr;
    private $_responsable_filiere;

    public function __construct($_nom, $_nbr, $_responsable_filiere)
    {
        $con = new Connect();
        $con = $con->connector();

        $sql = "SELECT id FROM Filiere";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $i = 0;
        while($row = mysqli_fetch_assoc($result)) {
           $mat[$i] = $row["id"];
           $i++;
        }
        } else {
            $this->_id = 1;
        }
        mysqli_close($con);
        $this->_id = $mat[mysqli_num_rows($result)-1] + 1;
        $this->_nom = $_nom;
        $this->_nbr = $_nbr;
        $this->_responsable_filiere = $_responsable_filiere;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getNom()
    {
        return $this->_nom;
    }

    public function getNbr()
    {
        return $this->_nbr;
    }

    public function getResp()
    {
        return $this->_responsable_filiere;
    }

    

    public function enregistrerFiliere()
    {

        $con = new Connect();
        $con = $con->connector();
        $sql = "INSERT INTO Filiere VALUES ('$this->_id', '$this->_nom', '$this->_responsable_filiere')";
        
        if (mysqli_query($con, $sql))
        {
            echo "Filière enregistrée avec succès";
        }
        
        else
        {
            echo "Echec d'enregistrement";
        }
        
        mysqli_close($con);
    }

    public function deleteFiliere($idF)
    {
        $con = new Connect();
        $con = $con->connector();

        $sql = "Delete FROM Filiere where id = $idF";

        if(mysqli_query($con, $sql))
        {
            echo "Filière supprimée avec succès";
        }
        
        else
        {
            echo "Erreur lors de la suppression, veillez réessayer";
        }
    
        mysqli_close($con);
    }

    

    public function modifierResponsableOfFiliere($idF, $respoF)
    {
        $con = mysqli_connect("localhost", "root", "", "PROJET_WEB");
        
        if (!$con)
        {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE  Filiere SET responsable_filiere = '$respoF' WHERE id = 'idF' ";
        
        if(mysqli_query($con, $sql))
        {
            echo "Responsable modifié avec succès";
        }
        
        else
        {
            echo "Erreur lors de la modification";
        }
    
        mysqli_close($con);
    }

    public function modifierNomOfFiliere($idF, $n)
    {
        $con = mysqli_connect("localhost", "root", "", "PROJET_WEB");
        
        if (!$con)
        {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE  Filiere SET nom = '$n' WHERE id = 'idF' ";
        
        if(mysqli_query($con, $sql))
        {
            echo "Nom de la filière modifié avec succès";
        }
        
        else
        {
            echo "Erreur lors de la modification";
        }
    
        mysqli_close($con);
    }

}

function func1liste()
{
    $con = mysqli_connect("localhost", "root", "", "PROJET_WEB");

    if (!$con)
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    else{
        $sql = "SELECT id, nom, responsable_filiere FROM Filiere";
        $result = mysqli_query($con, $sql);
        $lim = mysqli_num_rows($result);
        $tab = array();
        for($i = 0; $i < $lim;  $i++)
        {
            $row = mysqli_fetch_assoc($result);
            $name_F = $row['nom'];
            $resp_F = $row['responsable_filiere'];
            $sql = 'SELECT * FROM Etudiant WHERE id_Filiere='.$row['id'];
            $resultt = mysqli_query($con, $sql);
	    $nb = mysqli_num_rows($resultt);
	    $obj = new Filiere($name_F, $nb, $resp_F);
            $tab[$i] = $obj;
        }
        mysqli_close($con);
        return $tab;
    }
}
?>
