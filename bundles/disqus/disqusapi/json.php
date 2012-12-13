<?php
/*
***************************************************************************
*   Copyright (C) 2007 by Cesar D. Rodas                                  *
*   crodas@phpy.org                                                       *
*                                                                         *
*   Permission is hereby granted, free of charge, to any person obtaining *
*   a copy of this software and associated documentation files (the       *
*   "Software"), to deal in the Software without restriction, including   *
*   without limitation the rights to use, copy, modify, merge, publish,   *
*   distribute, sublicense, and/or sell copies of the Software, and to    *
*   permit persons to whom the Software is furnished to do so, subject to *
*   the following conditions:                                             *
*                                                                         *
*   The above copyright notice and this permission notice shall be        *
*   included in all copies or substantial portions of the Software.       *
*                                                                         *
*   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,       *
*   EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF    *
*   MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.*
*   IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR     *
*   OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, *
*   ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR *
*   OTHER DEALINGS IN THE SOFTWARE.                                       *
***************************************************************************
*/

/**
 *    Serialize and Unserialize PHP Objects and array
 *    into JSON notation. 
 *
 *    @category   Javascript
 *    @package    JSON
 *    @author     Cesar D. Rodas <crodas@phpy.org>
 *    @copyright  2007 Cesar D. Rodas
 *    @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 *    @version    1.0
 *    @link       http://cesars.users.phpclasses.org/json 
 */

define('IN_NOWHERE',0);
define('IN_STRING',1);
define('IN_OBJECT',2);
define('IN_ATOMIC',3);
define('IN_ASSIGN',4);
define('IN_ENDSTMT',5);
define('IN_ARRAY',6);

/**
 *  JSON
 *
 *    This class serilize an PHP OBJECT or an ARRAY into JSON
 *    notation. Also convert a JSON text into a PHP OBJECT or
 *    array.
 *
 *    @category   Javascript
 *    @package    JSON
 *    @author     Cesar D. Rodas <crodas@phpy.org>
 *    @copyright  2007 Cesar D. Rodas
 *    @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 *    @version    1.0
 *    @link       http://cesars.users.phpclasses.org/json 
 */
class JSON
{
     /**
     *    Was parsed with an error?
     *    
     *    var bool
     *    @access private
     */
    var $error;
    
    function Json() {
        $this->error = false;
    }
    
    /**
     *    Serialize
     *
     *    Serialize a PHP OBJECT or an ARRAY into 
     *    JSON notation.
     *
     *    param mixed $obj Object or array to serialize
     *    return string JSON.
     */
    function serialize($obj) {
        if ( is_object($obj) ) {
            $e = get_object_vars($obj);
            /* bug reported by Ben Rowe */
            /* Adding default empty array if the */
            /* object doesn't have any property */
            $properties = array();
            foreach ($e as $k => $v) {
                $properties[] = $this->_serialize( $k,$v );
            }
            return "{".implode(",",$properties)."}";
        } else if ( is_array($obj) ) {
            return $this->_serialize('',$obj);
        }
    }
    
    /**
     *    UnSerialize
     *
     *    Transform an JSON text into a PHP object
     *    and return it.
     *    @access public 
     *    @param string $text JSON text
     *    @return mixed PHP Object, array or false.
     */
    function unserialize( $text ) {
        $this->error = false;
        
        return !$this->error ? $this->_unserialize($text) : false;
    }
    
    /**
     *    UnSerialize
     *
     *    Transform an JSON text into a PHP object
     *    and return it.
     *    @access private 
     *    @param string $text JSON text
     *    @return mixed PHP Object, array or false.
     */
    function _unserialize($text) {
        $ret = new stdClass;
         
        while (  $f = $this->getNextToken($text,$i,$type)  ) {
            switch ( $type ) {
                case IN_ARRAY:
                    $tmp = $this->_unserializeArray($text);
                    $ret = $tmp[0];
                    break;
                case IN_OBJECT:
                    $g=0;
                    do  {
                        $varName = $this->getNextToken($f,$g,$xType);
                        if ( $xType != IN_STRING )  {
                            return false; /* error parsing */
                        }
                        $this->getNextToken($f,$g,$xType);
                        if ( $xType != IN_ASSIGN) return false;
                        $value = $this->getNextToken($f,$g,$xType);
                        
                        if ( $xType == IN_OBJECT) {
                            $ret->$varName = $this->unserialize( "{".$value."}" );
                            $g--;
                        } else if ($xType == IN_ARRAY) {
                            $ret->$varName = $this->_unserializeArray( $value);
                            $g--;
                        } else
                            $ret->$varName = $value;
                        
                        $this->getNextToken($f,$g,$xType);
                    } while ( $xType == IN_ENDSTMT);
                    break;
                default:
                    $this->error = true;
                    break 2;
            }
        }
        return $ret;
    }
    
    /**
     *    JSON Array Parser
     *
     *    This method transform an json-array into a PHP 
     *    array
     *    @access private
     *    @param string $text String to parse
     *    @return Array PHP Array
     */
    function _unserializeArray($text) {
        $r = array();
        do {
            $f = $this->getNextToken($text,$i,$type);
            switch ( $type ) {
                case IN_STRING:
                case IN_ATOMIC:
                    $r[] = $f;
                    break;
                case IN_OBJECT:
                    $r[] = $this->unserialize("{".$f."}");
                    $i--;
                    break;
                case IN_ARRAY: 
                    $r[] = $this->_unserializeArray($f);
                    $i--;
                    break;
                    
            }
            $this->getNextToken($text,$i,$type);
        } while ( $type == IN_ENDSTMT);
        
        return $r;
    }
    
