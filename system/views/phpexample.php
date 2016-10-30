<!DOCTYPE html>
<html lang="<?=$this->ViewData('lang')?>">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
<?=$this->ViewData('title');?>
</title>

<!-- Bootstrap CSS -->
<link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

<?=$this->getParameter('','fixie');?>
<script src="https://cdn.polyfill.io/v1/polyfill.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<style>
html, body {
width: 100%;
height: 100%;
}
.main {
position: relative;
clear: both;
width: 100%;
min-height: 50%;
}
.footer {
position: relative;
clear: both;
width: 100%;
}
</style>
</head>

<body>


<nav class="navbar navbar-default">
<div class="container">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="#"><span><?=$this->ViewData('maintitle');?></span></a>
</div>
<div class="collapse navbar-collapse" id="navbar-ex-collapse">
<ul class="nav navbar-nav navbar-right">

<?php foreach ($this->ViewData('links')->items as $value): ?>
<li><a href="<?=$value['href'];?>"  hreflang="<?=$value['hreflang'];?>"><?=$value?></a></li>
<?php endforeach; ?>

</ul>
</div>
</div>
</nav>

<header class="section">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="page-header">
<h1><?=$this->ViewData('header');?>
<small> <?=$this->ViewData('smallheader');?></small>
</h1>
</div>
</div>
</div>
</div>
</header>


<main class="main">

<section class="section">
<div class="container">
<div class="row">
<div class="col-md-2">
<ul class="list-group">
<?php foreach ($this->ViewData('list')->items as $value): ?>
<li class="list-group-item"><a href="<?=$value['href'];?>"><?=$value;?></a></li>
<?php endforeach; ?>
</ul>
</div>
<div class="col-md-10">
<div class="well">
<h2><?=$this->ViewData('subheader');?></h2>
<p>
<?=$this->ViewData('content');?>
</p>
</div>
</div>
</div>
</div>
</section>

</main> <!-- main -->


<footer class="section footer">
<div class="container">
<div class="row">
<div class="col-sm-6">
<h3><?=$this->ViewData('footerheader');?></h3>
<p><?=$this->ViewData('footercontent');?></p>
</div>
<div class="col-sm-6">
<div class="row">
<div class="col-md-12 text-right">
<a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
<a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
<a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
<a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
</div>
</div>
</div>
</div>
</div>
</footer>


</body>

</html>