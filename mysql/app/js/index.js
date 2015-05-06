$(document).ready(function() {
	var serializedData = null;
	 
	$("#edit-form").submit(function(event){
		event.preventDefault();

		var $form = $(this);
		var serializedData = $form.serialize();
		
		$.post("../server/index.php", serializedData, function(result){
			console.log(result);

			var data = result;
			$("#query-result").html(data);
		})
	});
	
});
