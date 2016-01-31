@extends('layouts.master')

@section('content')

	<h2>Item Barcode</h2>
	{{ $code }}
	
	{{ DNS1D::getBarcodeHTML($code, "EAN13",2,60); }} 

@stop