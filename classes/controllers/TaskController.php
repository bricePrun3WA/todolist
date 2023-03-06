<?php
	require('../classes/data/Task.php');

	// Managing task actions from pages
	class TaskController {
		
		// Current PDO Object to link the database
		private $db;
		
		// Singleton pattern
		private static ?TaskController $instance = null;

		public function __construct() {
			require('../config.php');
			
			$this->db = $db;
		}
		
		////////////////////
		// Manage the only instance de the controller
		////////////////////
		public static function getInstance() {
			if (self::$instance) {
				return self::$instance;
			}
			
			$instance = new TaskController();
			self::$instance = $instance;
			return $instance;
		}
		
		/**
		 * Adds a new task to do in the list
		 * @param array $params, all post params: a needed TITLE, and a not mandatory DESCRIPTION
		 * @return string the JSON boolean of the statement (or error)
		 */
		public function addTask(array $params = []) : string {
			if (!isset($_POST) || !isset($_POST['title'])) {
				return json_encode([
					'type' => 'error',
					'message' => 'Missing parameter'
				]);
			}
			
			// PDO Insert in database the new task to create
			$stmt = $this->db->prepare("
				INSERT INTO tasks(title, state, description, creation_date)
				VALUES(:title, 'todo', :description, CURRENT_TIMESTAMP)
			");
			$stmt->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
			$stmt->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
			
			// Is the statement done without an error ?
			return json_encode([
				'done' => $stmt->execute()
			]);
		}
		
		/**
		 * List all tasks from database
		 * @param array $params, all post params
		 * @return string the JSON of a Task array (or error)
		 */
		public function listTasks(array $params = []) {
			// Search query
			$stmt = $this->db->prepare('
					SELECT *
					FROM tasks
					ORDER BY (state = \'done\'), creation_date DESC
				');
			$stmt->execute();
			
			// Managment of the query
			$listTasks = array();
			while ($aTask = $stmt->fetch(PDO::FETCH_OBJ)) {	
				$myTaskObj = new Task(
					$aTask->id,
					$aTask->title,
					$aTask->state,
					$aTask->creation_date,
					$aTask->description
				);
				
				array_push($listTasks, $myTaskObj->convertToArray());
			}
			
			// JSON at the end
			return json_encode($listTasks);
		}
		
		/**
		 * Search an existing task
		 * @param array $params, all post params, with an id of an existing task
		 * @return string the JSON of the Task Object (or error)
		 */
		public function getTask() : string  {
			if (!isset($_POST) || !isset($_POST['id'])) {
				return json_encode([
					'type' => 'error',
					'message' => 'Missing parameter'
				]);
			}
			
			$stmt = $this->db->prepare('
					SELECT *
					FROM tasks
					WHERE id = :id
				');
				
			$stmt->bindParam(':id', $_POST['id']);
			$stmt->execute();
			while ($aTask = $stmt->fetch(PDO::FETCH_OBJ)) {
				$myTaskObj = new Task(
					$aTask->id,
					$aTask->title,
					$aTask->state,
					$aTask->creation_date,
					$aTask->description
				);
				return json_encode($myTaskObj->convertToArray());
			}
		}
		
		/**
		 * Makes an existing task in the list, to "DONE" or "TO DO"
		 * @param array $params, all post params, including:
		 * 		-	id of an existing task
		 * 		-	done, the state of the task
		 * @return string the JSON result from execution (or error)
		 */
		public function updateTaskState(array $params = []) : string {
			if (!isset($_POST) || !isset($_POST['id']) || !isset($_POST['done'])) {
				return json_encode([
					'type' => 'error',
					'message' => 'Missing parameter(s)'
				]);
			}
			
			$state = ($_POST['done'] === 'true' ? 'done' : 'todo');
			
			$stmt = $this->db->prepare("
				UPDATE tasks
				SET state = :state
				WHERE id = :id
			");
			$stmt->bindParam(':state', $state, PDO::PARAM_STR);
			$stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
			
			// Is the statement done without an error ?
			return json_encode([
				'done' => $stmt->execute()
			]);
		}
		
		/**
		 * Deletes an existing task in the list
		 * @param array $params, all post params, including id of an existing task
		 * @return string the JSON result from execution (or error)
		 */
		public function deleteTask(array $params = []) : string {
			
			// Check needed params
			if (!isset($_POST)
					|| !isset($_POST['id'])) {
						
				return json_encode([
					'type' => 'error',
					'message' => 'Missing parameter'
				]);
			}
			
			// 
			$stmt = $this->db->prepare("
				DELETE FROM tasks
				WHERE id = :id
			");
			$stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
			
			// Is the statement done without an error ?
			return json_encode([
				'done' => $stmt->execute()
			]);
		}
	}
?>