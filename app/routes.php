<?php
use Carbon\Carbon as Carbon;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| TIMELINE
|--------------------------------------------------------------------------
|   
|   Home
|
*/
Route::get('timeline', function()
{
    return View::make('timeline');
});



/*
|--------------------------------------------------------------------------
| API
|--------------------------------------------------------------------------
*/
// Route::group(array('prefix' => 'api'), function()
// {
//     //Route::resource('despesas', 'DespesasController');
//     Route::resource('clientes', 'ClienteController');

//     // Second Route
//     Route::get('/teste', function() {
//         return 'Rota api/teste OK';
//     });

//     // Third Route
//     Route::get('/todos', function() {
//         return 'Lords and Ladies';
//     });

// });



/*
|--------------------------------------------------------------------------
| CLIENTES
|--------------------------------------------------------------------------
*/
Route::get('getcostumers', array('as' => 'getcostumers', 'uses' => 'ClienteController@getCostumers'));
Route::get('clientes/{cliente_id}/mini', array('uses' => 'ClienteController@mini'));
Route::get('clientes/{cliente_id}/enviarcontato', array('uses' => 'ClienteController@enviarcontato'));
Route::get('clientes/{cliente_id}/conversas', array('as' => 'conversas', 'uses' => 'ClienteController@getConversas'));
Route::get('clientes/{cliente_id}/tarefas', array('as' => 'cliente.tarefas', 'uses' => 'ClienteController@getTarefas'));
Route::resource('clientes', 'ClienteController');
Route::when('clientes*', 'auth');



/*
|--------------------------------------------------------------------------
| TAREFAS
|--------------------------------------------------------------------------
*/
Route::get('tarefas/{tarefa_id}/check', array('uses' => 'TarefasController@check'));
Route::delete('tarefas/{tarefa_id}/excluir', array('uses' => 'TarefasController@excluir'));
Route::resource('tarefas', 'TarefasController');
Route::when('tarefas*', 'auth');


/*
|--------------------------------------------------------------------------
| DespesaS
|--------------------------------------------------------------------------
*/
Route::resource('despesas', 'DespesasController');
Route::when('despesas*', 'auth');


/*
|--------------------------------------------------------------------------
| CONVERSAS
|--------------------------------------------------------------------------
*/
Route::resource('conversas', 'ConversasController');
Route::get('conversas/create/{cliente_id}', array('as' => 'createconversa', 'uses' => 'ConversasController@create'));
// Route::get('conversas/send/{conversa_id}', array('as' => 'conversas.sendto', 'uses' => 'ConversasController@sendTo'));
//Route::post('conversas/send', array('as' => 'conversas.sendnow', 'uses' => 'ConversasController@sendNow'));
Route::when('conversas*', 'auth');


/*
|--------------------------------------------------------------------------
| Relatórios
|--------------------------------------------------------------------------
*/
Route::group(array('prefix' => 'relatorios'), function()
{
    // NOVO RELATÓRIO BASEADO NO RESOURCE INFORMADO
    Route::get('create/{resource_name}', array('uses' => 'RelatoriosController@create') );

});
Route::get('relatorios/{relatorio_id}/download', array('as' => 'relatorios.download', 'uses' => 'RelatoriosController@downloadpdf'));
Route::get('relatorios/{relatorio_id}/pdf', array('as' => 'relatorios.pdf', 'uses' => 'RelatoriosController@streampdf'));
Route::get('relatorios/{relatorio_id}/print', array('as' => 'relatorios.pdf', 'uses' => 'RelatoriosController@printThis'));
//Route::get('relatorios', array('as' => 'relatorios.index', 'uses' => 'RelatoriosController@index'));
Route::resource('relatorios', 'RelatoriosController');

Route::when('relatorios/create*', 'auth');
Route::when('relatorios/edit*', 'auth');
Route::when('relatorios*', 'auth', array('post', 'delete'));



