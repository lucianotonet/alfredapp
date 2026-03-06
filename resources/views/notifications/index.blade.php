@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="panel panel-primary" id="notifications">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="icon-bell-o"></i> NOTIFICAÇÕES</h3>
            </div>        
            
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-2 col-md-2 col-lg-2">
                        <div class="list-group">
                            <a class="list-group-item {{ ( !Input::has('view') || Input::get('view') == 'unread' ) ? 'active' : '' }}" href="{{ url('notifications') }}">
                                Não lidas <span class="badge">{{ $labels['count_unread'] }}</span>                                
                            </a>
                            <a class="list-group-item {{ (Input::has('view') && Input::get('view') == 'next' ) ? 'active' : '' }}" href="{{ url('notifications/?view=next') }}">
                                Agendadas  <span class="badge">{{ $labels['count_next'] }}</span>                            
                            </a>
                            <a class="list-group-item {{ (Input::has('view') && Input::get('view') == 'all' ) ? 'active' : '' }}" href="{{ url('notifications/?view=all') }}">
                                Todas                                
                                <span class="badge">{{ $labels['count_all'] }}</span>
                            </a>                            
                        </div>
                    </div>
                    <div class="col-sm-10 col-md-10 col-lg-10">
                    
                        <?php 
                            if( Input::get('order') == 'asc' ){ 
                                $new_url = array_merge( Input::query(), ['order'=>'desc'] );
                                ?>
                                <a href="{{ url( 'notifications/?'. http_build_query( $new_url ) ) }}">
                                    <i class="fa fa-chevron-circle-up"></i>
                                    Mais recente antes
                                </a>
                        <?php 
                            }else{ 
                                $new_url = array_merge( Input::query(), ['order'=>'asc'] );
                                ?>
                                <a href="{{ url( 'notifications/?'. http_build_query( $new_url ) ) }}">
                                    <i class="fa fa-chevron-circle-down"></i>
                                    Mais antiga antes
                                </a>
                        <?php } ?>

                        @include('notifications.panels.index') 

                        {{ $notifications->appends( Request::except('page') )->links() }}               
                        
                    </div>
                </div>
                
            </div>
            

        </div>
    
    </div>
@stop


@section('styles')

@stop


@section('scripts')
    <script>
        $('.modal').on('hidden.bs.modal', function (e) {
            $(this).removeData('bs.modal');
        })
    </script>
@stop