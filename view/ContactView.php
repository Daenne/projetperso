<h1>Contact</h1>

<form method="post" action="<?= HOST;?>mailSend">
	<div>
		<label for="name">Nom : </label>
		<input type="text" name="user_name">
	</div>
	<div>
		<label for="mail">E-mail : </label>
		<input type="email" name="user_mail">
	</div>
	<div>
		<label for="message">Message : </label>
		<textarea name="user_message"></textarea>
	</div>
	<div>
		<input type="submit" value="Envoyer" />
	</div>
</form>