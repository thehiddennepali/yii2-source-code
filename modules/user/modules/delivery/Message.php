<?php
/**
 * Created by PhpStorm.
 * User: Nurbek
 * Date: 3/14/16
 * Time: 9:11 PM
 */


namespace delivery;


class Message extends \yii\swiftmailer\Message
{
    private $_body;
    public function setHtmlBody($html)
    {
        $this->_body = $html;
        return $this;
    }
    public function setTextBody($text)
    {
        $this->_body = $text;
        return $this;
    }
    public function getBody()
    {
        return $this->_body;
    }
} 