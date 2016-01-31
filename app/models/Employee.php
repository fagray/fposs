<?php

class Employee extends \Eloquent {

	protected $table = "fposs_employees";
	protected $fillable = ['fname','lname','address','email','contact_no','role'];
}