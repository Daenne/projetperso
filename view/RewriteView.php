<section>
  <div>

  	<h2>Modifier l'article : </h2>

      <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=vf59xyjgxn48ibyemdd9z3bljo7vnd99c667lokvdam3ykfi"></script>
  		<script>tinymce.init({ selector:'textarea' });</script>

		<form action ="<?= HOST;?>edit/id/<?= strip_tags($initialArticle['id']); ?>" method="post">
      <div>
          <div>
              <input name="title" type="text" value="<?= strip_tags($initialArticle['title']) ?>"><br />
          </div>
      </div>
      <div>
        <div>
          <textarea name="content"><?= nl2br(strip_tags($initialArticle['content'])); ?></textarea>
        </div>  
      </div>
      <?php 
            if (!empty($initialArticle['image']))
            {
              echo "<img src=". WEB . "img/article_img/" . $initialArticle['image'] . " />";
            }
            ;?>
        <label>Image : </label>
        <input type="hidden" name="MAX_FILE_SIZE" value="250000" />
        <input type="file" name="picture">
        <p>
          <button type="submit" name="addArticle">Ajouter</button>
        </p>
    </form>
      <button type="submit">Modifier</button>
		</form>
  </div>
</section>