/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function()
{

   // Todas tarefas
   //$tarefas = Tarefa::with('cliente')->all();

   $tarefas = Tarefa::orderBy('done', 'ASC')->orderBy('id', 'ASC')->get();
   $hoje    = Carbon::now();

   // TAREFAS DO DIA   
   $tarefas = $tarefas->filter(function($tarefa){
      if( Carbon::createFromFormat("Y-m-d H:i:s", $tarefa->start)->isToday() ) return $tarefa;
   });

    // PROXIMAS
   $ontem        = Carbon::create(date('Y'), date('m'), date('d'))->subDay();
   $daquiummes  = Carbon::create(date('Y'), date('m'), date('d'))->addMonths(1);
   $tarefas->proximas = Tarefa::where('start','>', $ontem)->where('start','<=', $daquiummes)->orderBy('start', 'ASC')->where('done', 0)->with('cliente', 'conversas')->get();
   
   
   // CLIENTES MAIS IMPORTANTES
    $clientes = new Cliente;
    $topten = DB::table('pedidos')
                 ->select('cliente_id', DB::raw('count(*) as total'))
                 ->groupBy('cliente_id')
                 ->orderBy('total', 'DESC')
                 ->take(10)
                 ->get();
    if( count($topten) ){
         $itemIds = array();
         foreach ($topten as $cliente) {
            $itemIds[] = $cliente->cliente_id;
         }
         $ids = implode(',', $itemIds);
          
         $clientes->topten = Cliente::whereIn('id', $itemIds)
          ->orderByRaw(DB::raw("FIELD(id, $ids)"))
          ->take( 5 )
          ->get();
    }else{
         $clientes->topten = array();
    }


   // echo "<pre>";
   // print_r( $clientes );
   // echo "<pre><br>";   
   // //print_r( count($atrasadas) );


   // exit;

   
   $tarefas->ontem = Tarefa::where('start', '=', strtotime("-1 day"))->get();
   //$tarefas->hoje  = Tarefa::where('start', '=', Carbon::now() )->get();


   return View::make('dashboard', compact('tarefas','clientes'));
});
Route::when('/', 'auth');


/*
|--------------------------------------------------------------------------
| DEMO
|--------------------------------------------------------------------------
*/
Route::get('/demo', function()
{
   $clientes = Cliente::all();
   $tarefas  = Tarefa::all();

   return View::make('demo', compact('clientes', 'tarefas'));
});



/*
|--------------------------------------------------------------------------
| FINANCEIRO
|--------------------------------------------------------------------------
*/
// SALDO
Route::resource('financeiro/saldo', 'BalanceController');

Route::get('financeiro/dashboard', array('uses' => 'TransactionsController@dashboard') );
Route::get('financeiro/{id}/delete', array('uses' => 'TransactionsController@destroy') );
Route::resource('financeiro', 'TransactionsController');
Route::when('financeiro*', 'auth');




/*
|--------------------------------------------------------------------------
| PRODUTOS
|--------------------------------------------------------------------------
*/
Route::resource('produtos', 'ProdutosController');
Route::when('produtos*', 'auth');



/*
|--------------------------------------------------------------------------
| CATEGORIAS
|--------------------------------------------------------------------------
*/
Route::resource('categories', 'CategoriesController');



/*
|--------------------------------------------------------------------------
| FORNECEDORS
|--------------------------------------------------------------------------
*/
Route::resource('fornecedors', 'FornecedorsController');
Route::when('fornecedors*', 'auth');


/*
|--------------------------------------------------------------------------
| VENDEDORES
|--------------------------------------------------------------------------
*/
Route::resource('vendedors', 'VendedorsController');
Route::when('vendedors*', 'auth');


/*
|--------------------------------------------------------------------------
| NOTIFICAÇÕES
|--------------------------------------------------------------------------
*/

// $schema = new CreateNotificationsTable;
// $schema->up();   

Route::get('notifications/{id}/close', array('as' => 'close', 'uses' => 'NotificationsController@fechar'));
Route::get('notifications/unread', array('as' => 'naolidas', 'uses' => 'NotificationsController@unread'));
Route::get('notifications/clean', array('as' => 'limpar', 'uses' => 'NotificationsController@clean'));
Route::resource('notifications', 'NotificationsController');

  
  // $contacts = new CreateContactsTable;
  // $contacts->down();
  // $contacts->up();

  // $tarefas     = new CreateTarefasTable;
  // $notifications = new CreateNotificationsTable;
  
  // $tarefas->down();
  // $notifications->down();
  // //sleep(3);
  // $tarefas->up();
  // $notifications->up();

  // $users     = new ConfideSetupUsersTable;
  // $users->down();
  // $users->up();

  // $settings     = new CreateSettingsTable;
  // $settings->down();
  // $settings->up();

  // $settings     = new CreateSettingsTable;
  // $settings->down();
  // $settings->up();

