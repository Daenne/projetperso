<?php

class Newsletter extends Connexion 
{
    protected $db;

    public function __construct(){
        $this->db = $this->getDb();
    }

    public function addNewsletter($user_mail_newsletter) {

        $subscribe = $this->db->prepare('INSERT INTO users_mail(user_mail_newsletter) VALUES (?)');
        $subscribe = $subscribe->execute(array($user_mail_newsletter));
        return $subscribe;
    }

    public function getSubscriber($id_newsletter) {

    	$subscriber = $this->db->prepare('SELECT * FROM users_mail WHERE id_newsletter = :id_newsletter');
    	$subscriber->bindValue(':id_newsletter', (int) $id_newsletter, PDO::PARAM_INT);
    	$subscriber->execute();
    	return $subscriber;
    }

    public function stopNewsletter($user_mail_newsletter) {

    	$unsubscribe = $this->db->prepre('DELETE FROM users_mail WHERE user_mail_newsletter = :user_mail_newsletter');
    	$unsubscribe->bindValue(':user_mail_newsletter', $user_mail_newsletter, PDO::PARAM_STR);
    	$unsubscribe = $unsubscribe->execute();
    	return $unsubscribe;

    }
}