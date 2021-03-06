<?php

class ArticlesController extends Controller
{
    protected $manager;

    public function __construct() {

        $this->manager = new ArticlesManager();
    }

// MENU
    //ARTICLES 20 - 363
    //COMMENTS

    /////ARTICLES 369 - 564

      //CREATE

    public function getPicture($params)
    {
      extract($params);

      try
      {
        if (isset($_FILES['picture']) AND (!empty($_FILES['picture']['name']))) 
        {
          $maxSize = 20971520; // 2Mo
          $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');

          if($_FILES['picture']['size'] <= $maxSize) 
          {
            $uploadPicture = strtolower($_FILES['picture']['name']);
            $pictureExtension = strtolower(strrchr($_FILES['picture']['name'], '.'));

            if(in_array($pictureExtension, $validExtensions))
            {
              $way = ROOT."web/img/article_img/".$uploadPicture;

              $result = move_uploaded_file($_FILES['picture']['tmp_name'], "$way");

              if ($result) 
              {
                return $uploadPicture;
              } 
              else 
              {
                throw new Exception(
                  "<br/><p class=\"container has-text-centered has-text-weight-bold\">Erreur durant l'importation de votre photo de profil.</p>",
                  $this->render('Error.twig'));   
              }
            } 
            else 
            {
              throw new Exception(
                  "<br/><p class=\"container has-text-centered has-text-weight-bold\">Votre photo doit être au format jpg, jpeg, gif ou png.</p>",
                  $this->render('Error.twig'));  
            }
          } 
          else 
          {
            throw new Exception(
                "<br/><p class=\"container has-text-centered has-text-weight-bold\">Votre photo ne doit pas dépasser 2Mo.</p>",
                  $this->render('Error.twig'));
          }
        }
      }
      catch(Exception $e) 
      {
        echo $e->getMessage();
      }
    }

    public function addArticle($params) 
    {
      extract($params);
      try
      {
        if($_SESSION['authentification']) 
        {
          if ((!empty($title)) && (!empty($content))) 
          {
            $picture = $this->getPicture($params);
            if($picture) 
            {
              $newArticle = $this->manager->postArticleWithPicture($title, $content, $picture);
              if ($newArticle === false) 
              {
                throw new Exception(
                  "<br/><p class=\"container has-text-centered has-text-weight-bold\">Impossible d'ajouter l'article.</p>",
                  $this->render('Error.twig'));
              } 
              else 
              {
                $this->redirect('admin');
              }
            }
            else
            {
              $newArticle = $this->manager->postArticle($title, $content);
              if ($newArticle === false) 
              {
                throw new Exception(
                  "<br/><p class=\"container has-text-centered has-text-weight-bold\">Impossible d'ajouter l'article.</p>",
                  $this->render('Error.twig'));
              } 
              else 
              {
                $this->redirect('admin');
              }
            }
          }
          else
          {
            throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Tous les champs ne sont pas remplis.</p>",
                  $this->render('Error.twig'));
          }
        }
        else
        {
          throw new Exception(
            "<br/><p class=\"container has-text-centered has-text-weight-bold\">Vous n'avez pas les accès requis</p>",
              $this->render('Error.twig'));  
        } 
      }
      catch(Exception $e) 
      { 
        echo $e->getMessage();
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
      extract($params = array('page' => $params['page'], EXTR_OVERWRITE));

      if ((isset($page)) && ($page != null)) 
      {
        $page = intval($page);
        $currentPage = $this->havePagination($page);
        $articlesList = $this->manager->getArticles($currentPage); 
        $allPages = $this->manager->getPagination();
        $pageTitle = 'Articles';

          $this->render('ArticlesView.twig', array(
            'pageTitle' => $pageTitle,
            'articlesList' => $articlesList,
            'currentPage' => $currentPage,
            'allPages' => $allPages
          ));
      }  
      else
      {
        throw new Exception(
          "<br/><p class=\"container has-text-centered has-text-weight-bold\">Cette page n'existe pas</p>",
          $this->render('Error.twig'));          
      }
    }

