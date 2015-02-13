<!-- Pushy Menu -->
<nav class="pushy pushy-left navbar-inverse">
   <!--  <div class="well-sm">
    
        {{Confide::user() ? Confide::user()->username : ''}}

    </div> -->
    <ul class="btn-group-vertical text-right">        
        <li class="active ">
            <a href="<?php echo url('/pedidos'); ?>">
                    Pedidos <i class="fa fa-pencil-square-o"></i>                 
            </a>
        </li>
        <li class="">
            <a href="<?php echo url('/tarefas'); ?>">
                Tarefas <i class="icon-square-check"></i> 
            </a>
        </li>
        <li class="">
            <a href="<?php echo url('/clientes'); ?>">
                
                    Clientes <i class="fa fa-users"></i> 
                
            </a>
        </li>
        <li class="">
            <a href="<?php echo url('/produtos'); ?>">
                
                    Produtos <i class="fa fa-bookmark-o"></i> 
                
            </a>
        </li>
        <li class="">
            <a href="<?php echo url('/fornecedors'); ?>">
                Fornecedores  <i class="fa fa-briefcase"></i> 
            </a>
        </li>
        <li class="">
            <a href="<?php echo url('/vendedors'); ?>">
                Vendedores <i class="fa fa-group"></i> 
            </a>
        </li>        
        <li class="">
            <a href="<?php echo url('/relatorios'); ?>">
                Relatórios <i class="fa fa-graph"></i> 
            </a>
        </li>    
        <li class="active">
            <a href="<?php echo url('/financeiro/dashboard'); ?>">
                <h3 class="title"><i class="icon-dollar"></i> FINANCEIRO</h3>
            </a>
        </li>        
        <li><a href="<?php echo url('/logout'); ?>"><i class="fa fa-sign-out"></i> Sair</a></li>
    </ul>

</nav>      
