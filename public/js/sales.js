// script for sales module
//@Author : RSantillan



$(document).ready(function(){

	// var tableBody = $('table#tblYSale tbody');
	var tabText = "";

	var saleType;
	var total;

	$('.search-result-container').hide();

	$('a#yes').click(function(){

		saleType = 'yesterday';

		tabText = "yesterday";

		$('.loading').html('Retrieving data...');

		ajaxRequest(saleType);


	});

	$('a#month').click(function(){

		saleType = 'thismonth';
		console.log(saleType);

		tabText = "thismonth";

		$('.loading').html('Retrieving data...');

		ajaxRequest(saleType);



	});

	$('a#week').click(function(){

		saleType = 'thisweek';
		console.log(saleType);

		tabText = "thisweek";

		$('.loading').html('Retrieving data...');

		ajaxRequest(saleType);



	});


	//handle the search invoice function
	$('#formSearchInvoice').submit(function(e){

		e.preventDefault();



		var invoiceNumber = $('input#tbInvoiceNum').val();

		$.ajax({

	 		url : '/sales/search/',
	 		type: 'GET',
	 		data : { inv_num : invoiceNumber },
	 		

	 		success : function(data){

				// $('.loading').html('');
				$('.search-result-container').show(function(){

					$(this).delay().slideDown(5000);
				});

	 			console.log(data);
	 			clearTableBody();
	 			//append the data to the DOM
	 			appendSalesResultToContainer(data,invoiceNumber);
	 			// setTimeout(appendToContainer(data),"function(){ $('.loading').html(''); };",5500);
	 			
			},
			error : function(e){

				console.log('Error' + e.status +': ' + e.statusText);
			}

	

		}); /* end ajax request */

		return false;

	});

	function ajaxRequest(type){

		$.ajax({

	 		url : '/sales/retrieve',
	 		type: 'GET',
	 		data : { type : saleType },
	 		

	 		success : function(data){

				// $('.loading').html('');
	 			console.log(data);
	 			//append the data to the DOM
	 			// appendToContainer(data);

	 			setTimeout(appendToContainer(data),"function(){ $('.loading').html(''); };",5500);
	 			
			},
			error : function(e){

				console.log('Error' + e.status +': ' + e.statusText);
			}

	

		}); /* end ajax request */


	}

	function appendToContainer(data){

		var tr = '<tr>';

		//append the total sales
		
		

		$.each(data, function(key,val){

				tr += 	'<td><a href="/store/items/sales/'+val.trans_id+'">' + val.trans_id + 	'</a></td>';
				tr += 	'<td> Php ' + val.amount + 	'</td>';
				tr += 	'<td>' + val.cashier + 	'</td>';
				tr += 	'<td>' + val.created_at + 	'</td>';
				tr += 	'</tr>';


				
		});

		switch(tabText){

			case 'yesterday' : 

				
				$('table#tblYSale tbody').html(tr)
				$('#yesterdayTotal').html('Php ' + parseFloat(Math.round(data.total * 100) / 100).toFixed(2));

			break;

			case 'thismonth' : 

				$('table#tblMSale tbody').html(tr);
				$('#monthTotal').html('Php ' + parseFloat(Math.round(data.total * 100) / 100).toFixed(2));

			break;

			case 'thisweek' : 

				$('table#tblWSale tbody').html(tr);
				$('#weekTotal').html('Php ' + parseFloat(Math.round(data.total * 100) / 100).toFixed(2));

			break;
			
		}
	}

	function appendSalesResultToContainer(data,invoiceNumber){

		var total = 0;
		

		$.each(data,function(key,val){

			total += val.qty * val.price;
			$('tbody.result-body').append('<tr><td>'+ val.barcode  +'</td><td>'+ val.name +
			'</td><td>'+val.price+'</td><td>'+val.qty+'</td></tr>');

			$('p#total').html('Total Amount Due : Php <strong>' + total +'</strong> | Cash Tendered : '+ val.cash 
		+ ' | Change : ' + val.change + '| Cashier : ' + val.cashier);

			$('#iv').html(invoiceNumber + ' |  Transaction Timestamp : ' + val.created_at + 
				'<span class="pull-right"><a title="Close" class="btn btn-small" href="#">x</a></span>' );
		});


		$('a.btn-small').click(function(){

			
				$('.search-result-container').delay().slideUp(800,function(){

					$(this).hide();
				});
			
		});

		
	}

	function clearTableBody(){

		$('tbody.result-body').html('');
	}


});