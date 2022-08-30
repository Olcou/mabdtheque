<?php
$title = 'Contact - Ma BDthéque';
require 'header.php';
?>

<div class="overflow-hidden">
  <img src="./assets/images/bg-mabd.jpg" alt="ma bdthéque background" height="383">
</div>

<section class="contact" id="contact">
  <div class="container my-5">
    <h2 class="pt-4">Contact :</h2>


    <div class="contact-title">
      <p>Si vous souhaitez nous contacter, n'hésitez pas à remplir le formulaire ci-dessous:</p>
    </div>

    <form class="row g-3">
      <div class="col-md-6">
        <label for="Default01" class="form-label">Nom</label>
        <input type="text" class="form-control" id="Default01">
      </div>
      <div class="col-md-6">
        <label for="Default02" class="form-label">Prénom</label>
        <input type="text" class="form-control" id="Default02">
      </div>
      <div class="col-md-6">
        <label for="validationDefault03" class="form-label">Pseudo</label>
        <input type="text" class="form-control" id="validationDefault03" required>
      </div>
      <div class="col-md-6">
        <label for="validationDefault04" class="form-label">Email</label>
        <input type="text" class="form-control" id="validationDefault04" required>
      </div>
      <div class="col-mb-12">
        <label for="validationDefault05" class="form-label">Message</label>
        <textarea class="form-control" id="validationDefault05" rows="3" required></textarea>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
        <label class="form-check-label" for="invalidCheck2">
          En soumettant ce formulaire, j’accepte que mes informations soient utilisées exclusivement dans le cadre de ma demande et de la relation commerciale éthique et personnalisée qui pourrait en découler si je le souhaite.
        </label>
      </div>
      <div class="py-1 text-center">
                <button class="btn btn-outline-secondary" name="submit-contact" type="submit">Envoyer</button>
            </div>
    </form>

  </div>

</section>

<?php require 'footer.php'; ?>