// echo "ROUTES";
// exit;


/*
|--------------------------------------------------------------------------
| NOTES
|--------------------------------------------------------------------------
*/
Route::resource('notes', 'NotesController');
Route::when('notes*', 'auth');




/*
|--------------------------------------------------------------------------
| LOGS
|--------------------------------------------------------------------------
*/
Route::resource('reports', 'ReportsController');
Route::when('reports*', 'auth');

/*
|--------------------------------------------------------------------------
| PEDIDOS
|--------------------------------------------------------------------------
*/
Route::resource('pedidos', 'PedidosController');

Route::get('pedidos/create/{cliente_id}', array('as' => 'createpedido', 'uses' => 'PedidosController@create'));
Route::get('pedidos/send/{pedido_id}', array('as' => 'pedidos.sendto', 'uses' => 'PedidosController@sendTo'));
Route::post('pedidos/send', array('as' => 'pedidos.sendnow', 'uses' => 'PedidosController@sendNow'));
Route::get('pedidos/preview/{pedido_id}', array('as' => 'pedidos.preview', 'uses' => 'PedidosController@preview'));

Route::get('pedidos/{pedido_id}/arquivar', function($id){
    $pedido = Pedido::find($id);
    if( $pedido ){
        $pedido->arquivar();
        $pedido->save();

        $alert[] = [ 'class'    => 'alert-success',
                     'message'  => 'Pedido arquivado!' ];  

        Session::flash('alerts', $alert);        
    }    
    else {
        $alert[] = [   'class'   => 'alert-danger',
                'message'   => 'Pedidos não encontrado!' ];  

        Session::flash('alerts', $alert);
    }
    return Redirect::to( URL::previous() );
});


Route::get('pedidos/{pedido_id}/pdf', array('as' => 'pedidos.pdf', 'uses' => 'PedidosController@pdf'));
Route::get('pedidos/{pedido_id}/download', array('as' => 'pedidos.donwload', 'uses' => 'PedidosController@download'));
Route::get('pedidos/{pedido_id}/print', array('as' => 'pedidos.printpreview', 'uses' => 'PedidosController@printPreview'));


Route::when('pedidos*', 'auth');



/*
|--------------------------------------------------------------------------
| EMAILS
|--------------------------------------------------------------------------
*/
Route::get('emails/getcontacts', array('as' => 'email.getcontacts', 'uses' => 'EmailsController@getContacts'));
Route::get('emails/create/{resource}/{id}', array('as' => 'email.create', 'uses' => 'EmailsController@create'));
Route::resource('emails', 'EmailsController');
Route::get('emails/track/{id}', array('as' => 'email.track', 'uses' => 'EmailsController@track'));


//Route::when('emails*', 'auth');


/*
|--------------------------------------------------------------------------
| EVENTOS
|--------------------------------------------------------------------------
*/
Route::resource('eventos', 'EventosController');
Route::when('eventos*', 'auth');


/*
|--------------------------------------------------------------------------
| MOVIMENTOS
|--------------------------------------------------------------------------
*/
Route::resource('movimentos', 'MovimentosController');
Route::when('movimentos*', 'auth');



/*
|--------------------------------------------------------------------------
| CONFIGURAÇÕES
|--------------------------------------------------------------------------
*/
Route::get('settings/reset', array('uses' => 'SettingsController@reset'));
Route::resource('settings', 'settingsController');
Route::when('settings*', 'auth');



// // SEARCH
// Route::get('search', function()
// {
//     return View::make('search');
// });
// Route::post('/search', function()
// {
//     $q = Input::get('keyword');
//     $searchTerms = explode(' ', $q);

//     $query = DB::table('clientes');

//     foreach($searchTerms as $term)
//     {
//         $query->where('name', 'LIKE', '%'. $term .'%');
//     }
//     $clientes = $query->get();

//     return View::make('search')->with( 'clientes', $clientes);

// });



// TEMPLATE
Route::get('/template', function()
{
    return View::make('template');
});






// /**
//  *    POSTS
//  */
// Route::resource('posts', 'PostsController');//

// Confide routes
Route::get('users/create', 'UsersController@create'); // Comentar em ambiente de produção
Route::post('users', 'UsersController@store');
Route::get('login', 'UsersController@login');
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('logout', 'UsersController@logout');

Route::get('invoice', function(){
   return View::make('clientes.invoice');
});





