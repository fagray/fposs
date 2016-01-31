
$(document).ready(function(){

	var tbBarcodeBlock = $('#tbBarcode');

	var tbItemNameBlock = $('#tbItemName');

	$('#selectInputType').on('change',function(){

		var selection = $(this).val();

		switch(selection){

			case 'inputBarcode' : 

				tbBarcodeBlock.show();
				tbItemNameBlock.hide();

			break;

			case 'inputItemName'  :

				tbItemNameBlock.css("display","block");
				tbBarcodeBlock.hide();

				handleItemAutoSuggest();

			break;


		}

	

	});


	function handleItemAutoSuggest(){

		$.getJSON('/cart/items/find/all',function(data){

					console.log(data);

					$('datalist#item-list').empty();

					$.each(data,function(key,value){

						$('datalist#item-list').append('<option value="'+value.name+'">');
						// $('ul.populated_items').append('<a><li>'+ value.name +'</li></a>');


					});

				});

		// $('input#item_name').on('keyup',function(){

		// 	$('ul.populated_items').css("display","block");

		// 	var value = $(this).val();

		// 		//find the item
				
			


		// });


	}
	


});