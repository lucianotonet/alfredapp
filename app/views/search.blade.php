@extends('layouts.master')

@section('content')
      <h1>Buscar</h1>
      
      {{ Form::open( array('url' => '/search') ) }}
      
        <div class="control-group large">
            <div class="input-append">
              {{ Form::text( 'keyword', null, array( 'placeholder' => 'Digite o que procura aqui',
                                                        'class'    => 'span2',
                                                        'id'       => 'appendedInputButton-02' ) ) }}
              <!-- <button class="btn btn-large" type="button"><span class="fui-search"></span></button> -->
              {{ Form::submit('Buscar', array( 'class' => 'btn btn-large') ) }}
            </div>
          </div>

      {{ Form::close() }}

            
                @if (@$clientes)

                    <h2 class="sub-header">Resultados</h2>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Endereço</th>
                                    <th>Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                    
                            @foreach ($clientes as $cliente)
                                
                                <tr>
                                    <td><?php echo $cliente->id ?></td>
                                    <td><?php echo $cliente->name ?></td>
                                    <td><?php echo $cliente->email ?></td>
                                    <td><?php echo $cliente->address ?></td>
                                    <td></td>
                                </tr>
                               
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                @endif

@stop


@section('dock')
    <a class="btn btn-primary active" href="#fakelink"><i class="fui-list-columned"></i></a>
    <a class="btn btn-primary" href="#fakelink"><i class="fui-list-numbered"></i></a>
    <a class="btn btn-primary big" href="#fakelink" data-toggle="modal" data-target=".quick-add"><i class="fui-plus"></i></a>
    <a class="btn btn-primary" href="#fakelink"><i class="fui-list-small-thumbnails"></i></a>
    <a class="btn btn-primary" href="#fakelink"><i class="fui-list-small-thumbnails"></i></a>
@stop