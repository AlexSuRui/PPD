<?php

class Utilisateur {
    
    public $UID, $Nom, $Prenom, $Identifiant, $MotDePasse, $Email, $Statut, $Demandeur, $Bloque, $Reputation, $Administrateur;
    
    public function __construct ($aUID = null, $aNom = null, $aPrenom = null, $aIdentifiant = null,
	$aMotDePasse = null, $aEmail = null, $aStatut = null, $aDemandeur = null, $aBloque = null, $aReputation = null, $aAdministrateur = null) {
        $this->UID = $aUID; 
		$this->Nom = $aNom;
		$this->Prenom = $aPrenom ;
		$this->Identifiant = $aIdentifiant ;
		$this->MotDePasse = $aMotDePasse ;
		$this->Email = $aEmail;
		$this->Statut = $aStatut;
		$this->Demandeur = $aDemandeur ;
		$this->Bloque = $aBloque ;
		$this->Reputation = $aReputation ;
		$this->Administrateur = $aAdministrateur;		
    }

    public function __toString() {
        return $this->Prenom . " " . $this->Nom;
    }
    
    public static function Echantillon () {
        return new User (1024, "Dupont", "François", "D.F.", "Mon mot de passe", "francois.dupont@site.fr", "Chercheur", 1, 0, 90, 0);
    }
    
}

class Categorie {
    
    public $UID, $Nom, $Description, $CategorieParente;
    
    public function __construct ($aUID, $aNom, $aDescription, $aCategorieParente) {
        $this->UID = $aUID;
        $this->Nom = $aNom;
        $this->Description = $aDescription;
        $this->CategorieParente = $aCategorieParente;
    }
    
    public function __toString() {
        return $this->Nom;
    }
    
    public static function Echantillon () {
        return new Categorie (120, "Exemple", "Catégorie exemple faite pour les tests.");
    }
    
}

class Type {
    
    public $UID, $Nom, $Description;
    
    public function __construct ($aUID, $aNom, $aDescription) {
        $this->UID = $aUID;
        $this->Nom = $aNom;
        $this->Description = $aDescription;
    }
    
    public function __toString() {
        return $this->Nom;
    }
    
    public static function Echantillon () {
        return new Type (120, "Exemple", "Type exemple fait pour les tests.");
    }
    
}

class Algorithme {
    
    public $UID, $Nom, $Description, $TypeUID;
    
    public function __construct ($aUID, $aNom, $aDescription, $aTypeUID) {
        $this->UID = $aUID;
        $this->Nom = $aNom;
        $this->Description = $aDescription;
        $this->TypeUID = $aTypeUID;
    }
    
    public function __toString() {
        return $this->Nom;
    }
    
    public static function Echantillon () {
        return new Algorithme (120, "Exemple", "Algorithme exemple fait pour les tests.", 120);
    }
    
}

class Demande {
    
    public $UID, $Nom, $Description, $DatePublication, $Verrouille, $MasquerLesContributions, $UserUID, $CategorieUID, $TypeUID;
    
    public function __construct ($aUID, $aNom, $aDescription, $aDatePublication, $aVerrouille, $aMasquerLesContributions, $aUserUID, $aCategorieUID, $aTypeUID) {
        $this->UID = $aUID;
        $this->Nom = $aNom;
        $this->Description = $aDescription;
        $this->DatePublication = $aDatePublication;
		$this->Verrouille = $aVerrouille;
		$this->MasquerLesContributions = $aMasquerLesContributions;
		$this->UserUID = $aUserUID;
		$this->CategorieUID = $aCategorieUID;
		$this->TypeUID = $aTypeUID;
    }
    
    public function __toString() {
        return $this->Nom;
    }
    
    public static function Echantillon () {
        return new Demande (120, "Exemple", "Algorithme exemple fait pour les tests.", date("Y-m-d H:i:s"), 0, 0, 1, 1, 1);
    }
    
}

class ImageAnnotable extends Demande {
	
	public $Chemin;
	
	public function __construct($aUID, $aNom, $aDescription, $aDatePublication, $aVerrouille, $aMasquerLesContributions, $aUserUID, $aCategorieUID, $aTypeUID, $aChemin) {
		parent::__construct($aUID, $aNom, $aDescription, $aDatePublication, $aVerrouille, $aMasquerLesContributions, $aUserUID, $aCategorieUID, $aTypeUID);
		$this->Chemin = $aChemin;
	}
	
	public static function Echantillon () {
        return new ImageAnnotable (120, "Exemple", "Algorithme exemple fait pour les tests.", date("Y-m-d H:i:s"), 0, 0, 1, 1, 1, "https://sandiego.ncsy.org/files/2013/10/mountain-04.jpg");
    }
	
}

class Contribution {
	
	public $UID, $DatePublication, $Verrouille, $DemandeUID, $UserUID;
	
	public function __construct ($aUID, $aDatePublication, $aVerrouille, $aDemandeUID, $aUserUID) {
        $this->UID = $aUID;
        $this->DatePublication = $aDatePublication;
		$this->Verrouille = $aVerrouille;
		$this->DemandeUID = $aDemandeUID;
		$this->UserUID = $aUserUID;
    }
	
	public static function Echantillon () {
		return new Contribution(130, date("Y-m-d H:i:s"), 0, 1, 1);
	}
	
}

class Annotation extends Contribution {
	
	public $Texte, $Confiance, $PositionX, $PositionY;
	
	public function __construct($aUID, $aDatePublication, $aVerrouille, $aDemandeUID, $aUserUID, $aTexte, $aConfiance, $aPositionX, $aPositionY) {
		parent::__construct($aUID, $aDatePublication, $aVerrouille, $aDemandeUID, $aUserUID);
		$this->Texte = $aTexte;
		$this->Confiance = $aConfiance;
		$this->PositionX = $aPositionX;
		$this->PositionY = $aPositionY;
	}
	
	public static function Echantillon () {
		return new Annotation(130, date("Y-m-d H:i:s"), 0, 1, 1, "Jaune", 80, 30, 75);
	}
	
}

class Enrichissement {
	
	public $UID, $DemandeUID, $AlgorithmeUID;
	
	public function __construct($aUID, $aDemandeUID, $aAlgorithmeUID) {
		$this->UID = $aUID;
		$this->DemandeUID = $aDemandeUID;
		$this->AlgorithmeUID = $aAlgorithmeUID;
	}
	
	public static function Echantillon () {
		return new Enrichissement(1, 1, 1);
	}
	
}

class AnnotationExtraite extends Enrichissement {
	
	public $Texte, $Sources;
	
	public function __construct($aUID, $aDemandeUID, $aAlgorithmeUID, $aTexte, $aSources) {
		parent::__construct($aUID, $aDemandeUID, $aAlgorithmeUID);
		$this->Texte = $aTexte;
		$this->Sources = $aSources;
	}
	
	public static function Echantillon () {
		return new AnnotationExtraite(2, 1, 1, "Soleil", "Jaune, Rond, Grand, Loin");
	}
	
}

?>