<?php

class ArticlesController
{
    protected $manager;
    protected $newsletter;

    public function __construct() {

        $this->manager = new ArticlesManager();
        $this->newsletter = new Newsletter();
    }

    //ARTICLES 
      //CREATE

      public function addArticle($params) 
      {

        extract($params);

        try
        {
          if($_SESSION['authentification']) 
          {

            if ((!empty($title)) && (!empty($content))) 
            {
              $newArticle = $this->manager->postArticle($title, $content);
              if ($newArticle === false) 
              {
                throw new Exception("<p>Impossible d'ajouter l'article. Retour à la page d'accueil <a href=\"<?= HOST; ?>\">ici</a></p>");
              } 
              else 
              {

                $myView = new View('');
                $myView->redirect('admin');
              }
            }
            else
            {
              throw new Exception("<p>Tous les champs ne sont pas remplis. Retour à la page d'accueil <a href=\"<?= HOST;?>\">ici</a></p>");
            }
          }
          else
          {
            throw new Exception("Vous n'avez pas les accès requis");
            
          } 
        }
        catch(Exception $e) 
        { 
          echo 'Erreur : ' . $e->getMessage();
        }
      }

      //READ

    public function havePagination ($page)
    {
      $allPages = $this->manager->getPagination();

      if(isset($page) AND !empty($page) AND $page > 0 AND $page <= $allPages) 
      {
        $page = intval($page);
        $currentPage = $page;
      } 
      else 
      {
        $currentPage = 1;
      }

      return $currentPage;
    } 


    public function showArticles($params) 
    {
      extract($params);

      $page = intval($page);
      
      $currentPage = $this->havePagination($page);

      $articlesList = $this->manager->getArticles($currentPage);

      $allPages = $this->manager->getPagination();

      $pageTitle = 'Articles';

      $myView = new View('ArticlesView');
      $myView->render(array('articlesList' => $articlesList, 'currentPage' => $currentPage, 'allPages' => $allPages, 'pageTitle' => $pageTitle)); 
    }


    public function showOneArticle($params){
      try {
        extract($params = array('id' => $params['id'], EXTR_OVERWRITE));

          if (isset($id)) 
          {
            $article = $this->manager->getArticle($id);
            //$article = $article->fetch();
            $pageTitle = $article['title'];
            $comments = $this->getComments($id);

            $myView = new View('ArticleView');
            $myView->render(array('article' => $article, 'pageTitle' => $pageTitle, 'comments' => $comments));
          }
          else 
          {
            throw new Exception("<p>Aucun identifiant de billet envoyé. Retour à la page d'accueil <a href=\"<?= HOST;?>home\">ici</a></p>");
          }
      }
      catch(Exception $e) 
      { 
        echo 'Erreur : ' . $e->getMessage();
      } 
    }

      //UPDATE

    public function rewriteArticle($params)
    {
    extract($params = array('id' => $params['id'], 'title' => $params['title'], 'content' => $params['content'], EXTR_OVERWRITE));

      try
      {
        if (isset($_SESSION['authentification']))
          {
            if (isset($id) && $id > 0) 
            {
              $initialArticle = $this->manager->getArticle($id);
              //$initialArticle = $initialArticle->fetch();
        
              $pageTitle = 'Modifier un article';

              $myView = new View('RewriteView');
              $myView->render(array('initialArticle' => $initialArticle, 'pagetitle' => $pageTitle));
            }
            else 
            {
              throw new Exception("<p>Impossible de modifier l'article. Retour à la page d'accueil <a href=\"home\">ici</a></p>");
            }
          }
          else 
          {
            throw new Exception("<p>Vous n'avez pas les accès nécessaires. Retour à la page d'accueil <a href=\"home\">ici</a></p>");
          }       
      }
      catch(Exception $e) 
      { 
        echo 'Erreur : ' . $e->getMessage();
      }
    }

