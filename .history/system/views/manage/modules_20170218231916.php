<?php
$this->ul="list-group";
$this->li="list-group-item";
echo $this->menu($this->items);
//$this->stop=true;
echo $this->dump($this->nav($this->items));


	echo "<ul>";
	$path = $this->nav($this->items);
	$dir[] = $path;
	while (count($dir) != 0) {
		$v = array_shift($dir);
		foreach ($v as $k => $item) {
			if (is_array($item)) {
				$dir[] = $item;
				echo "<li>".$item[$k]."</li>";
			}
			else {
				echo "<li>".$item."</li>";
			}
		}
	}
	echo "</ul>";
?>