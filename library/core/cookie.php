<?php
/**
 * Created on Thu Mar 01 2018
 *
 * YMVC framework License
 * Copyright (c) 1996 - 2018 ydk2 All rights reserved.
 * 
 * YMVC version 3 fast and simple to use 
 * PHP MVC framework for PHP 5.4 + with PHP and XSLT files 
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * Redistribution and use of this software in source and binary forms, with or without modification,
 * are permitted provided that the following condition is met:
 * Redistributions of source code must retain the above copyright notice, 
 * this list of conditions and the following disclaimer.
 *   
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, 
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, 
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, 
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * For more information on the YMVC project, 
 * please see <http://ydk2.tk>. 
 *   
 **/

namespace Library\Core;

class Cookie
{
    /**
     * The array that stores the cookie
     *
     * @var array
     */
    protected $data = array();
    
    /**
     * Expiration time from now
     *
     * @var integer
     */
    protected $expire;
    /**
     * Domain for the website
     *
     * @var string
     **/
    protected $domain;
    
    /**
     * Cookie constructor
     * Default expiration is 28 days (28 * 3600 * 24 = 2419200).
     * Parameters:
     * @param string $cookie: $_COOKIE variable
     * @param integer $expire: expiration time for the cookie in seconds
     * @param string $domain: domain for the application `example.com`, `test.com`
     **/
    public function __construct($cookie, $expire = 2419200, $domain = null)
    {
        // Set up the data of this cookie
        $this->data = $cookie;
        
        $this->expire = $expire;
        
        if ($domain){
            $this->domain = $domain;
        }  else {
            $this->domain =
            isset($_SERVER['HTTP_X_FORWARDED_HOST']) ?
            $_SERVER['HTTP_X_FORWARDED_HOST'] :
            isset($_SERVER['HTTP_HOST']) ?
            $_SERVER['HTTP_HOST'] :
            $_SERVER['SERVER_NAME'];
        }
    }
    /**
     * getter
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return (isset($this->data[$name]))?$this->data[$name]:"";
    }
    /**
     * setter
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value = null)
    {
        // Check whether the headers are already sent or not
        if (headers_sent()){
            throw new \Exception("Can't change cookie " . $name . " after sending headers.");
        }
        
        // Delete the cookie
        if (!$value) {
            setcookie($name, null, time() - 10, '/', '.' . $this->domain, false, true);
            unset($this->data[$name]);
            unset($_COOKIE[$name]);
        } else {
            // Set the actual cookie
            setcookie($name, $value, time() + $this->expire, '/', $this->domain, false, true);
            $this->data[$name] = $value;
            $_COOKIE[$name] = $value;
        }
    }
}
?>