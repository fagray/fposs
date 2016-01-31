function hehe(qty){

	alert(qty);

}

$(document).ready(function(){

	var loader = $('div#loader');
	$('div#loader').hide();

	//default selection
	var selection = 'inputBarcode';

	//barcode
	var selectionBarCode ;

	//hide the right bar on page load
	$('#rightBar').hide();
	
	

	//grab the transaction id and append it inside the form
	var trans_id = getTransId();
	var qty = getQty();
	


	//if the page is loaded, retrieve all the cart items
	// loader.html('Retrieving items');
	// loader.show();

	setTimeout(retrieveCartItems(), "function(){ $('div#loader').hide(); };",3000);


	
	//total amount due
	var total = 0;
	var amount = 0;
	var change = 0;


	//no. of items on the cart
	var items = 0;

	//hide the notification msg first
	var flash = $("div#flash").hide();
	var form = $('form#regForm');
	var tableBody = $('table#items tbody');
	var tr;

	/* Shortcut keys */

	$(document).keydown(function(e) {

		    switch(e.which) {
		    	
		        case 113: // pay
		       	handlePayment();
		        break;

		        case 118: // void
		        handleVoidTransaction(); 
		        break;

		        case 119: // sale
		        window.location.href='/store/items/sales';
		        break;


		        default: return; // exit this handler for other keys
   		 }
   		e.preventDefault(); // prevent the default action (scroll / move caret)
	});

	/* End Shortcut keys */

	//handle register selection
	$('select#selectModeType').on('change',function(){

		var selection = $(this).val();

		if(selection == 'modeReturns'){

			window.location.href='/sales/registrar/mode/returns';

		}else if(selection == 'modeSales'){

			window.location.href='/sales/registrar/';

		}
	});

	//handle to add payment 
	$('#payKey').click(function(){

		handlePayment();

	});

	function handlePayment(){

		if(total == 0 ){

			alert('Cart is empty!');
			return false;
		}
		
		//show the right bar
			$('#rightBar').show(function(){

				$(this).delay().fadeIn(3000);

			});

			$('.tbAmount').focus();
			
	}

	//handle if the payment key is pressed
	$('a#paymentKey').click(function(){

		if(total != 0){

			$('#txtAmount').focus();
			return true;
		}

	});

	//handle if the void key is pressed
	$('a#voidKey').click(function(){

		handleVoidTransaction();

	});

	function handleVoidTransaction(){

		if(total != 0){

				var con = confirm("Are you sure you want to void the transaction ?");
				// con ? tableBody.html('') : null

				if(con){

					tableBody.html('');
					showPasswordModal();


				}
				// insert the listed items from the cart to the registers table
				//with a remarks of voided

				// processVoid();

				return false;
		}

		alert("Nothing to void.");
	}
	
	// registrar module

	$('#barcode').on('keyup',function(){

		var code = $(this).val();

		if(code.length >= 12){

			form.submit();
			clearInput();
		}

	});

		form.submit(function(e){

			e.preventDefault();
			total = 0;

			if(selection == 'inputBarcode'){

				$('input[name="cash"]').removeAttr('disabled','disabled');

					//loader.show();
					//get the barcode on the form
					selectionBarCode = $('#barcode').val();


					handleFormSubmission(selectionBarCode);
					//alert(selectionBarCode);
					loader.hide();
					return false;


			}else{

				// selectionBarCode = $('.data-list-option ').attr('data-code')
				var item_name = $('#item_name').val();

				$('#item_name').val('');
				//alert(item_name);

				$.getJSON('/item/findbyname/'+item_name,function(data){

					console.log(data);

					selectionBarCode = data;

					

				});

				handleFormSubmission(selectionBarCode);

				$('#item_name').focus();

				return false;

			//	selectionBarCode = $('.data-list-option ').selected();
				//alert(selectionBarCode);
				
			}
		


		}); // end form-submit

		function handleFormSubmission(code){

			//retrieve the json object
			$.getJSON('/sample/' + code,function(data){

				// console.log(data);

				//if item not found,return false
				if(data.found == 'false'){

					throwErrorMessage();
					clearInput();
					loader.hide();
					return false;
					
				}else if(data.response == '300'){

					throwProductionErrorMessage();
					clearInput();
					loader.hide();
					return false;
				}

				if(data.length != 0 ){

					setTimeout(retrieveCartItems(), "function(){ $('#loader').hide(); };",1000);
					// setTimeout()
					return true;	
				}
				
					throwErrorMessage();
					clearInput();
					return false;
			}); //end getJSON


		}

		

	//handle input selection
	//
	var tbBarcodeBlock = $('#tbBarcode');

	var tbItemNameBlock = $('#tbItemName');

	$('#selectInputType').on('change',function(){

		selection = $(this).val();

		switch(selection){

			case 'inputBarcode' : 

				tbBarcodeBlock.show();
				tbItemNameBlock.hide();

			break;

			case 'inputItemName'  :

				tbItemNameBlock.css("display","block");
				tbBarcodeBlock.hide();

				handleItemAutoSuggest();
				clearInput();

			break;


		}

	}); //select onchange

	// $('#item_name').on('change',function(data){

	// 	//alert($(this).val());
	// 	var value = $(this).val();
	// //	 var bcode  = $("#item-list").text();
	// 	//var category = $(this).find('option[value=' + cat_id + ']').text();
	// 	//var bcode = $('datalist#item-list').find('<option value='+value +'').attr('data-code');
		

	// 	alert(bcode);

	// });
	// 
	
	function showPasswordModal(){

		 $.fn.SimpleModal({
		               
		                title:    "<i class='icon icon-lock'></i> Super Admin Password Required",
			            contents: "Please enter the super admin's password : <input id='txtPass' autofocus='autofocus' type='password'/><hr/><button id='btnProceed' type='button' class='btn btn-primary'>Proceed</button><span id='feedback'></span>"
			      }).showModal();

			  $('#btnProceed').click(function(e){
			      		e.preventDefault();

			      		inputPass = $('#txtPass').val();
			      		$(this).attr('disabled','disabled');
			      		$(this).text('Checking password...');

			      		checkPassword(inputPass);
		      		
			      	
			      });
	}


	function handleItemAutoSuggest(){

		$.getJSON('/cart/items/find/all',function(data){

					console.log(data);

					$('datalist#item-list').empty();

					$.each(data,function(key,value){

						$('datalist#item-list').append('<option class="data-list-option" data-code="'+value.barcode+'" value="'+value.name+'">');
						// $('ul.populated_items').append('<a><li>'+ value.name +'</li></a>');


					});

				});
	} //function autosuggest
	

	//end input selection	
	


	// handle payment process

	$('form#payment').submit(function(e){

		//show some loading bar here lol


		e.preventDefault();

		var cash = $('input[name="cash"]').val();

		if(cash < total){

			alert('Not enough cash ! Amount to be paid is Php' + total + '.00.');
			return false;
		}

		var reqUrl = $(this).attr('action');
		// alert(url);
		var qty =  getQty();
		// var change = total  - 

		var method = $(this).attr('method');

		total = $('.total').text();

		// alert(qty);

		//set the qty on the hidden input field
		$('input[name="qty"]').val(qty);
		$('input[name="amount"]').val(total);
		$('input[name="trans_id"]').val(trans_id);
		$('input[name="change"]').val(change);
		// $('input[name="vat"]').val(vat);
		// $('input[name="cash"]').val(cash);
		// alert(total);
		
		var postData = $(this).serialize();
		console.log(postData);


		$.ajax({

	 		url : reqUrl,
	 		type: 'GET',
	 		data : postData,

	 		success : function(data){

	 			console.log(data);
	 			
	 			setTimeout("window.location.href='/sales/', function(){ $('#loader').hide(); };",500);
	 			alert('Order complete.Printing receipt.');
	 			window.open('/test/' + trans_id);
	 			

			},
			error : function(e){

				console.log('Error' + e.status +': ' + e.statusText);
			}

	

		}); /* end ajax request */





	});


	//calculate change

	$('input[name="cash"]').keyup(function(){

		var cash = $(this).val();
		// var amount = $('input[name="cash"]').val();
		var total = $('.total').text();

		console.log(total);

		$('input[name="cash"]').val($(this).val());

		// alert(cash);

		change = cash - total;
		//append it to the dom 
		// if(cash < total ){

		// 	$('input[type="submit"]').
		// }

		$('span#change').html("Change : Php " + change + ".00");
		$('span#amount').html("Cash : Php " + cash + ".00");

		//append the values inside the form
		
	});

	

	function getTransId(){

		return  $('span#trans_id strong').attr('data-value');
	}

	function getQty(){

		return $('input[id="qty"]').val();
	}


	function retrieveCartItems(){
		// loader.html('Retrieving Items');
		// loader.show();

		var items = $.getJSON('/cart/items/',function(data){

			tr = '<tr>';
			

			$.each(data,function(key,val){

				console.log(data);

				total += val.total;

				displayOutput(val);
				append(total);
				displayPaymentDetails();
				clearInput();
			});

			

			// append(total);

		});

		// setTimeout(loader.hide(),3000);
		

		
	}


	function displayOutput(val,qty){

		tr += 	'<td id="tdBarcode" data-value="'+val.barcode+'">' + val.barcode + 	'</td>';
		tr += 	'<td>' + val.item_name+ 	'</td>';
		tr += 	'<td id="tdPrice" data-value="'+val.price+'"> Php ' + val.price +'.00'+ 	'</td>';
		// tr += '<td>' + '<input id="qty" type="number" onmouseleave="hehe()">' + '</td>';ss
		tr += 	'<td><input id="qty" class="span1" type="number" name="tdQty" value="' + val.qty + '"></td>';
		// tr += 	'<td>' + val.qty + '</td>';
		tr += 	'<td><button data-barcode="'+ val.barcode +'" id="removeItem">x</button></td>';
		tr += 	'</tr>';	


	}

	function checkPassword(password){
		var receipt_no = getTransactionCode();

                    $.ajax({

                    url : '/auth/password/check',
                    type: 'GET',
                    data : { admin_password : password } ,

                    success : function(data){

                        // $('.loading').html('');
                        console.log(data);

                        if(data.response == 300){
							console.log("error");
					    	$('#btnProceed').removeAttr('disabled');
					    	$('#btnProceed').text('Proceed');
					    	$('span#feedback').html('<span style="color:red">Invalid password!</span>');
					    	$('#txtPass').val('');
					    	$('#txtPass').attr('required','required');
					    	$('#txtPass').focus();

                        }else if(data.response == 200){

                        	

                        	console.log("success");

                        	 $.fn.SimpleModal().hide();

                        	$.getJSON('/sales/registrar/mode/returns/'+receipt_no+'/void',function(data){

								console.log(data);
								//alert("Transaction has been voided. Reloading page");
								// window.location.href='/sales/registrar//';
								

							});
                        	// window.location.href ='/system/logs';
                        	
                        	// alert(action);
                        	
                        	processVoid();
                        }

                    },
                    error : function(e){

                        console.log('Error' + e.status +': ' + e.statusText);
                    }

            

                }); /* end ajax request */

                   
        }//end check password function

    function processVoid(){

    	var trans_id = getTransId();

				$.ajax({

			 		url : '/sales/registrar/void/',
			 		type: 'GET',
			 		data : { trans_id : trans_id },
			 		
			 		success : function(data){

			 			console.log(data);
			 			$('span#change').html("");
						$('span#amount').html("");
						$('.total').html("");
						total = 0;
						$('strong#trans_id').html(data);

			 			// setTimeout("window.location.href='/sales/', function(){ $('#loader').hide(); };",500);
			 			
					},
					error : function(e){

						console.log('Error' + e.status +': ' + e.statusText);
					}

			

				}); /* end ajax request */
    }

	
	function append(total){

		var due = 0;

		//append it to the table
		// tr.clear();
		tableBody.html(tr);

		$('input[name="tdQty"]').on('change',function(){
			var new_qty = $(this).val();
			var price = $('td#tdPrice').attr('data-value');
			var code = $('td#tdBarcode').attr('data-value');
			$('input[name="cash"]').val('');
			$('span#change').html('');
			$('span#amount').html('');
			// $('input[name="cash"]').val('');
			//update the qty on the temp cart table
				$.ajax({

				 		url : '/sales/registrar/cart/items/quantity/update',
				 		type: 'GET',

				 		data : { qty : new_qty,barcode : code },

				 		success : function(data){
				 			// updateCart();
				 			console.log(data);
				 			// setTimeout("window.location.href='/sales/', function(){ $('#loader').hide(); };",200);
				 			// retrieveCartItems();
				 			// updateCart(data);
				 			// console.log(data);
				 			
							// $.each(data,function(key,val){

							// 	// console.log(data);
							// 	total += val.total;
								
							// });

						
				 			$('.total').html(price * new_qty);
				 			// console.log(total);

						},
						error : function(e){

				 			// console.log("pota");
							// retrieveCartItems();
							console.log('Error' + e.status +': ' + e.statusText);
						}


					}); /* end ajax request */




		});
		
		// var vat = total * .12;
		// var subtotal = total - vat ;
		
		$('.total').html('<strong> ' +  Math.round( (total * 100 )/ 100 ).toFixed(2)  + '</strong></p>');
		// $('#vat').html('VAT (12 %) :  Php ' + parseFloat(Math.round(vat * 100) / 100).toFixed(2)  + '</strong></p>');
		// $('#subtotal').html(' Subtotal : Php ' + parseFloat(Math.round(subtotal * 100) / 100).toFixed(2)  + '</p>');
		displayPaymentDetails();

		$('button#removeItem').click(function(){

			$('input[name="cash"]').val('');

					total = 0;
					var barcode = $(this).attr('data-barcode');
					$(this).parent().parent().remove();


					///remove item on the temp cart
					$.ajax({

				 		url : '/cart/items/remove',
				 		type: 'GET',

				 		data : { barcode : barcode },

				 		success : function(data){
				 			// updateCart();
				 			console.log(data);
				 			// setTimeout("window.location.href='/sales/', function(){ $('#loader').hide(); };",200);
				 			// retrieveCartItems();
				 			// updateCart(data);
				 			console.log(data);
				 			
							$.each(data,function(key,val){

								// console.log(data);
								total += val.total;
								
							});

						
				 			$('.total').html(total);
				 			displayPaymentDetails();
				 			console.log(total);

						},
						error : function(e){

				 			// console.log("pota");
							// retrieveCartItems();
							console.log('Error' + e.status +': ' + e.statusText);
						}


					}); /* end ajax request */
					
					

					
				});



		
	}

	function displayPaymentDetails(){

		var vat = total * .12;
		var subtotal = total - vat ;
		$('#vat').html('VAT (12 %) :  Php ' + parseFloat(Math.round(vat * 100) / 100).toFixed(2)  + '</strong></p>');
		$('#subtotal').html(' Subtotal : Php ' + parseFloat(Math.round(subtotal * 100) / 100).toFixed(2)  + '</p>');

	}

	function throwErrorMessage(){

				flash.show();
				flash.addClass('alert alert-danger');
				flash.html("Item not found.");
				flash.delay(4000).slideUp();
				
	}

	function throwProductionErrorMessage(){

				flash.show();
				flash.addClass('alert alert-danger');
				flash.html("Item was not set for production or out of stocks. .");
				flash.delay(4000).slideUp();
				
	}

	function clearInput(){

		$('form#regForm input[name="code"]').val('');
	}

	function getTransactionCode(){

		return $("#trans_id").val();
	}


});

	//handle if the payment key is presseds
	
