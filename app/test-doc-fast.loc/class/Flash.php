<?php


class Flash {
    static protected $_name = 'flash';
    static protected $_nameMessage = 'message';
    const INFO = 1;
    const NOTICE = 2;
    const WARNING = 3;

    static public function get($index, $keep = false)
    {
        if ( self::isExists($index) ) {
            $retVal = $_SESSION[ self::$_name ][ $index ];
            if (!$keep) {
                unset($_SESSION[ self::$_name ][ $index ]);
            }
            return $retVal;
        }
    }

    static function set($index, $value)
    {
        $_SESSION[ self::$_name ][ $index ] = $value;
    }

    static function isExists($index)
    {
        return isset($_SESSION[ self::$_name ][ $index ]);
    }

    static function setMessage($text, $type)
    {
        self::set(
            self::$_nameMessage,
            array(
                'text' => $text,
                'type' => $type
            )
        );
    }

    static public function getMessage($keep = false)
    {
        return self::get( self::$_nameMessage, $keep );
    }

    static public function getMessageText($keep = false)
    {
        if ( self::isExists( self::$_nameMessage ) ) {
            $message = self::getMessage($keep);
            return $message['text'];
        }
    }

    static public function getMessageType($keep = true)
    {
        if ( self::isExists( self::$_nameMessage ) ) {
            $message = self::getMessage($keep);
            return $message['type'];
        }
    }

    static public function setInfo($text)
    {
        self::setMessage($text, self::INFO );
    }

    static public function setNotice($text)
    {
        self::setMessage($text, self::NOTICE );
    }

    static public function setWarning($text)
    {
        self::setMessage($text, self::WARNING );
    }
}
