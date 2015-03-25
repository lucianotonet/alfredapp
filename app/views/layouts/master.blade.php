<!DOCTYPE html>
<html lang="br">
<head>
    <meta charset="utf-8">
    <title>{{Config::get('settings.app_title')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootcards CSS for desktop -->
    {{-- HTML::style("//cdnjs.cloudflare.com/ajax/libs/bootcards/0.1.0/css/bootcards-desktop.min.css") --}}

    <!-- Latest compiled and minified CSS -->
    {{ HTML::style('css/bootstrap.min.css') }}
    {{-- HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css') --}}

    <!-- BootFlat CSS -->
    {{ HTML::style('css/bootflat.css') }}

    <!-- Font Awesome -->
    <!-- <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"> -->
    {{ HTML::style('css/font-awesome.min.css') }}

    <!-- icheck theme -->
    {{ HTML::style('js/icheck/skins/all.css') }}

    <!-- Data tables -->
    <!-- <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"> -->

    <!-- SIDEBAR CSS -->
    {{-- HTML::style('css/simple-sidebar.css') --}}

    <!-- SIDEBAR CSS -->
    {{ HTML::style('css/pushy.css') }}

    <!-- CSS Animations -->
    {{ HTML::style('css/animations.min.css') }}
    
    {{ HTML::style('css/jquery-ui.min.css') }}
    {{ HTML::style('js/jquery-notifyjs/styles/metro/notify-metro.css') }}

    {{ HTML::style('css/icomoon/style.css')}}

    {{-- HTML::style('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.1.1/fullcalendar.min.css') --}}

    {{ HTML::style('css/jquery.dynatable.css') }}

    {{ HTML::style('css/bootstrap-datepicker3.min.css') }}


    <!-- Custom styles -->
    {{ HTML::style('css/style.css') }}

    <!-- Estilos de cada página -->
    @yield('styles')

    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<![endif]-->
</head>
<body>


<?php if(Confide::user()){ //SE ESTIVER LOGADO... ?>
    
    @include('layouts.menu')

    <!-- Site Overlay -->
    <div class="site-overlay"></div>

        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container text-center">
                <div class="pull-left">
                    
                    <div class="dropdown">
                    
                    <!-- Menu Button -->
                    <div class="menu-btn btn">
                        <i class="fa fa-bars"></i>
                    </div>

                    <a data-toggle="modal" href='#notifications_modal' class="btn btn-link notification-info" data-url="{{url('notifications')}}">                        
                        <i class="icon-bell-o fa-2x"></i>
                        
                        <?php $notifications_info = count( Notification::where('status',0)->where('date','<', date('Y-m-d H:i:s') )->get() ); ?>
                        @if ($notifications_info)
                            <span class="badge badge-danger">{{ $notifications_info }}</span>
                        @else
                            <span class="badge badge-danger hide">{{ $notifications_info }}</span>
                        @endif
                            
                        
                                
                    </a>

                    <a href="{{url('tarefas')}}" class="btn btn-link tarefas-info">                        
                        <i class="fa fa-check-square-o fa-2x"></i>
                        
                        <?php $tarefas_info = count( Tarefa::where('done',0)->where('start','<=', date('Y-m-d') )->get() ); ?>
                        @if ($tarefas_info)
                            <span class="badge badge-danger">{{ $tarefas_info }}</span>
                        @endif
                                
                    </a>

                    <a  href="{{url('financeiro')}}" class="btn btn-link transactions_info">

                        <i class="icon-dollar fa-2x"></i>
                        <?php $transactions_info = count( Transaction::where('done',0)->where('date','<=', date('Y-m-d') )->where( 'user_id', Auth::id() )->get() ); ?>
                        @if ($transactions_info)
                            <span class="badge badge-danger">{{ $transactions_info }}</span>
                        @endif
                    </a>

                    
                    </div>
                
                </div>

                

                <a id="logo" class="pull-right hidden-xs"  href="<?php echo url('/') ?>" >

                     <img src="{{Config::get('settings.app_logo')}}" alt="" class="img-responsive">

                    <!-- <img src="{{asset('img/logo.png')}}" alt="" class="img-responsive"> -->

                </a>
                

            </div>
        </div>
<?php } ?>

    
    <span class="loading animated fadeIn">
        <img src="{{asset('img/loading.gif')}}" class="img-responsive" >
    </span>



    @if (Session::has('alerts'))

        <div class="container">
        @foreach (Session::get('alerts') as $alert)
           

            <div class="alert <?php echo @$alert['class'] ?> fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
               
               <p>{{@$alert['message']}}</p>          

            
                <?php 
                    if( isset($alert['links']) ){
                        echo "<p>";
                        foreach ( $alert['links'] as $item => $value ){ ?>
                            <a href="{{$value['link']}}" class="btn {{$item}}">
                                {{$value['text']}}
                            </a>                    
                        <?php }
                        echo "</p>";
                    }
                ?>
            
            </div>
        @endforeach
        </div>
    @endif

    
<?php
    
    if(Confide::user()){ //SE ESTIVER LOGADO... ?>

    @if  ( Session::has('notifications') )
        
        
        <div class="modal fade" id="notifications_modal">
            <div class="modal-dialog">
               
                <div class="modal-content modal-sm">                    
                    
                    <div class="alert-group" style="max-height:480px; overflow:auto;">
                        @foreach ( Session::get('notifications') as $notification )
                            
                                @include('notifications.item')
                            
                        @endforeach
                    </div>

                    <div class="modal-footer">
                        <a href="{{url('notifications')}}" class="btn btn-primary btn-sm" >Ver todas</a>                        
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fechar</button>                        
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    @endif

<?php } ?>

    @if ($errors)
        <div class="container">
            <!-- if there are creation errors, they will show here -->
            {{ HTML::ul($errors->all()) }}
        </div>
    @endif


        <!-- MAIN CONTENT -->
        @yield('content')
        <!-- /MAIN CONTENT -->



    {{-- <span class="loading btn-primary animated visible fadeIn" >
        <img src="{{asset('img/loading.gif')}}" class="img-responsive">
    </span> --}}

<div class="loading-splash hidden">
    <p class="loading-splash-content text-center">
        &nbsp;
        <img src="{{asset('/img/preloader.gif')}}" alt="" class="preloader flat animated">
        <br>
        Carregando...
    </p>
</div>

<style>
    .loading-splash-content {
      padding: 30px;
      font-size: 16px;
    }
</style>


    <!-- EMAIL Modal -->
    <div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="emailLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="false">&times;</span><span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">
                        <img src="{{asset('/img/preloader.gif')}}" alt="" class="preloader flat animated">
                        <br>
                        Um momento, por favor...
                        &nbsp;
                    </p>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="emailLabel" aria-hidden="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="false">&times;</span><span class="sr-only">Close</span>
            </button>
          </div>
          <div class="modal-body">
            {{-- <p class="text-center loading-splash text-center">
                <img src="{{asset('/img/preloader.gif')}}" alt="" class="preloader flat animated">
                <br>
                Um momento, por favor...
                &nbsp;
            </p> --}}
          </div>
          <div class="modal-body">
            <p class="text-center">
                &nbsp;
            </p>
          </div>
        </div>
      </div>
    </div>


    <!-- Transactions modals -->
    <div class="modal fade" id="transactions_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="false">&times;</span><span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">
                        <img src="{{asset('/img/preloader.gif')}}" alt="" class="preloader flat animated">
                        <br>
                        Um momento, por favor...
                        &nbsp;
                    </p>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    <!-- DOCK NAVBAR -->
    <!-- <nav id="dock" class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
        <div class="container">
            <div class="btn-toolbar text-center">
                <div class="btn-group">

                    @yield('dock')

                </div>
            </div>
        </div>
    </nav> -->



    <!-- Load JS here ++++++++++++++++++++++++++++++++++++++++++-->
    <!-- Bootstrap -->
    <?php
    echo HTML::script('js/jquery-1.11.1.min.js');
    //echo HTML::script('//code.jquery.com/ui/1.11.2/jquery-ui.js');
    echo HTML::script('js/jquery-ui.min.js');
    echo HTML::script('js/bootstrap.min.js');
    echo HTML::script('js/isotope.pkgd.js');
    ?>

    <!-- Bootflat's JS files.-->
    <?php
    echo HTML::script('js/icheck.min.js');
    echo HTML::script('js/jquery.fs.selecter.min.js');
    //echo HTML::script('js/jquery.fs.stepper.min.js');
    ?>

    <!-- Data Tables JS -->
    <!-- <script src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script src="http://cdn.datatables.net/plug-ins/725b2a2115b/integration/bootstrap/3/dataTables.bootstrap.js"></script>

    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>-->


    <?php
    echo HTML::script('js/bootbox.js');
    //echo HTML::script('js/less-1.7.3.min.js');
    //echo HTML::script('js/holder.js');
    echo HTML::script('js/jquery.transit.min.js');
    echo HTML::script('js/pushy.min.js');//MENU
    //echo HTML::script('js/jquery.searchable-1.0.0.min.js');
    echo HTML::script('js/jquery.autocomplete.min.js');
    echo HTML::script('js/jquery.price_format.min.js');
    echo HTML::script('js/jquery.mask.min.js');
    //echo HTML::script('js/tinymce/tinymce.min.js');
    
    echo HTML::style('js/bootstrap3-wysihtml5.css');
    
    // echo HTML::script('js/bootstrap-wysihtml5-0.0.2.min.js');
    echo HTML::script('js/bootstrap3-wysihtml5.min.js');
    echo HTML::script('js/bootstrap3-wysihtml5.all.min.js');
    //echo HTML::style('css/bootstrap.min.css');
    //echo HTML::script('js/jquery-1.7.2.min.js');
    //echo HTML::script('js/bootstrap.min.js');

    echo HTML::script('js/jquery.dynatable.js');

    echo HTML::script('js/jquery.timeago.js');

    echo HTML::script('js/moment-with-locales.min.js');
    //echo HTML::script('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.1.1/fullcalendar.min.js');

    //ANGULAR JS
    //echo HTML::script('js/angular.min.js');
    //echo HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.3.0/angular.min.js');
    
    //echo HTML::script("//ajax.googleapis.com/ajax/libs/angularjs/1.3.0/angular-resource.min.js");
    //echo HTML::script("//ajax.googleapis.com/ajax/libs/angularjs/1.3.0/angular-route.min.js");
    //echo HTML::script("//cdn.firebase.com/js/client/1.0.18/firebase.js");
    //echo HTML::script("//cdn.firebase.com/libs/angularfire/0.8.0/angularfire.min.js");


    // Bootcards JS    
    //echo HTML::script("//cdnjs.cloudflare.com/ajax/libs/bootcards/0.1.0/js/bootcards.min.js");

    

    // echo HTML::script('js/jquery/jquery.js');
    // echo HTML::script('js/jquery-ui/ui/jquery-ui.js');
    // echo HTML::script('js/angular/angular.js');
    // echo HTML::script('js/angular-ui-calendar/src/calendar.js');
    // echo HTML::script('js/fullcalendar/fullcalendar.js');
    // echo HTML::script('js/fullcalendar/gcal.js');

    echo HTML::script('js/bootstrap-datepicker.min.js');
    echo HTML::script('js/locales/bootstrap-datepicker.pt-BR.min.js');


    echo HTML::script('js/jquery-notifyjs/notify.min.js');
    echo HTML::script('js/jquery-notifyjs/styles/metro/notify-metro.js');

    echo HTML::script('js/notifications.js');

    echo HTML::script('js/scripts.js');


    ?>

    @yield('scripts')

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-33871454-5', 'auto');
        ga('send', 'pageview');
    </script>

</body>
</html>