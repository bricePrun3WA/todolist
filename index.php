<?php
	declare(strict_types=1);
	
	// Load classes and initialize instances we need to need to use for actions
	require ("./classes/controllers/ViewController.php");
	
	// Instanciate the only way to get pages through navigation
	$viewControllerInstance = ViewController::getInstance();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Todo List</title>

        <link type="text/css" rel="stylesheet" href="http://localhost/Todo-list/assets/css/style.css" />
		
		<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <head>
    <body>
        <header>
            <h1>Todo List</h1>
        </header>

        <main>
			<div class="row">
				<div class="column text-center">
					<?php
						// Manages the selected page
						$viewControllerInstance->getView();
					?>
				</div>
			</div>
        </main>

        <footer>
            &copy; &emsp; Brice PRUNIER - <?php echo date("Y"); ?>
        </footer>
    </body>
</html>