    /**
     *  Tokenizer
     *
     *  Return to the Parser the next valid token and the type     
     *  of the token. If the tokenizer fails it returns false.
     *    
     *    @access private
     *  @param string $e Text to extract token
     *  @param integer $i  Start position to search next token
     *  @param integer $state Variable to get the token type
     *  @return string|bool Token in string or false on error.
     */
    function getNextToken($e, &$i, &$state) {
        $state = IN_NOWHERE;
        $end = -1;
        $start = -1;
        while ( $i < strlen($e) && $end == -1 ) {
            switch( $e[$i] ) {
                /* objects */
                case "{":
                case "[":
                    $_tag = $e[$i]; 
                    $_endtag = $_tag == "{" ? "}" : "]";
                    if ( $state == IN_NOWHERE ) {
                        $start = $i+1;
                        switch ($state) {
                            case IN_NOWHERE:
                                $aux = 1; /* for loop objects */
                                $state = $_tag == "{" ? IN_OBJECT : IN_ARRAY;
                                break;
                            default:
                                break 2; /* exit from switch and while */
                        }
                        while ( ++$i && $i < strlen($e) && $aux != 0 ) {
                            switch( $e[$i] ) {
                                case $_tag:
                                    $aux++;
                                    break;
                                case $_endtag:
                                    $aux--;
                                    break;
                            }
                        }
                        $end = $i-1;
                    }
                    break;
                
                case '"':
                case "'":
                    $state = IN_STRING;
                    $buf = "";
                    while ( ++$i && $i < strlen($e) && $e[$i] != '"' ) {
                        if ( $e[$i] == "\\") 
                            $i++;
                        $buf .= $e[$i];
                    }
                    $i++;
                    return eval('return "'.str_replace('"','\"',$buf).'";');
                    break;
                case ":":
                    $state = IN_ASSIGN;
                    $end = 1;
                    break;
                case "n":
                    if ( substr($e,$i,4) == "null" ) {
                        $i=$i+4;
                        $state = IN_ATOMIC;
                        return NULL;
                    }
                    else break 2; /* exit from switch and while */
                case "t":
                    if ( substr($e,$i,4) == "true") {
                        $state = IN_ATOMIC;
                        $i=$i+4;
                        return true;
                    }
                    else break 2; /* exit from switch and while */
                    break;
                case "f":
                    if ( substr($e,$i,5) == "false") {
                        $state = IN_ATOMIC;
                        $i=$i+5;
                        return false;
                    }
                    else break 2; /* exit from switch and while */
                    break;    
                case ",":
                    $state = IN_ENDSTMT;
                    $end = 1;
                    break;
                case " ":
                case "\t":
                case "\r":
                case "\n":
                    break;
                case "+":
                case "-":
                case 0:
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                case 7:
                case 8:
                case 9:
                case '.':
                    $state = IN_ATOMIC;
                    $start = (int)$i;
                    if ( $e[$i] == "-" || $e[$i] == "+")
                        $i++;
                    for ( ;  $i < strlen($e) && (is_numeric($e[$i]) || $e[$i] == "." || strtolower($e[$i]) == "e") ;$i++){
                        $n = $i+1 < strlen($e) ? $e[$i+1] : "";
                        $a = strtolower($e[$i]);
                        if ( $a == "e" && ($n == "+" || $n == "-"))
                            $i++;
                        else if ( $a == "e") 
                            $this->error=true;
                    }
                    
                    $end = $i;
                    break 2; /* break while too */
                default: 
                    $this->error = true;
                    
            }
            $i++;
        }
        
        return $start == -1 || $end == -1 ? false : substr($e, $start, $end - $start);
    }
    
    /** 
     *    Internal Serializer
     *
     *    @param string $key Variable name
     *    @param mixed $value Value of the variable
     *    @access private
     *    @return string Serialized variable
     */
    function _serialize (  $key = '', &$value ) {
        $r = '';
        if ( $key != '')$r .= "\"${key}\" : ";
        if ( is_numeric($value) ) {
            $r .= ''.$value.'';
        } else if ( is_string($value) ) {
            $r .= '"'.$this->toString($value).'"';
        } else if ( is_object($value) ) {
            $r .= $this->serialize($value);
        } else if ( is_null($value) ) {
            $r .= "null";
        } else if ( is_bool($value) ) {
            $r .= $value ? "true":"false";
        } else if ( is_array($value) ) {
            foreach($value as $k => $v)
                $f[] = $this->_serialize('',$v);
            $r .= "[".implode(",",$f)."]";
            unset($f);
        }
        return $r;
    }
    
    /** 
     *    Convert String variables
     *
     *    @param string $e Variable with an string value
     *    @access private
     *    @return string Serialized variable
     */
    function toString($e) {
        $rep = array("\\","\r","\n","\t","'",'"');
        $val = array("\\\\",'\r','\n','\t','\'','\"');
        $e = str_replace($rep, $val, $e);
        return $e;
    }
}
?>