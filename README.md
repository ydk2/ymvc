# YMVC Framework #

Simple MVC framework for PHP 5.2+ (lower not tested) used XSLT and PHP views.

### Some info ###

* For example use please look in system folder, more examples in future.
* Version 0.1.1 alfa

### Some working Demo  ###

Working test on server you can see here's  [YMVC testing](http://ymvc.ydk2.tk/). 
Remember it is very early state of work.

### Is done ###

* Loaders for Views both XSLT and PHP
* Same functions names in both mode
* App scheme , some helpers
* Easy change views, models 
* Call PHP called class functions inside XSLT: 'php:function ($self,'function_name','arg1;arg2;...')'
* DB connector using PDO (Sqlite not memory, PoSQL class not included, MySQL)
* Errors support by "SystemExceptions" class 
* Example testing controllers with views in "system/controllers", "system/views" and sample model in "system/models"

### Featured ###

* Multi locale support
* Routing from GET and array or DB table
* Files and directories helper, read write upload etc...
* And many more...


### Who do I talk to? ###

* ydk2
* info@ydk2.tk