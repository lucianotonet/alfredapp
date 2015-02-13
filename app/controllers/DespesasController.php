<?php
use Carbon\Carbon as Carbon;
class DespesasController extends \BaseController {

	/**
	 * Display a listing of despesas
	 *
	 * @return Response
	 */
	public function index()
	{

		// $despesas = new CreateDespesasTable;
		// $despesas->down();		
		// $despesas->up();

		$despesas = Despesa::where('relatorio_id', 0)->get();
		
		//$total    = 0;			
		if($despesas){
			foreach ($despesas as $despesa) {			
				$despesa['date'] = date( 'd/m/Y', strtotime($despesa['date']) );
				//$total += $despesa['valor'];

				//Formata numeros para exiição	
				$despesa['valor']    = number_format( (float)$despesa['valor'] , 2, ',', '.' );    
			}
		}

		return Response::json( $despesas );

		//if( Request::ajax() ){
		//}else{
		//	return View::make('despesas.index', compact('despesas'));
		//}

	}

	/**
	 * Show the form for creating a new despesa
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('despesas.create');
	}

	/**
	 * Store a newly created despesa in storage.
	 *
	 * @return Response
	 */
	public function store()
    {
      $validator = Validator::make($data = Input::all(), Despesa::$rules);



      if ($validator->fails())
      {		
        return Redirect::back()->withErrors($validator)->withInput();

      }else{
       		

        $data['valor']    = number_format( $data['valor'] , 2, '.', '');       
        $data['date']     = new Carbon( $data['date'], 'America/Sao_Paulo' );
        $data['date'] 	  = $data['date']->format('Y-m-d');        

        //return $data['date'];

        $despesa	      = Despesa::create($data);


        $relatorio = Relatorio::find( @$data['relatorio_id'] );
        if( $relatorio ){
        	$ids   			  = explode(',', $relatorio->ids);
        	$ids[] 			  = $despesa->id;
        	$relatorio->ids   = implode(',', $ids);
        	$relatorio->save();        	
        }

        
        // Alert
		$alert[] = [	'class' => 'alert-success',
						'message'   => '<strong><i class="fa fa-check"></i></strong> Despesa registrada com sucesso'];
		Session::flash('alerts', $alert);	
		return Redirect::to( URL::previous() );   


      }
	}

	/**
	 * Display the specified despesa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$despesa = Despesa::findOrFail($id);

		return View::make('despesas.show', compact('despesa'));
	}

	/**
	 * Show the form for editing the specified despesa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$despesa = Despesa::find($id);

		return View::make('despesas.edit', compact('despesa'));
	}

	/**
	 * Update the specified despesa in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$despesa = Despesa::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Despesa::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$despesa->update($data);

		return Redirect::route('despesas.index');
	}

	/**
	 * Remove the specified despesa from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if( Despesa::destroy($id) ){
			// Alert
			$alert[] = [	'class' => 'alert-success',
							'message'   => '<strong><i class="fa fa-check"></i></strong> Despesa excluída com sucesso' ];
		}else{
			// Alert			
			$alert[] = [	'class' 	=> 'alert-danger',
							'message'   => '<strong><i class="fa fa-check"></i></strong> Erro! Não foi possível excluir a despesa.'			                             ];
		}
		Session::flash('alerts', $alert);	
		return Redirect::to( URL::previous() );      
	}

}
