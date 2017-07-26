<?php

namespace common\collections\executer;

/**
 * Interface Execute
 * @package common\collections\executer
 */
interface ExecuteInterface
{
    /**
     * function exec command async or no
     * @param $command
     * @param $async
     *
     * @return mixed
     */
    public function exec($command, $async = false);

    /**
     * get result by key(if exec more one command) else no requeider params
     * @param $key
     *
     * @return mixed
     */
    public function getResult($key = null);
}