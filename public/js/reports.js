	
	//module containers 
	var salesContainer = $('#bySales');
	var itemsContainer = $('#byItems');
	var graphicalContainer = $('#graphicalFormatContainer');
	var inventoryContainer = $('#byInventory');

	//handle the user selection
	var selection = '';

	//onload, hide the reports panel first
	$('#reportsPanel').hide();

	//handle the report format 
	$('a.report-format').click(function(e){

		e.preventDefault();

		var format = $(this).attr('data-format');

		if(format == 'detailed'){
			
			$('#reportsPanel').hide();
			$('#reportsPanel').show();

		}else if(format == 'graphical'){
			$('#reportsPanel').show();
			showContainer(graphicalContainer);
			alert('Not yet available');
		}
	});

	$('.btn').click(function(){

		selection = $(this).attr('data-module');

		switch(selection){

			case 'items' : 
				
				showContainer(itemsContainer);

			break;

			case 'inventory' : 
				
				showContainer(inventoryContainer);
				handleInventoryReport();
			break;

			case 'sales' : 
				
				setDatePicker();
				showContainer(salesContainer);
				handleSalesReport();

			break;


			default : "Invalid selection";
			break;
		}
	});


	//show the specified container based on the module selected
	function showContainer(module){

		module.css("display","block");
		$('.module-containers').html(module);
		setDatePicker();
	}

	//clear the current container

	function setDatePicker(){

		 $('#tbFrom').datetimepicker({
            format:'Y-m-d',
            timepicker:false,
            mask:true,
        });

        $('#tbTo').datetimepicker({
            format:'Y-m-d',
            timepicker:false,
            mask:true,
        });
	}

	//sales report selection
	function handleSalesReport(){

		//generate sales
            $('#formGenerateSalesReport').submit(function(e){

                e.preventDefault();


                var postData = $(this).serialize();
                $.ajax({

                     type : 'GET',
                     url : '/reports/sales/generate/range',
                   
                    data : postData,

                	success : function(data){

                	
                	appendSalesReportToTable(data);
                    console.log(data);

                }

                });
                
                return false;


            }); 

	}//sales report handler

	//SALES  - append result to table
	function appendSalesReportToTable(data){

		var tr = '<tr>';
		if(data.length < 1){

			tr += '<td colspan="4" style="background:red;color:#fff;">No results found.</td>';

		}else{

			$.each(data,function(key,val){

				tr += '<td><a target="_blank" href="/store/items/sales/'+val.trans_id+'/">'+val.trans_id +'</td>';
				tr += '<td>'+val.created_at +'</td>';
				
				tr += '<td>Php '+val.amount +'</td>';
				tr += '<td>'+val.cashier +'</td>';
				tr += '<tr/>';

			});

		}
		

		$('tbody#tbodySales').html(tr);

	}

	//inventory selection 
	function handleInventoryReport(){

			//generate inventory reports
            $('.formGenerateInventoryReports').submit(function(e){

                e.preventDefault();



                var postData = $(this).serialize();

	                $.ajax({

	                     type : 'GET',
	                     url : '/reports/inventory/generate/range',
	                   
	                    data : postData,

	                	success : function(data){

	                	
	                	appendInventoryReportToTable(data);
	                    console.log(data);

	                }

	                });
                
                return false;


            }); 


	}

	function appendInventoryReportToTable(data){

		var stock_on_hand = 0;
		var shipment_unit = '';
		var tr = '<tr>';

		if(data.length < 1){

			tr += '<td colspan="4" style="background:red;color:#fff;">No results found.</td>';

		}else{

			$.each(data,function(key,val){
				shipment_unit = val.shipment_unit;
				stock_on_hand += val.qty;

				tr += '<td><a target="_blank" href="/store/items/sales/'+val.trans_id+'/">'+val.name +'</td>';
				tr += '<td>'+val.created_at +'</td>';
				tr += '<td>'+val.qty + ' ' + val.shipment_unit +'</td>';
				
				tr += '<td>'+val.received_by +'</td>';
				if(val.type == "1"){

						tr += '<td>Delivered</td>';
				}else{

					tr += '<td>Manual editing of stocks</td>';
				}
				
				tr += '<tr/>';

			});


		}
		

		
		$('.stockOnHandContainer').html('<strong>Total Stocks Received : ' + stock_on_hand  + ' ' + shipment_unit +'</strong>');
		$('tbody#tbodyInventory').html(tr);


	}
	