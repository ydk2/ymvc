<!DOCTYPE html>
<html lang="pl">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?=$this->ViewData('title');?></title>
</head>
<body>
<div>
<h3><?=$this->ViewData('title');?></h3>
<div><?=$this->ViewData('content');?></div>
<div><?=$this->ViewData('message');?></div>
<div><?=self::Call('test');?></div>
<div><?=$this->getParameter('', 'test');?></div>
</div>
</body>
</html>
