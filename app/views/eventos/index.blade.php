@extends('layouts.master')

@section('content')

    <div class="container">        


        <div class="panel panel-primary">
              <div class="panel-heading">
                    <h3 class="panel-title title">EVENTOS</h3>
              </div>
              <div class="panel-body">
                    
                
                <style>                    
                    #loading {
                        position: absolute;
                        top: 5px;
                        right: 5px;
                        }
                    #calendar {
                        
                        } 
                </style>
                
                <div id='loading' style='display:none'>loading...</div>
                <div id='calendar'></div>
                <p>json.php needs to be running in the same directory.</p>


              </div>
        </div>

    </div>

@stop