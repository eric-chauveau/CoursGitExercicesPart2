<?php
	// VÉRIFICATION ET INITIALISATION PAR DÉFAUT DES VARIABLES:
	// ces variables sont les suivantes:
	// * user: le "IdUser" de l'utilisateur
	// * demandeur: le nom et le prénom de la personne qui demande le tirage
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

	// pour afficher tous les paramètres de configuration:
	//phpinfo();

	$user = $_POST['user'];
	if($user == "")
		$user = $_POST['IdUser'];
		
	if($user == ""){
		 echo "Vous n'êtes pas autorisés à visualiser cette page !";
		 exit();
	}

  	$demandeur = $_POST['demandeur'];
	$dateRetour = $_POST['dateRetour'];
	$urgent = $_POST['urgent'];
	$nbPages = $_POST['nbPages'];
	$nbExemplaires = $_POST['nbExemplaires'];
	$original = $_POST['original'];
	$adresseFichier = $_POST['adresseFichier'];
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

	if($original==""){
		$original = "2";
	}
	if($urgent==""){
		$urgent = "1";
	}
	if($tirage==""){
		$tirage = "2";
	}
	if($couleurPapier==""){
		$couleurPapier= "blanc";
	}
	if($agraphage==""){
		$agraphage= "0";
	}
	if($typeCours==""){
		$typeCours = "2";
	} 


	if($demandeur==""){
	  // Requête (webservice) sur ESEO-NET pour récupérer le nom et le prénom
	  // de l'utilisateur en fonction de son 'IdUser' :

	  // 1°) création de la session:
	  try {
	    $client = new SoapClient('http://eseo-net/opdotnet/webservices/session.asmx?wsdl');
	    $session = $_POST['IdSession'];
	    $params = array( 'IdSession' => $session,
                           'IdUser' => $user);
	    $O = $client->InitSessionFromOp($params);
	    $guid = $O->InitSessionFromOpResult;
	  } catch (Exception $e) {
               var_dump($e);
          }

	  // 2°) accès à l'annuaire:
	  try {
  	    $client = new SoapClient('http://eseo-net/opdotnet/webservices/public/annuaire.asmx?wsdl');
	    $params = array('guid' => $guid, 
                          'idPersonne' => $user,
                          'typePersonne' => 26, 
                          'listeChamps' => 'PRE,NOM' );
	    $O = $client->DetailPersonne($params);
          } catch (Exception $e) {
               var_dump($e);
          } 	  

	  // 3°) on parcourt le résultat (XML):
	  $xml = simplexml_load_string($O->DetailPersonneResult);
	  $demandeur = $xml->attributes()->PrÃ©nom . "  " . $xml->attributes()->Nom;

	}

	include("entete.php");	
?>

<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=800>
<TR><TD ALIGN=CENTER VALIGN=TOP>
	<FONT COLOR="#003366" FACE="Helvetica" SIZE=+2>
	Demandes de tirage
	</FONT>
	<BR><BR>

	<FORM ACTION="confirmationDemandeDeTirage.php" METHOD=POST
	 ENCTYPE="multipart/form-data">

	<TABLE BORDER=0 CELLPADDING=5 CELLSPACING=0 WIDTH=620>
	<TR><TD ALIGN=RIGHT BGCOLOR="#c4c4ff" VALIGN=CENTER>
		Demandeur
	</TD><TD ALIGN=LEFT BGCOLOR="#c4c4ff" COLSPAN=3 VALIGN=CENTER>
		&nbsp; <?echo $demandeur;?>	
		<INPUT TYPE="hidden" NAME="user" VALUE="<? echo $user; ?>">
<!--
		<INPUT TYPE="text" NAME="demandeur" 
		VALUE="<?echo $demandeur;?>" SIZE="50">
