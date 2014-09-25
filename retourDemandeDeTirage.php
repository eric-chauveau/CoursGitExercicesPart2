<?php
	// VERIFICATION ET INITIALISATION PAR DEFAUT DES VARIABLES
	// ces variables sont les suivantes:
	//
	// * demandeur: le nom de la personne qui demande le tirage
	// * dateRetour: la date de retour souhaitée
	// * urgent: 1 = non, 2 = oui
	// * nbPages: le nombre de page du document 
	// * nbExemplaires: le nombre d'exemplaires demandés
	// * original:  1 = papier, 2 = fichier
	// * adresseFichier: l'adresse du fichier copié
	// * couleurPapier: la couleur du papier (par défaut blanc)
	// * tirage: 1 = recto, 2 = recto/verso
	// * couverture: 1 = oui, 2 = non
	// * agraphage: type d'agraphage (entier de 0 à 4)
	// * typeCours: 1 = tp, 2 = cours, 3 = personnel, 4 = autre 
	// * nomCours: le nom du cours
	// * instructionsParticulieres: au cas où...
	// * promo:  1 = oui, 2 = non 
        //          (p1,p2,i1,i2,i3,itii,fc,aeseo,mastere,admin,autre)
	// * division:  1 = oui, 2 = non
        //             (complet, a, b, c, d, paris, dijon,
        //              bio, ee, env, rt, sea, si, sirt, tst)

	// on récupère toutes les variables:
  	$demandeur = $_POST['demandeur'];
  	$user = $_POST['user'];
	$dateRetour = $_POST['dateRetour'];
	$urgent = $_POST['urgent'];
	$nbPages = $_POST['nbPages'];
	$nbExemplaires = $_POST['nbExemplaires'];
	$original = $_POST['original'];
	$adresseFichier = $_POST['adresseFichier'];
	$adresseFichier_name = $_POST['adresseFichier_name'];
	$couleurPapier = $_POST['couleurPapier'];
	$tirage = $_POST['tirage'];
	$couverture = $_POST['couverture'];
	$agraphage = $_POST['agraphage'];
	$typeCours = $_POST['typeCours'];
	$nomCours = $_POST['nomCours'];
	$instructionsParticulieres = $_POST['instructionsParticulieres'];

	$p1 = $_POST['p1'];
	$p2 = $_POST['p2'];
	$i1 = $_POST['i1'];
	$i2 = $_POST['i2'];
	$i3 = $_POST['i3'];
	$itii = $_POST['itii'];
	$fc = $_POST['fc'];
	$aeseo = $_POST['aeseo'];
	$mastere = $_POST['mastere'];
	$admin = $_POST['admin'];
	$autre = $_POST['autre'];

	$complet = $_POST['complet'];
	$a = $_POST['a'];
	$b = $_POST['b'];
	$c = $_POST['c'];
	$d = $_POST['d'];
	$paris = $_POST['paris'];
	$dijon = $_POST['dijon'];
	$bio = $_POST['bio'];
	$ee = $_POST['ee'];
	$env = $_POST['env'];
	$rt = $_POST['rt'];
	$sea = $_POST['sea'];
	$si = $_POST['si'];
	$sirt = $_POST['sirt'];
	$tst = $_POST['tst'];

	$toutEstOK = "0";

	// on récupère la date du jour:
	$dateDemande = date("Y-m-j",time());
?>

