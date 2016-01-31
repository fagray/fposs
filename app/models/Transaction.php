<?php

class Transaction extends \Eloquent {

	protected $table = "fposs_transactions";
	protected $fillable = ['trans_id','cashier','terminal_ip'];

	
}