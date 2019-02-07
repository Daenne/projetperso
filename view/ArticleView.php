<section>
  <h2>
  <?= strip_tags($article['title']); ?>
  </h2>

  <p>Posté le <?= $article['date_create']; ?></p>
  <?php 
            if (!empty($article['image']))
            {
              echo "<img src=". WEB . "img/article_img/" . $article['image'] . " />";
            }
            ;?>
  <p><?= nl2br($article['content']); ?></p>

  <div>
        <h3>Commentaires : </h3>
          <?php
          while ($comment = $comments->fetch()){
          ?>
          <div>
            <header>
              <p>
                <strong><?= strip_tags($comment['author']) ?></strong>
              </p>
            </header>
            <div>
              <div>
                <?= nl2br(strip_tags($comment['comment'])); ?>
                <br>
                le <?= $comment['comment_date_fr'] ?>
              </div>
              <form action="index.php?action=warningComment&amp;id=<?= $comment['id']; ?>" method="post"">
                <input type="submit" value="Signaler">
              </form> 
            </div>
          </div><br/>
          <?php
          }
          ?>
        <div>
        <h3 >Ajouter un commentaire : </h3>
        <form action="<?= HOST;?>addComment/id/<?= $article['id']; ?>" method ="post">
            <div>
              <label for="author">Pseudo</label>
              <div>
                <input name="author" type="text" placeholder="Exemple : ManuMano">
              </div>
            </div>
            <div>
              <label for="content">Message</label>
              <div>
                <textarea name="content" placeholder="J'écris ici mon commentaire"></textarea>
              </div>
            </div>
            <p><button type="submit">Envoyer</button></p>
          </form>
      </div>
</section>
