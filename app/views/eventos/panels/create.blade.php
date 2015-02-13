<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title title">ADICIONAR EVENTO</h3>
    </div>
    <div class="list-group">
        <div class="list-group-item">
            

            <div class="form-group">
                <input type="text" class="form-control input-lg" id="title" name="title" placeholder="Título">
            </div>

            <div class="form-group row">                
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="input-group date">
                        <span class="input-group-addon primary"><span class="icon-calendar"></span></span>
                        <input type="date" class="form-control input-lg" id="start-date" name="start" required>                    
                        <span class="input-group-addon primary"><span class="icon-clock"></span></span>
                        <input type="time" class="form-control input-lg" id="start-time" name="start-time" >
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="input-group date">
                        <span class="input-group-addon primary">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="" class="primary">                                    
                                </label>
                            </div>
                        </span>
                        <input type="date" class="form-control input-lg" id="start-date" name="start" required>                    
                        <span class="input-group-addon primary"><span class="icon-clock"></span></span>
                        <input type="time" class="form-control input-lg" id="start-time" name="start-time" >
                    </div>

                </div>
            </div>

            <div class="form-group" id="end-group">
                <label for="end" class="col-sm-3 control-label">End</label>
                <div class="input-group col-sm-6 form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="end" data-link-format="yyyy-mm-dd">
                    <input type="text" class="form-control" placeholder="End Date" name="end-date" id="end-date" readonly="readonly" style="background-color: white; cursor: default;">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
                <div class="col-sm-3">
                    <input name="end-time" id="end-time" class="form-control" readonly="readonly" style="background-color: white; cursor: default;">
                    <div class="time-panel" id="time-panel-end">
                        
                    </div>
                </div>
            </div>
                           
        </div>
        <div class="list-group-item"></div>
        <div class="list-group-item"></div>
    </div>
    <div class="panel-footer">
        <a href="#" class="btn btn-primary btn-sm">
            <i class="fa fa-chevron-left"></i>
        </a>
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-primary btn-sm">Left</button>
            <button type="button" class="btn btn-primary btn-sm">Middle</button>
            <button type="button" class="btn btn-primary btn-sm">Right</button>
        </div>
    </div>
</div>

<a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Trigger modal</a>
<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