/*
 * Outputs a color (#000000) based Text input
 *
 * @param $text String of text
 * @param $min_brightness Integer between 0 and 100
 * @param $spec Integer between 2-10, determines how unique each color will be
 */

function magicColor($text,$min_brightness=100,$spec=2)
{
    // Check inputs
    if(!is_int($min_brightness)) throw new Exception("$min_brightness is not an integer");
    if(!is_int($spec)) throw new Exception("$spec is not an integer");
    if($spec < 2 or $spec > 10) throw new Exception("$spec is out of range");
    if($min_brightness < 0 or $min_brightness > 255) throw new Exception("$min_brightness is out of range");
    
    
    $hash = md5($text);  //Gen hash of text
    $colors = array();
    for($i=0;$i<3;$i++)
        $colors[$i] = max(array(round(((hexdec(substr($hash,$spec*$i,$spec)))/hexdec(str_pad('',$spec,'F')))*255),$min_brightness)); //convert hash into 3 decimal values between 0 and 255
        
    if($min_brightness > 0)  //only check brightness requirements if min_brightness is about 100
        while( array_sum($colors)/3 < $min_brightness )  //loop until brightness is above or equal to min_brightness
            for($i=0;$i<3;$i++)
                $colors[$i] += 10;  //increase each color by 10
                
    $output = '';
    
    for($i=0;$i<3;$i++)
        $output .= str_pad(dechex($colors[$i]),2,0,STR_PAD_LEFT);  //convert each color to hex and append to output
    
    return '#'.$output;
}




   /**
    * 
    */
   class Saudacoes
   {
      
      function __construct()
      {
      }      

      public static function ola(){           

         date_default_timezone_set("America/Sao_Paulo");                  
         $nome = Confide::user() ? Confide::user()->username : '';
         $hr = date(" H ");           

         if($hr >= 12 && $hr < 20) {  
            $turno = "Boa tarde";  
         }else if ($hr >= 20 && $hr <  24){  
             $turno = "Boa noite";  
         }else if ($hr >= 0 && $hr <  6){  
             $turno = "Dormir é para os fracos \o/";  
         }else if ($hr >= 6 && $hr <12 ){  
             $turno = "Bom dia";  
         }else{  
             $turno = "Que horas são?";  
         }           

         return  $turno;  
      }  

   }   


      /**
   *     FAZMERIR
   *     Não faz quase nada...
   *       Mas converte formato monetário para numérico =)
   *       ( Útil para tratamento de valores que precisam ser processados )
   *    
   *       FazMeRir::bonito('1234567890');
   *          returns "1.234.567.890,00"      
   *       
   *       FazMeRir::feio('1234567890');
   *          retunrs "1234567890.00"
   *       
   *       FazMeRir::igual('1234567890');
   *          returns "1234567890"
   * 
   **/
   class FazMeRir {
      
      function __construct($valor)
      {
          $valor = $valor;
      }

      public static function feio($valor){
         $valor = str_replace( '.', '', $valor);
         $valor = str_replace( ',', '.', $valor );
         $valor = number_format( $valor, 2, '.', '');      
         return $valor;
      }

      public static function bonito($valor){
         $valor = number_format( (float)$valor, 2, ',', '.');
         return $valor;
      }
      
      public static function igual($valor){
         $valor = $valor;
         return $valor;
      }

   }



/**
* 
*/

class AboutDate
{
   
   function __construct( String $data)
   {
      
   }

   public static function timeAgo($value='')
   {
      setlocale(LC_TIME, 'pt_BR.utf-8');
      $value  = strtotime($value);
      // $year   = date('Y', $value);
      // $month  = date('m', $value);
      // $day    = date('d', $value);
      // $hour   = date('H', $value);
      // $minute = date('i', $value);
      // $second = date('s', $value);
      // $dt = Carbon::create($year, $month, $day, $hour, $minute, $second);
      // return $dt->formatLocalized('%A, %d de %B');
      return Carbon::createFromTimeStamp( $value )->diffForHumans();
   }
   


