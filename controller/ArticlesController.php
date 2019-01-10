<?php

class ArticlesController
{
    protected $manager;

    public function __construct() {

        $this->manager = new ArticlesManager();
    }

    public function showArticles($params) 
    {
        $articlesList = $this->manager->getArticles();
        

        $myView = new View('ArticlesView');
        $myView->render(array('articlesList' => $articlesList)); 

        //return $articlesList;
    }

    public function showOneArticle($params){

      extract($params);

      if (isset($id)) {

        $article = $this->manager->getArticle($id);

        $myView = new View('ArticleView');
        $myView->render(array('article' => $article));
      }
      else 
      {
        echo "tant pis";
                //throw new Exception("<p>Aucun identifiant de billet envoyé. Retour à la page d'accueil <a href="<?= HOST;">ici</a></p>");
      }
    }

    //quand changement ou redirect myView->redirect('la page ou je veux redirect')
    
}