    public function showOneArticle($params)
    {
      try 
      {
        extract($params = array('id' => $params['id'], EXTR_OVERWRITE));

        $search_array = $this->manager->getArticle($id);

        if ((isset($id)) && is_numeric($id) && $id == $search_array['id'])
        {
          $article = $this->manager->getArticle($id);
          $pageTitle = $article['title'];
          $comments = $this->getComments($id);
            
          $this->render('ArticleView.twig', array(
                  'pageTitle' => $pageTitle,
                  'article' => $article,
                  'comments' => $comments
          ));
        }
        else 
        {
          throw new Exception(
            "<br/><p class=\"container has-text-centered has-text-weight-bold\">Aucun identifiant de billet envoyé</p>",
             $this->render('Error.twig'));
        }
      }
      catch(Exception $e) 
      { 
        echo $e->getMessage();
      } 
    }

      //UPDATE

    public function rewriteArticle($params)
    {
      extract($params);

      try
      {
        if (isset($_SESSION['authentification']))
        {
          if (isset($id) && $id > 0) 
          {
            $initialArticle = $this->manager->getArticle($id);
            $tinyKey = 'vf59xyjgxn48ibyemdd9z3bljo7vnd99c667lokvdam3ykfi';
            $pageTitle = 'Modifier un article';

            $this->render('RewriteView.twig', array(
                    'pageTitle' => $pageTitle,
                    'initialArticle' => $initialArticle,
                    'tinyKey' => $tinyKey
            ));
          }
          else 
          {
            throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Impossible de modifier l'article</p>",
            $this->render('Error.twig'));
          }
        }
        else 
        {
          throw new Exception(
            "<br/><p class=\"container has-text-centered has-text-weight-bold\">Vous n'avez pas les accès requis</p>",
            $this->render('Error.twig'));
        }      
      }
      catch(Exception $e) 
      { 
        echo $e->getMessage();
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
              $picture = $this->getPicture($params);
              if($picture) 
              {
                $updateArticle = $this->manager->updateArticleWithPicture($params['id'], $params['title'], $params['content'], $picture);
                if ($updateArticle === false) 
                {
                  throw new Exception(
                    "<br/><p class=\"container has-text-centered has-text-weight-bold\">Impossible de modifier l'article</p>",
                    $this->render('Error.twig'));
                } 
                else 
                {
                  $this->redirect('admin');
                }
              }
              else
              {
                $updateArticle = $this->manager->updateArticle($params['id'], $params['title'], $params['content']);
                if ($updateArticle === false) 
                {
                  throw new Exception(
                    "<br/><p class=\"container has-text-centered has-text-weight-bold\">Impossible de modifier l'article</p>",
                    $this->render('Error.twig'));
                } 
                else 
                {
                  $this->redirect('admin');
                }
              }  
            }
            else
            {
              throw new Exception(
                "<br/><p class=\"container has-text-centered has-text-weight-bold\">Aucun identifiant de billet envoyé.</p>",
                $this->render('Error.twig'));
            }
          }
          else 
          {
            throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Tous les champs ne sont pas remplis.</p>",
              $this->render('Error.twig'));
          }
        }
        else 
        {
          throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Vous n'avez pas les accès requis</p>",
              $this->render('Error.twig'));
        }
      }
      catch(Exception $e) 
      { 
        echo $e->getMessage();
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
              throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Impossible de supprimer l'article.</p>",
              $this->render('Error.twig'));
            } 
            else 
            {
              $this->redirect('admin');
            }
          }
          else 
          {
            throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Aucun identifiant de billet envoyé.</p>",
              $this->render('Error.twig'));
          }
        }
        else 
        {
          throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Vous n'avez pas les accès requis</p>",
              $this->render('Error.twig'));
        }
      } 
      catch(Exception $e) 
      { 
        echo $e->getMessage();
      }  
    }

    /////COMMENTS

      //CREATE

    public function addComment($params) 
    {
      extract($params);
      try
      {
        if (isset($id) && $id > 0) 
        {
          if (!empty($author) && !empty($content)) 
          {   
            $affectedLines = $this->manager->postComment($id, $author, $content);
            if ($affectedLines === false) 
            {
                throw new Exception(
                "<br/><p class=\"container has-text-centered has-text-weight-bold\">Impossible d'ajouter le commentaire.</p>",
                $this->render('Error.twig'));
            }
            else 
            {
                $this->redirect('article/id/'. $id);
            }
          }
          else 
          {
            throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Tous les champs ne sont pas complétés.</p>",
              $this->render('Error.twig'));
          }
        }
        else 
        {
          throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Aucun identifiant de billet envoyé.</p>",
              $this->render('Error.twig'));
        }  
      }
      catch(Exception $e) 
      { 
        echo $e->getMessage();
      } 
    }

      //READ

    public function getAllComments($params)
    {
      try
      { 
        if(isset($_SESSION['authentification']))
        {
          $comments = $this->manager->getAllComments();
          $pageTitle = 'Gestion des commentaires';

          $this->render('AdminCommentView.twig', array(
            'pageTitle' => $pageTitle,
            'comments' => $comments
          ));
        }
        else 
        {
          throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Vous n'avez pas les accès requis</p>",
              $this->render('Error.twig'));
        }
      }
      catch(Exception $e)
      {
        echo $e->getMessage();
      }  
    }

    public function getComments($params)
    {
      $comments = $this->manager->getComments($params);
      return $comments;
    }

      //UPDATE

    public function acceptedComment ($params)
    {
      extract($params);
      try 
      {
        if(isset($_SESSION['authentification']))
        {
          if(isset($id) && $id> 0) 
          {
            $updateComment = $this->manager->validComment($id);
            if ($updateComment === true) 
            {
              $this->redirect('adminComment');
            }
            else 
            {
            throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Impossible de valider le commentaire.</p>",
              $this->render('Error.twig'));
            } 
          }
          else 
          {
            throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Aucun identifiant de commentaire envoyé.</p>",
              $this->render('Error.twig'));
          }
        }
        else 
        {
          throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Vous n'avez pas les accès requis.</p>",
              $this->render('Error.twig'));
        }
      }      
      catch(Exception $e)
      {
        echo $e->getMessage();
      }   
    }

    public function signaledComment ($params)
    {
      extract($params);
      try 
      {
        if(isset($id) && $id > 0) 
        {
          $updateComment = $this->manager->warningComment($id);
          $pageTitle = 'Commentaire signalé';
          if ($updateComment === false) 
          {
            throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Impossible de signaler le commentaire.</p>",
              $this->render('Error.twig'));
          }
          else 
          {
            $this->render('SuccessView.twig', array(
                  'pageTitle' => $pageTitle
              ));
          }
        }
        else 
        {
          throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Aucun identifiant de commentaire envoyé.</p>",
              $this->render('Error.twig')); 
        }
      }  
      catch(Exception $e)
      {
        echo $e->getMessage();
      }
    }

      //DELETE

    public function deleteComment($params)
    {
      extract($params);
      try
      {
        if(isset($_SESSION['authentification']))
        {
          if (isset($id) && $id> 0) 
          {
            $deleteComment = $this->manager->deleteComment($id);
            if ($deleteComment === false) 
            {
            throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Impossible de supprimer le commentaire</p>",
              $this->render('Error.twig'));
            } 
            else 
            {
              $this->redirect('adminComment');
            }
          }
          else 
          {
            throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Aucun identifiant de commentaire envoyé.</p>",
              $this->render('Error.twig'));
          }
        }
        else 
        {
          throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Vous n'avez pas les accès requis.</p>",
              $this->render('Error.twig'));
        }
      } 
      catch(Exception $e)
      {
        echo $e->getMessage();
      }
    }
}