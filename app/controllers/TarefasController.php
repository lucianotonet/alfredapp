<?php

use Faker\Factory as Faker;
use Carbon\Carbon as Carbon;

class TarefasController extends \BaseController {

	/**
	 * Display a listing of tarefas
	 *
	 * @return Response
	 */
	public function index()
	{
		

		// $tarefas 	   = new CreateTarefasTable;
		// $notificationsnotificationsnotificationsnotificationsnotifications = new CreateNotificationsTable;
		
		// $tarefas->down();
		// //$notifications->down();
		// //sleep(3);
		// $tarefas->up();
		// $notifications->up();

		// foreach ($tarefasBKP as $tarefa) {
		// 	Tarefa::create($tarefa->toArray());
		// }

		//exit;

      $tarefas = Tarefa::orderBy('start', 'DESC')->with('cliente', 'notifications')->get();

           
        $hoje    = date('Y-m-d');
        $ontem   = Carbon::create(date('Y'), date('m'), date('d'))->subDay();
        $amanha  = Carbon::create(date('Y'), date('m'), date('d'))->addDay();
        $proximo = Carbon::create(date('Y'), date('m'), date('d'))->addDay();//Igual amanhã?
        if( $proximo->isWeekend() ){
        	$proximo = new Carbon('next monday');        	
        }	
 
      	$tarefas->pendentes = Tarefa::where('start','<',$hoje )->where('done', 0)->orderBy('start', 'ASC')->with('cliente', 'conversas')->get();
 		$tarefas->hoje      = Tarefa::where('start','<',$amanha->startOfDay())->where('start','>',$ontem)->where('done', 0)->with('cliente', 'conversas')->get();

 		$tarefas->nextDay   = Tarefa::where('done', 0)
 									->where('start','>=',$amanha) 									
 									->where('start','<',$proximo->addDay()) 	
 									->orderBy('start', 'DESC')
 									->with('cliente', 'conversas')
 									->get();

 		$tarefas->proximas   = Tarefa::where('start','>=',$amanha)->orderBy('start', 'ASC')->where('done', 0)->with('cliente', 'conversas')->get();
 		$tarefas->concluidas = Tarefa::where('done', 1)->orderBy('updated_at', 'DESC')->with('cliente', 'conversas')->get();

      // $tarefas->nextDay   = $tarefas->each( function($tarefa){
      // 		if(  Carbon::is $tarefa->start  )
      // })

      if( Request::ajax() ){
         return $tarefas;
      }
      
      //return $tarefas;
	  
	  return View::make('tarefas.index', compact('tarefas'));
	
	}

	/**
	 * Show the form for creating a new tarefa
	 *
	 * @return Response
	 */
	public function create()
	{
      if( isset($_GET['conversa_id']) ){
         $conversa = Conversa::find($_GET['conversa_id']);
      }else{
         $conversa = "";
      }

      if( isset($_GET['cliente_id']) ){
         $cliente = Cliente::find($_GET['cliente_id']);
      }else{
         $cliente = "";
      }


		return View::make('tarefas.create', compact('conversa','cliente') );
	}

	/**
	 * Store a newly created tarefa in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
	   $validator = Validator::make($data = Input::all(), Tarefa::$rules, Tarefa::$messages);
        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['start'] = date( 'Y-m-d H:i:s', strtotime( $data['start'] ) );

        if( $tarefa = Tarefa::create($data) ){
	         
	         // ADICIONAR NOTIFICAÇÃO
	         if( !empty( $data['notification'] ) ){

	            $notificationDate = Carbon::createFromFormat('Y-m-d H:i:s', $data['start'])->subDays( $data['notification'] );	            

		         echo "<pre>";
		         print_r( $data );
		         echo "</pre>";
		         exit;

	            // CREATE NOTIFICACAO...
	            Notification::create([
	                                   'date'      => $notificationDate->format('Y-m-d H:i:s'),
	                                   'class'	   => 'info',                                   
	                                   'title'	   => 'Lembrete de tarefa!',
	                                   'message'   => $data['notification-text'],
	                                   'tarefa_id' => $tarefa->id
	            					]);

	         }


     	    $alert[] = [ 'class' 	=> 'alert-success',
     	    			 'message'  => '<strong><i class="fa fa-check"></i></strong> Nova tarefa criada!' ];
            Session::flash('alerts', $alert);	
					
			return Redirect::to('tarefas/'.$tarefa->id);

        }

         return Redirect::back()->withErrors($validator)->withInput(Input::all());

  //     if( !Input::get('id') ){

  //     }else{
  //        /**
  //         * MOVAR PARA UPDATE?
  //         * MARCA TAREFA COMO CONCLUÍDA OU NÃO
  //         * @var [type]
  //         */
  //        $id = Input::get('id');
  //        $tarefa = Tarefa::findOrFail($id);
  //        $tarefa->check();

