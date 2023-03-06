<?php
	class Task {
		private string $id;
		private string $state;
		private string $title;
		private string $description;
		private string $creationDate;
		
		/**
		 * Only Constructor for a task
		 * @params string $id: ID in the task DB
		 * @params string $title / name of the task
		 * @params string $state / state, to do (or canceled ?)
		 * @params string $creationDate / Date where this task was instered is DB
		 * @params string $description / non mandatory description linked with the title
		 */
		public function __construct(
				string $id,
				string $title,
				string $state,
				string $creationDate,
				string $description = '') {
			
			$this->id = $id;
			$this->title = $title;
			$this->state = $state;
			$this->description = $description;
			$this->creationDate = $creationDate;
		}
		
		public function getId() : string {
			return $this->id;
		}
		
		public function getState() : string {
			return $this->state;
		}
		
		public function setState(string $state) : void {
			$this->state = $state;
			return;
		}
		
		public function getTitle() : string {
			return $this->title;
		}
		
		public function setTitle(string $title) : void {
			$this->title = $title;
			return;
		}
		
		public function getDescription() : string {
			return $this->description;
		}
		
		public function setDescription(string $description) : void {
			$this->description = $description;
			return;
		}
		
		public function getCreationDate() : string {
			return $this->creationDate;
		}
		
		/**
		 * Get an array conversion of the object (for JSON)
		 * @returns array from the current task targeted 
		 */
		public function convertToArray() : array {
			return [
				'id' => $this->getId(),
				'title' => $this->getTitle(),
				'state' => $this->getState(),
				'description' => $this->getDescription(),
				'creationDate' => $this->getCreationDate()
			];
		}
	}
?>