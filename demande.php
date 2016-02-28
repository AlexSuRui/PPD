<?php
		include "module.php";
		include "moduleBDD.php";
		session_start();
		/*startDocument("Demande");
		navBar();*/
		connection(true);
		
		if (isset($_SESSION["utilisateur"]))
			$me = $_SESSION["utilisateur"];
		else
			header('Location: index.php'); 
			
		if ($me->Demandeur == 0)
			header('Location: demandes.php'); 
		
		if (isset($_POST["submit"])) {
			$nom = addslashes($_POST["nom"]);
			$description = addslashes($_POST["description"]);
			$categorie = $_POST["categorie"];
			$date = date("Y-m-d H:i:s");
			$verrouille = 0;
			$masquer = $_POST["masquer"];
			
			$Image = inserer_image_annotable($nom, $description, $date, $verrouille, $masquer, $me->UID, $categorie, 1, "");
			
			$uploaddir = 'images';
			
			if ($Image != null) {
			$DirectoryURL = $uploaddir ."/".$Image->UID;
			$FileURL = $uploaddir ."/".$Image->UID."/".basename($_FILES['image']['name']);
			if (mkdir($DirectoryURL, 0777, true)) {
				if (move_uploaded_file($_FILES['image']['tmp_name'], $FileURL)) {
					$message .= "Le fichier est valide.<br/>";
					$Image->Chemin = $FileURL;
					maj_image_annotable($Image);
					header('Location: demandes.php');
					} else {
					$erreur .= "Attaque potentielle par téléchargement de fichiers.<br/>";
					supprimer_image_annotable($Image);
					}   
				} else {
					$erreur .= "Erreur lors de la création du dossier.<br/>";
					supprimer_image_annotable($Image);
				}
			}
			else
				 $erreur = "Erreur lors de la création de l'image annotable.";			
		}
		
		$categories = get_categories();
	?>

<?php include('header.php'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Soumettre une demande
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>demande</li>
			<li class="active">ajouter</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
		 <div class="row">
            <div class="col-xs-12">
  <?php
	if ($message != "")
		ecrireMessage($message);
	if ($erreur != "")
		ecrireErreur($erreur);
  ?>
    <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Veuillez compléter ce formulaire</h3>
                </div><!-- /.box-header -->
				<div class="box-body">
  <form class="form-horizontal" role="form" action="demande.php" method="post"  enctype="multipart/form-data">
    <?php
        echoInput("nom", "Nom :", "Entrez un nom");
        echoInput("description", "Description :", "Entrez une description");
        ?>
    <div class="form-group">
      <label class="control-label col-sm-2" for="'.$id.'">Catégorie :</label>
      <div class="col-sm-10">
        <select class="form-control" name="categorie" onchange="this.form.submit()">
          <?php
            foreach ($categories as $categorie) {
                if ($selected == $categorie->UID)
                    echo "<option value=".$categorie->UID." selected>".$categorie->Nom."</option>";
                else
                    echo "<option value=".$categorie->UID.">".$categorie->Nom."</option>";
            }
            ?>
        </select>
      </div>
	</div>
	<div class="form-group">
		<label class="col-sm-2" for="image">Sélectionnez une image à publier</label>
		<div class="col-sm-10">
			<input type="file" name="image" id="image">
		</div>
	</div>
      <strong>Masquer les contributions :</strong>
      <input type="radio" name="masquer" value="1" />
      Oui
      <input type="radio" name="masquer" value="0" checked />
      Non
    </center>
    <br/>
    <div class="col-sm-2" role="group">
        <button type="submit" class="btn btn-success btn-lg" name="submit">Soumettre la demande</button>
    </div>
  </form>

</div>
</div><!-- /.box -->
			</div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
<?php include('footer.php'); ?>