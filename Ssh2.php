<?php

namespace gud3\executor;

/**
 * Class Ssh2
 */
class Ssh2 extends ExecuteAbstract implements ExecuteInterface
{
    /**
     * @var resource
     */
    private $_connection;

    /**
     * Ssh2 constructor.
     *
     * @param     $ip
     * @param     $login
     * @param     $password
     * @param int $port
     */
    public function __construct($ip, $login, $password, $port = 22)
    {
        $this->_connection = ssh2_connect($ip, $port);
        
        ssh2_auth_password($this->_connection, $login, $password);
    }

    /**
     * @param      $command
     * @param bool $async
     * @param bool $returnStream
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function exec($command, $async = false, $returnStream = false)
    {
        if (is_array($command)) {
            if ($returnStream === true) {
                throw new \Exception('Function not return stream from array');
            }

            foreach ($command as $cmd) {
                $this->exec($cmd, $async);
            }
        } else {
            $this->getCommandFlag($command, $async);

            $stream = ssh2_exec($this->_connection, $command);
            stream_set_blocking($stream, true);

            $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);

            $this->result[] = stream_get_contents($stream_out);

            fclose($stream);
        }

        if (count($this->result) <= 1) {
            if ($returnStream) {
                return [end($this->result), $stream];
            }

            return end($this->result);
        } else {
            return $this->result;
        }
    }

    /**
     * @param $path
     */
    public function getFile($path, $fileName)
    {
        $sftp = ssh2_sftp($this->_connection);
        $file = @fopen("ssh2.sftp://" . intval($sftp) . "/{$path}{$fileName}", 'r');
        if (!$file) {
            return [];
        }
        $filesize = filesize("ssh2.sftp://{$sftp}/{$path}{$fileName}");

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
     */
    public function setFile($path, $fileName, $content)
    {
        $sftp = ssh2_sftp($this->_connection);
        $file = fopen("ssh2.sftp://" . intval($sftp) . "{$path}{$fileName}", 'w+');

        $write = fwrite($file, $content);

        fclose($file);

        return $write;
    }
}