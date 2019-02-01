<section>
  <div>
    <h2>Derniers articles en ligne</h2>
    <article id="all_articles">
        <?php
            while ($article = $articlesList->fetch()) 
            { 

                if (strlen($article['content']) <= 200)
                {
                    $content = $article['content'];
                }
                else
                {
                    $begin = substr($article['content'], 0, 200);
                    $begin = substr($begin, 0, strrpos($begin, ' ')) . '...';
                    $content = $begin;
                } 
            ?>

        <div class="article">
            <div>
            <p><?= strip_tags($article['title']); ?></p>
            </div>
            <div>
            <p>Posté le <?= $article['date_create']; ?>
            <p><?= nl2br(strip_tags($content)); ?></p>
            <a href="<?= HOST;?>article/id/<?= $article['id'];?>">Lire la suite</a>
            </div>  
        </div>        
        <?php
        }
        ?>   
        <div id="pagination">

      <?php
      for($i=1;$i<=$allPages;$i++) {
         if($i == $currentPage) {
            echo $i.' ';
         } elseif ($i == $currentPage + 1) {
            echo '<a class="next" href="'.$i.'">'.$i.'</a> ';
         }
         else {
            echo '<a href="'.$i.'">'.$i.'</a> ';
         }
      }
      ?>  
        </div>
    </article>
   
  <div>
    <p>M'inscrire à la newsletter</p>
    <form action="<?= HOST; ?>subscribe" method="post">
      <input type="email" name="user_mail_newsletter" placeholder="Votre adresse e-mail">
      <input type="submit">
    </form>
  </div>     

<script src="<?=WEB;?>/js/jquery-ias.min.js"></script>
<script src="<?=WEB;?>/js/pagination.js"></script>
</section>
