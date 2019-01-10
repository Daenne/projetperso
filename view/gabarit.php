<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?= WEB; ?>style.css">
	<title>Titre de la page</title>
</head>
<body>
	<h1>HEADER</h1>
	<nav>
		<ul>
			<li><a href="<?= HOST.'home'; ?>">Accueil</a></li>
			<li><a href="<?= HOST.'articles'; ?>">Articles</a></li>
			<li>Projets</li>
			<li>A propos</li>
			<li>Contact</li>
		</ul>
	</nav>
<!--ma page-->

<?= $contentPage; ?>

	<p> DB Charlotte - 2018
		Site hébergé par 1&1 Internet SARL 7 place de la Gare BP 70109 57201 Sarreguemines Cedex</p>
</body>
</html>