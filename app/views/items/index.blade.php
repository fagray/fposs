@extends('layouts.master')

@section('external-styles')

    <style type="text/css">
        div .controls {

            /*margin-left: 20px;*/
            cursor: pointer;
            /*list-style-type: square;*/
        }

        #items-container .mix {

            display: none;
        } 
    </style>
    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/dataTables.tableTools.css">
    <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.css">
@stop



@section('content')

    <h2 class="head-1 ">Items Module</h2><br/>
    <a class="button" data-toggle="collapse" data-target="#demo">
        <i class="icon icon-plus"></i> Options
    </a>

    <div id="demo" class="collapse card">

        <div class="subnavbar">

                  <div style="background:fff;" class="subnavbar-inner">
                    <div class="container payment">
                      <ul class="mainnav">
                        @if(Auth::user()->role == '2' || Auth::user()->role == '3')

                            <li>
                                <a class="payment-key" href="/items/create/">
                                    <i class="icon-plus"></i>
                                    <span>Add New</span> 
                                </a> 
                            </li>
                             <li>
                                <a class="payment-key" target="_blank" href="/items/productions/"><i class="icon-cog"></i>
                                    <span>Production</span> 
                                </a> 
                            </li>
                            <li>
                                <a class="payment-key" target="_blank" href="/store/items/sales/">
                                    <i class="icon-money"></i>
                                    <span>Sales</span> 
                                </a> 
                            </li>
                            <li>
                                <a class="payment-key" target="_blank" href="/items/barcodes/" ><i class="icon-barcode"></i>
                                    <span>Barcode Labels</span> 
                                </a> 
                            </li>

                             <li>
                                <a class="payment-key" target="_blank" href="/categories" ><i class="icon-barcode"></i>
                                    <span>Categories</span> 
                                </a> 
                            </li>


                        @elseif(Auth::user()->role == '1')

                            <li>
                                <a class="payment-key" target="_blank" href="/store/items/sales/">
                                    <i class="icon-money"></i>
                                    <span>Sales</span> 
                                </a> 
                            </li>
                            <li>
                                <a class="payment-key" target="_blank" href="/items/barcodes/" ><i class="icon-barcode"></i>
                                    <span>Barcode Labels</span> 
                                </a> 
                            </li>

                        @endif
                        
                       
                        
                        </ul>
                        </li>
                   
                      </ul>
                    </div>
                    <!-- /container --> 
                  </div>
                  <!-- /subnavbar-inner --> 
            </div>    


    </div><!-- /actions -->


    <div class="widget widget-table ">

            <!-- Nav tabs -->
        <ul class="nav nav-tabs">
          
          <li><a href="#grid" data-toggle="tab">Grid View</a></li>
          <li  class="active" ><a href="#items" data-toggle="tab"> Master List</a></li>
        
        </ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="items">
        <div class="widget-content">
            <table id="item-data"  class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Barcode </th>
                    <th>Item Name </th>
                    <th>Price</th>
                    <th>Category</th>
                    <th class="td-actions">Actions </th>
                </tr>
                </thead>
                <tbody>

                    @foreach($items as $item)
                        <tr>
                            <td> {{ $item->barcode }} </td>
                            <td> {{ link_to('/items/'.$item->id,$item->name) }} </td>
                            <td>Php  {{ number_format($item->price,2) }} </td>
                            <td> {{ Category::find($item->category_id)->cat_name }}  </td>
                            <td class="td-actions">
                               <div class="btn-group">
                                      <button data-toggle="dropdown" class="btn dropdown-toggle">Actions <span class="caret"></span></button>
                                      <ul class="dropdown-menu">
                                        
                                       
                                        <li>
                                            <a href="/items/{{$item->id }}/edit"><i class="icon icon-pencil"></i>  
                                                Edit Data
                                            </a>
                                        </li>

                                      
                                      </ul>
                                </div>
                               
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <!-- /widget-content -->

  </div><!-- /items content -->
    <div class="tab-pane  " id="grid">
        <div class="row">
            <div class="span3">

                <p><strong>Filter Item By Category</strong></p>
                <div class="controls">
                    <div class="list-group">
                      <a href="#" class="list-group-item ">
                        <div class="filter" data-filter="all">Show All</div>
                      </a>
                       @foreach($categories as $category)
                            <div class="filter active" data-filter="{{ $category->cat_name }}">
                                <a href="#" class="list-group-item">{{ $category->cat_name }}</a>
                            </div>
                        @endforeach
                      
                      
                    </div><!-- /list-group -->
                   
                </div><!-- /controls -->
            </div><!-- /span3 -->
       
                <div  id="items-container">
                    @foreach($items as $item)
                        <div class="mix {{ Category::find($item->category_id)->cat_name }} span3">
                            <div class="card ">
                              <img style="margin-left: 90px;" height="120" width="80" src="/img/cupcake.jpg"  alt="{{ $item->name }}">
                              <div class="card-block" style="min-height: 120px;">
                                <p style="font-size: 15px;" class="card-title">{{ $item->name }} </p>

                              <div class="card-text">{{ $item->description }}</div>
                              </div>
                               <div class="price">
                                    <p  align="center">
                                    Php {{ number_format($item->price,2) }}/ order </p>
                                </div>
                            </div><!-- /card -->
                        </div><!-- /span4 -->
                    @endforeach
                    

                </div><!-- /items-container -->

            </div><!-- /row -->
        
    </div><!-- /end of #grid view -->
  

</div>
        
        
    </div>
    

@stop


@section('external-scripts')
    <script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/js/dataTables.tableTools.js"></script>
    <script type="text/javascript" src="/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="/js/jquery.mixitup.min.js"></script>
    <script type="text/javascript">
  
        $(document).ready(function() {

             $(function(){
                $('#items-container').mixitup();
              });

        //data-tables
        $('#item-data').DataTable( {
            dom: 'T<"clear">lfrtip',
            tableTools: {

                "sSwfPath": "/swf/copy_csv_xls_pdf.swf"
            }
            }); //end data-tables

      


        });
    </script>
@stop