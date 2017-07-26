<?php

namespace gud3\executor;

/**
 * Class ExecuteAbstract
 * @package gud3\executor
 */
abstract class ExecuteAbstract
{
    public $result;

    /**
     * getter result by array key
     * @return mixed
     */
    public function getResult($key = null)
    {
        if ($key) {
            if (!isset($this->result[$key])) {
                throw new \Exception('No find key in array');
            }
        } else {
            $key = 0;
        }

        return $this->result[$key];
    }

    /**
     * add to command flag async
     * @param $command
     * @param $async
     *
     * @return string
     */
    protected function getCommandFlag(&$command, $async)
    {
        $os = $this->checkOs();
        switch ($os) {
        case self::OS_LINUX:
            if ($async) {
                $command = $command . ' > /dev/null &';
            }
            break;
        case self::OS_WINDOWS:
            // TODO review
            //$command = str_replace(';', '&', $command);
            if ($async) {
                $mode = 'r';
            } else {
                $mode = 'w';
            }
            //$command = 'start /B cmd /C "' . $command;
            break;
        default:
            throw new \Exception('No find os');
        }
    }

    const OS_WINDOWS = 1;
    const OS_LINUX = 2;

    /**
     * identity Operation System
     * @return int
     */
    protected function checkOs()
    {
        if (substr(php_uname(), 0, 7) == "Windows") {
            return self::OS_WINDOWS;
        } else {
            return self::OS_LINUX;
        }
    }
}