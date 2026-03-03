<div class="list-group">
	<a class="list-group-item {{ ( $module == 'general' ) ? 'active' : '' }}" href="{{ url('settings/') }}">Geral</a>
	<a class="list-group-item {{ ( $module == 'email' ) ? 'active' : '' }}" href="{{ url('settings/email') }}">E-mail</a>
	<a class="list-group-item {{ ( $module == 'pedidos' ) ? 'active' : '' }}" href="{{ url('settings/pedidos') }}">Pedidos</a>
	<a class="list-group-item {{ ( $module == 'notifications' ) ? 'active' : '' }}" href="{{ url('settings/notifications') }}">Notificações</a>
	<a class="list-group-item {{ ( $module == '' ) ? 'active' : '' }}" href="{{ url('settings/advanced') }}">Avançado</a>
</div>