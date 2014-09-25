<?php
function transfert ()
{
	$ret = false;
	$img_blob = '';			// tempon de stockage de l'image pour transfert vers la DB
	$img_taille = 0;		// taille de l'image à stocker dans la DB
	$img_type = '';			// type d'image à stocker dans la DB
	$img_nom = '';			// nom de l'image à stocker dans la DB
	$taille_max = 250000;	// taille maximale de l'image transferable
	
	// ouvre une interface pour sélectionner le fichier à transferer
	$ret = is_uploaded_file ($_FILES['fic']['tmp_name']);
	if ( !$ret )
	{
		echo "Erreur de transfert";
		return false;
	}
	else
	{
		// Le fichier a bien été reçu
		$img_taille = $_FILES['fic']['size'];
		if ( $img_taille > $taille_max )
		{
			echo "Le fichier est trop gros !";
			return false;
		}
		$img_type = $_FILES['fic']['type'];
		$img_nom = $_FILES['fic']['name'];
		
		include ("connexion.php");
		
		$img_blob = file_get_contents ($_FILES['fic']['tmp_name']);
		
		$req = "INSERT INTO images (".
							"imageName, imgSize, imgType, imageData ".
							") VALUES (".
							"'".$img_nom."', ".
							"'".$img_taille."', ".
							"'".$img_type."', ".
							"'".$img_blob."') ";
							
		$ret = mysql_query ($req) or die (mysql_error ());
		return true;
	}
}
?>