   public static function diaDaSemana($data='')
   {
      setlocale(LC_TIME, 'pt_BR.utf-8');
      //$dt = Carbon::create($data);
      $dt = Carbon::createFromFormat("Y-m-d", $data);

             if ($dt->dayOfWeek === Carbon::SUNDAY) {
           echo 'Domingo';
       }else if ($dt->dayOfWeek === Carbon::MONDAY) {
           echo 'Segunda-feira';
       }else if ($dt->dayOfWeek === Carbon::TUESDAY) {
           echo 'Terça-feira';
       }else if ($dt->dayOfWeek === Carbon::WEDNESDAY) {
           echo 'Quarta-feira';
       }else if ($dt->dayOfWeek === Carbon::THURSDAY) {
           echo 'Quinta-feira';
       }else if ($dt->dayOfWeek === Carbon::FRIDAY) {
           echo 'Sexta-feira';
       }else if ($dt->dayOfWeek === Carbon::SATURDAY) {
           echo 'Sábado';
       }
   }

   public static function date( $data, $tipo ){

      if( isset($tipo) and isset($data)) {
         
         $dataEnviada = $data;

         


         $diasextenso = array(
                           "Domingo",
                           "Segunda-feira",
                           "Terça-feira",
                           "Quarta-feira",
                           "Quinta-feira",
                           "Sexta-feira",
                           "Sábado"
                        );
         $date = DateTime::createFromFormat('d/m/Y', $dataEnviada);


         $feriados = array('01/01','31/12','25/12','01/05','25/04');
      
         switch ($tipo) {
            case 'l':
               return $diasextenso[$date->format('w')];
               break;
            default:

               echo 'Data Informada: ', $date->format('d/m/Y H:i'), PHP_EOL . '<br />';
               echo 'Dia da semana (numero): ', $date->format('w'), PHP_EOL . '<br />';
               echo 'Dia da semana (extenso): ', $diasextenso[$date->format('w')], PHP_EOL . '<br />';
               echo 'Ultimo dia do mes: ', $date->format('t'), PHP_EOL . '<br />';
               echo 'Final de semana?: ', $date->format('w') == 0 || $date->format('w') == 6 ? 'Sim' : 'Não', PHP_EOL . '<br />';
               echo 'É feriado?: ', in_array($date->format('d/m'),$feriados) ? 'Sim' : 'Não' . '<br />';
               return $date;               
               break;
         }
      }else{
         return false;
      }
   }

   public static function semana(){
      $tomorrow  = mktime (0, 0, 0, date("m")  , date("d")+1, date("Y")  );
      $yesterday = mktime (0, 0, 0, date("m")  , date("d")-1, date("Y")  );
      $lastmonth = mktime (0, 0, 0, date("m")-1, date("d")  , date("Y")  );
      $nextyear  = mktime (0, 0, 0, date("m")  , date("d")  , date("Y")+1);

      //$pastweend = 
     
      $lastWeekStart = mktime(0 , 0 , 0 , date('n'), date('j')-6, date('Y')) - ((date('N'))*3600*24); 
      $lastWeekEnd   = mktime(23, 59, 59, date('n'), date('j')  , date('Y')) - ((date('N'))*3600*24); 

      $thisWeekStart = mktime(0 , 0 , 0 , date('n'), date('j')+1, date('Y')) - ((date('N'))*3600*24); 
      $thisWeekEnd   = mktime(23, 59, 59, date('n'), date('j')+7, date('Y')) - ((date('N'))*3600*24);

      $nextWeekStart = mktime(0 , 0 , 0 , date('n'), date('j')+8 , date('Y')) - ((date('N'))*3600*24); 
      $nextWeekEnd   = mktime(23, 59, 59, date('n'), date('j')+14, date('Y')) - ((date('N'))*3600*24); 

      echo date('d/m/Y', $lastWeekStart);
      echo ' - ';
      echo date('d/m/Y', $lastWeekEnd);
      echo '<br>';
      echo date('d/m/Y', $thisWeekStart);
      echo ' - ';
      echo date('d/m/Y', $thisWeekEnd);      
      echo '<br>';
      echo date('d/m/Y', $nextWeekStart);
      echo ' - ';
      echo date('d/m/Y', $nextWeekEnd);
      echo '<br>';
   }
}

/**
 *    404 RDIRECT
 *    
 *    Se 404 retorna para a pagina anterior ou para a home
 */
App::missing(function($exception)
{
   //  $alert[] = [   'class' => 'alert-danger', 'message'   => '<strong><i class="fa fa-warning"></i></strong> Erro 404! Não foi possível encontrar o item solicitado.' ];
   //  Session::flash('alerts', $alert);
   // // $url = URL::previous() ? : '/';
   // return Redirect::to( URL::previous() );  

});