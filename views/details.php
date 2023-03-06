<div class="align-center">
	<h2>Task details</h2>
	<div id="myDetails">
		Loading...
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		/** LOADING from the selected task (knowable thanks to the URL) */
		$.post(
			"http://<?php echo $_SERVER['HTTP_HOST']; ?>/Todo-list/api/actions.php",
			{ action: "get_task", id: "<?php echo $_GET['id'] ?>"},
			function(data) {
				if ((JSON.parse(data))?.type === 'error') {
					$("#myDetails").html('Lo&ading error.');
					return;
				}
				
				// Converts and displays data from task
				const myData = JSON.parse(data);
				const taskHtml = `								
					<p><b>Status :</b> ${(myData?.state === 'done' ? 'Done' : 'TO DO')}</p>
					<p>Created at ${(new Date(myData?.creationDate)).toLocaleDateString('en-EN')}</p>
					<div>
						<b>Description :</b><br/>
						${(!myData?.description ? '/' : myData.description)}
					</div>
				`;
				
				// Diplays the loaded content
				$("#myDetails").html(taskHtml);
			}
		);
	});
</script>