<?php	
	// CONNEXION A LA BASE DE DONNEES:
	if( $toutEstOK=="0") {

		//$connexion = mysql_connect("localhost","root","");
		$connexion = mysql_connect("localhost","nom de la table à changer","mot de passe à changer");
		if ($connexion){
		   // si la connexion a réussi, on sélectionne la base de
		   // données "stage":
		   //$selectedDataBase = mysql_select_db("INTRANET",$connexion);
		   $selectedDataBase = mysql_select_db("impression",$connexion);

		   if($selectedDataBase){


			// si la sélection s'est bien passée, on construit tout
			// d'abord la requête, et on l'effectue ensuite.
			// On veut juste récupérer les informations du stage
			// dont le numero est donné par la variables "numero":
			$select = "INSERT INTO demandeDeTirages ";
			$select = "$select (demandeur,user,dateDemande,";
			$select = "$select dateRetour,urgent,nbPages,nbExemplaires,";
			$select = "$select original,adresseFichier,";
			$select = "$select couleurPapier,tirage,couverture,";
			$select = "$select agraphage,typeCours,nomCours,";
			$select = "$select instructionsParticulieres,";
			$select = "$select p1,p2,i1,i2,i3,itii,fc,aeseo,mastere, admin, autre,";
			$select = "$select complet,a,b,c,d,paris,dijon,bio,ee,env,rt,sea,si,sirt,tst)";

			$select = "$select VALUES ('$demandeur','$user',";
			$select = "$select '$dateDemande','$dateRetour','$urgent',";
			$select = "$select '$nbPages','$nbExemplaires',";
			if($original=="1"){
				$select = "$select 'papier',";
			} else {
				$select = "$select 'fichier',";
			} 
			$select = "$select '$adresseFichier',";
			$select = "$select '$couleurPapier',";
			if($tirage=="1"){
				$select = "$select 'recto',";
			} else {
				$select = "$select 'rectoverso',";
			}
			if($couverture=="1"){
				$select = "$select 'oui',";
			} else {
				$select = "$select 'non',";
			}
			$select = "$select '$agraphage',";
			if($typeCours=="1"){
				$select = "$select 'tp',";
			} else if ($typeCours=="2"){
				$select = "$select 'cours',";
			} else if ($typeCours=="3"){
				$select = "$select 'personnel',";
			} else {
				$select = "$select 'autre',";
			}

			$select = "$select '$nomCours',";
			$select = "$select '$instructionsParticulieres',";

			if($p1=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($p2=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($i1=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($i2=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($i3=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($itii=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($fc=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($aeseo=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($mastere=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($admin=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($autre=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";

	// * promo:  1 = oui, 2 = non 
        //          (p1,p2,i1,i2,i3,itii,fc,aeseo,mastere,admin,autre)
	// * division:  1 = oui, 2 = non
        //             (complet, a, b, c, d, paris, dijon,
        //              bio, ee, env, rt, sea, si, sirt, tst)
			if($complet=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($a=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($b=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($c=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($d=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($paris=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($dijon=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($bio=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($ee=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($env=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($rt=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($sea=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($si=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($sirt=="on")
			     $select = "$select 'oui',";
			else $select = "$select 'non',";
			if($tst=="on")
			     $select = "$select 'oui'";
			else $select = "$select 'non'";


			$select = "$select );";

			// on effectue la requête sur la base de données:
			//printf("%s<BR>\n", $select);
			$resultat =  mysql_query($select);
		   }

		}
	}

	include("entete.php");	
?>

<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=800>
<TR><TD ALIGN=CENTER VALIGN=TOP>
	<?php
	if( $toutEstOK=="1"){
		echo "Le champ \"demandeur\" n'est pas correctement rempli.\n";
	} elseif( $toutEstOK=="2"){
		echo "Le champ \"date de retour souhait&eacute;\" n'est pas correctement rempli.\n";
	} elseif( $toutEstOK=="3") {
		echo "Le champ \"nombre de pages\" n'est pas correctement rempli.\n";
	} elseif( $toutEstOK=="4"){
		echo "Le champ \"nombre d'exemplaires\" n'est pas correctement rempli.\n";
	} elseif( $toutEstOK=="5") {
		echo "Le champ \"fichier\" n'est pas correctement rempli.\n";
	}elseif( $toutEstOK=="6") {
		echo "La copie du fichier s'est mal effectuée (trop grande taille ?)\n";
	} elseif( $toutEstOK=="7"){
		echo "Le champ \"couleur papier\" n'est pas correctement rempli.\n";
	} elseif( $toutEstOK=="8"){
		echo "Le champ \"intitulé\" n'est pas correctement rempli.\n";
	}

	if( $toutEstOK!="0"){
		printf("\t<FORM METHOD=POST ACTION=\"demandeDeTirage.php\">\n");
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"demandeur\" VALUE=\"%s\">\n",
			$demandeur);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"%s\">\n",
			$user);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"dateRetour\" VALUE=\"%s\">\n",
			$dateRetour);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"urgent\" VALUE=\"%s\">\n",
			$urgent);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"nbPages\" VALUE=\"%s\">\n",
			$nbPages);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"nbExemplaires\" VALUE=\"%s\">\n",
			$nbExemplaires);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"original\" VALUE=\"%s\">\n",
			$original);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"couleurPapier\" VALUE=\"%s\">\n",
			$couleurPapier);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"tirage\" VALUE=\"%s\">\n",
			$tirage);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"couverture\" VALUE=\"%s\">\n",
			$couverture);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"agraphage\" VALUE=\"%s\">\n",
			$agraphage);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"typeCours\" VALUE=\"%s\">\n",
			$typeCours);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"nbCours\" VALUE=\"%s\">\n",
			$nbCours);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"nomCours\" VALUE=\"%s\">\n",
			$nomCours);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"instructionsParticulieres\" VALUE=\"%s\">\n",
			$instructionsParticulieres);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"p1\" VALUE=\"%s\">\n",$p1);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"p2\" VALUE=\"%s\">\n",$p2);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"i1\" VALUE=\"%s\">\n",$i1);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"i2\" VALUE=\"%s\">\n",$i2);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"i3\" VALUE=\"%s\">\n",$i3);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"itii\" VALUE=\"%s\">\n",$itii);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"fc\" VALUE=\"%s\">\n",$fc);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"aeseo\" VALUE=\"%s\">\n",$aeseo);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"mastere\" VALUE=\"%s\">\n",$mastere);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"admin\" VALUE=\"%s\">\n",$admin);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"autre\" VALUE=\"%s\">\n",$autre);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"complet\" VALUE=\"%s\">\n",$complet);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"a\" VALUE=\"%s\">\n",$a);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"b\" VALUE=\"%s\">\n",$b);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"c\" VALUE=\"%s\">\n",$c);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"d\" VALUE=\"%s\">\n",$d);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"paris\" VALUE=\"%s\">\n",$paris);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"dijon\" VALUE=\"%s\">\n",$dijon);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"bio\" VALUE=\"%s\">\n",$bio);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"ee\" VALUE=\"%s\">\n",$ee);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"env\" VALUE=\"%s\">\n",$env);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"rt\" VALUE=\"%s\">\n",$rt);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"sea\" VALUE=\"%s\">\n",$sea);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"si\" VALUE=\"%s\">\n",$si);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"sirt\" VALUE=\"%s\">\n",$sirt);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"tst\" VALUE=\"%s\">\n",$tst);
		printf("\t<INPUT TYPE=\"submit\"");
		printf(" VALUE=\"Retour &agrave; la page pr&eacute;c&eacute;dente\">\n");
		printf("\t</FORM>\n");

	} elseif(!$connexion){
		// la connexion n'a pas pu se faire:
		echo "Impossible de se connecter &agrave ";
		echo "la base.";
	} elseif (!$selectedDataBase) {
		// la base "stage" n'est pas accessible:
		echo "Impossible d'acc&eacute;der &agrave; ";
		echo "la base.";

		// on ferme la connexion à la base:
		mysql_close($connexion);
	} elseif( ! $resultat) {

		// la requête ne s'est pas faite:
		echo "L'insertion du nouvel &eacute;l&eacute;ment n'a pas pu ";
		echo "se faire (fichier inexistant ?).";

		printf("\t<FORM METHOD=POST ACTION=\"demandeDeTirage.php\">\n");
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"demandeur\" VALUE=\"%s\">\n",
			$demandeur);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"%s\">\n",
			$user);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"dateRetour\" VALUE=\"%s\">\n",
			$dateRetour);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"urgent\" VALUE=\"%s\">\n",
			$urgent);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"nbPages\" VALUE=\"%s\">\n",
			$nbPages);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"nbExemplaires\" VALUE=\"%s\">\n",
			$nbExemplaires);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"original\" VALUE=\"%s\">\n",
			$original);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"couleurPapier\" VALUE=\"%s\">\n",
			$couleurPapier);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"tirage\" VALUE=\"%s\">\n",
			$tirage);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"couverture\" VALUE=\"%s\">\n",
			$couverture);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"agraphage\" VALUE=\"%s\">\n",
			$agraphage);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"typeCours\" VALUE=\"%s\">\n",
			$typeCours);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"nbCours\" VALUE=\"%s\">\n",
			$nbCours);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"nomCours\" VALUE=\"%s\">\n",
			$nomCours);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"instructionsParticulieres\" VALUE=\"%s\">\n",
			$instructionsParticulieres);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"p1\" VALUE=\"%s\">\n",$p1);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"p2\" VALUE=\"%s\">\n",$p2);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"i1\" VALUE=\"%s\">\n",$i1);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"i2\" VALUE=\"%s\">\n",$i2);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"i3\" VALUE=\"%s\">\n",$i3);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"itii\" VALUE=\"%s\">\n",$itii);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"fc\" VALUE=\"%s\">\n",$fc);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"aeseo\" VALUE=\"%s\">\n",$aeseo);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"mastere\" VALUE=\"%s\">\n",$mastere);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"admin\" VALUE=\"%s\">\n",$admin);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"autre\" VALUE=\"%s\">\n",$autre);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"complet\" VALUE=\"%s\">\n",$complet);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"a\" VALUE=\"%s\">\n",$a);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"b\" VALUE=\"%s\">\n",$b);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"c\" VALUE=\"%s\">\n",$c);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"d\" VALUE=\"%s\">\n",$d);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"paris\" VALUE=\"%s\">\n",$paris);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"dijon\" VALUE=\"%s\">\n",$dijon);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"bio\" VALUE=\"%s\">\n",$bio);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"ee\" VALUE=\"%s\">\n",$ee);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"env\" VALUE=\"%s\">\n",$env);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"rt\" VALUE=\"%s\">\n",$rt);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"sea\" VALUE=\"%s\">\n",$sea);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"si\" VALUE=\"%s\">\n",$si);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"sirt\" VALUE=\"%s\">\n",$sirt);
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"tst\" VALUE=\"%s\">\n",$tst);
		printf("\t<INPUT TYPE=\"submit\"");
		printf(" VALUE=\"Retour &agrave; la page pr&eacute;c&eacute;dente\">\n");
		printf("\t</FORM>\n");

		// on ferme la connexion à la base:
		mysql_close($connexion);
	} else {
		// tout va bien; l'insertion a été faite:
		printf("La demande de tirage a bien &eacute;t&eacute; enregistr&eacute;e");
		printf("<BR><BR>\n");

		printf("\t<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=0 WIDTH=580> \n");
		printf("\t<TR><TD ALIGN=CENTER VALIGN=CENTER>\n");
		printf("\t\t<FORM METHOD=POST ACTION=\"demandeDeTirage.php\">\n");
		printf("\t\t<INPUT TYPE=\"hidden\" NAME=\"user\" VALUE=\"%s\">\n", $user);
		printf("\t\t<INPUT TYPE=\"hidden\" NAME=\"demandeur\" VALUE=\"%s\">\n", $demandeur);
		printf("\t\t<INPUT TYPE=\"submit\" VALUE=\"Demander un nouveau tirage\">\n");
		printf("\t\t</FORM>\n");
		printf("\t</TD></TR>\n");
		printf("\t</TABLE>\n<BR>\n");

		// on ferme la connexion à la base:
		mysql_close($connexion);
	}

	?>
	<BR><BR>
</TD></TR>
</TABLE>

<?
	include("fin.php");
?>
