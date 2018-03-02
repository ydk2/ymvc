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

class Data 
{

    /**
     * __get
     * @param mixed $property 
     * @return mixed 
     */
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    
    /**
     * __set
     * @param mixed $property 
     * @param mixed $value 
     * @return mixed 
     */
    public function __set($property, $value) {
        //if (property_exists($this, $property)) {
            $this->$property = $value;
        //}
        return $this;
    }
    
    /**
     * __unset
     * @param mixed $property 
     * @return mixed 
     */
    public function __unset($property){
        if (property_exists($this, $property)) {
            unset($this->$property);
        }
    }
}
?>