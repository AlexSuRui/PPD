<?php

include "classes.php";

$SERVER = "localhost";
$DATABASE = "NCSP";
$USER = "root";
$PASSWORD = "";
$DEBUG = false;

$message = "";
$erreur = "";

function debug_mode() {
    global $DEBUG;
    $DEBUG = true;
}

function connection($connect_to_database = true) {

    global $SERVER, $DATABASE, $USER, $PASSWORD, $DEBUG, $message, $erreur;
    global $connexion;
	
    if ($connect_to_database) 
        $connexion=mysqli_connect($SERVER,$USER,$PASSWORD,$DATABASE) or die("Error " . mysqli_error($connexion));
    else
        $connexion=mysqli_connect($SERVER,$USER,$PASSWORD) or die("Error " . mysqli_error($connexion));
}

function drop_database() {
    global $connexion, $DATABASE, $DEBUG, $message, $erreur;    
    if(mysqli_query($connexion,"DROP DATABASE ".$DATABASE)===true){
        if ($DEBUG)
            $message.="La base de données <b>".$DATABASE."</b> est supprimée avec succés.<br/>";
	}
    
    else
        if ($DEBUG)
            $erreur.= "Problème au niveau de la suppression de la base de données <b>".$DATABASE."</b><br/>".mysqli_error($connexion)."<br/>";
}

function create_database() {
    global $DATABASE, $DEBUG, $message, $erreur;
    global $connexion;
    if(mysqli_query($connexion,"CREATE DATABASE ".$DATABASE." DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci")===true)
    {
        if ($DEBUG)
            $message.="La base de données <b>".$DATABASE."</b> est créée avec succés.<br/>";
    }	
    else
        if ($DEBUG)
            $erreur.= "Problème lors de la création de la base de données <b>".$DATABASE."</b><br/>".mysqli_error($connexion)."<br/>";
    
    $db_selected=mysqli_select_db($connexion,$DATABASE);
    if(!$db_selected){
        die("Impossible de selectionner la base de données <b>".$DATABASE."</b><br/>".mysqli_connect_error());
    }	
}

function create_table() {
    global $connexion, $DEBUG, $message, $erreur;
    $arguments = func_get_args();
    $requete = "";
    $first = true;
    $second = true;
    $table_name = "";
    foreach ($arguments as $argument) {
        if ($first) {
            $table_name = $argument;
            $requete .= "CREATE TABLE ".$table_name." (";
            $first = false;
        } elseif ($second) {
            $requete .= $argument;
            $second = false;
        } else {
            $requete .= ", ".$argument;
        }
    }
    $requete .= ")";
	
	if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG)
            $message.= "Création de la table <b>".$table_name."</b> réussie.<br/>";
    }
    else 
    {
        if ($DEBUG)
            $erreur.=  "Erreur lors de la création de table <b>".$table_name."</b> (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
    }
}

