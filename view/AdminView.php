<?php include_once(VIEW.'adminTemplate.php'); ?>
<section>
  <div>    
    <h2>Ajouter un article : </h2>

      <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=vf59xyjgxn48ibyemdd9z3bljo7vnd99c667lokvdam3ykfi"></script>
      <script>tinymce.init({ selector:'textarea'});</script>

    <form action="" method ="post">
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
        <p>
          <button type="submit" name="addArticle">Ajouter</button>
        </p>
    </form><br/>


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
      <header>
        <p>
          <?= strip_tags($article['title']); ?>
        </p>
      </header>
      <div>
        <div>
          <?= $content; ?>
          <br>
          <p>Posté le <?= $article['date_create']; ?></p>
        </div>
      </div>
      <footer>
        <a href="<?= HOST;?>article/id/<?= $article['id'];?>">Lire la suite</a>
        <a href="<?= HOST;?>edit/id/<?= $article['id'];?>"><button>Modifier</button></a>
        <a href="<?= HOST;?>delete/id/<?= $article['id'];?>"><button>Supprimer</button></a>
      </footer>
    </div>
    <br/>  
    <?php
    }
    ?>
  </div>
</section>