$(document).ready(function(){
	//var baseAddress = 'http://localhost/branvis/bank/';
	var baseAddress = 'http://www.branvis.com/bank/';
	
    $(':checkbox').change(function(){
    	// get the id
    	var group = $('#group').val();
    	var user = $('#user').val();

    	// send to the webservice
    	$.ajax( {
			type:'Post',
			url:baseAddress + 'services/transaction/reconcile.php?rec=' + this.checked + '&trans=' + this.id + '&user=' + user + '&group=' + group,
			success:function(data) {
 				//alert(data);
 				// possibly do something
			}

		})
    })
});