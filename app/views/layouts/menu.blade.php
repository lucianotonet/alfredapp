<!-- Pushy Menu -->
<nav class="pushy pushy-left navbar-inverse">
   <!--  <div class="well-sm">
    
        {{Confide::user() ? Confide::user()->username : ''}}

    </div> -->
    <ul class="btn-group-vertical text-left">        
        <li class="active ">
            <a href="<?php echo url('/pedidos'); ?>">
                <i class="fa fa-pencil-square-o"></i> Pedidos                 
            </a>
        </li>
        <li class="">
            <a href="<?php echo url('/tarefas'); ?>">
                <i class="fa fa-check-square-o"></i> Tarefas 
            </a>
        </li>
        <li class="">
            <a href="<?php echo url('/clientes'); ?>">            
                <i class="fa fa-users"></i> Clientes  
            </a>
        </li>
        <li class="">
            <a href="<?php echo url('/produtos'); ?>">
                
                <i class="fa fa-bookmark-o"></i> Produtos  
                
            </a>
        </li>
        <li class="">
            <a href="<?php echo url('/fornecedors'); ?>">
               <i class="fa fa-briefcase"></i> Fornecedores  
            </a>
        </li>
        <li class="">
            <a href="<?php echo url('/vendedors'); ?>">
                 <i class="fa fa-group"></i> Vendedores
            </a>
        </li>        
        <li class="active">
            <a href="<?php echo url('/financeiro/dashboard'); ?>">
                <i class="fa fa-money"></i> Financeiro 
            </a>
        </li>        
        <li class="">
            <a href="<?php echo url('/relatorios'); ?>">
                 <i class="fa fa-file-pdf-o"></i> Relatórios
            </a>
        </li>    
        <li class="">
            <a href="<?php echo url('/settings'); ?>">
                 <i class="fa fa-cog"></i> Confgurações
            </a>
        </li>    
        <li><a href="<?php echo url('/logout'); ?>"><i class="fa fa-sign-out"></i> Sair</a></li>
    </ul>

</nav>      
