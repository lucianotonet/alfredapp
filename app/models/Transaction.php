<?php

class Transaction extends Eloquent {

	protected $table = 'transactions';
	// Add your validation rules here
	public static $rules = [];
	public $timestamps = true;
	protected $fillable = array(
	                            'recurring_type', 
	                            'recurring_times', 
	                            'recurring_cycle', 	                            
	                            'recurring_transaction_id', 	
	                            'amount',
	                            'date',

	                            'type',
	                            'description',
	                            'user_id', 
	                            'done'                  
	                        );
	protected $visible = array(
	                           'recurring_type', 
	                           'recurring_times', 
	                           'recurring_cycle', 	                           	                          
	                           'recurring_transaction_id',
	                           'amount',
	                           'date'	                           
	                        );

	public function getCategory()
	{
		return $this->belongsTo('category');
	}

	public function getMasterTransaction()
	{
		return $this->belongsTo('Transaction', 'recurring_transaction_id');
	}

	public function getRecurringTransactions()
	{
		if( $this->recurring_transaction_id >= 1 ){
			return $this->hasMany('Transaction', 'recurring_transaction_id', 'recurring_transaction_id');			
		}else{
			return $this->hasMany('Transaction', 'recurring_transaction_id', 'id');			
		}
			
	}


	public function isOverdue()
	{
		if ( $this->done != 1  &&  $this->date < date('Y-m-d') )
		{
			return true;
		}			
		return false;
	}


	public static function boot()
   {
		parent::boot();

		// Setup event bindings...		
		Transaction::saving(function($transaction)
	    {
	    	$user_id = Auth::id();
	    	// $balance = Balance::where('user_id', $user_id)->orderBy('id','DESC')->first();

	    	// if( $balance and $transaction->done == 1 ){	    		
	    	// 	$balance->amount = ($balance->amount + $transaction->amount);	    		
	    	// 	$balance->save();
	    	// }

	        $transaction->user_id = $user_id;
			return $transaction;
	    });
	}

}