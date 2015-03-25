<?php

use Carbon\Carbon as Carbon;

class NotificationsController extends \BaseController {

	/**
	 * Display a listing of notifications
	 *
	 * @return Response
	 */
	public function index()
	{
		if ( Request::ajax() ) {
			$notifications = Notification::where('status', 0)->where('date','<=',date('Y-m-d H:i:s'))->orderBy('date', 'DESC')->get();
			return Response::json($notifications, '200');
		}
      // $schema = new CreateNotificationsTable;
      // $schema->up();
      //

      // Notificação TESTE
      // Notification::create([
      //    'class'    => 'info',
      //    'title'    => 'E-email recebido!',
      //    'message'  => 'XXX abriu seu e-mail <span class="timeago" title="'.date('Y-m-d H:i:s').'">agora mesmo</span>',
      //    'status'   => 0,
      // ]);



      // $notifications = new CreateNotificationsTable;
      // $notifications->down();
      // sleep(3);
      // $notifications->up();

      // foreach ($clientesBKP as $cliente) {
      //    Notification::create($cliente->toArray());
      // }

      //exit;
	  $amanha  = Carbon::create(date('Y'), date('m'), date('d'))->addDay();

      $notifications 		   = Notification::all();
      $notifications->naolidas = Notification::where('status', 0)->where('date','<=',date('Y-m-d H:i:s'))->orderBy('date', 'DESC')->get();
      $notifications->proximas = Notification::where('status', 0)->where('date','>',date('Y-m-d H:i:s'))->get();
      $notifications->lidas    = Notification::where('status', 1)->orderBy('updated_at', 'DESC')->get();


		return View::make('notifications.index', compact('notifications'));
	}

	/**
	 * Show the form for creating a new notification
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('notifications.create');
	}

	/**
	 * Store a newly created notification in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
   //    	if( isset( $_POST['mandrill_events'] ) ){
   //    		// NOTIFICAÇÃO DO MANDRILL
			// $msg     = array();
			// $dados   = @$_POST['mandrill_events'];

			// $dados   = json_decode($dados);

			// // Mail Defaults
			// $msg['from']      = 'contato@lucianotonet.com';
			// $msg['from_name'] = 'L. Tonet';
			// $msg['to']        = 'tonetlds@gmail.com';

			// // SEND THE MAIL
			// Mail::send('notifications.email', compact('dados'), function($message)use($msg){
			// //$message->from('contato@lucianotonet.com', 'L. Tonet');
			// //$message->from( $msg['from'], @$msg['from_name'] );
			// $message->to( $msg['to'] );

			// $message->subject('Notificação do Mandrill');
			// });

			// // NOTIFICATION
			// $notification          = new Notification;
			// $notification->title   = 'E-mail aberto';
			// $dados                 = '<pre>'.$dados.'</pre>';
			// $notification->message = $dados;
			// $notification->save();

			// return;
   //    	}


		$validator = Validator::make($data = Input::all(), Notification::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		// echo "<pre>";
  //       print_r($data);
  //       echo "</pre>";
  //       exit;


		Notification::create($data);

		// $alert = array(                     
		// 	'alert-success' => '<strong><i class="fa fa-check"></i></strong> Notificação criada!'
		// );
		$alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Notificação criada!' ];
		Session::flash('alerts', $alert);	
		return Redirect::to( URL::previous() );  
	}

	/**
	 * Display the specified notification.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$notification = Notification::findOrFail($id);

		return View::make('notifications.show', compact('notification'));
	}

	/**
	 * Show the form for editing the specified notification.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$notification = Notification::find($id);

		return View::make('notifications.edit', compact('notification'));
	}

	/**
	 * Update the specified notification in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$notification = Notification::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Notification::$rules);


		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$notification->update($data);

		// $alert = array(                     
		// 	'alert-success' => '<strong><i class="fa fa-check"></i></strong> Notificação atualizada!'
		// );
		$alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Notificação atualizada!' ];
		Session::flash('alerts', $alert);	
		return Redirect::to( URL::previous() );  
	}

	/**
	 * Remove the specified notification from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{      	
	   	Notification::destroy($id);

		$alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Notificação excluída!' ];
		Session::flash('alerts', $alert);	
	
		return Redirect::to( URL::previous() );  
	}



   /**
    *    NOTIFICAÇÕES LIDAS
    *
    * @param  int  $id
    * @return Response
    */
   public function unread()
   {
      // $schema = new CreateNotificationsTable;
      // $schema->up();
      $notifications = Notification::where('status', 0)->orderBy('id','DESC')->get();

      // $notifications->filter(function($notification) {
      //    if ($notification->status) {
      //       return true;
      //    }
      // });

      print_r( count($notifications) );


      return $notifications;

   }



   /**
    * CLOSE NOTIFICATION (no destroy)
    *
    * @param  int  $id
    * @return Response
    */
   public static function fechar($id)
   {
      if(!isset($id)){
         return Response::json(array('error' => 'ID não informado'));
      }

      if( $notification = Notification::find($id) ){

      	if( $notification->status ) {
			$notification->status = 0;      		
			$notification->save();			
			$alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong> Notificação marcada como não lida!'];
			Session::flash('alerts', $alert);	
		
			return Redirect::to( URL::previous() );  
      	}

         $notification->close();         
      }


      return Response::json(array('success' => true));
   }



   /**
    *   EXCLUI TODAS NOTIFICAÇÔES LIDAS
    *
    * @param  int  $id
    * @return Response
    */
    public function clean()
    {
		// $schema = new CreateNotificationsTable;
		// $schema->up();
		$notifications = Notification::where('status', 1)->get();
		$total = count($notifications);

		foreach ($notifications as $notification) {
			$notification->destroy( $notification->id );
		}
     	
		$alert[] = [   'class' => 'alert-success', 'message'   => '<strong><i class="fa fa-check"></i></strong>'.$total.' notificações excluídas!' ];
		Session::flash('alerts', $alert);	
	
		return Redirect::to( URL::previous() );        

    }


}
