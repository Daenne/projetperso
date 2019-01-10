<section>
  <div>
    <h2>Derniers articles en ligne</h2>
    <article>
        <?php
            while ($article = $articlesList->fetch()) { ?>
                <?php
                if (strlen($article['content']) <= 200)
                {
                    $content = $article['content'];
                }
                else
                {
                    $begin = substr($article['content'], 0, 200);
                    $begin = substr($begin, 0, strrpos($begin, ' ')) . '...';
                    $content = $begin;
                } ?>
        <div>
            <p><?= strip_tags($article['title']); ?></p>
        </div>
        <div>
            <p>Posté le <?= $article['date_create']; ?>
            <p><?= nl2br(strip_tags($content)); ?></p>
            <a href="<?= HOST;?>article/id/<?= $article['id'];?>">Lire la suite</a>
        </div>
        <?php
        }
        ?>
    </article>
  </div>        
</section>