function inserer_utilisateur($Nom, $Prenom, $Identifiant, $MotDePasse, $Email, $Statut, $Demandeur, $Bloque, $Reputation, $Administrateur) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "INSERT INTO UTILISATEUR (Nom, Prenom, Identifiant, MotDePasse, Email, Statut, Demandeur, Bloque, Reputation, Administrateur) VALUES ('$Nom', '$Prenom', '$Identifiant', '$MotDePasse', '$Email', '$Statut', $Demandeur, $Bloque, $Reputation, $Administrateur)";
        
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
			$message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $message .= "Profil <b>$Prenom $Nom ($Identifiant)</b> créé.<br />";
		}
        $UID = mysqli_insert_id($connexion);
        return new Utilisateur($UID, $Nom, $Prenom, $Identifiant, $MotDePasse, $Email, $Statut, $Demandeur, $Bloque, $Reputation, $Administrateur);
    }
    else 
    {
        if ($DEBUG) {
			$erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $erreur .= "Erreur lors de la création du profil <b>$Prenom $Nom ($Identifiant)</b> (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function maj_utilisateur($Utilisateur) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "UPDATE UTILISATEUR SET Nom = '".$Utilisateur->Nom."', Prenom = '".$Utilisateur->Prenom."', Identifiant = '".$Utilisateur->Identifiant."', MotDePasse = '".$Utilisateur->MotDePasse."', Email = '".$Utilisateur->Email."', Statut = '".$Utilisateur->Statut."', Demandeur = ".$Utilisateur->Demandeur.", Bloque = ".$Utilisateur->Bloque.", Reputation = ".$Utilisateur->Reputation.", Administrateur = ".$Utilisateur->Administrateur." WHERE UserUID = ".$Utilisateur->UID;
    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
        	$message .= "<b>Request : </b> ".$requete."<br/>";
            $message .= "Profil de <b>".$Utilisateur->Prenom." ".$Utilisateur->Nom." (".$Utilisateur->Identifiant.")</b> mis à jour.<br />";
		}
        return $Utilisateur;
    }
    else 
    {
        if ($DEBUG) {
        	$erreur .= "<b>Request : </b> ".$requete."<br/>";
            $erreur .= "Erreur lors de la mise du profil de <b>".$Utilisateur->Prenom." ".$Utilisateur->Nom." (".$Utilisateur->Identifiant.")</b> (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function supprimer_utilisateur($Utilisateur) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "DELETE FROM UTILISATEUR WHERE UserUID = ".$Utilisateur->UID;
    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
			$message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $message .= "Profil <b>".$Utilisateur->Prenom." ".$Utilisateur->Nom." (".$Utilisateur->Identifiant.")</b> supprimé avec succès.<br />";
		}
        return $Utilisateur;
    }
    else 
    {
        if ($DEBUG) {
            $erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $erreur .= "Erreur lors de la suppression du profil <b>".$Utilisateur->Prenom." ".$Utilisateur->Nom." (".$Utilisateur->Identifiant.")</b> (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function inserer_categorie($Nom, $Description, $CategorieParente = null) {
    global $connexion, $DEBUG, $message, $erreur;
	if ($CategorieParente == null)
		$requete = "INSERT INTO CATEGORIE (Nom, Description) VALUES ('$Nom', '$Description')";
	else
    	$requete = "INSERT INTO CATEGORIE (Nom, Description, CategorieParente) VALUES ('$Nom', '$Description', $CategorieParente)";

    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
            $message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $message .= "Catégorie <b>$Nom</b> ajoutée avec succès dans la base de données.<br />";
		}
        $UID = mysqli_insert_id($connexion);
        return new Categorie($UID, $Nom, $Description, $CategorieParente);        
    }
    else 
    {
        if ($DEBUG) {
            $erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $erreur .= "Erreur lors de l'ajout de la catégorie <b>$Nom</b> dans la base de données (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function maj_categorie($Categorie) {
    global $connexion, $DEBUG, $message, $erreur;
	if ($Categorie->CategorieParente == null) 
		$requete = "UPDATE CATEGORIE SET Nom = '".$Categorie->Nom."', Description = '".$Categorie->Description."' WHERE CategorieUID = ".$Categorie->UID;
	else
    	$requete = "UPDATE CATEGORIE SET Nom = '".$Categorie->Nom."', Description = '".$Categorie->Description."', CategorieParente = '".$Categorie->CategorieParente."' WHERE CategorieUID = ".$Categorie->UID;
    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
        	$message .= "<b>Request : </b> ".$requete."<br/>";
            $message .= "Catégorie <b>".$Categorie->Nom."</b> mise à jour.<br />";
		}
        return $Categorie;
    }
    else 
    {
        if ($DEBUG) {
        	$erreur .= "<b>Request : </b> ".$requete."<br/>";
            $erreur .= "Erreur lors de la mise de la catégorie <b>".$Categorie->Nom."</b> (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}


function supprimer_categorie($Categorie) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "DELETE FROM CATEGORIE WHERE CategorieUID = ".$Categorie->UID;
    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
			$message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $message .= "Catégorie <b>".$Categorie->Nom."</b> supprimé avec succès.<br />";
		}
        return $Categorie;
    }
    else 
    {
        if ($DEBUG) {
            $erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $erreur .= "Erreur lors de la suppression de la categorie <b>".$Categorie->Nom."</b> (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function inserer_type($Nom, $Description) {
    global $connexion, $DEBUG, $message, $erreur;
	$requete = "INSERT INTO TYPE (Nom, Description) VALUES ('$Nom', '$Description')";
    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
            $message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $message .= "Type <b>$Nom</b> ajouté avec succès dans la base de données.<br />";
		}
        $UID = mysqli_insert_id($connexion);
        return new Type($UID, $Nom, $Description);        
    }
    else 
    {
        if ($DEBUG) {
            $erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $erreur .= "Erreur lors de l'ajout du type <b>$Nom</b> dans la base de données (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function maj_type($Type) {
    global $connexion, $DEBUG, $message, $erreur;
	$requete = "UPDATE TYPE SET Nom = '".$Type->Nom."', Description = '".$Type->Description."' WHERE TypeUID = ".$Type->UID;
	    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
        	$message .= "<b>Request : </b> ".$requete."<br/>";
            $message .= "Type <b>".$Type->Nom."</b> mis à jour.<br />";
		}
        return $Type;
    }
    else 
    {
        if ($DEBUG) {
        	$erreur .= "<b>Request : </b> ".$requete."<br/>";
            $erreur .= "Erreur lors de la mise du type <b>".$Type->Nom."</b> (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function supprimer_type ($Type) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "DELETE FROM TYPE WHERE TypeUID = ".$Type->UID;
    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
			$message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $message .= "Type <b>".$Type->Nom."</b> supprimé avec succès.<br />";
		}
        return $Type;
    }
    else 
    {
        if ($DEBUG) {
            $erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $erreur .= "Erreur lors de la suppression du type <b>".$Type->Nom."</b> (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function inserer_algorithme($Nom, $Description, $TypeUID) {
    global $connexion, $DEBUG, $message, $erreur;
	$requete = "INSERT INTO ALGORITHME (Nom, Description, TypeUID) VALUES ('$Nom', '$Description', $TypeUID)";
    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
            $message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $message .= "Algorithme <b>$Nom</b> ajouté avec succès dans la base de données.<br />";
		}
        $UID = mysqli_insert_id($connexion);
        return new Algorithme($UID, $Nom, $Description, $TypeUID);        
    }
    else 
    {
        if ($DEBUG) {
            $erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $erreur .= "Erreur lors de l'ajout de l'algorithme <b>$Nom</b> dans la base de données (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function maj_algorithme($Algorithme) {
    global $connexion, $DEBUG, $message, $erreur;
	$requete = "UPDATE ALGORITHME SET Nom = '".$Algorithme->Nom."', Description = '".$Algorithme->Description."', TypeUID = ".$Algorithme->TypeUID." WHERE AlgorithmeUID = ".$Algorithme->UID;
	    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
        	$message .= "<b>Request : </b> ".$requete."<br/>";
            $message .= "Algorithme <b>".$Algorithme->Nom."</b> mis à jour.<br />";
		}
        return $Algorithme;
    }
    else 
    {
        if ($DEBUG) {
        	$erreur .= "<b>Request : </b> ".$requete."<br/>";
            $erreur .= "Erreur lors de la mise de l'algorithme <b>".$Algorithme->Nom."</b> (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function supprimer_algorithme ($Algorithme) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "DELETE FROM ALGORITHME WHERE AlgorithmeUID = ".$Algorithme->UID;
    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
			$message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $message .= "Algorithme <b>".$Algorithme->Nom."</b> supprimé avec succès.<br />";
		}
        return $Algorithme;
    }
    else 
    {
        if ($DEBUG) {
            $erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $erreur .= "Erreur lors de la suppression de l'algorithme <b>".$Algorithme->Nom."</b> (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

// GESTION DES DEMANDES

function inserer_demande($Nom, $Description, $DatePublication, $Verrouille, $MasquerLesContributions, $UserUID, $CategorieUID, $TypeUID) {
	global $connexion, $DEBUG, $message, $erreur;
	$requete = "INSERT INTO DEMANDE (Nom, Description, DatePublication, Verrouille, MasquerLesContributions, UserUID, CategorieUID, TypeUID) VALUES ('$Nom', '$Description', '$DatePublication', $Verrouille, $MasquerLesContributions, $UserUID, $CategorieUID, $TypeUID)";
    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
            $message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $message .= "Demande <b>$Nom</b> ajoutée avec succès dans la base de données.<br />";
		}
        $UID = mysqli_insert_id($connexion);
        return new Demande($UID, $Nom, $Description, $DatePublication, $Verrouille, $MasquerLesContributions, $UserUID, $CategorieUID, $TypeUID);        
    }
    else 
    {
        if ($DEBUG) {
            $erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $erreur .= "Erreur lors de l'ajout de la demande <b>$Nom</b> dans la base de données (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function maj_demande($Demande) {
    global $connexion, $DEBUG, $message, $erreur;
	$requete = "UPDATE DEMANDE SET Nom = '".$Demande->Nom."', Description = '".$Demande->Description."', DatePublication = '".$Demande->DatePublication."', Verrouille = ".$Demande->Verrouille.", MasquerLesContributions = ".$Demande->MasquerLesContributions.", UserUID = ".$Demande->UserUID.", CategorieUID = ".$Demande->CategorieUID.", TypeUID = ".$Demande->TypeUID." WHERE DemandeUID = ".$Demande->UID;
	    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
        	$message .= "<b>Request : </b> ".$requete."<br/>";
            $message .= "Demande <b>".$Demande->Nom."</b> mise à jour.<br />";
		}
        return $Demande;
    }
    else 
    {
        if ($DEBUG) {
        	$erreur .= "<b>Request : </b> ".$requete."<br/>";
            $erreur .= "Erreur lors de la mise de la demande <b>".$Demande->Nom."</b> (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function supprimer_demande ($Demande) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "DELETE FROM DEMANDE WHERE DemandeUID = ".$Demande->UID;
    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
			$message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $message .= "Demande <b>".$Demande->Nom."</b> supprimée avec succès.<br />";
		}
        return $Demande;
    }
    else 
    {
        if ($DEBUG) {
            $erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $erreur .= "Erreur lors de la suppression de la demande <b>".$Demande->Nom."</b> (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function inserer_image_annotable($Nom, $Description, $DatePublication, $Verrouille, $MasquerLesContributions, $UserUID, $CategorieUID, $TypeUID, $Chemin) {
	global $connexion, $DEBUG, $message, $erreur;
	
	$demande = inserer_demande($Nom, $Description, $DatePublication, $Verrouille, $MasquerLesContributions, $UserUID, $CategorieUID, $TypeUID);
	
	if ($demande != null) {
		$requete = "INSERT INTO IMAGEANNOTABLE (DemandeUID, Chemin) VALUES (".$demande->UID.", '$Chemin')";
    
		if (mysqli_query($connexion, $requete) === TRUE) {
			if ($DEBUG) {
				$message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
				$message .= "Immage annotable <img src='$Chemin' height='24'/> <b>$Nom</b> ajoutée avec succès dans la base de données.<br />";
			}
			$UID = $demande->UID;
			return new ImageAnnotable ($UID, $Nom, $Description, $DatePublication, $Verrouille, $MasquerLesContributions, $UserUID, $CategorieUID, $TypeUID, $Chemin);        
		}
		else 
		{
			if ($DEBUG) {
				$erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
				$erreur .= "Erreur lors de l'ajout de l'image annotable <b>$Nom</b> dans la base de données (". mysqli_errno($connexion) .") :<br /><b>"
				  . mysqli_error($connexion)."</b><br/>";
			}
			supprimer_demande($demande);
			return null;
		}
	} 
	else 
	{
		return $demande;
	}
}

function maj_image_annotable($ImageAnnotable) {
    global $connexion, $DEBUG, $message, $erreur;
	
	$ImageAnnotable = maj_demande($ImageAnnotable);
	
	if ($ImageAnnotable != null) {
		$requete = "UPDATE IMAGEANNOTABLE SET Chemin = '".$ImageAnnotable->Chemin."' WHERE DemandeUID = ".$ImageAnnotable->UID;
			
		if (mysqli_query($connexion, $requete) === TRUE) {
			if ($DEBUG) {
				$message .= "<b>Request : </b> ".$requete."<br/>";
				$message .= "Image annotable <b>".$ImageAnnotable->Nom."</b> mise à jour.<br />";
			}
			return $ImageAnnotable;
		}
		else 
		{
			if ($DEBUG) {
				$erreur .= "<b>Request : </b> ".$requete."<br/>";
				$erreur .= "Erreur lors de la mise de l'image annotable <b>".$ImageAnnotable->Nom."</b> (". mysqli_errno($connexion) .") :<br /><b>"
				  . mysqli_error($connexion)."</b><br/>";
			}
			return null;
		}

	} else {
		return $ImageAnnotable;
	}
}


function supprimer_image_annotable($ImageAnnotable) {

	global $connexion, $DEBUG, $message, $erreur;
	$ImageAnnotable = supprimer_demande($ImageAnnotable);
	
	if ($ImageAnnotable != null) {
		$requete = "DELETE FROM IMAGEANNOTABLE WHERE DemandeUID = ".$ImageAnnotable->UID;
		
		if (mysqli_query($connexion, $requete) === TRUE) {
			if ($DEBUG) {
				$message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
				$message .= "Image annotable <b>".$ImageAnnotable->Nom."</b> supprimée avec succès.<br />";
			}
			return $ImageAnnotable;
		}
		else 
		{
			if ($DEBUG) {
				$erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
				$erreur .= "Erreur lors de la suppression de l'image annotable <b>".$ImageAnnotable->Nom."</b> (". mysqli_errno($connexion) .") :<br /><b>"
				  . mysqli_error($connexion)."</b><br/>";
			}
			return null;
		}
	}
	else
	{
		return $ImageAnnotable;
	}	
}

// GESTION DES CONTRIBUTIONS

function inserer_contribution($DatePublication, $Verrouille, $DemandeUID, $UserUID) {
	global $connexion, $DEBUG, $message, $erreur;
	$requete = "INSERT INTO CONTRIBUTION (DatePublication, Verrouille, DemandeUID, UserUID) VALUES ('$DatePublication', $Verrouille, $DemandeUID, $UserUID)";
    
    if (mysqli_query($connexion, $requete) === TRUE) {
        $UID = mysqli_insert_id($connexion);
        if ($DEBUG) {
            $message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $message .= "Contribution N°<b>$UID</b># ajoutée avec succès dans la base de données.<br />";
		}
        return new Contribution($UID, $DatePublication, $Verrouille, $DemandeUID, $UserUID);        
    }
    else 
    {
        if ($DEBUG) {
            $erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $erreur .= "Erreur lors de l'ajout de la contribution dans la base de données (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function maj_contribution($Contribution) {
    global $connexion, $DEBUG, $message, $erreur;
	$requete = "UPDATE CONTRIBUTION SET DatePublication = '".$Contribution->DatePublication."', Verrouille = ".$Contribution->Verrouille.", DemandeUID = ".$Contribution->DemandeUID.", UserUID = ".$Contribution->UserUID." WHERE ContributionUID = ".$Contribution->UID;
	    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
        	$message .= "<b>Request : </b> ".$requete."<br/>";
            $message .= "Conribution N°<b>".$Contribution->UID."</b># mise à jour.<br />";
		}
        return $Contribution;
    }
    else 
    {
        if ($DEBUG) {
        	$erreur .= "<b>Request : </b> ".$requete."<br/>";
            $erreur .= "Erreur lors de la mise de la contribution N°<b>".$Contribution->UID."</b># (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function supprimer_contribution ($Contribution) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "DELETE FROM CONTRIBUTION WHERE ContributionUID = ".$Contribution->UID;
    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
			$message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $message .= "Contribution N°<b>".$Contribution->UID."</b># supprimée avec succès.<br />";
		}
        return $Contribution;
    }
    else 
    {
        if ($DEBUG) {
            $erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $erreur .= "Erreur lors de la suppression de la contribution N°<b>".$Contribution->UID."</b># (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function inserer_annotation($DatePublication, $Verrouille, $DemandeUID, $UserUID, $Texte, $Confiance, $PositionX, $PositionY) {
	global $connexion, $DEBUG, $message, $erreur;
	
	$contribution = inserer_contribution($DatePublication, $Verrouille, $DemandeUID, $UserUID);
	
	if ($contribution != null) {
		$requete = "INSERT INTO ANNOTATION (ContributionUID, Texte, Confiance, PositionX, PositionY) VALUES (".$contribution->UID.", '$Texte', $Confiance, $PositionX, $PositionY)";
    
		if (mysqli_query($connexion, $requete) === TRUE) {
			if ($DEBUG) {
				$message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
				$message .= "Annotation <b>$Texte</b> ajoutée avec succès dans la base de données.<br />";
			}
			$UID = $contribution->UID;
			return new Annotation ($UID, $DatePublication, $Verrouille, $DemandeUID, $UserUID, $Texte, $Confiance, $PositionX, $PositionY);        
		}
		else 
		{
			if ($DEBUG) {
				$erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
				$erreur .= "Erreur lors de l'ajout de l'annotation <b>$Texte</b> dans la base de données (". mysqli_errno($connexion) .") :<br /><b>"
				  . mysqli_error($connexion)."</b><br/>";
			}
			supprimer_contribution($contribution);
			return null;
		}
	} 
	else 
	{
		return $contribution;
	}
}

function maj_annotation($Annotation) {
    global $connexion, $DEBUG, $message, $erreur;
	
	$Annotation = maj_contribution($Annotation);
	
	if ($Annotation != null) {
		$requete = "UPDATE ANNOTATION SET Texte = '".$Annotation->Texte."', Confiance = ".$Annotation->Confiance.", PositionX = ".$Annotation->PositionX.", PositionY = ".$Annotation->PositionY." WHERE ContributionUID = ".$Annotation->UID;
			
		if (mysqli_query($connexion, $requete) === TRUE) {
			if ($DEBUG) {
				$message .= "<b>Request : </b> ".$requete."<br/>";
				$message .= "Annotation <b>".$Annotation->Texte."</b> mise à jour.<br />";
			}
			return $Annotation;
		}
		else 
		{
			if ($DEBUG) {
				$erreur .= "<b>Request : </b> ".$requete."<br/>";
				$erreur .= "Erreur lors de la mise de l'annotation <b>".$Annotation->Texte."</b> (". mysqli_errno($connexion) .") :<br /><b>"
				  . mysqli_error($connexion)."</b><br/>";
			}
			return null;
		}

	} else {
		return $Annotation;
	}
}

function supprimer_annotation($Annotation) {

	global $connexion, $DEBUG, $message, $erreur;
	$Annotation = supprimer_contribution($Annotation);
	
	if ($Annotation != null) {
		$requete = "DELETE FROM ANNOTATION WHERE ContributionUID = ".$Annotation->UID;
		
		if (mysqli_query($connexion, $requete) === TRUE) {
			if ($DEBUG) {
				$message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
				$message .= "Annotation <b>".$Annotation->Texte."</b> supprimée avec succès.<br />";
			}
			return $Annotation;
		}
		else 
		{
			if ($DEBUG) {
				$erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
				$erreur .= "Erreur lors de la suppression de l'annotation <b>".$Annotation->Texte."</b> (". mysqli_errno($connexion) .") :<br /><b>"
				  . mysqli_error($connexion)."</b><br/>";
			}
			return null;
		}
	}
	else
	{
		return $Annotation;
	}	
}

// GESTION DES ENRICHISSEMENTS

function inserer_enrichissement($DemandeUID, $AlgorithmeUID) {
	global $connexion, $DEBUG, $message, $erreur;
	$requete = "INSERT INTO ENRICHISSEMENT (DemandeUID, AlgorithmeUID) VALUES ($DemandeUID, $AlgorithmeUID)";
    
    if (mysqli_query($connexion, $requete) === TRUE) {
        $UID = mysqli_insert_id($connexion);
        if ($DEBUG) {
            $message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $message .= "Enrichissement N°<b>$UID</b># ajouté avec succès dans la base de données.<br />";
		}
        return new Enrichissement($UID, $DemandeUID, $AlgorithmeUID);        
    }
    else 
    {
        if ($DEBUG) {
            $erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $erreur .= "Erreur lors de l'ajout de l'enrichissement dans la base de données (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function maj_enrichissement($Enrichissement) {
    global $connexion, $DEBUG, $message, $erreur;
	$requete = "UPDATE ENRICHISSEMENT SET DemandeUID = ".$Enrichissement->DemandeUID.", AlgorithmeUID = ".$Enrichissement->AlgorithmeUID." WHERE EnrichissementUID = ".$Enrichissement->UID;
	    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
        	$message .= "<b>Request : </b> ".$requete."<br/>";
            $message .= "Enrichissement N°<b>".$Enrichissement->UID."</b># mis à jour.<br />";
		}
        return $Enrichissement;
    }
    else 
    {
        if ($DEBUG) {
        	$erreur .= "<b>Request : </b> ".$requete."<br/>";
            $erreur .= "Erreur lors de la mise de l'enrichissement N°<b>".$Enrichissement->UID."</b># (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function supprimer_enrichissement ($Enrichissement) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "DELETE FROM ENRICHISSEMENT WHERE EnrichissementUID = ".$Enrichissement->UID;
    
    if (mysqli_query($connexion, $requete) === TRUE) {
        if ($DEBUG) {
			$message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $message .= "Enrichissement N°<b>".$Enrichissement->UID."</b># supprimé avec succès.<br />";
		}
        return $Enrichissement;
    }
    else 
    {
        if ($DEBUG) {
            $erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
            $erreur .= "Erreur lors de la suppression de l'enrichissement N°<b>".$Enrichissement->UID."</b># (". mysqli_errno($connexion) .") :<br /><b>"
              . mysqli_error($connexion)."</b><br/>";
		}
        return null;
    }
}

function inserer_annotation_extraite($DemandeUID, $AlgorithmeUID, $Texte, $Sources) {
	global $connexion, $DEBUG, $message, $erreur;
	
	$enrichissement = inserer_enrichissement($DemandeUID, $AlgorithmeUID);
	
	if ($enrichissement != null) {
		$requete = "INSERT INTO ANNOTATIONEXTRAITE (EnrichissementUID, Texte, Sources) VALUES (".$enrichissement->UID.", '$Texte', '$Sources')";
    
		if (mysqli_query($connexion, $requete) === TRUE) {
			if ($DEBUG) {
				$message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
				$message .= "Annotation extraite <b>$Texte</b> ajoutée avec succès dans la base de données.<br />";
			}
			$UID = $enrichissement->UID;
			return new AnnotationExtraite ($UID, $DemandeUID, $AlgorithmeUID, $Texte, $Sources);        
		}
		else 
		{
			if ($DEBUG) {
				$erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
				$erreur .= "Erreur lors de l'ajout de l'annotation extraite <b>$Texte</b> dans la base de données (". mysqli_errno($connexion) .") :<br /><b>"
				  . mysqli_error($connexion)."</b><br/>";
			}
			supprimer_enrichissement($enrichissement);
			return null;
		}
	} 
	else 
	{
		return $enrichissement;
	}
}

function maj_annotation_extraite($AnnotationExtraite) {
    global $connexion, $DEBUG, $message, $erreur;
	
	$AnnotationExtraite = maj_enrichissement($AnnotationExtraite);
	
	if ($AnnotationExtraite != null) {
		$requete = "UPDATE ANNOTATIONEXTRAITE SET Texte = '".$AnnotationExtraite->Texte."', Sources = '".$AnnotationExtraite->Sources."' WHERE EnrichissementUID = ".$AnnotationExtraite->UID;
			
		if (mysqli_query($connexion, $requete) === TRUE) {
			if ($DEBUG) {
				$message .= "<b>Request : </b> ".$requete."<br/>";
				$message .= "Annotation extraite <b>".$AnnotationExtraite->Texte."</b> mise à jour.<br />";
			}
			return $AnnotationExtraite;
		}
		else 
		{
			if ($DEBUG) {
				$erreur .= "<b>Request : </b> ".$requete."<br/>";
				$erreur .= "Erreur lors de la mise de l'annotation extraite <b>".$AnnotationExtraite->Texte."</b> (". mysqli_errno($connexion) .") :<br /><b>"
				  . mysqli_error($connexion)."</b><br/>";
			}
			return null;
		}

	} else {
		return $AnnotationExtraite;
	}
}

function supprimer_annotation_extraite($AnnotationExtraite) {

	global $connexion, $DEBUG, $message, $erreur;
	$AnnotationExtraite = supprimer_enrichissement($AnnotationExtraite);
	
	if ($AnnotationExtraite != null) {
		$requete = "DELETE FROM ANNOTATIONEXTRAITE WHERE EnrichissementUID = ".$AnnotationExtraite->UID;
		
		if (mysqli_query($connexion, $requete) === TRUE) {
			if ($DEBUG) {
				$message .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
				$message .= "Annotation extraite <b>".$AnnotationExtraite->Texte."</b> supprimée avec succès.<br />";
			}
			return $AnnotationExtraite;
		}
		else 
		{
			if ($DEBUG) {
				$erreur .= "<b>Requête : </b> <b><i>".$requete."</i></b><br/>";
				$erreur .= "Erreur lors de la suppression de l'annotation extraite <b>".$AnnotationExtraite->Texte."</b> (". mysqli_errno($connexion) .") :<br /><b>"
				  . mysqli_error($connexion)."</b><br/>";
			}
			return null;
		}
	}
	else
	{
		return $AnnotationExtraite;
	}	
}

// MANIPULATION

function authentification ($Identifiant, $MotDePasse) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "SELECT * FROM UTILISATEUR WHERE Identifiant = '".$Identifiant."' AND MotDePasse = '".$MotDePasse."'";
    if ($resultats = mysqli_query($connexion, $requete)) {
        if (mysqli_num_rows($resultats)>0) {
            $tuple = mysqli_fetch_assoc($resultats);
            if ($DEBUG)
                $message .= "Authentification réussie pour l'utilisateur <b>".$Identifiant."</b>.<br/>";
            return new Utilisateur($tuple["UserUID"], $tuple["Nom"], $tuple["Prenom"], $tuple["Identifiant"], $tuple["MotDePasse"], $tuple["Email"], $tuple["Statut"], $tuple["Demandeur"], $tuple["Bloque"], $tuple["Reputation"], $tuple["Administrateur"]);
        } else {
            if ($DEBUG)
                $erreur .= "Le couple identifiant/mot de passe fourni est incorrect.<br/>";
            return null;
        }
    } else {
        if ($DEBUG)
            $erreur .= "Impossible d'effectuer la requête d'authentification :<br/>"."SELECT * FROM UTILISATEUR WHERE Identifiant = '".$Identifiant."' AND MotDePasse = 'XXX'<br/>";
        return null;
    }
}

function get_utilisateur($UserUID) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "SELECT * FROM UTILISATEUR WHERE UserUID = ".$UserUID;
    if ($resultats = mysqli_query($connexion, $requete)) {
        if (mysqli_num_rows($resultats)>0) {
            $tuple = mysqli_fetch_assoc($resultats);
            if ($DEBUG)
                $message .= "Utilisateur retrouvé : <b>".$tuple["Identifiant"]."</b><br/>";
            return new Utilisateur($tuple["UserUID"], $tuple["Nom"], $tuple["Prenom"], $tuple["Identifiant"], $tuple["MotDePasse"], $tuple["Email"], $tuple["Statut"], $tuple["Demandeur"], $tuple["Bloque"], $tuple["Reputation"], $tuple["Administrateur"]);
        } else {
            if ($DEBUG)
                $erreur .= "Pas d'utilisateur ayant cet identifiant unique.<br/>";
            return null;
        }
    } else {
        if ($DEBUG)
            $erreur .= "Impossible d'effectuer la requête :<br/>".$requete."<br/>";
        return null;
    }
}

function get_utilisateur_selon_identifiant($Identifiant) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "SELECT * FROM Utilisateur WHERE Identifiant = '".$Identifiant."'";
    if ($resultats = mysqli_query($connexion, $requete)) {
        if (mysqli_num_rows($resultats)>0) {
            $tuple = mysqli_fetch_assoc($resultats);
            if ($DEBUG)
                $message .= "Utilisateur retrouvé : <b>".$tuple["Identifiant"]."</b><br/>";
            return new Utilisateur($tuple["UserUID"], $tuple["Nom"], $tuple["Prenom"], $tuple["Identifiant"], $tuple["MotDePasse"], $tuple["Email"], $tuple["Statut"], $tuple["Demandeur"], $tuple["Bloque"], $tuple["Reputation"], $tuple["Administrateur"]);
        } else {
            if ($DEBUG)
                $erreur .= "Pas d'utilisateur ayant cet identifiant.<br/>";
            return null;
        }
    } else {
        if ($DEBUG)
            $erreur .= "Impossible d'effectuer la requête :<br/>".$requete."<br/>";
        return null;
    }
}

function get_utilisateur_selon_email($Email) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "SELECT * FROM Utilisateur WHERE Email = '".$Email."'";
    if ($resultats = mysqli_query($connexion, $requete)) {
        if (mysqli_num_rows($resultats)>0) {
            $tuple = mysqli_fetch_assoc($resultats);
            if ($DEBUG)
                $message .= "Utilisateur retrouvé : <b>".$tuple["Identifiant"]."</b><br/>";
            return new Utilisateur($tuple["UserUID"], $tuple["Nom"], $tuple["Prenom"], $tuple["Identifiant"], $tuple["MotDePasse"], $tuple["Email"], $tuple["Statut"], $tuple["Demandeur"], $tuple["Bloque"], $tuple["Reputation"], $tuple["Administrateur"]);
        } else {
            if ($DEBUG)
                $erreur .= "Pas d'utilisateur ayant cet email.<br/>";
            return null;
        }
    } else {
        if ($DEBUG)
            $erreur .= "Impossible d'effectuer la requête :<br/>".$requete."<br/>";
        return null;
    }
}

function get_utilisateurs($Limit = 0, $Start = 0) {
    global $connexion, $DEBUG, $message, $erreur;
	
    if ($Limit == 0)
        $requete = "SELECT * FROM UTILISATEUR";
    elseif ($Start == 0)
        $requete = "SELECT * FROM UTILISATEUR LIMIT ".$Limit;
    else
        $requete = "SELECT * FROM UTILISATEUR LIMIT ".$Start.",".$Limit;
    
    $users = array();
    if ($resultats = mysqli_query($connexion, $requete)) {
        if ($DEBUG)
            $message .= mysqli_num_rows($resultats)." utilisateurs retrouvés.<br/>";
        while ($tuple = mysqli_fetch_assoc($resultats)) {
            $users[] = new Utilisateur($tuple["UserUID"], $tuple["Nom"], $tuple["Prenom"], $tuple["Identifiant"], $tuple["MotDePasse"], $tuple["Email"], $tuple["Statut"], $tuple["Demandeur"], $tuple["Bloque"], $tuple["Reputation"], $tuple["Administrateur"]);
        }
        return $users;
    } else {
        if ($DEBUG)
            $erreur .= "Impossible d'effectuer la requête :<br/>".$requete."<br/>";
        return null;
    }
}

function get_categories() {
    global $connexion, $DEBUG, $message, $erreur;
	
    $requete = "SELECT * FROM CATEGORIE";
    
    $categories = array();
    if ($resultats = mysqli_query($connexion, $requete)) {
        if ($DEBUG)
            $message .= mysqli_num_rows($resultats)." catégories retrouvés.<br/>";
        while ($tuple = mysqli_fetch_assoc($resultats)) {
            $categories[] = new Categorie($tuple["CategorieUID"], $tuple["Nom"], $tuple["Description"], $tuple["CategorieParente"]);
        }
        return $categories;
    } else {
        if ($DEBUG)
            $erreur .= "Impossible d'effectuer la requête :<br/>".$requete."<br/>";
        return null;
    }
}

// MANIPULATION DES DEMANDES

function get_demande($DemandeUID) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "SELECT * FROM DEMANDE WHERE DemandeUID = ".$DemandeUID;
    if ($resultats = mysqli_query($connexion, $requete)) {
        if (mysqli_num_rows($resultats)>0) {
            $tuple = mysqli_fetch_assoc($resultats);
            if ($DEBUG)
                $message .= "Demande retrouvée : <b>".$tuple["Nom"]."</b><br/>";
            return new Demande ($tuple["DemandeUID"], $tuple["Nom"], $tuple["Description"], $tuple["DatePublication"], $tuple["Verrouille"], $tuple["MasquerLesContributions"], $tuple["UserUID"], $tuple["CategorieUID"], $tuple["TypeUID"]);
        } else {
            if ($DEBUG)
                $erreur .= "Pas de demande ayant cet identifiant unique.<br/>";
            return null;
        }
    } else {
        if ($DEBUG)
            $erreur .= "Impossible d'effectuer la requête :<br/>".$requete."<br/>";
        return null;
    }
}

function get_image_annotable($DemandeUID) {
    global $connexion, $DEBUG, $message, $erreur;
	
	$demande = get_demande($DemandeUID);
	
	if ($demande != null) {	
		$requete = "SELECT * FROM IMAGEANNOTABLE WHERE DemandeUID = ".$DemandeUID;
		if ($resultats = mysqli_query($connexion, $requete)) {
			if (mysqli_num_rows($resultats)>0) {
				$tuple = mysqli_fetch_assoc($resultats);
				if ($DEBUG)
					$message .= "Image annotable retrouvée : <img src='".$tuple["Chemin"]."' height='24'/></b><br/>";
				return new ImageAnnotable ($demande->UID, $demande->Nom, $demande->Description, $demande->DatePublication, $demande->Verrouille, $demande->MasquerLesContributions, $demande->UserUID, $demande->CategorieUID, $demande->TypeUID, $tuple["Chemin"]);
			} else {
				if ($DEBUG)
					$erreur .= "Pas d'image annotable relité à la demande N°<b>$DemandeUID</b>#.<br/>";
				return null;
			}
		} else {
			if ($DEBUG)
				$erreur .= "Impossible d'effectuer la requête :<br/>".$requete."<br/>";
			return null;
		}
	}
	else
	{
		return $demande;
	}
}

function get_demandes($CategorieUID = 0, $Limit = 0, $Start = 0) {
    global $connexion, $DEBUG, $message, $erreur;
	
    $requete = "SELECT * FROM DEMANDE";
	
	if ($CategorieUID != 0)
		$requete .= " WHERE CategorieUID = ".$CategorieUID;
	
    if ($Start == 0 && $Limit != 0)
        $requete .= " LIMIT ".$Limit;
    elseif ($Start != 0 && $Limit != 0)
        $requete .= " LIMIT ".$Start.",".$Limit;
    
    $demandes = array();
    if ($resultats = mysqli_query($connexion, $requete)) {
        if ($DEBUG)
            $message .= mysqli_num_rows($resultats)." demandes référencées.<br/>";
        while ($tuple = mysqli_fetch_assoc($resultats)) {
            $demandes[] = new Demande ($tuple["DemandeUID"], $tuple["Nom"], $tuple["Description"], $tuple["DatePublication"], $tuple["Verrouille"], $tuple["MasquerLesContributions"], $tuple["UserUID"], $tuple["CategorieUID"], $tuple["TypeUID"]);
        }
        return $demandes;
    } else {
        if ($DEBUG)
            $erreur .= "Impossible d'effectuer la requête :<br/>".$requete."<br/>";
        return null;
    }
}

function getCurrentUserDemande($id = 1) {
	global $connexion, $DEBUG, $message, $erreur;
	$requete = "SELECT * FROM `imageannotable` join `demande` ON `imageannotable`.`DemandeUID` = `demande`.`DemandeUID` WHERE UserUID = ".$id;
	$demandes = array();
	if ($resultats = mysqli_query($connexion, $requete)) {
        if ($DEBUG)
            $message .= mysqli_num_rows($resultats)." images annotables référencées.<br/>";
        /*while ($tuple = mysqli_fetch_assoc($resultats)) {
            $demandes[] = get_image_annotable($tuple["DemandeUID"]);
        }*/
        return mysqli_fetch_all($resultats, MYSQLI_ASSOC);
		
    } else {
        if ($DEBUG)
            $erreur .= "Impossible d'effectuer la requête :<br/>".$requete."<br/>";
        return null;
    }
}
function get_images_annotables($CategorieUID = 0, $Limit = 0, $Start = 0) {
    global $connexion, $DEBUG, $message, $erreur;
	
	$requete = "SELECT * FROM DEMANDE D WHERE ( SELECT COUNT(*) FROM IMAGEANNOTABLE I WHERE I.DemandeUID = D.DemandeUID) > 0";
	
	if ($CategorieUID != 0)
		$requete .= " AND CategorieUID = ".$CategorieUID;
	
    if ($Start == 0 && $Limit != 0)
        $requete .= " LIMIT ".$Limit;
    elseif ($Start != 0 && $Limit != 0)
        $requete .= " LIMIT ".$Start.",".$Limit;
    
    $demandes = array();
    if ($resultats = mysqli_query($connexion, $requete)) {
        if ($DEBUG)
            $message .= mysqli_num_rows($resultats)." images annotables référencées.<br/>";
        while ($tuple = mysqli_fetch_assoc($resultats)) {
            $demandes[] = get_image_annotable($tuple["DemandeUID"]);
        }
        return $demandes;
    } else {
        if ($DEBUG)
            $erreur .= "Impossible d'effectuer la requête :<br/>".$requete."<br/>";
        return null;
    }
}

function get_contribution($ContributionUID) {
    global $connexion, $DEBUG, $message, $erreur;
    $requete = "SELECT * FROM CONTRIBUTION WHERE ContributionUID = ".$ContributionUID;
    if ($resultats = mysqli_query($connexion, $requete)) {
        if (mysqli_num_rows($resultats)>0) {
            $tuple = mysqli_fetch_assoc($resultats);
            if ($DEBUG)
                $message .= "ContributionUID retrouvée.</b><br/>";
            return new Contribution ($tuple["ContributionUID"], $tuple["DatePublication"], $tuple["Verrouille"], $tuple["DemandeUID"], $tuple["UserUID"]);
        } else {
            if ($DEBUG)
                $erreur .= "Pas de contribution ayant cet identifiant unique.<br/>";
            return null;
        }
    } else {
        if ($DEBUG)
            $erreur .= "Impossible d'effectuer la requête :<br/>".$requete."<br/>";
        return null;
    }
}

function get_annotation($ContributionUID) {
    global $connexion, $DEBUG, $message, $erreur;
	
	$contribution = get_contribution($ContributionUID);
	
	if ($contribution != null) {	
		$requete = "SELECT * FROM ANNOTATION WHERE ContributionUID = ".$ContributionUID;
		if ($resultats = mysqli_query($connexion, $requete)) {
			if (mysqli_num_rows($resultats)>0) {
				$tuple = mysqli_fetch_assoc($resultats);
				if ($DEBUG)
					$message .= "Annotation retrouvée : <b>".$tuple["Texte"]."</b><br/>";
				return new Annotation ($contribution->UID, $contribution->DatePublication, $contribution->Verrouille, $contribution->DemandeUID, $contribution->UserUID, $tuple["Texte"], $tuple["Confiance"], $tuple["PositionX"], $tuple["PositionY"]);
			} else {
				if ($DEBUG)
					$erreur .= "Pas d'annotation reliée à la contribution N°<b>$ContributionUID</b>#.<br/>";
				return null;
			}
		} else {
			if ($DEBUG)
				$erreur .= "Impossible d'effectuer la requête :<br/>".$requete."<br/>";
			return null;
		}
	}
	else
	{
		return $contribution;
	}
}

function get_contributions($DemandeUID) {
    global $connexion, $DEBUG, $message, $erreur;
	
    $requete = "SELECT * FROM CONTRIBUTION WHERE DemandeUID = $DemandeUID";
    
    $contributions = array();
    if ($resultats = mysqli_query($connexion, $requete)) {
        if ($DEBUG)
            $message .= mysqli_num_rows($resultats)." contributions référencées.<br/>";
        while ($tuple = mysqli_fetch_assoc($resultats)) {
            $contributions[] = new Contribution ($tuple["ContributionUID"], $tuple["DatePublication"], $tuple["Verrouille"], $tuple["DemandeUID"], $tuple["UserUID"]);
        }
        return $contributions;
    } else {
        if ($DEBUG)
            $erreur .= "Impossible d'effectuer la requête :<br/>".$requete."<br/>";
        return null;
    }
}

function get_annotations($DemandeUID, $userUID = 0) {
    global $connexion, $DEBUG, $message, $erreur;
	
	$requete = "SELECT * FROM CONTRIBUTION C WHERE C.DemandeUID = $DemandeUID AND (SELECT COUNT(*) FROM ANNOTATION A WHERE A.ContributionUID = C.ContributionUID) > 0 ";
	if($userUID != 0) {
		$requete .= " AND UserUID = $userUID";
	}else{
		$requete .= "ORDER BY UserUID";
	}
    
    $annotations = array();
    if ($resultats = mysqli_query($connexion, $requete)) {
        if ($DEBUG)
            $message .= mysqli_num_rows($resultats)." annotations référencées.<br/>";
        while ($tuple = mysqli_fetch_assoc($resultats)) {
            $annotations[] = get_annotation($tuple["ContributionUID"]);
        }
        return $annotations;
    } else {
        if ($DEBUG)
            $erreur .= "Impossible d'effectuer la requête :<br/>".$requete."<br/>";
        return null;
    }
}

?>