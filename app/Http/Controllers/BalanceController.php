<?php 
use Carbon\Carbon as Carbon;
class BalanceController extends BaseController {

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        $balance = Balance::orderBy('id', 'DESC')->where( 'user_id', Auth::id() )->first();
     
        // SALDO DE HOJE
        // $hoje = Carbon::now();      
        // $balanceToday = DB::table('transactions')
        //                             ->where( 'created_at', '>=', $hoje->startOfDay() ) // Desde a meia noite
        //                             ->where( 'created_at', '<=', date('Y-m-d H:i:s') ) // Até agora
        //                             ->where( 'user_id', Auth::id() )
        //                             ->where( 'done', 1 )
        //                             //->get();
        //                             ->sum( 'amount' );
    

        // // BALANCE
        // $lastBalance = Balance::orderBy('id', 'DESC')->where( 'user_id', Auth::id() )->first();
        // if( !$lastBalance ){ 
        //     // PRIMEIRO BALANCO
        //     $firstBalance = DB::table('transactions')                                    
        //                             ->where( 'created_at', '<', $hoje->startOfDay() ) // Até agora
        //                             ->where( 'user_id', Auth::id() )
        //                             ->where( 'done', 1 )
        //                             //->get();
        //                             ->sum( 'amount' );

        //     $lastBalance = Balance::create(['amount'=>$firstBalance]) ;
        // }

        // // BALANCE é DE HOJE?
        // if ( date('Y-m-d') == date("Y-m-d", strtotime($lastBalance->crated_at) ) ) {
        //     //atualiza
        //     $lastBalance->amount = ($balanceToday + $lastBalance->amount);
        //     $balance = $lastBalance;
        // }else{
        //     //Cria novo
        //     $newBalance = new Balance;
        //     $newBalance->amount = ($balanceToday + $lastBalance->amount);
        //     $balance = $newBalance;
        // }

        // echo "Saldo anterior: " . $lastBalance->amount;
        // echo "<br />";

        // echo "Hoje: " . $balanceToday;       

        // echo "<br />";

        // echo "Total: " . $balance->amount;
        
        return Response::json( $balance );
        exit;




        // SE NÃO EXISTE REGISTRO DE SALDO, CRIA NOVO
        if( !$balance ){
            $balance = new Balance;
            // Calcula Valor inicial do novo saldo
            $amount = DB::table('transactions')->where( 'created_at', '<', $hoje->startOfDay() )->where('user_id', Auth::id() )->where('done', 1 )->sum('amount');
            $balance->amount = $amount;
            $balance->save();
        }
        
                
        $lastBalanceDate = Carbon::createFromFormat('Y-m-d H:i:s', $balance->created_at );


        // SE O SALDO NÂO É DE HOJE, CRIA NOVO
        if(  !$lastBalanceDate->isToday() ){
            $lastBalance = $balance->amount;
            $balance     = new Balance;
            $balance->amount = $lastBalance;
            $balance->save();
        
        }
        
        // ATUALIZA O ÚLTIMO BALANCE
        $amount      = DB::table('transactions')
                                    ->where( 'created_at', '>=', $hoje->startOfDay() ) // Desde a meia noite
                                    ->where( 'created_at', '<=', date('Y-m-d H:i:s') ) // Até agora
                                    ->where( 'user_id', Auth::id() )
                                    ->where( 'done', 1 )
                                    //->get();
                                    ->sum( 'amount' );
        
        // $transactionsToday = Transaction::where( 'created_at', '>=', $hoje->startOfDay() )
        //                              ->where( 'created_at', '<=', date('Y-m-d H:i:s') )
        //                              ->where( 'user_id', Auth::id() )
        //                              ->where( 'done', 1 )
        //                              ->get();


        // Soma valor do dia com o saldo anterior
        $amount = ($amount + $balance->amount);

        // return Response::json( $amount  );
        // exit;

        // Atualiza o saldo no banco
        $balance->amount = $amount;
        $balance->save();

        return $balance->amount;
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return "creating a balance?";
    }

    /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
    public function store()
    {

    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {

    }

    /**
    * Show the form for editing the specified resource.
    *    
    * @return Response
    */
    public function edit()
    {
        $balance = Balance::orderBy('id', 'desc')->first();
        if( !$balance ){
            $balance = new Balance;
            $balance->amount = '0';
        }
        $balance->save();

        return View::make('transactions.panels.balance')->with('balance');
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function update($id)
    {

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {

    }
  
}

?>