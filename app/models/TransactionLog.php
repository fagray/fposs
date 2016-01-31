<?php

class TransactionLog extends \Eloquent {

	protected $table = "fposs_transaction_logs";
	protected $fillable = ['invoice_num','action','item_code','item_desc','cashier'];

	public static function recordLog($invoice,$action,$item_code,$item_desc,$cashier){


		$log = new TransactionLog();
		$log->invoice_num = $invoice;
		$log->action = $action;
		$log->item_code = $item_code;
		$log->item_desc = $item_desc;
		$log->cashier = $cashier;
		$log->save();

	}
}