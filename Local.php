<?php

namespace common\collections\executer;

/**
 * Class Client
 * @package common\collections\executer
 */
class Local extends ExecuteAbstract implements ExecuteInterface
{
    /**
     * @param $command
     * @param bool $async
     * @return int|string
     */
    public function exec($command, $async = false)
    {
        if (is_array($command)) {
            foreach ($command as $cmd) {
                $this->exec($cmd, $async);
            }
        } else {
            $this->getCommandFlag($command, $async);

            switch ($this->checkOs()) {
            case self::OS_WINDOWS:
                $this->result[] = pclose(popen($command));
                break;
            case self::OS_LINUX:
                $this->result[] = exec($command);
                break;
            }
        }

        if (count($this->result) <= 1) {
            return end($this->result);
        } else {
            return $this->result;
        }
    }

    /**
     * @param $path
     * @param $fileName
     * @return array|string
     */
    public function getFile($path, $fileName)
    {
        if (substr($path, -1) != DIRECTORY_SEPARATOR) {
            $path .= DIRECTORY_SEPARATOR;
        }
        $file = @fopen("{$path}{$fileName}", 'r');
        if (!$file) {
            return [];
        }
        $filesize = filesize("{$path}{$fileName}");

        $read = 0;
        $string = '';
        while ($read < $filesize && ($buffer = fread($file, $filesize - $read))) {
            $read += strlen($buffer);
            $string .= $buffer;
        }

        fclose($file);

        return $this->result[] = $string;
    }

    /**
     * @param $path
     * @param $fileName
     * @param $content
     * @return int
     */
    public function setFile($path, $fileName, $content)
    {
        if (substr($path, -1) != DIRECTORY_SEPARATOR) {
            $path .= DIRECTORY_SEPARATOR;
        }
        $file = @fopen("{$path}{$fileName}", 'w+');

        $write = fwrite($file, $content);

        fclose($file);

        return $write;
    }
}