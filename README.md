
# YMVC Framework 

Simple MVC framework for PHP 5.2+ (lower not tested) used XSLT and PHP views.

### Some info 

* For example use please look in system folder, more examples in future.
* Version 0.1.1 alfa

To use XSL mode in controller class "class Example extends XCoreRender" otherwise "class Example extends CoreRender".

### Some working Demo 

Working test on server you can see here's  [YMVC testing](http://ymvc.ydk2.tk/). 
Remember it is very early state of work.

### Is done

* Loaders for Views both XSLT and PHP
* Same functions names in both mode
* App scheme , some helpers
* Easy change views, models 
* Call PHP called class functions inside XSLT: 'php:function ($self,'function_name','arg1;arg2;...')'
* DB connector using PDO (Sqlite not memory, PoSQL class not included, MySQL)
* Errors support by "SystemExceptions" class 
* Example testing controllers with views in "system/controllers", "system/views" and sample model in "system/models"
* Added virtual functions: "onInit" called in constructor, "onRun" called in view, "onEnd“ called after view and "onDestruct" called in destructor.

### Now working on

* Routing and layouts

### Featured

* Multi locale support
* Routing from GET and array or DB table
* Files and directories helper, read write upload etc...
* And many more...


### Who do I talk to?

* [ydk2.tk](http://www.ydk2.tk/)
* info@ydk2.tk