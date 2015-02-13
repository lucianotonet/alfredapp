<?php
use Carbon\Carbon as Carbon;
class Balance extends Eloquent {

	protected $table = 'balance';
	public $timestamps = true;
	protected $fillable = array('amount','user_id');

	public function user()
	{
		return $this->belongsTo('User');
	}	

	
	public static function boot()
   {
		parent::boot();		
       
		// Setup event bindings...
		Balance::saving(function($balance)
		{           
			$balance->user_id = Auth::id();
			return $balance;
		});


		$user_id = Auth::id();
		$balance = Balance::where('user_id', $user_id)->orderBy('id','DESC')->first();

	 
		if( count( $balance ) > 0 ){
			$date = Carbon::createFromFormat('Y-m-d H:i:s', $balance->created_at );
			if( $date->isToday() ) {
				// Deixa como está.
			}else{
				// Cria o pro=imeiro registro
				$todayAmount = DB::table('transactions')                                    
									->where( 'created_at', '>', date("Y-m-d")." 00:00:00" ) 
                                    ->where( 'created_at', '<=', date('Y-m-d H:i:s') ) // Até agora
                                    ->where( 'user_id', Auth::id() )
                                    ->where( 'done', 1 )
                                    //->get();
                                    ->sum( 'amount' );

				$newAmount = $balance->amount + $todayAmount;
				// Cria um novo pro dia de hoje
				$balance = Balance::create(['amount'=>$newAmount, 'user_id'=>$user_id]);
			}
		}else{
			// Cria o pro=imeiro registro
			$amount = DB::table('transactions')                                    
                                    ->where( 'created_at', '<=', date('Y-m-d H:i:s') ) // Até agora
                                    ->where( 'user_id', Auth::id() )
                                    ->where( 'done', 1 )
                                    //->get();
                                    ->sum( 'amount' );
			$balance = Balance::create(['amount'=>$amount, 'user_id'=>$user_id]);
		}
	}

}