  //        print_r($tarefa);
  //        return $tarefa;
  //     }
		// return Redirect::route('tarefas.index');

	}

	/**
	 * Display the specified tarefa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//$tarefasBKP = Tarefa::all();


		// $tarefas 	   = new CreateTarefasTable;
		// $notifications = new CreateNotificationsTable;
		
		// $tarefas->down();
		// $notifications->down();
		// //sleep(3);
		// $tarefas->up();
		// $notifications->up();

		// // foreach ($tarefasBKP as $tarefa) {
		// // 	Tarefa::create($tarefa->toArray());
		// // }

		// //exit;



		$tarefa = Tarefa::with('cliente', 'notifications')->find($id);		

		// echo "<pre>";
		// print_r($tarefa);
		// echo "</pre>";
		// exit;

		return View::make('tarefas.show', compact('tarefa') );
	}

	/**
	 * Show the form for editing the specified tarefa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tarefa = Tarefa::with('notifications')->find($id);

		// echo "<pre>";		
		// print_r($tarefa);
		// echo "</pre>";
		// exit;

		//$notification = new Notification;

		// $notification = Carbon::createFromFormat('Y-m-d H:i:s', $data['start'])->subDays( $data['notification'] );


		// $notification = Carbon::createFromDate(2000, 1, 1, 'America/Toronto');
		// $dtVancouver = Carbon::createFromDate(2000, 1, 1, 'America/Vancouver');
		// echo $dtOttawa->diffInHours($dtVancouver);                             // 3

		// echo $dtOttawa->diffInHours($dtVancouver, false);                      // 3
		// echo $dtVancouver->diffInHours($dtOttawa, false);                      // -3

		// $dt = Carbon::create(2012, 1, 31, 0);
		// echo $dt->diffInDays($dt->copy()->addMonth());                         // 31
		// echo $dt->diffInDays($dt->copy()->subMonth(), false);  



		return View::make('tarefas.edit', compact('tarefa'));
	}

	/**
	 * Update the specified tarefa in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		$tarefa = Tarefa::with('notifications')->find($id);
        
		$validator = Validator::make($data = Input::all(), Tarefa::$rules);
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
			
		
		if( @$data['done'] == 1 ){
			$tarefa->done = 1;	
			Conversa::create([
			    'tarefa_id'  => $tarefa->id,
				'cliente_id' => @$tarefa->cliente_id,
				'resumo'	 => '<strong><i class="fa fa-check"></i> Tarefa '.$tarefa->id.' concluída!</strong><br/>'
			]);
		}else{
			$tarefa->done = 0;	
		};


		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit;


		$tarefa->update($data);

		$alert[] = [ 'class' 	=> 'alert-success',
     	    		 'message'  => '<strong><i class="fa fa-check"></i></strong> Salvo!' ];
		Session::flash('alerts', $alert);	
	
		return Redirect::to( URL::previous() );  
	}


   /**
    * CHECK TAREFA
    *
    * @param  int  $id
    * @return Response
    */
   public function check($id)
   {
		if(!isset($id)){			
			$alert[] = [ 'class' 	=> 'alert-warning', 'message'  => '<strong><i class="fa fa-warning"></i></strong> Você precisa informar o ID da tarefa.' ];

			Session::flash('alerts', $alert);	
			return Redirect::to( URL::previous() );  
		}

		$tarefa = Tarefa::find($id);
		$tarefa->check();
		$tarefa->save();
		
		if( $tarefa->done ){
			$alert[] = [ 'class' 	=> 'alert-success', 'message'  => '<strong><i class="fa fa-check"></i></strong> Tarefa '.$tarefa->id.' marcada como <strong>CONCLUÍDA</strong>!<br /> <a href="'. url( "tarefas/".$tarefa->id ) .'" class="btn btn-primary">Ver tarefa</a> ' ];			
		}else{			
			$alert[] = [ 'class' 	=> 'alert-success', 'message'  => '<strong><i class="fa fa-check"></i></strong> Tarefa '.$tarefa->id.' marcada como <strong>NÃO CONCLUÍDA</strong>!' ];						
		}

		Session::flash('alerts', $alert);	

		return Redirect::to( URL::previous() );  
   }


	/**
	 * Remove the specified tarefa from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Tarefa::destroy($id);

		return Response::json(array('success' => true));
	}

	/**
	 * Remove the specified tarefa from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function excluir($id)
	{
		Tarefa::destroy($id);
		
		$alert[] = [ 'class' 	=> 'alert-success', 'message'  => '<strong><i class="fa fa-check"></i></strong> Tarefa excluída com successo' ];						
		Session::flash('alerts', $alert);		

		return Redirect::to( URL::previous() );  
	}

}