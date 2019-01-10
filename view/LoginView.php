<section>
  <div>
  	<h2>Espace administrateur</h2>
    <p>Veuillez entrer le mot de passe pour accéder à l'interface d'administration : </p>
    <form action="<?= HOST;?>login" method="post">
      <div>
        <label>Identifiant : </label>
        <div>
          <input type="text" name="pseudo" placeholder="Votre pseudo">
        </div>
      </div>
      <div>
        <label>Mot de passe : </label>
        <div>
          <input type="password" name="password" placeholder="Votre mot de passe">
        </div>
      </div>
      <div>
        <div>
          <input type="submit" name="addAdminConnexion" value="Valider">
        </div>
      </div>
    </form>
    <br/>
    <p>Cette page est réservée à l'administration du blog</p>
  </div>
</section> 