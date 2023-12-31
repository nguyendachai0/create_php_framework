<?php

namespace thecodeholic\phpmvc;

class Session
{
    protected const FLASH_KEY = 'flash_messages';
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            // Mark to be remove
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
    public function setFlash($key, $message)
    {
        $_SESSION['flash_messages'][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }
    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }
    public function set($key, $value)
    {
        $_SESSION[$key]  = $value;
    }
    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }
    public function remove($attr)
    {
        $_SESSION[$attr] = null;
    }
    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            if ($flashMessages[$key]['remove']) {
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}
