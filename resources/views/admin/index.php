<!doctype html>
<html ng-app="App" ng-controller="appController">
<head>

    <meta charset="utf-8">
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <meta name="description" content="{{ ui.metaDescription }}">
    <meta name="keywords" content="{{ ui.metaKeywords }}">

    <link media="all" type="text/css" rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="bower_components/font-awesome-4.2.0/css/font-awesome.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="bower_components/angular-loading-bar/build/loading-bar.css"/>
    <link media="all" type="text/css" rel="stylesheet" href="bower_components/angular-bootstrap-lightbox/dist/angular-bootstrap-lightbox.css"/>

    <!-- CSS Files -->
    <link href="backend/css//style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
</head>

<body>

<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Admin</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <h1>Navbar example</h1>
        <p>This example is a quick exercise to illustrate how the default, static and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
        <p>To see the difference between static and fixed top navbars, just scroll.</p>
        <p>
            <a class="btn btn-lg btn-primary" href="../../components/#navbar" role="button">View navbar docs &raquo;</a>
        </p>
    </div>

</div> <!-- /container -->

<footer id="footer-area">

</footer>
</body>
</html>