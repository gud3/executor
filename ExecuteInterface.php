<?php

namespace gud3\executor;

/**
 * Interface Execute
 * @package gud3\executor
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
     * get result by key(if exec more one command) else no required params
     * @param $key
     *
     * @return mixed
     */
    public function getResult($key = null);
}