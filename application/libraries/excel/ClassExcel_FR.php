<?php
class ExcelRead_FR{

// Les variables :
var $Fichier; // Le Fichier excel à lire !
var $Feuille; // La Feuille a Récupérer !
var $Cellule; // La Cellule a lire
var $IdConnexion;
var $Classeur;

function OuvreLeFichier($LeDocument){
	/* Cette fonction Ouvre le document Excel 
	* Elle est a appelé aprés avoir renseigner la variable
	* Fichier.
	* Elle renseigne les variables IdConnexion et Classeur
	*/ 
	$this->IdConnexion = new com("Excel.Application")or die("Erreur lors de la connexion au fichier excel : $Fichier");
	$Rep = getcwd();
	$$LeDocument=$Rep."\\".$$LeDocument;
	$this->Classeur = $this->IdConnexion->WorkBooks->Open($LeDocument) or die("Erreur impossible d'ouvrir le classeur");
}

function RecupereValeurCellule($feuil, $cell){ 
	if (!isset($this->Classeur)){
		if (!isset($this->Fichier)){
			return False;
		}else{
			$this->OuvreLeFichier($this->Fichier);
		}
	}
	$Classeur = $this->Classeur;
	$Feuille = $this->Classeur->Sheets($feuil);
	$SelectedFeuille = $Feuille->Select;
	$Cellule = $Feuille->Range($cell);
	$ValeurCellule = $Cellule->Value;
	return $ValeurCellule;
}


function EcritDansCellule($feuil, $cell, $NouvelleValeur){
	if (!isset($this->Classeur)){
		if (!isset($this->Fichier)){
			return False;
		}else{
			$this->OuvreLeFichier($this->Fichier);
		}
	}
	$Classeur = $this->Classeur;
	$Feuille = $this->Classeur->Sheets($feuil);
	$SelectedFeuille = $Feuille->Select;
	$Cellule = $Feuille->Range($cell);
	$Cellule->Value = $NouvelleValeur;
}
function CellIsEmpty($cell){
	$Classeur = $this->Classeur;
	$Feuille = $this->Classeur->Sheets($this->Feuille);
	$SelectedFeuille = $Feuille->Select;
	$Cellule = $Feuille->Range($cell);
	if ($Cellule->Value == ""){
		return true;
	}else{
		return False;
	}
}

function CellIsMerged($cell){
	
	$Classeur = $this->Classeur;
	$Feuille = $this->Classeur->Sheets($this->Feuille);
	$SelectedFeuille = $Feuille->Select;
	$Cellule = $Feuille->Range($cell);
	if ($y = $Cellule->MergeCells){
		return true;
	}else{
		return False;
	}

}

function Enregistrer(){
	$this->Classeur->Save();
}
function Fermer(){
	//com_release($this->IdConnexion);
	$this->IdConnexion->Quit();
	$this->IdConnexion	= null;
}
function RecupereDerniereLigne(){

}
}


?>