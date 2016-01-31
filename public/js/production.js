//Production JS
//@Author : RSantillan

$(document).ready(function(){

		var item;
		var item_name;

		$('div.item a').click(function(e){

			e.preventDefault();

			item = $(this).attr('data-item');
			item_name = $(this).attr('data-name');

			var qty = 12;

			sendRequest(item,qty);
			
			append();

			$('button.remove').click(function(){
		 		
		 		//setTimeout("window.location.href='/sales/', function(){ $('#loader').hide(); };",500);
				// $(this).parent().delay(1000).fadeOut();
				$(this).parent().remove();
			
			});
		
	});

	function sendRequest(item,qty){

			$.ajax({

		 		url : '/items/'+ item +'/inventory/check',
		 		type: 'GET',
		 		data : { qty : qty },
		 		

		 		success : function(data){

		 			console.log(data);
		 			//setTimeout("window.location.href='/sales/', function(){ $('#loader').hide(); };",500);
		 			
				},
				error : function(e){

					console.log('Error' + e.status +': ' + e.statusText);
				}

			}); /* end ajax request */
	}	

	function append(){

		$('form#production').append('<div><button type="button" class="remove">x</button>' + item_name + 
				 '<span class="pull-right"><input type="number" value="12" name="qty[]"><input id="qty"  type="hidden" value="'+ item +'" name="items[]"></span><br/><hr/></div>');

	}	

		
});