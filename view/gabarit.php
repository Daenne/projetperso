<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?= WEB; ?>logocdbfavicon.ico" />
	<link rel="stylesheet" href="<?= WEB; ?>style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title><?= $pageTitle; ?></title>
</head>
<body>
	<h1>HEADER</h1>
	<nav>
		<ul>
			<li><a href="<?= HOST.'home'; ?>">Accueil</a></li>
			<li><a href="<?= HOST;?>articles/page/1">Articles</a></li>
			<li><a href="<?= HOST.'projets'; ?>">Projets</a></li>
			<li><a href="<?= HOST.'apropos'; ?>">A propos</a></li>
			<li><a href="<?= HOST.'contact'; ?>">Contact</a></li>
			<li><a href="<?= HOST.'login'; ?>"">Admin</a></li>
		</ul>
	</nav>
	
<!--ma page-->
<?= $contentPage; ?>

	<p> DB Charlotte - 2018
		Site hébergé par 1&1 Internet SARL 7 place de la Gare BP 70109 57201 Sarreguemines Cedex</p>
</body>
</html>