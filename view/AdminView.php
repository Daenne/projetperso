<?php include_once(VIEW.'adminTemplate.php'); ?>
<section>
  <div>    
    <h2>Ajouter un article : </h2>

      <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=vf59xyjgxn48ibyemdd9z3bljo7vnd99c667lokvdam3ykfi"></script>
      <script>tinymce.init({ selector:'textarea'});</script>

    <form action="<?=HOST;?>write" method ="post" enctype="multipart/form-data">
      <div>
        <label for="title">Titre : </label>
        <div>
            <input name="title" type="text">
        </div>
      </div>
      <div>
        <label for="content">Article : </label>
        <div>
          <textarea name="content"></textarea>
        </div>  
      </div>
      <div>
        <label>Image : </label>
        <input type="hidden" name="MAX_FILE_SIZE" value="250000" />
        <input type="file" name="picture">
      </div>
        <p>
          <button type="submit" name="addArticle">Ajouter</button>
        </p>
    </form><br/>

    <div>
    <?php
      while ($article = $articlesList->fetch()) { 
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
      <div>
          <p>
            <?= strip_tags($article['title']); ?>
          </p>
        <div>
          <div>

            <?php 
            if (!empty($article['image']))
            {
              echo "<img src=". WEB . "img/article_img/" . $article['image'] . " />";
            }
            ;?>
            <?= $content; ?>
            <br>
            <p>Posté le <?= $article['date_create']; ?></p>
          </div>
      </div>
      <footer>
        <a href="<?= HOST;?>article/id/<?= $article['id'];?>">Lire la suite</a>
        <a href="<?= HOST;?>rewrite/id/<?= $article['id'];?>"><button>Modifier</button></a>
        <a href="<?= HOST;?>delete/id/<?= $article['id'];?>"><button>Supprimer</button></a>
      </footer>
    <br/>  
    <?php
    }
    ?>
    </div>
  </div>
</section>
