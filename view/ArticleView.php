<section>
  <h2>
  <?= strip_tags($article['title']); ?>
  </h2>

  <p>Posté le <?= $article['date_create']; ?></p>
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
</section>