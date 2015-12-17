<!-- app/views/nerds/show.blade.php -->

<!DOCTYPE html>
<html>
<head>
	<title>Look! I'm CRUDding</title>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<a class="navbar-brand" href="{{ URL::to('products') }}">Nerd Alert</a>
	</div>
	<ul class="nav navbar-nav">
		<li><a href="{{ URL::to('products') }}">View All Nerds</a></li>
		<li><a href="{{ URL::to('prodcust/create') }}">Create a Nerd</a>
	</ul>
</nav>

<h1>Showing {{ $item->product_id }}</h1>

<?php echo Form::model($item, array('route' => array('products.update', $item->product_id))) ?>
</div>
</body>
</html>