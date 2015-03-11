<?php
/*      Utilize alguma ferramenta de CSS Inline, como :
 *          * http://templates.mailchimp.com/resources/inline-css/
 *          * http://zurb.com/ink/inliner.php
 *          * http://inlinestyler.torchboxapps.com/
 *
 *      Cole o conteúdo inlinificado no arquivo "email.blade.php"
 *      
 **/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<!-- If you delete this meta tag, Half Life 3 will never be released. -->
<meta name="viewport" content="width=device-width">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>NOVO PEDIDO</title>
    
<style>
    /* ------------------------------------- 
        GLOBAL 
------------------------------------- */
* { 
    margin:0;
    padding:0;
}
* { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; font-size:0.99em !important;}

img { 
    max-width: 100%; 
}
.collapse {
    margin:0;
    padding:0;
}
body {
    -webkit-font-smoothing:antialiased; 
    -webkit-text-size-adjust:none; 
    width: 100%!important; 
    height: 100%;
}
small,  small ul li {
    font-size: 0.85em !important;
}
strong {
    font-weight: bold;
}


/* ------------------------------------- 
        ELEMENTS 
------------------------------------- */
a { color: #2BA6CB;}

.btn {
    text-decoration:none;
    color: #FFF;
    background-color: #666;
    padding:10px 16px;
    font-weight:bold;
    margin-right:10px;
    text-align:center;
    cursor:pointer;
    display: inline-block;
}

p.callout {
    padding:15px;
    background-color:#ECF8FF;
    margin-bottom: 15px;
}
.callout a {
    font-weight:bold;
    color: #2BA6CB;
}

table.social {
/*  padding:15px; */
    background-color: #ebebeb;
    
}
.social .soc-btn {
    padding: 3px 7px;
    font-size:12px;
    margin-bottom:10px;
    text-decoration:none;
    color: #FFF;font-weight:bold;
    display:block;
    text-align:center;
}
a.fb { background-color: #3B5998!important; }
a.tw { background-color: #1daced!important; }
a.gp { background-color: #DB4A39!important; }
a.ms { background-color: #000!important; }

.sidebar .soc-btn { 
    display:block;
    width:100%;
}

/* ------------------------------------- 
        HEADER 
------------------------------------- */
table.head-wrap { width: 100%;}


.header.container table td.logo { padding: 15px; }
.header.container table td.label { padding: 15px; padding-left:0px;}


/* ------------------------------------- 
        BODY 
------------------------------------- */
table.body-wrap {
    width: 100%;
    background: #f5f5f5;
}
.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th {
    background-color: #f9f9f9
}

.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th {
    background-color: #f5f5f5
}
.table>thead>tr>th,.table>tbody>tr>th,.table>tfoot>tr>th,.table>thead>tr>td,.table>tbody>tr>td,.table>tfoot>tr>td {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd
}

.table>thead>tr>th {
    vertical-align: bottom;
    border-bottom: 2px solid #ddd;
    padding: 0px 8px;
}

.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>th,.table>caption+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>td,.table>thead:first-child>tr:first-child>td {
    border-top: 0
}

.table>tbody+tbody {
    border-top: 2px solid #ddd
}

.table .table {
    background-color: #fff
}

.table-condensed>thead>tr>th,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>tbody>tr>td,.table-condensed>tfoot>tr>td {
    padding: 5px
}

.table-bordered {
    border: 1px solid #ddd
}

.table-bordered>thead>tr>th,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>tbody>tr>td,.table-bordered>tfoot>tr>td {
    border: 1px solid #ddd
}

.table-bordered>thead>tr>th,.table-bordered>thead>tr>td {
    border-bottom-width: 2px
}

.table-striped>tbody>tr:nth-child(odd)>td,.table-striped>tbody>tr:nth-child(odd)>th {
    background-color: #f9f9f9
}

.table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th {
    background-color: #f5f5f5
}


/* ------------------------------------- 
        FOOTER 
------------------------------------- */
table.footer-wrap { width: 100%;    clear:both!important;
}
.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
.footer-wrap .container td.content p {
    font-size:10px;
    font-weight: bold;
    
}


/* ------------------------------------- 
        TYPOGRAPHY 
------------------------------------- */
h1,h2,h3,h4,h5,h6 {
font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
line-height: 1;
margin-bottom: 2px;
color: #000;
font-weight: bold;
margin-top: 0px;
}
h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

h1 { font-weight:200; font-size: 44px;}
h2 { font-weight: "bold"; font-size: 20px !important; }
h3 { /* font-weight:500; */ font-size: 27px; border-bottom: 1px solid rgb(221, 221, 221);}
h4 { font-weight:"bold"; font-size: 23px; border-bottom: 1px solid rgb(221, 221, 221);}
h5 { font-weight:900; font-size: 17px;}
h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

h4 {    
    font-size: 23px;
    border-bottom: 1px solid rgb(221, 221, 221);
    background: #808080;
    color: #fff;
    font-weight: 300;
    padding: 3px;
}

.collapse { margin:0!important;}

p, ul { 
    margin-bottom: 10px; 
    font-weight: normal; 
    font-size:14px; 
    line-height: 1;
}
p.lead { font-size:17px; }
p.last { margin-bottom:0px;}

ul li {
    margin-left:5px;
    list-style-position: inside;
}

/* ------------------------------------- 
        SIDEBAR 
------------------------------------- */
ul.sidebar {
    background:#ebebeb;
    display:block;
    list-style-type: none;
}
ul.sidebar li { display: block; margin:0;}
ul.sidebar li a {
    text-decoration:none;
    color: #666;
    padding:10px 16px;
/*  font-weight:bold; */
    margin-right:10px;
/*  text-align:center; */
    cursor:pointer;
    border-bottom: 1px solid #777777;
    border-top: 1px solid #FFFFFF;
    display:block;
    margin:0;
}
ul.sidebar li a.last { border-bottom-width:0px;}
ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}



/* --------------------------------------------------- 
        RESPONSIVENESS
        Nuke it from orbit. It's the only way to be sure. 
------------------------------------------------------ */

/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
.container {
    display: block!important;
    max-width: 700px !important;
    margin: 0 auto!important;
    clear: both!important;
    padding: 0px 20px;
}

/* This should also be a block element, so that it will fill 100% of the .container */
.content {
    padding: 8px 0px;
    /*max-width:700px;*/
    margin:0 auto;
    display:block; 
}

/* Let's make sure tables in the content area are 100% wide */
.content table { width: 100%; }


/* Odds and ends */
.column {
    width: 300px;
    float:left;
}
.column tr td { padding: 15px; }
.column-wrap { 
    padding:0!important; 
    margin:0 auto; 
    max-width:600px!important;
}
.column table { width:100%;}
.social .column {
    width: 280px;
    min-width: 279px;
    float:left;
}

/* Be sure to place a .clear element after each set of columns, just to be safe */
.clear { display: block; clear: both; }


/* ------------------------------------------- 
        PHONE
        For clients that support media queries.
        Nothing fancy. 
-------------------------------------------- */
@media only screen and (max-width: 600px) {
    
    a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

    div[class="column"] { width: auto!important; float:none!important;}
    
    table.social div[class="column"] {
        width:auto!important;
    }

}
td, th {
vertical-align: top;
}
</style>

<style type="text/css"></style></head>
 
<body bgcolor="#FFFFFF">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#3bafda" style="background-color:#3bafda;">
    <tbody  bgcolor="#3bafda">
        <tr  bgcolor="#3bafda">
            <td  bgcolor="#3bafda"></td>
            <td class="header container"  bgcolor="#3bafda">
                    
                <div class="content" style="background-color:#3bafda;">
                    <table bgcolor="#3bafda">
                        <tbody bgcolor="#3bafda">
                            <tr bgcolor="#3bafda">
                                <td>
                                    <h2 class="collapse" style="color: #fff;">PEDIDO nº {{$pedido->id}}</h6>
                                </td>
                                <td align="right" style="">
                                    <h2 class="collapse" style="color: #fff;">{{$pedido->data}}</h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                    
            </td>
            <td bgcolor="#3bafda"></td>   
        </tr>
    </tbody>
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap">
    <tbody>
        <tr>
            <td></td>
            <td class="container" bgcolor="#FFFFFF">

                <div class="content">

                    <table>
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <h4>CLIENTE</h4>
                                    <strong>
                                        {{ $pedido->cliente->nome }}
                                    </strong>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="33%">

                                    <p>
                                        {{ ($pedido->cliente->telefone) ? $pedido->cliente->telefone.'<br />' : '' }}
                                        {{ ($pedido->cliente->celular) ? $pedido->cliente->celular.'<br />' : '' }}                                        
                                        {{ $pedido->cliente->email }}<br />
                                    </p>
                                
                                </td>

                                <td width="33%">
                                    <p>
                                        {{ $pedido->cliente->empresa }}<br />
                                        CNPJ: {{ $pedido->cliente->cnpj }}<br />
                                        IE: {{ $pedido->cliente->ie }} 
                                    </p>
                                </td>
                                <td width="33%">
                                    <p>
                                        {{ ($pedido->cliente->endereco) ? $pedido->cliente->endereco.'<br />' : '' }}
                                        {{ ($pedido->cliente->bairro) ? 'Bairro '.$pedido->cliente->bairro.'<br />' : '' }}
                                        {{ ($pedido->cliente->cidade) ? $pedido->cliente->cidade.' - '.$pedido->cliente->uf.'<br />' : '' }}
                                        {{ ($pedido->cliente->cep) ? $pedido->cliente->cep.'<br />' : '' }}
                                    </p>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <table>
                        <tr>
                            <td>
                               &nbsp;
                            </td>
                        </tr>
                    </table>

                    
                    <table>
                        <tbody>
                            
                            <tr>
                                

                                <td  width="66%">
                                    
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td colspan="2">
                                                    <h4>FORNECEDOR</h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="50%">
                                                    <strong>{{($pedido->fornecedor->empresa) ? $pedido->fornecedor->empresa : @$pedido->fornecedor->nome }}</strong>                        
                                                    <p>
                                                        {{ ($pedido->fornecedor->empresa) ? @$pedido->fornecedor->nome. '<br>' : '' }}
                                                        {{ ($pedido->fornecedor->telefone) ? $pedido->fornecedor->telefone . '<br>' : '' }}
                                                        {{ ($pedido->fornecedor->celular) ? $pedido->fornecedor->celular . '<br>' : '' }}
                                                        CNPJ: {{$pedido->fornecedor->cnpj}}   <br />                                    
                                                        IE: {{$pedido->fornecedor->ie}}   
                                                    </p>
                                                </td>
                                                <td width="50%">                                                
                                                    <p>
                                                        {{ ($pedido->fornecedor->endereco) ? $pedido->fornecedor->endereco.'<br />' : '' }}
                                                        {{ ($pedido->fornecedor->bairro) ? $pedido->fornecedor->bairro.'<br />' : '' }}
                                                        {{ ($pedido->fornecedor->cidade) ? $pedido->fornecedor->cidade.'/'.@$pedido->fornecedor->uf.'<br />' : ''}}
                                                    </p>
                                                </td>
                                            </tr>                                        
                                        </tbody>
                                    </table>
                                    
                                </td>
                                <td  width="33%">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h4>VENDEDOR</h4>
                                                    <strong>{{$pedido->vendedor->nome}}</strong>
                                                    <br />
                                                    {{ ($pedido->vendedor->telefone) ? $pedido->vendedor->telefone . '<br>' : '' }}
                                                    {{ ($pedido->vendedor->celular) ? $pedido->vendedor->celular . '<br>' : '' }}
                                                    {{ ($pedido->vendedor->email) ? $pedido->vendedor->email . '<br>' : '' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>                                  
                                </td>
                            </tr>
                        </tbody>
                    </table>
                            

                    <table>
                        <tr>
                            <td>
                               &nbsp;
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td>

                                <table>
                                    <tbody>
                                        <tr>
                                            <td colspan="3">
                                                <h4>ENTREGA</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="33%">
                                                <p>
                                                    <strong>FRETE</strong><br />
                                                    {{$pedido->frete}}                                                    
                                                </p>
                                            </td>                                        
                                            <td width="33%">
                                                <p>
                                                    <strong>Data</strong><br />
                                                    <strong style="font-size:110% !important;">{{$pedido->entrega_data}}</strong><br />
                                                    <small><?php //echo AboutDate::diaDaSemana($pedido->entrega_data) ?></small>
                                                    <small><?php //echo AboutDate::getCreatedAtAttribute($pedido->created_at) ?></small>
                                                    
                                                    <!-- <small>{{-- AboutDate::date($pedido->entrega_data, 'l') --}}</small> -->
                                                </p>
                                            </td>                                        
                                            <td width="33%">
                                                <p>
                                                    <strong>Endereço</strong><br />
                                                    {{$pedido->entrega_endereco}} 
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td>
                               &nbsp;
                            </td>
                        </tr>
                    </table>

                        
                    <table>
                        <tr>
                            <td>
                                <h4>PRODUTOS</h4>                                
                            </td>
                        </tr>
                    </table>


                    <table class="table table-striped table-hover">
                        <thead class="bg-info">                            
                            <tr>
                                <th width="65">Qtd.</th>   
                                <th width="35">cód</th>            
                                <th>Produto</th>
                                <th width="65">acab.</th>
                                <th width="75" align="right">Preço</th>
                                <th width="100" align="right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>       
                            <?php foreach ($pedido->itens as $item){ ?>
                            <tr>
                                <td align="center"  width="65">{{ $item['qtd'] }} {{ $item['unidade'] }}</td>
                                <td align="center">{{ @$item['produto']->cod }}</td>
                                <td>{{ @$item['produto']->nome }}</td>
                                <td width="65">{{ @$item['acabamento']->name }}</td>
                                <td align="right">R$ <span class="price">{{ $item['preco'] }}</span></td>
                                <td align="right">R$ <span class="price">{{ $item['subtotal'] }}</span></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <br />

                    <table>
                        <tbody>
                            <tr>
                                <td style="padding: 10px;  border-left: 1px solid #cecece;  border-right: 1px solid #cecece;">
                                    <strong>PAGAMENTO:</strong>
                                    <p>{{$pedido->pgto}}</p>
                                </td>
                                <td style="text-align:right;">                                    
                                    <em class="">Total</em>                    
                                    <h2 style="text-align:right;">
                                        <i style="font-size: 0.6em !important;">R$</i> {{$pedido->total}}
                                    </h2>                                                                            
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    

                    <table>
                        <tr>
                            <td>
                               &nbsp;
                            </td>
                        </tr>
                    </table>

                    <hr />
                    
                    <div style="padding: 10px;  border-left: 1px solid #cecece;  border-right: 1px solid #cecece;">
                        <strong>Observações:</strong>
                        <br />
                        <p>{{$pedido->obs}}</p>
                    </div>

                    <hr />

                    <table>
                        <tr>
                            <td>
                               &nbsp;
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tbody>
                            <tr>
                                <td width="50%">
                                    <small>
                                        <strong>Observações complementares:</strong>
                                        <ul>
                                            <li>Material de origem natural. estando sujeito à sofrer variações em sua tonetlidade ou veios.</li>
                                            <li>O material deve ser conferido do ato do descarregamento.</li>
                                            <li>Cessando nossa responsabilidade de uma vez entregue, não aceitamos reclamações posteriores.</li>
                                            <li>Havendo variações no quantitaitvo fornecido prevalece o preço unitário</li>
                                            <li>Para efeitos de medidas, peças com largura menor que 15cm considera-se 15cm</li>
                                            <li>Para cancelamento de pedidos multa de 20% do valor total do pedido.</li>
                                        </ul>
                                    </small>
                                </td>
                                <td width="50%">
                                    <small>
                                        <strong>Será fornecido pelo cliente:</strong>
                                        <ul>
                                            <li>Descarga do meterial</li>
                                            <li>Preparação da cancha</li>
                                            <li>Serventes para os pedreiros</li>
                                            <li>Estadia para os pedreiros</li>
                                            <li>Material para a fixação (cimento, areia, buchas, parafusos, etc.)</li>
                                            <li>Pontos de água, luz e bitoneira.</li>
                                        </ul>
                                    </small>
                                </td>
                            </tr>    
                        </tbody>

                    </table>

                    <hr />                    

                    <table>
                        <tr>
                            <td>
                               &nbsp;
                            </td>
                        </tr>
                    </table>

                    
                    <table>
                        <tbody>
                            <tr>
                                <td width="60%" style="border:solid 1px #cecece; padding: 10px;">
                                    <small>
                                        <strong>CLIENTE:</strong>
                                        &nbsp;
                                    </small>
                                </td>
                                <td width="40%" style="border:solid 1px #cecece; padding: 10px;">
                                    <small>
                                        <strong>CPF:</strong>
                                        &nbsp;
                                    </small>
                                </td>
                            </tr>    
                            <tr>
                                <td width="60%" style="border:solid 1px #cecece; padding: 10px;">
                                    <small>
                                        <strong>VENDENDOR:</strong>
                                        &nbsp;
                                    </small>
                                </td>
                                <td width="40%" style="border:solid 1px #cecece; padding: 10px;">
                                    <small>
                                        <strong>TEL:</strong>
                                        &nbsp;
                                    </small>
                                </td>
                            </tr>    
                        
                        </tbody>

                    </table>


                    <table>
                        <tr>
                            <td>
                               &nbsp;
                            </td>
                        </tr>
                    </table>



            </div><!-- /content -->
                                    
        </td>
        <td></td>
    </tr>
</tbody></table><!-- /BODY -->

<!-- FOOTER -->
<!-- <table class="footer-wrap" style="background: #e6e9ed;">
    <tbody><tr>
        <td></td>
        <td class="container"> -->
            
                <!-- content -->
                <!-- <div class="content">
                <table>
                <tbody><tr>
                    <td align="center"> -->
                        <!-- <p>
                            <a href="#">Terms</a> |
                            <a href="#">Privacy</a> |
                            <a href="#"><unsubscribe>Unsubscribe</unsubscribe></a>
                        </p> -->
                    <!-- </td>
                </tr>
            </tbody></table>
                </div> --><!-- /content -->
                
        <!-- </td>
        <td></td>
    </tr>
</tbody></table> --><!-- /FOOTER -->


</body></html>