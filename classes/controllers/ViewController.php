<?php
	// Loading views class
	class ViewController {
		
		// Singleton pattern
		private static ?ViewController $instance = null;

		public function __construct() {}
		
		////////////////////
		// Manage the only instance de the controller
		////////////////////
		public static function getInstance() {
			if (self::$instance) {
				return self::$instance;
			}
			
			$instance = new ViewController();
			self::$instance = $instance;
			return $instance;
		}
		
		/* For under folder purposes (for a main index) */
		public function getView() : void {
			
			// Location for directory base for detecting a view file
			$baseDir = "./views";
			
			// The asked view to display
			$selectedView = str_replace('/Todo-list/', '', $_SERVER['REQUEST_URI']);
			$selectedView = str_replace('.php', '', $selectedView);
			
			// Remove all the "get" parametemeters
			$selectedView = explode('?', $selectedView)[0];
			
			// Search only the first part of URL
			$selectedView = explode('/', $selectedView)[0];
			
			// If a ressource is detected, then we can return the selected element from view
			if (file_exists($baseDir.'/'.$selectedView.'.php')) {
				require($baseDir.'/'.$selectedView.'.php');			
				return;
			}
			
			// else, redirect to home menu
			require($baseDir.'/home.php');			
			return;
		}
	}
?>