-->
		<INPUT TYPE="hidden" NAME="demandeur" VALUE="<?echo $demandeur;?>">
	</TD></TR>
	<TR><TD ALIGN=RIGHT VALIGN=CENTER>
		nombre de pages 
	</TD><TD ALIGN=LEFT VALIGN=CENTER>
		&nbsp;
		<INPUT TYPE="text" NAME="nbPages" 
		VALUE="<?echo $nbPages;?>" SIZE="4">
	</TD><TD ALIGN=RIGHT VALIGN=CENTER>
		retour souhait&eacute;
		&nbsp;
		<INPUT TYPE="text" NAME="dateRetour" 
		VALUE="<?echo $dateRetour;?>" SIZE="10">
	</TD><TD ALIGN=RIGHT VALIGN=CENTER>
		urgent : 
		<SELECT NAME="urgent">
			<OPTION VALUE="1"
			<?if($urgent=="1") {echo "SELECTED";}?>
			>non</OPTION>
			<OPTION VALUE="2" 
			<?if($urgent=="2"){echo "SELECTED";}?>
			>oui</OPTION>
		</SELECT>
	</TD></TR>

	<TR><TD ALIGN=RIGHT>
		original
	</TD><TD ALIGN=LEFT>
		&nbsp;
		<SELECT NAME="original">
			<OPTION VALUE="1"
			<?if($original=="1") {echo "SELECTED";}?>
			>papier</OPTION>
			<OPTION VALUE="2" 
			<?if($original=="2"){echo "SELECTED";}?>
			>fichier &lt;8Mo </OPTION>
			<OPTION VALUE="3" 
			<?if($original=="3"){echo "SELECTED";}?>
			>fichier &gt;8Mo (*)</OPTION>
		</SELECT>
	</TD><TD ALIGN=RIGHT>
		couverture
		&nbsp;
		<SELECT NAME="couverture">
			<OPTION VALUE="1"
			<?if($couverture=="1") {echo "SELECTED";}?>
			>oui</OPTION>
			<OPTION VALUE="2" 
			<?if($couverture=="2"){echo "SELECTED";}?>
			>non</OPTION>
		</SELECT>
	</TD><TD ALIGN=RIGHT>
		&nbsp;

	</TD></TR>

	<TR><TD ALIGN=RIGHT VALIGN=CENTER>
	   	<INPUT TYPE=hidden name=MAX_FILE_SIZE value=10240000>
		nom du fichier
	</TD><TD ALIGN=LEFT VALIGN=CENTER COLSPAN=3>
		&nbsp;
		<input type=file name=adresseFichier size=50>
		<BR>&nbsp;
	</TD></TR> 

	<TR><TD ALIGN=RIGHT VALIGN=CENTER>
		tirages
	</TD><TD ALIGN=LEFT VALIGN=CENTER>
		&nbsp;
		<SELECT NAME="tirage">
			<OPTION VALUE="1"
			<?if($tirage=="1") {echo "SELECTED";}?>
			>recto</OPTION>
			<OPTION VALUE="2" 
			<?if($tirage=="2"){echo "SELECTED";}?>
			>recto/verso</OPTION>
		</SELECT>		
	</TD><TD ALIGN=RIGHT VALIGN=CENTER>
		couleur papier
		&nbsp;
		<INPUT TYPE="text" NAME="couleurPapier" 
		VALUE="<?echo $couleurPapier;?>" SIZE="10">
	</TD><TD ALIGN=RIGHT VALIGN=CENTER>
		agrafage
		&nbsp;
		<SELECT NAME="agraphage">
			<OPTION VALUE="0"
			<?if($agraphage=="0") {echo "SELECTED";}?>
			>aucun</OPTION>
			<OPTION VALUE="1"
			<?if($agraphage=="1") {echo "SELECTED";}?>
			>1</OPTION>
			<OPTION VALUE="2" 
			<?if($agraphage=="2"){echo "SELECTED";}?>
			>2</OPTION>
			<OPTION VALUE="3"
			<?if($agraphage=="3") {echo "SELECTED";}?>
			>3</OPTION>
			<OPTION VALUE="4" 
			<?if($agraphage=="4"){echo "SELECTED";}?>
			>4</OPTION>
		</SELECT>		
	</TD></TR>
	<TR><TD ALIGN=RIGHT COLSPAN=4 VALIGN=CENTER>
		<FONT SIZE=-1>
		TYPE D'AGRAFAGE :
		&nbsp;&nbsp;
		1: <IMG SRC="Images/agraphage1.png" WIDTH=30>
		&nbsp;&nbsp;
		2: <IMG SRC="Images/agraphage2.png" WIDTH=30>
		&nbsp;&nbsp;
		3: <IMG SRC="Images/agraphage3.png" WIDTH=30>
		&nbsp;&nbsp;
		4: <IMG SRC="Images/agraphage4.png" WIDTH=45>
		</FONT>
	</TD></TR>
	<TR><TD ALIGN=RIGHT BGCOLOR="#c4c4ff" VALIGN=TOP>
		nature du tirage
	</TD><TD ALIGN=LEFT BGCOLOR="#c4c4ff" COLSPAN=3 VALIGN=TOP>
		&nbsp;
		<SELECT NAME="typeCours">
			<OPTION VALUE="1"
			<?if($typeCours=="1") {echo "SELECTED";}?>
			>tp</OPTION>
			<OPTION VALUE="2" 
			<?if($typeCours=="2"){echo "SELECTED";}?>
			>cours</OPTION>
			<OPTION VALUE="3" 
			<?if($typeCours=="3"){echo "SELECTED";}?>
			>personnel</OPTION>
			<OPTION VALUE="4" 
			<?if($typeCours=="4"){echo "SELECTED";}?>
			>autre</OPTION>
		</SELECT>
	</TD></TR>
	</TD></TR>
	<TR><TD ALIGN=RIGHT BGCOLOR="#c4c4ff" VALIGN=TOP>
		intitulé
	</TD><TD ALIGN=LEFT BGCOLOR="#c4c4ff" COLSPAN=3 VALIGN=TOP>
		&nbsp;
		<INPUT TYPE="text" NAME="nomCours" 
		VALUE="<?echo $nomCours;?>" SIZE="50">
	</TD></TR>
	<TR><TD ALIGN=CENTER BGCOLOR="#c4c4ff" COLSPAN=2 VALIGN=TOP>
		 <B>promotion</B>
		 <TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0>
		 <TR><TD ALIGN=RIGHT> p1 
		 </TD><TD> <INPUT TYPE="checkbox" NAME="p1" <? if($p1=="on") echo "CHECKED"; ?>>
		 </TD><TD ALIGN=RIGHT> itii 
		 </TD><TD> <INPUT TYPE="checkbox" NAME="itii" <? if($itii=="on") echo "CHECKED"; ?> >
		 </TD></TR>
		 <TR><TD ALIGN=RIGHT> p2 
		 </TD><TD> <INPUT TYPE="checkbox" NAME="p2" <? if($p2=="on") echo "CHECKED"; ?> >
		 </TD><TD ALIGN=RIGHT> formation continue 
		 </TD><TD> <INPUT TYPE="checkbox" NAME="fc" <? if($fc=="on") echo "CHECKED"; ?> >
		 </TD></TR>
		 <TR><TD ALIGN=RIGHT> i1 
		 </TD><TD> <INPUT TYPE="checkbox" NAME="i1" <? if($i1=="on") echo "CHECKED"; ?> >
		 </TD><TD ALIGN=RIGHT> aeseo 
		 </TD><TD> <INPUT TYPE="checkbox" NAME="aeseo" <? if($aeseo=="on") echo "CHECKED"; ?> >
		 </TD></TR>
		 <TR><TD ALIGN=RIGHT> i2 
		 </TD><TD> <INPUT TYPE="checkbox" NAME="i2" <? if($i2=="on") echo "CHECKED"; ?> >
		 </TD><TD ALIGN=RIGHT> mastere 
		 </TD><TD> <INPUT TYPE="checkbox" NAME="mastere" <? if($mastere=="on") echo "CHECKED"; ?> > 
		 </TD></TR>
		 <TR><TD ALIGN=RIGHT> i3 
		 </TD><TD> <INPUT TYPE="checkbox" NAME="i3" <? if($i3=="on") echo "CHECKED"; ?> >
		 </TD><TD ALIGN=RIGHT> administration 
		 </TD><TD> <INPUT TYPE="checkbox" NAME="admin" <? if($admin=="on") echo "CHECKED"; ?> > 
		 </TD></TR>
		 <TR><TD ALIGN=RIGHT> &nbsp;
		 </TD><TD> &nbsp;
		 </TD><TD ALIGN=RIGHT> autre
		 </TD><TD> <INPUT TYPE="checkbox" NAME="autre" <? if($autre=="on") echo "CHECKED"; ?> >
		 </TD></TR>
		 </TABLE>
	</TD><TD ALIGN=CENTER BGCOLOR="#c4c4ff"COLSPAN=2 VALIGN=TOP>
		<B>division</B>
		 <TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0>
		 <TR><TD ALIGN=RIGHT> 
		 	 compl&egrave;te 
		         <INPUT TYPE="checkbox" NAME="complet" <? if($complet=="on") echo "CHECKED"; ?>>
		 </TD><TD ALIGN=RIGHT>
		 	  &nbsp;&nbsp;&nbsp;&nbsp;
			  a
		          <INPUT TYPE="checkbox" NAME="a" <? if($a=="on") echo "CHECKED"; ?> >
		 </TD><TD ALIGN=RIGHT>
		 	  &nbsp;&nbsp;&nbsp;&nbsp;
		 	  bio 
		          <INPUT TYPE="checkbox" NAME="bio" <? if($bio=="on") echo "CHECKED"; ?> >
		 </TD><TD ALIGN=RIGHT>
		 	  &nbsp;&nbsp;&nbsp;&nbsp;
		 	  sea
		          <INPUT TYPE="checkbox" NAME="sea" <? if($i1=="sea") echo "CHECKED"; ?> > 
		 </TD></TR>

		  <TR><TD>
			  &nbsp;
		 </TD><TD ALIGN=RIGHT>
		 	  b
		          <INPUT TYPE="checkbox" NAME="b" <? if($b=="on") echo "CHECKED"; ?> >
		  </TD><TD ALIGN=RIGHT>
		  	  ee
		          <INPUT TYPE="checkbox" NAME="ee" <? if($ee=="on") echo "CHECKED"; ?> >
		 </TD><TD ALIGN=RIGHT>
		 	  si
		          <INPUT TYPE="checkbox" NAME="si" <? if($si=="on") echo "CHECKED"; ?> >
		 </TD></TR>

		 <TR><TD ALIGN=RIGHT>
		 	 paris
		         <INPUT TYPE="checkbox" NAME="paris" <? if($paris=="on") echo "CHECKED"; ?> >
		 </TD><TD ALIGN=RIGHT>
		 	 c
		         <INPUT TYPE="checkbox" NAME="c" <? if($c=="on") echo "CHECKED"; ?> >
		 </TD><TD ALIGN=RIGHT>
		 	  env
		          <INPUT TYPE="checkbox" NAME="env" <? if($env=="on") echo "CHECKED"; ?> >
		 </TD><TD ALIGN=RIGHT>
		 	  sirt
		          <INPUT TYPE="checkbox" NAME="sirt" <? if($sirt=="on") echo "CHECKED"; ?> >
		 </TD></TR>

		 <TR><TD ALIGN=RIGHT> 
		 	  dijon
		          <INPUT TYPE="checkbox" NAME="dijon" <? if($dijon=="on") echo "CHECKED"; ?> >
		 </TD><TD ALIGN=RIGHT>
		 	  d
		          <INPUT TYPE="checkbox" NAME="d" <? if($d=="on") echo "CHECKED"; ?> >
		 </TD><TD ALIGN=RIGHT>
		 	  rt
		          <INPUT TYPE="checkbox" NAME="rt" <? if($rt=="on") echo "CHECKED"; ?> > 
		 </TD><TD ALIGN=RIGHT>
		 	  tst
		          <INPUT TYPE="checkbox" NAME="tst" <? if($tst=="on") echo "CHECKED"; ?> >
		 </TD></TR>
		 </TABLE>

		 <BR>
		 nombre d'exemplaires <FONT COLOR=red>(**)</FONT>&nbsp;
		<INPUT TYPE="text" NAME="nbExemplaires" VALUE="<?echo $nbExemplaires;?>" SIZE="4">


	</TD></TR>
	<TR><TD ALIGN=RIGHT  VALIGN=TOP>
		instructions<BR>particuli&egrave;res
	</TD><TD ALIGN=LEFT COLSPAN=3 VALIGN=TOP>
		&nbsp;
		<INPUT TYPE="text" NAME="instructionsParticulieres" 
		VALUE="<?echo $instructionsParticulieres;?>" SIZE="50">
		<BR>
		&nbsp;&nbsp;(nom d'un fichier &gt; 8Mo, autre, ...)
	</TD></TR>
	<TR><TD ALIGN=JUSTIFY VALIGN=CENTER COLSPAN=4>
		<TABLE BORDER=0 WIDTH="100%">
		<TR><TD ALIGN=LEFT VALIGN=TOP>
			<FONT SIZE=-1>
			(*) Si la taille du fichier excède 8Mo, 
			veuillez copier le fichier
			sous
			<CENTER>
			<I>\\Depot-eseo\DemandeDeTirage</I>,
			</CENTER>
			et indiquer le nom du fichier dans le champ&nbsp;:
			<CENTER>
			<I>instructions	particuli&egrave;res</I>
			</CENTER>
			</FONT>
		</TD><TD ALIGN=RIGHT VALIGN=TOP>
			<INPUT TYPE="submit" VALUE="Envoyer la demande">
		</TD></TR>
		</TABLE>
		<FONT SIZE=-1 COLOR=red>(**)
		  le nombre d'exemplaires peut ne pas être indiqué pour 
		  les promotions P1, P2, I1, I2 et I3, ainsi que pour leurs diff&eacute;rentes 
		  divisions&nbsp;; le nombre d'exemplaire est alors récupéré automatiquement.
		  Si toutefois vous désirez un nombre diff&eacute;rent, vous pouvez l'indiquer
		  directement.
		</FONT>
	</TD></TR>
	</TABLE>
	</FORM>
</TD></TR>
</TABLE>




<?
	include("fin.php");
?>

