<html>

 
<head>

 <title>Exemplo de implementação de barra de progresso usando JQuery com PHP</title>

 <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" />

 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

 <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script> 

</head>

<body>

 
 <iframe id="hiddenframe" style="display: none;" src="about:blank"></iframe>

 
 <button onclick="$('#hiddenframe').attr('src', 'http://magentotovtex.local/MagentoToVtex.php')">Processar Algo!</button><br /><br />

 <div id="progresso" style="width: 200px; height: 15px;"></div>

 
 <script>

 $(function() {

  $("#progresso").progressbar({ value: 0 });

 });

 </script> 

 
</body>

