@extends('layouts.master')

@section('content')
   
        
        <?php   
            use Faker\Factory as Faker;
            $faker = Faker::create('pt_BR');
        ?>            
        

    <div class="container">    
        
        <ul class="timeline">
            <li data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                <h1 class="title timeline-title">HOJE <small>22 de Outubro <br>Quarta-feira</small> </h1>
            </li>
        
            <li>
                <ul id="collapseOne" class="timeline panel-collapse collapse in">
                    
                    <li>
                        <div class="panel panel-primary">
                              <div class="panel-heading">
                                    <h3 class="panel-title title"><i class="icon-directions-car"></i> VISITA</h3>
                              </div>
                              <div class="panel-body">
                                    Panel content
                              </div>
                        </div>
                    </li>

                    <li>
                        <div class="panel panel-primary">
                              <div class="panel-heading">
                                    <h3 class="panel-title title"><i class="fa fa-phone"></i> Ligação</h3>
                              </div>
                              <div class="panel-body">
                                    Panel content
                              </div>
                        </div>
                    </li>

                    <li>
                        <div class="panel panel-primary">
                              <div class="panel-heading">
                                    <h3 class="panel-title title"><i class="icon-paper"></i> RELATÓRIO</h3>
                              </div>
                              <div class="panel-body">
                                    Panel content
                              </div>
                        </div>
                    </li>


                </ul>
            </li>


            <li>
                <h1 class="title timeline-title">AMANHÃ <small>25 de julho<br>Terça-feira</small> </h1>
            </li>

            <li>
                <div class="panel panel-primary bootcards-file">

                  <div class="panel-heading">
                    <h3 class="panel-title title">File</h3>
                  </div>
                  <div class="list-group">
                    <div class="list-group-item">
                      <a href="#">
                        <i class="icon-file-pdf"></i>
                      </a>
                      <h4 class="list-group-item-heading">
                        <a href="#">Title</a>
                      </h4>
                      <p class="list-group-item-text"><strong>PDF</strong></p>
                      <p class="list-group-item-text"><strong>3.2Mb</strong></p>
                    </div>
                    <div class="list-group-item">
                      <p class="list-group-item-text"><strong>Added by Jack Herbert on 5 Mar 2014</strong></p>
                    </div>
                    <div class="list-group-item">
                      <p class="list-group-item-text">Description...</p>
                    </div>      
                  </div>
                  <div class="panel-footer clearfix">
                    <div class="btn-group btn-group-justified">
                      <div class="btn-group">
                        <button class="btn btn-default">
                          <i class="fa fa-arrow-down"></i>
                          Download  
                        </button>
                      </div>
                      <div class="btn-group">
                        <button class="btn btn-default">
                          <i class="fa fa-star"></i>
                          Favorite  
                        </button>
                      </div>
                      <div class="btn-group">
                        <button class="btn btn-default">
                          <i class="fa fa-envelope"></i>
                          Email 
                        </button>
                      </div>
                    </div>
                  
                  </div>  

                </div>
            </li>
            
        </ul>
    
    </div>

    <style>
    .panel {
        margin-bottom: 0px;
    }
    .timeline{

    }
    .timeline li .timeline-title{
        border-bottom: 1px solid #cecece;
    }
    .timeline li:before{
        border-left: 1px solid rgb(203, 203, 203);
        content: "";
        position: relative;
        margin-left: 20px;
        height: 20px;
        display: -webkit-box;
        top: 0px;  
    }
    .timeline > li > .timeline-badge {
        color: #fff;
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 1.4em;
        text-align: center;
        position: absolute;
        top: 16px;
        left: 50%;
        margin-left: -25px;
        background-color: #999999;
        z-index: 100;
        border-top-right-radius: 50%;
        border-top-left-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    }
    .timeline li:first-child:before{        
        display: none;        
    }
    .timeline li:first-child:before .title{        
        margin-top: 0px;
        padding-top: 0px;
    }
    .timeline li{
        margin: 0px;
    }
    </style>
        
@stop