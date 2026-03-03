<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title text-uppercase">
            <i class="icon icon-calendar"></i>&nbsp; Usuários</h3>
        </div>
        <div class="panel-body">
            <div class="pull-right">
                <div class="btn-group">
                    <a href="{{ url('users/create') }}" class="btn btn-success" data-toggle="modal" data-target="#modal">
                        <i class="fa fa-plus"></i> Adicionar
                    </a>
                </div>
            </div>

            <!-- /input-group -->
        </div>
        <div class="panel-body">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>E-mail</th>
                        <th></th>
                        <th class="text-right">Opções</th>                        
                    </tr>
                </thead>
                <tbody> 

                    @foreach ($users as $user)
                        <tr class="">
                            <td width="auto"><a href="{{ url('users/'.$user->id.'/edit') }}" data-target="#modal" data-toggle="modal">{{ $user->id }}</a></td>
                            <td><a href="{{ url('users/'.$user->id.'/edit') }}" data-target="#modal" data-toggle="modal">{{ $user->username }}</a></td>
                            <td>{{ $user->email }}</td>                        
                            <td><small>{{ ($user->confirmed) ? "Ativo" : "Pendente" }}</small></td>
                            <td class="text-right">
                                
                                    <a href="{{ url( 'emails/create/?mail_to=' . $user->email ) }}" class="btn btn-sm btn-primary" data-target="#modal" data-toggle="modal"><i class="fa fa-envelope"></i></a>                                    
                                    <a href="{{ url('users/'.$user->id.'/edit') }}" data-target="#modal" data-toggle="modal" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="{{url('users/'.$user->id.'/delete')}}" onclick="return confirm('Excluir este usuário?')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                                <div class="btn-group">
                                </div>

                            </td>                    
                        </tr>
                    @endforeach  
                        
                </tbody>
            </table>
           
        </div>
    </div>
</div>