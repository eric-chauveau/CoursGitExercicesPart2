<?php

Function noaccent($txt) { // Enlève les accents et les espaces:
   $temp = $txt;
   // Chars cherchés entre [ et ]
   $pattern = "[àâ]";
   // Remplace ces chars par un a
   $temp = eregi_replace($pattern,"a",$temp);
   // Remplace les é:
   $pattern = "[éèêë]";
   $temp = eregi_replace($pattern,"e",$temp);
   // Remplace les é:
   $pattern = "[î]";
   $temp = eregi_replace($pattern,"i",$temp);
   // Remplace les é:
   $pattern = "[ô]";
   $temp = eregi_replace($pattern,"o",$temp);
   // Remplace les ü:
   $pattern = "[üù]";
   $temp = eregi_replace($pattern,"u",$temp);
   // Remplace les ç:
   $pattern = "[ç]";
   $temp = eregi_replace($pattern,"c",$temp);
   // Remplace les espaces:
   $pattern = "[ ]";
   $temp = eregi_replace($pattern,"_",$temp);
   // Remplace le caractère '°':
   $pattern = "[°]";
   $temp = eregi_replace($pattern,"_",$temp);

   return($temp);
}

	// VERIFICATION ET INITIALISATION PAR DEFAUT DES VARIABLES
	// ces variables sont les suivantes:
	// * user: le "login" de l'utilisateur
	// * demandeur: le nom de la personne qui demande le tirage
	// * dateRetour: la date de retour souhaitée
	// * urgent: 1 = non, 2 = oui
	// * nbPages: le nombre de page du document 
	// * nbExemplaires: le nombre d'exemplaires demandés
	// * original:  1 = papier, 2 = fichier < 8Mo, 3 = fichier > 8Mo
	// * adresseFichier: le nom du fichier (chemin relatif)
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

  $demandeur = $_POST['demandeur'];
  $user = $_POST['user'];
  $dateRetour = $_POST['dateRetour'];
  $urgent = $_POST['urgent'];
  $nbPages = $_POST['nbPages'];
  $nbExemplaires = $_POST['nbExemplaires'];
  $original = $_POST['original'];
  $adresseFichier = $_FILES['adresseFichier']['tmp_name'];
  $adresseFichier_name = $_FILES['adresseFichier']['name'];
  $couleurPapier = $_POST['couleurPapier'];
  $tirage = $_POST['tirage'];
  $couverture = $_POST['couverture'];
  $agraphage = $_POST['agraphage'];
  $typeCours = $_POST['typeCours'];
  $nomCours = $_POST['nomCours'];
  $instructionsParticulieres = $_POST['instructionsParticulieres'];

	//promotion   ($promo = $_POST['promo'];)
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

	$nombreDePromotions = 0;
	$tabPromotions = array();
	if($p1=="on") { $nombreDePromotions++; $tabPromotions[$nombreDePromotions]="p1";}
	if($p2=="on") { $nombreDePromotions++; $tabPromotions[$nombreDePromotions]="p2";}
	if($i1=="on") { $nombreDePromotions++; $tabPromotions[$nombreDePromotions]="i1";}
	if($i2=="on") { $nombreDePromotions++; $tabPromotions[$nombreDePromotions]="i2";}
	if($i3=="on") { $nombreDePromotions++; $tabPromotions[$nombreDePromotions]="i3";}

	//divisions ($division = $_POST['division'];)
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

	$nombreDeDivisions = 0;
	$tabDivisions = array();
	if($complet=="on") { $tabDivisions[++$nombreDeDivisions]="complet";
	} else {
	     if($a=="on")     $tabDivisions[++$nombreDeDivisions]="a";
	     if($b=="on")     $tabDivisions[++$nombreDeDivisions]="b";
	     if($c=="on")     $tabDivisions[++$nombreDeDivisions]="c";
	     if($d=="on")     $tabDivisions[++$nombreDeDivisions]="d";
	     if($paris=="on") $tabDivisions[++$nombreDeDivisions]="paris";
	     if($dijon=="on") $tabDivisions[++$nombreDeDivisions]="dijon";
	     if($bio=="on")   $tabDivisions[++$nombreDeDivisions]="bio";
	     if($ee=="on")    $tabDivisions[++$nombreDeDivisions]="ee";
	     if($env=="on")   $tabDivisions[++$nombreDeDivisions]="nrj";
	     if($rt=="on")    $tabDivisions[++$nombreDeDivisions]="rt";
	     if($sea=="on")   $tabDivisions[++$nombreDeDivisions]="sea";
	     if($si=="on")    $tabDivisions[++$nombreDeDivisions]="si";
	     if($sirt=="on")  $tabDivisions[++$nombreDeDivisions]="sirt";
	     if($tst=="on")   $tabDivisions[++$nombreDeDivisions]="tst";
	}


	$toutEstOK = "0";
	if($nomCours ==""){
		$toutEstOK = "8";
	}
	if($couleurPapier ==""){
		$toutEstOK = "7";
	}
	if($original == "2"){
		if($adresseFichier_name ==""){
			$toutEstOK = "5";
		} 
	}
	if($original =="3" && $instructionsParticulieres==""){
		$toutEstOK = "6";
	}

	if($nbPages ==""){
		$toutEstOK = "3";
	}
	if($dateRetour ==""){
		$toutEstOK = "2";
	}	
	if($demandeur ==""){
		$toutEstOK = "1";
	}

	if($p1=="" && $p2=="" && $i1=="" && $i2=="" && $i3=="" && $itii=="" &&
           $fc=="" && $aeseo=="" && $mastere=="" && $admin=="" && $autre==""){
		$toutEstOK = "4"; // pas de promotion spécifiée
	}

	if($nbExemplaires=="" && ($autre=="on" || $fc=="on" || $itii=="on" ||
                                  $mastere=="on" || $admin=="on" || $aeseo=="on")){
		$toutEstOK="10"; // pas de nombre d'exemplaires spécifiées
	}


	if($complet=="" && $a=="" && $b=="" && $c=="" && $d=="" && $paris=="" &&
           $dijon=="" && $bio=="" && $ee=="" && $env=="" && $rt=="" &&
           $sea=="" && $si=="" && $sirt=="" && $tst==""){
	   	$toutEstOK="11"; // pas de division spécifiée
        }


	// on récupère la date du jour:
	$dateDemande = date("Y-m-j-G-i-s",time());

  	if( $toutEstOK == "0" && $original=="2"){
		// on vérirife que le fichier a bien été "uploadé":
		if(is_uploaded_file($_FILES['adresseFichier']['tmp_name'])) {
			$fichierDestination = "../Depot/v-$user-$dateDemande-$adresseFichier_name";
			$fichierDestination = Noaccent($fichierDestination);
			// copie du fichier temporaire -> fichier destination
			if( ! move_uploaded_file($adresseFichier, $fichierDestination))
				// si la copie s'est mal passée...
				$toutEstOK = "9";
		} else {
			// problème: le fichier n'existe pas...
			$toutEstOK= "9";
		}
  	} else {
		$fichierDestination = "";
	}


	$calculAutomatiqueDeLeffectic = "false";
	// on va chercher les effectifs si nécessaire:
	if($toutEstOK == "0" && $nbExemplaires=="") {
		$calculAutomatiqueDeLeffectic = "true";
		// CONNEXION A LA BASE DE DONNEES DES EFFECTIFS:
		$connexion = mysql_connect("localhost","nom de la Base à changer","mot de passe à changer");
		if ($connexion){
		   // si la connexion a réussie, on sélectionne la base de
		   // données "stage":
		   $selectedDataBase = mysql_select_db("impression",$connexion);
		   if($selectedDataBase){
		       // si la sélection s'est bien passée, on va chercher
		       // l'effectif correspondant à la promotion:	
		       $select = "SELECT * FROM promotion WHERE ";

		       $i = 1;
		       while( $i <= $nombreDePromotions){
		       	      if($i>1) $select = "$select OR ";
			      $j=1;
			      while($j <= $nombreDeDivisions){
			      	       if($j>1) $select = "$select OR ";

				       if($tabDivisions[$j]=="complet")
				       	    $select = "$select nom='$tabPromotions[$i]'";
				       else $select = "$select nom='$tabPromotions[$i]$tabDivisions[$j]'";
			      	       $j++;
			      }
			      $i++;
		       }

		       $select = $select.";" ;

		       // on effectue la requête sur la base de données:
		       $resultat =  mysql_query($select);
		       $tableau = mysql_fetch_array($resultat);

		       if($tableau==0){
		           echo "<CENTER>Le nombre d'élèves n'est pas connu pour cette division !</CENTER>";
			   $toutEstOK = "10";
		       } else {
		       	   while($tableau !=0){
			      $nbExemplaires = $nbExemplaires + $tableau["nombre"];
			      $tableau = mysql_fetch_array($resultat);
			   }
                       }
		   } else {
		       echo "Impossible de se connecter sur la base de données des effectifs !";
		       exit();
		   }
	      } else {
		       echo "Impossible de se connecter sur la base de données des effectifs !";
		       exit();
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
		echo "Aucune promotion n'a été spécifiée.\n";
	} elseif( $toutEstOK=="5") {
		echo "Le champ \"fichier\" n'est pas correctement rempli.\n";
	}elseif( $toutEstOK=="6") {
		echo "Le champ \"instructions particulières\" n'est pas correctement rempli.\n";
	} elseif( $toutEstOK=="7"){
		echo "Le champ \"couleur papier\" n'est pas correctement rempli.\n";
	} elseif( $toutEstOK=="8"){
		echo "Le champ \"intitulé\" n'est pas correctement rempli.\n";
	} elseif($toutEstOK=="9"){
		echo "La copie du fichier n'a pas pu se faire.\n";
	} elseif($toutEstOK=="10"){
		echo "Le nombre d'exemplaires doit être spécifié.\n";
	} elseif($toutEstOK=="11"){
		echo "La division doit être spécifiée.\n";
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
		if($calculAutomatiqueDeLeffectic=="false")
			printf("\t<INPUT TYPE=\"hidden\" NAME=\"nbExemplaires\" VALUE=\"%s\">\n",
			       $nbExemplaires);
	        else    printf("\t<INPUT TYPE=\"hidden\" NAME=\"nbExemplaires\" VALUE=\"\">\n");
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

	} else {
		printf("Voici votre demande de tirage :<BR><BR>\n");

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
		if($calculAutomatiqueDeLeffectic=="false")
			printf("\t<INPUT TYPE=\"hidden\" NAME=\"nbExemplaires\" VALUE=\"%s\">\n",
			       $nbExemplaires);
	        else    printf("\t<INPUT TYPE=\"hidden\" NAME=\"nbExemplaires\" VALUE=\"\">\n");
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

		printf("\t<INPUT TYPE=\"hidden\" NAME=\"p1\" VALUE=\"%s\">\n",$p1);
		printf("\t<INPUT TYPE=\"submit\"");
		printf(" VALUE=\"Retour &agrave; la page pr&eacute;c&eacute;dente\">\n");
		printf("\t</FORM>\n");

		printf("\t<FORM METHOD=POST ACTION=\"retourDemandeDeTirage.php\">\n");
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
		printf("\t<INPUT TYPE=\"hidden\" NAME=\"adresseFichier\" VALUE=\"%s\">\n",
			$fichierDestination);
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
		printf(" VALUE=\"Valider la demande\">\n");
		printf("\t</FORM>\n");


		printf("\t<TABLE BORDER=0 CELLPADDING=5 CELLSPACING=0 WIDTH=580>\n");
		printf("\t<TR><TD ALIGN=RIGHT BGCOLOR=\"#c4c4ff\" VALIGN=CENTER>\n");
		printf("\t\tDemandeur :\n");
		printf("\t</TD><TD ALIGN=LEFT BGCOLOR=\"#c4c4ff\" COLSPAN=3 VALIGN=CENTER>\n");
		printf("\t\t $demandeur \n");
		printf("\t</TD></TR>\n");
		printf("\t<TR><TD ALIGN=RIGHT VALIGN=CENTER>\n");
		printf("\t\t nombre de pages :\n");
		printf("\t</TD><TD ALIGN=LEFT VALIGN=CENTER>\n");
		printf("\t\t &nbsp;$nbPages\n");
		printf("\t</TD><TD ALIGN=LEFT>\n");
		printf("\t\t retour souhait&eacute; : &nbsp;$dateRetour\n");
		printf("\t</TD><TD ALIGN=LEFT VALIGN=CENTER>\n");
		printf("\t\t urgent :");
		if($urgent =="1")
			printf(" non \n");
		else
			printf(" oui \n");
		printf("\t</TD></TR>\n");
		printf("\t<TR><TD ALIGN=RIGHT VALIGN=CENTER>\n");
		if($nbExemplaires!=""){
			printf("\t\t nombre d'exemplaires :\n");
			printf("\t</TD><TD ALIGN=LEFT VALIGN=CENTER>\n");
			printf("\t\t &nbsp;$nbExemplaires \n");
		} else {
		        printf("\t\t&nbsp;\n");
			printf("\t</TD><TD ALIGN=LEFT VALIGN=CENTER>\n");
			printf("\t\t&nbsp;\n");
		}
		printf("\t</TD><TD ALIGN=RIGHT>\n");
		printf("\t\t original :\n");
		printf("\t</TD><TD ALIGN=LEFT VALIGN=CENTER>\n");
		printf("\t\t &nbsp;");
		if($original=="1") {
			printf("papier");
		} else {
			printf("fichier");
		}
		printf("\n\t</TD></TR>\n");
		if($original=="2"){
			printf("\t<TR><TD ALIGN=RIGHT COLSPAN=4 VALIGN=TOP>\n");
			printf("\t\tfichier : $adresseFichier_name \n");
			printf("\t</TD></TR>\n");
		}
		printf("\t<TR><TD ALIGN=RIGHT>\n");
		printf("\t\t couleur papier :\n");
		printf("\t</TD><TD ALIGN=LEFT VALIGN=TOP>\n");
		printf("\t\t &nbsp;$couleurPapier\n");
		printf("\t</TD><TD ALIGN=RIGHT VALIGN=CENTER>\n");
		printf("\t\t tirages :\n");
		printf("\t</TD><TD ALIGN=LEFT VALIGN=CENTER>\n");
		printf("\t\t &nbsp;");
		if($tirage=="1") {
			printf("recto\n");
		} else {
			printf("recto/verso\n");
		}
		printf("\t</TD></TR>\n");
		printf("\t<TR><TD ALIGN=RIGHT VALIGN=CENTER>\n");
		printf("\t\t couverture :\n");
		printf("\t</TD><TD ALIGN=LEFT VALIGN=CENTER>\n");
		printf("\t\t &nbsp;");
		if($couverture=="1") {
			printf("oui\n");
		} else {
			printf("non\n");
		}
		printf("\t</TD><TD ALIGN=RIGHT VALIGN=CENTER>\n");
		printf("\t\t agrafage :\n");
		printf("\t</TD><TD ALIGN=LEFT VALIGN=CENTER>\n");
		if($agraphage=="0")
			printf("\t\t &nbsp;aucun");
		else
			printf("\t\t &nbsp;$agraphage");
		printf("\t</TD></TR>\n");
		printf("\t<TR><TD ALIGN=RIGHT BGCOLOR=\"#c4c4ff\" VALIGN=TOP>\n");
		printf("\t\t instructions<BR>particuli&egrave;res\n");
		printf("\t</TD><TD ALIGN=LEFT BGCOLOR=\"#c4c4ff\" COLSPAN=3 VALIGN=TOP>\n");
		printf("\t\t &nbsp; $instructionsParticulieres\n");
		printf("\t</TD></TR>\n");
		printf("\t<TR><TD ALIGN=RIGHT VALIGN=TOP>\n");
		printf("\t\t nature du tirage :\n");
		printf("\t</TD><TD ALIGN=LEFT COLSPAN=3 VALIGN=TOP>\n");
		printf("\t\t &nbsp;");
		if($typeCours=="1") printf("tp");
		else if($typeCours=="2")printf("cours");
		else if ($typeCours=="3") printf("personnel");
		else printf("autre");
		printf("\n\t</TD></TR>\n");
		printf("\t</TD></TR>\n");
		printf("\t<TR><TD ALIGN=RIGHT VALIGN=TOP>\n");
		printf("\t\t intitulé :\n");
		printf("\t</TD><TD ALIGN=LEFT COLSPAN=3 VALIGN=TOP>\n");
		printf("\t\t &nbsp;$nomCours\n");
		printf("\t</TD></TR>\n");
		printf("\t<TR><TD ALIGN=RIGHT VALIGN=TOP>\n");
		printf("\t\t promotion :\n");
		printf("\t</TD><TD ALIGN=LEFT VALIGN=TOP>\n");
		if($p1=="on") printf("p1<BR>");
		if($p2=="on") printf ("p2<BR>");
		if($i1=="on") printf("i1<BR>");
		if($i2=="on") printf("i2<BR>");
		if($i3=="on") printf("i3<BR>");
		if($itii=="on") printf("itii<BR>");
		if($fc=="on") printf("fc<BR>");
		if($aeseo=="on") printf("aeseo<BR>");
		if($mastere=="on") printf("mastere<BR>");
		if($admin=="on") printf("admin<BR>");
		if($autre=="on") printf("autre<BR>");

		printf("\n\t</TD><TD ALIGN=RIGHT VALIGN=TOP>\n");
		printf("\t\t division :\n");
		printf("\t</TD><TD ALIGN=LEFT VALIGN=TOP>\n");

		if($complet=="on") printf("compl&egrave;te<BR>");
		if($a=="on") printf("a<BR>");
		if($b=="on") printf("b<BR>");
		if($c=="on") printf("c<BR>");
		if($d=="on") printf("d<BR>");
		if($paris=="on") printf("paris<BR>");
		if($dijon=="on") printf("dijon<BR>");
		if($bio=="on") printf("bio<BR>");
		if($ee=="on") printf("ee<BR>");
		if($env=="on") printf("env<BR>");
		if($rt=="on") printf("rt<BR>");
		if($sea=="on") printf("sea<BR>");
		if($si=="on") printf("si<BR>");
		if($sirt=="on") printf("sirt<BR>");
		if($tst=="on") printf("tst<BR>");

		printf("\n\t</TD></TR>\n");
		printf("\t</TABLE>\n");

	}

	?>

	<BR><BR>
</TD></TR>
</TABLE>

<?
	include("fin.php");
?>

