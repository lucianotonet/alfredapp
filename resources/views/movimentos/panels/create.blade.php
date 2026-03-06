<div class="panel panel-primary">
    <div class="panel-heading">
        <button type="button" class="close pull-right" data-dismiss="modal">
            <span aria-hidden="false">&times;</span><span class="sr-only">Close</span>
        </button>
        <h3 class="panel-title title">ADICIONAR MOVIMENTAÇÃO</h3>
    </div>            
    <div class="list-group" id="movimentos">     

    {{ Form::open(array('url' => 'movimentos')) }}

        <div class="list-group-item">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-6">
                    
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon bg-success title">
                            R$
                        </span>
                        <input type="text" name="valor" class="form-control mask money" placeholder="0,00" value="">
                    </div>
                </div><!-- /.col-lg-6 -->
                <div class="col-xs-12 col-sm-12 col-lg-3">
                
                    
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon bg-success">
                            <i class="fa fa-calendar-o"></i>
                        </span>                        
                        <input type="date" name="data" id="" class="form-control input-lg" value="<?php echo date('Y-m-d') ?>" />
                    </div>

                </div><!-- /.col-lg-6 -->
                <div class="col-xs-12 col-sm-12 col-lg-3">

                    <div class="input-group input-group-lg">
                        <a class="input-group-addon bg-info info" data-toggle="collapse" data-parent="#movimentos" href="#movimento_desc">
                            <i class="fa fa-reorder"></i>
                        </a>                        
                        <button type="submit" class="btn btn-success btn-lg form-control " href="#" ><i class='fa fa-check'></i> SALVAR</button>
                    </div>
                
              </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->         
         </div>
    
    {{Form::close()}}   
        

        <div id="movimento_desc" class="panel-collapse collapse collapsed bg-"> 
            <textarea name="desc" id="" cols="30" rows="10" class="form-control"></textarea>                    
        </div>

         <?php if( Request::ajax() ){ ?>
        <script>
        $(document).ready(function(){
            // 
            // Price Format
            // 
            $('.price').priceFormat({        
                prefix: '',
                centsSeparator: ',',
                thousandsSeparator: '.',
                allowNegative: true
            });

            $(".mask.money").mask("000.000.000,00");
        })
        </script>
        <?php } ?>
  
        
    </div>        

</div>