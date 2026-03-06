<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">       
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
        rel="stylesheet" type="text/css">
        <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css"
        rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/animate.min.css">

        <!-- CSS THEME -->        
        <link rel="stylesheet" href=""  id="bootstrap-theme-css">

        @yield('styles')

    </head>
    
    <body>

        <div class="section">
            
            <div class="container">

                @yield('content')

            </div>        

            <div class="container">
                <p class="text-center">
                    
                    <form action="" method="POST" class="form-inline" role="form">
                    
                        <div class="form-group">
                            <label class="" for="bootstrap-theme-changer">Bootstrap theme:</label>
                            <select name="" id="bootstrap-theme-changer" class="form-control">
                                <option value="">Padrão (nenhum)</option>
                                <option value="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">Bootstrap theme</option>
                            </select>
                        </div>
                    
                    </form>
                </p>            
            </div>

        </div>

        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <script>
            $.get("http://api.bootswatch.com/3/", function (data) {
                var themes = data.themes;
                var select = $("select#bootstrap-theme-changer");
                select.add;

                
                themes.forEach(function(value, index){
                    console.table(value);
                    select.append($("<option />")
                                  .val(value.cssMin)
                                  .text(value.name));
                });

                select.change(function(){
                    $("link#bootstrap-theme-css").attr("href", $(this).val());                    
                }).change();                    
                

            }, "json").fail(function(){
                alert("Falha ao carregar os temas!");
            });
        </script>  

        @yield('scripts')

    </body>

</html>