    public function editArticle($params)
    {
      extract($params = array('id' => $params['id'], 'title' => $params['title'], 'content' => $params['content'], EXTR_OVERWRITE));
      try
      {
        if (isset($_SESSION['authentification'])) 
        {
          if (!empty($params['title']) && !empty($params['content'])) 
          {
            if(isset($params['id']) && ($params['id']) > 0)
            {
              $updateArticle = $this->manager->updateArticle($params['id'], $params['title'], $params['content']);

              if ($updateArticle === false) {
                  throw new Exception("<p>Impossible de modifier l'article. Retour à la page d'accueil <a href=\"home\">ici</a></p>");
              }
              else {
                $myView = new View('');
                $myView->redirect('admin');
              }    
            }
            else
            {
              throw new Exception("<p>Aucun identifiant de billet envoyé. Retour à la page d'accueil <a href=\"home\">ici</a></p>");
            }
          }
          else 
          {
            throw new Exception("<p>Tous les champs ne sont pas remplis. Retour à la page d'accueil <a href=\"home\">ici</a></p>");
          }
        }
        else 
        {
          throw new Exception("<p>Vous n'avez pas les accès nécessaires. Retour à la page d'accueil <a href=\"home\">ici</a></p>");
        }
      }
      catch(Exception $e) 
      { 
        echo 'Erreur : ' . $e->getMessage();
      }
    }

      //DELETE

    public function deleteArticle ($params)
    { 
      extract($params);
      try
      {
        if(isset($_SESSION['authentification']))
        {
          if (isset($id) && $id > 0) 
          {
            $deleteArticle = $this->manager->deleteArticle($id);

            if ($deleteArticle === false) 
            {
              throw new Exception("<p>Impossible de supprimer l'article. Retour à la page d'accueil <a href=\"home\">ici</a></p>");
            } 
            else 
            {
              $myView = new View();
              $myView->redirect('admin');
            }
          }
          else 
          {
            throw new Exception("<p>Impossible de supprimer l'article. Retour à la page d'accueil <a href=\"home\">ici</a></p>");
          }
        }
        else 
        {
          throw new Exception("<p>Vous n'avez pas les accès nécessaires. Retour à la page d'accueil <a href=\"home\">ici</a></p>");
        }
      } 
      catch(Exception $e) 
      { 
        echo 'Erreur : ' . $e->getMessage();
      }  
    }

    //COMMENTS
      //CREATE

    public function addComment($params) 
    {
      extract($params);
      $affectedLines = $this->manager->postComment($id, $author, $content);
      try
      {
        if ($affectedLines === false) {
            throw new Exception("<p>Impossible d'ajouter le commentaire. Retour à la page d'accueil <a href=\"home\">ici</a></p>");
        }
        else {
            $myView = new View();
            $myView->redirect('article/'. $id);
        }
      }
      catch(Exception $e) 
      { 
        echo 'Erreur : ' . $e->getMessage();
      } 
    }

      //READ

    public function getComments($params)
    {
      //extract($params);
      $comments = $this->manager->getComments($params);
      return $comments;
    }


    //NEWSLETTER

    public function subscribeNewsletter($params)
    {
      extract($params);

      $subscribe = $this->newsletter->addNewsletter($user_mail_newsletter);

      try
      {
        if ((isset($user_mail_newsletter)) && $subscribe === true) {

          $pageTitle = 'Succès';

          $myView = new View('successView');
          $myView->render(array('pageTitle' => $pageTitle));
        }
        else {

          throw new Exception("<p>Vous n'avez pas renseigné votre adresse mail</p>");
        }
      }
      catch(Exception $e) 
      { 
        echo 'Erreur : ' . $e->getMessage();
      }

    }

    public function unsubscribeNewsletter($params)
    {
      extract($params);

      $unsubscribe = $this->newsletter->stopNewsletter($params);

      $myView = new View('successView');
      $myView->render();

    }

    public function sendNewsletter($params)
    {
      $subscribers = $this->newsletter->getSubscribers();

      $articles = $this->manager->getLastArticles();

      if ((isset($user_mail_newsletter)) && (filter_var($user_mail_newsletter, FILTER_VALIDATE_EMAIL))) 
      {
        while ($susbcriber = $subscribers->fetch()) {
          $to = $subscriber;
          $subject = "Nouveaux articles";
          
          while($article = $articles->fetch())
            {
              $myView = new View('NewsletterView');
              $myView->render(array('article' => $article));
            }
          $header = "From : CDB \n";
          mail($to, $subject, $article,$header);
        }
          
          $pageTitle = 'Succès';

          $myView = new View('successView');
          $myView->render(array('pageTitle' => $pageTitle));

        }
        else
        {
          echo "Vous ne pouvez pas envoyer la newsletter";
        }
    }

    //quand changement ou redirect myView->redirect('la page ou je veux redirect')
    
}