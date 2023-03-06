<?php
	require_once('./../classes/controllers/TaskController.php');
	
	// Missing Params
	if (!isset($_POST) || !isset($_POST['action'])) {
		return json_encode([
			'type' => 'error',
			'message' => 'Parameter not sent'
		]);
	}
	
	// All the interactions with database-linked controllers
	switch ($_POST['action']) {
		case 'add_task':
			$controller = new TaskController();
			echo $controller->addTask($_POST);
			break;
		case 'delete_task':
			$controller = new TaskController();
			echo $controller->deleteTask($_POST);
			break;
		case 'list_tasks':
			$controller = new TaskController();
			echo $controller->listTasks($_POST);
			break;
		case 'get_task':
			$controller = new TaskController();
			echo $controller->getTask($_POST);
			break;
		case 'update_task':
			$controller = new TaskController();
			echo $controller->updateTaskState($_POST);
			break;
		default:
			// Returns a blank if nothing is found
			return json_encode([]);
	}
?>