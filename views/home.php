<div class="row align-center">
	<?php /** NEW TASK FORM */ ?>
	<div class="column">
		<h2>Add a task</h2>
		<form id="formAddTask" class="text-left">
			<div class="form-group">
				<label for="titleAdd">Title</label><br/>
				<input type="text" name="title" id="titleAdd" />
			</div>
			<div class="form-group">
				<label for="descriptionAdd">Description</label><br/>
				<textarea name="description" id="descriptionAdd"></textarea>
			</div>
			<div class="form-group text-right">
				<button class="btn btn-validate">
					Confirm
				</button>
			</div>
		</form>
	</div>
	<div class="column">
		<?php /** ALL TASKS TABLE */ ?>
		<h2>All my tasks</h2>
		<table>
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th>Task</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody id="tasksContent">
				<tr>
					<td>Loading...</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3">&nbsp;</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<script type="text/javascript">
	// Manages the content of all the tasks in the table
	function loadTasks() {
		
		// Ajax call for the controller (Indirectly)
		$.post(
			"http://<?php echo $_SERVER['HTTP_HOST']; ?>/Todo-list//api/actions.php",
			{ action: "list_tasks" },
			function(data) {
				if ((JSON.parse(data))?.type === 'error') {
					$("#tasksContent").html('Loading error.');
					return;
				}
				
				let tasksHtml = '';
				
				// For each Task objects, we add a line in table
				for (let myData of JSON.parse(data)) {
					
					tasksHtml += `
						<tr>
							<td>
								<input type="checkbox" class="changeStatus" data-id="${myData?.id}" value="done" ${myData?.state === 'done' ? 'checked' : ''} />
							</td>
							<td>
								${(myData?.state === 'done' ? `<strike>${myData?.title}</strike>` : myData?.title)}
							</td>
							<td>
								<a class="btn btn-validate" href="./details/?id=${myData?.id}" target="_blank">
									&#128065;
								</a>
								<a class="btn btn-cancel deleteTask" data-id="${myData?.id}">
									&#128465;
								</a>
							</td>
						</tr>
					`;
				}
				
				// Displays all the line in the content
				$("#tasksContent").html(tasksHtml);
			}
		);
	}

	$(document).ready(function () {
		loadTasks();
		
		// Event listener for UPDATING a targeted TASK
		$(document).on('change', '.changeStatus', function(e) {
			$.post(
				"http://<?php echo $_SERVER['HTTP_HOST']; ?>/Todo-list/api/actions.php",
				{ action: "update_task", id: $(this).attr('data-id'), done: this.checked },
				function(data) {
					if ((JSON.parse(data))?.type === 'error') {
						$("#tasksContent").html('Loading error.');
						return;
					}
					
					// Reload of the list
					loadTasks();
				}
			);
		});
		
		// Event listener for DELETING a targeted TASK
		$(document).on('click', '.deleteTask', function(e) {
			$.post(
				"http://<?php echo $_SERVER['HTTP_HOST']; ?>/Todo-list/api/actions.php",
				{ action: "delete_task", id: $(this).attr('data-id') },
				function(data) {
					if ((JSON.parse(data))?.type === 'error') {
						$("#tasksContent").html('Loading error.');
						return;
					}
					
					// Reload of the list
					loadTasks();
				}
			);
		});
		
		// Event listener for ADDING TASK
		$('#formAddTask').submit(function(e) {
			
			// Prevent some events for mandatory inputs 
			e.preventDefault();
			if (!$("#titleAdd").val()) {
				return;
			}
			
			// AJAX call for launching the controller
			$.post(
				"http://<?php echo $_SERVER['HTTP_HOST']; ?>/Todo-list/api/actions.php",
				{
					title: $("#titleAdd")?.val(),
					description: $("#descriptionAdd")?.val(),
					action: "add_task"
				},
				function(data) {
					// Error during the add
					if ((JSON.parse(data))?.type === 'error') {
						console.log(data);
						return;
					}
					
					const myData = JSON.parse(data);
					if (!myData?.done) {
						console.log(data);
						return;
					} else {
						// Reload of the list
						loadTasks();
					}
				}
			);
			
			loadTasks();
		});
	});
</script>