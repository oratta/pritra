<!DOCTYPE html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="{{mix('css/app.css')}}"/>
</head>
<body>
<h1>Vue Sample</h1>
<div id="app">
    <navbar url={{url('/')}} appName={{config('app.name', 'Laravel')}}></navbar>
    <div class="container">
        <example></example>
        <hello name="Laravel"></hello>
        <hello name="ORATTA"></hello>
        <hello></hello>
    </div>
</div>
</body>
<script src="{{mix('js/sample_vue.js')}}"></script>
</html>