<html>
<head>
    <title></title>
    {{ HTML::script('js/libs/jquery-min.js') }}
    {{ HTML::script('js/test.js') }}
    {{ HTML::script('js/libs/tipsy.js') }}
</head>
<body>
    <p title="hello">Helo</p>
    <p>World</p>
</body>
<script type="text/javascript">
    // $('p').testFunc();
    $('p').tipsy();
</script>
</html>