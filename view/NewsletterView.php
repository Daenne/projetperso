	<div>
        <p><?= strip_tags($article['title']); ?></p>
    </div>
    <div>
        <p>Posté le <?= $article['date_create']; ?>
        <p><?= nl2br(strip_tags($content)); ?></p>
        <a href="<?= HOST;?>article/id/<?= $article['id'];?>">Lire la suite</a>
    </div>
    <div>
    	<a href="<?= HOST; ?>unsubscribe">Se désabonner de la newsletter</a>
    </div>