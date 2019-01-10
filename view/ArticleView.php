<section>
  <h2>
  <?= strip_tags($article['title']); ?>
  </h2>

  <p>Posté le <?= $article['date_create']; ?></p>
  <p><?= nl2br($article['content']); ?></p> 
</section>