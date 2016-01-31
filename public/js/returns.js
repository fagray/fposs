$(document).ready(function(){

	var tr;
	var vat = 0;

	var tableBody = $('table#return-items tbody');
	var total = 0;
	var tbQty = $('input[name="tdQty"]');
	var subtotal;
	var receipt_no  = 0;
	var amountDue = 0;


//handle register selection
	$('select#selectModeType').on('change',function(){

		var selection = $(this).val();

		if(selection == 'modeReturns'){

			window.location.href='/sales/registrar/mode/returns';

		}else if(selection == 'modeSales'){

			window.location.href='/sales/registrar/';

		}
	});


	//handle the form submission for returns
	$('#returnForm').submit(function(e){

		e.preventDefault();

		 receipt_no = $('#receipt_no').val();


		$('#receiptContainer').html('Receipt # ' + receipt_no + ' - Order Details ');



		$.getJSON('/sales/registrar/mode/returns/'+receipt_no,function(data){

			tr = '<tr>';
			console.log(data);

				populate(data);
			
			$('.qty').on('change',function(){

				

				var qty = $(this).val();
				var item_id = $(this).attr('data-item-id');
				//alert(item_id);

				//update the qty on the database
				$.getJSON('/sales/registrar/mode/returns/items/'+item_id+'/receipt/'+receipt_no+'/'+qty,function(data){
					subtotal = 0;

					$.each(data,function(key,val){

						subtotal += val.qty * val.price;

					});

				
				//	total = subtotal;

					// alert(subtotal);

					displayPaymentDetails(subtotal);
					//console.log(data);

					//populate(data);
					return false;

				});
				
			});

			

			
			
		});	

		

	});

	//handle payment input
	
	//total = subtotal + vat;

	$('form#payment').on('submit',function(e){

		e.preventDefault();

		//alert(total);
		//
		var total = $('.total').text();

		var cash = $('input[name="cash"]').val();
		// alert(cash);
		$('input[name="trans_id"]').val(receipt_no);
		$('input[name="cash"]').val(cash);
		$('input[name="amount"]').val(total);
		$('input[name="vat"]').val(vat);

		// alert(cash);

		if( cash < total ){

			alert('Not enough cash.');
			//cash = $('input[name="cash"]').val();
			// return false;

		}else{

			var postData = $(this).serialize();

				$.ajax({

			 		url : '/sales/registrar/mode/returns/update',
			 		type: 'GET',
			 		data : postData,

			 		success : function(data){

			 			console.log(data);
			 			
			 		//	setTimeout("window.location.href='/sales/', function(){ $('#loader').hide(); };",500);
			 			if(confirm('Transaction has been updated.Do you want to re-print the receipt ? ')){

			 					window.open('/test/' + receipt_no);
			 			}


			 		
			 			

					},
					error : function(e){

						console.log('Error' + e.status +': ' + e.statusText);
					}

			

				}); /* end ajax request */


		}

		


	});


	function populate(data){
		subtotal = 0;

		$.each(data,function(key,val){


				subtotal += val.price * val.qty;

				displayPurchasedItems(val);
				displayCustomerDetails(val);
				displayPaymentDetails(subtotal);
				tableBody.html(tr);

				//$('#total').html(total);

				$('span#dateTime').html('<strong>'+val.created_at+'</strong>');
				$('input[name="cash"]').val(val.cash);

			});

		total = subtotal + vat;
		//$('input[name="amount"]').val(total);
		$('button.removeItem').click(function(){

			var item_id = $(this).attr('data-item-id');

			if(confirm("Are you sure you want to remove this item  ? ")){

				// $.getJSON('/sales/registrar/mode/returns/'+receipt_no+'/items/'+item_id,function(data){

				// 	console.log(data);

				// });
			}

		});
	}

	$('#returnVoidKey').click(function(){

		if(confirm("Are you sure you want to void the transaction ? ")){

			//show password popup here
			
			 $.fn.SimpleModal({
		               
		                title:    "<i class='icon icon-lock'></i> Super Admin Password Required",
			            contents: "Please enter the super admin's password : <input id='txtPass' autofocus='autofocus' type='password'/><hr/><button id='btnProceed' type='button' class='btn btn-primary'>Proceed</button><span id='feedback'></span>"
			      }).showModal();

			  $('#btnProceed').click(function(e){
			      		e.preventDefault();

			      		inputPass = $('#txtPass').val();
			      		$(this).attr('disabled','disabled');
			      		$(this).text('Checking password...');

			      		return checkPassword(inputPass);
		      		
			      	
			      });

			
			  return false;
		}

		
	});

	function checkPassword(password){

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

                        	$.getJSON('/sales/registrar/mode/returns/'+receipt_no+'/void',function(data){

								console.log(data);
								alert("Transaction has been voided. Reloading page");
								window.location.href='/sales/registrar/mode/returns/';
								

							});
                        	// window.location.href ='/system/logs';
                        	
                        	// alert(action);

                        }

                    },
                    error : function(e){

                        console.log('Error' + e.status +': ' + e.statusText);
                    }

            

                }); /* end ajax request */

                   
                }//end check password function

	function displayPurchasedItems(val){

		tr += 	'<td id="tdBarcode" data-value="'+val.barcode+'">' + val.barcode + 	'</td>';
		tr += 	'<td>' + val.name+ 	'</td>';
		tr += 	'<td id="tdPrice" data-value="'+val.price+'"> Php ' + val.price +'.00'+ 	'</td>';
		// tr += '<td>' + '<input id="qty" type="number" onmouseleave="hehe()">' + '</td>';ss
		tr += 	'<td><input data-item-id="'+val.item_id+'" data-price="'+val.price+'" class="span1 qty" type="number" name="tdQty" value="' + val.qty + '"></td>';
		// tr += 	'<td>' + val.qty + '</td>';
		tr += 	'<td><button data-item-id="'+ val.item_id +'" class="removeItem">x</button></td>';
		tr += 	'</tr>';		

		

		
	}

	function displayCustomerDetails(val){

		$('span#cust_name').html(val.fname +' ' + val.lname);
		$('span#mobile_container').html(val.contact_num);

	}

	function displayPaymentDetails(total){

		// alert(subtotal);
		vat = total * .12;
		subtotal = total - vat;
		
		
		
		$('p#subtotal').html('Subtotal : Php ' +  parseFloat(Math.round(subtotal * 100) / 100).toFixed(2));
		$('p#vat').html('VAT : Php ' + parseFloat(Math.round(vat * 100) / 100).toFixed(2));
		
		$('span.total').html(parseFloat(Math.round(total * 100) / 100).toFixed(2));
		
	}

	





});