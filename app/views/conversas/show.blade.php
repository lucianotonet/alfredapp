@extends('layouts.master')

@section('content')

<div class="container" id="conversas">

    <div class="panel panel-primary">
        <div class="panel-heading">
        
            <h3 class="panel-title title">
                <span class="icon-chat"></span><span class="mls">
                Conversa
            </h3>
    
        </div>          
        <div class="row">
            <div class="tab-content col-md-10">
                <div class="tab-pane active" id="tab_a">
                    <h4>Pane A</h4>
                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames
                        ac turpis egestas.</p>
                </div>
                <div class="tab-pane" id="tab_b">
                    <h4>Pane B</h4>
                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames
                        ac turpis egestas.</p>
                </div>
                <div class="tab-pane" id="tab_c">
                    <h4>Pane C</h4>
                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames
                        ac turpis egestas.</p>
                </div>
                <div class="tab-pane" id="tab_d">
                    <h4>Pane D</h4>
                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames
                        ac turpis egestas.</p>
                </div>
            </div><!-- tab content -->                
            <ul class="list-group list-group-vertical col-md-2">
                <li class="list-group-item active" data-target="#tab_a" data-toggle="pill">
                    <a>Pill A</a>
                </li>
                <li class="list-group-item" data-target="#tab_b" data-toggle="pill">
                    <a>Pill B</a>
                </li>
                <li class="list-group-item" data-target="#tab_c" data-toggle="pill">
                    <a>Pill C</a>
                </li>
                <li class="list-group-item" data-target="#tab_d" data-toggle="pill">
                    <a>Pill D</a>
                </li>
            </ul>
        </div>            
    </div>
</div><!-- end of container -->

<div class="container">
    @include('conversas.panels.show')
</div>


@stop