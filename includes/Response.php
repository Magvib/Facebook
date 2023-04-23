<?php

class Response
{
    public const HTML = 'text/html';
    public const JSON = 'application/json';
    public const XML = 'application/xml';
    public const TEXT = 'text/plain';
    public const PDF = 'application/pdf';
    public const CSV = 'text/csv';
    public const PNG = 'image/png';
    public const JPEG = 'image/jpeg';
    public const GIF = 'image/gif';
    public const SVG = 'image/svg+xml';
    public const MP4 = 'video/mp4';
    public const MP3 = 'audio/mpeg';
    public const ICO = 'image/x-icon';
    public const ZIP = 'application/zip';
    public const RAR = 'application/x-rar-compressed';
    public const TAR = 'application/x-tar';
    public const GZIP = 'application/gzip';

    public $type = null;
    public $status = 200;

    public function __construct($type = null)
    {
        if ($type) {
            $this->type = $type;
        } else {
            $this->type = self::TEXT;
        }
    }

    public function send($data)
    {
        // Check if header is allready sent
        if (headers_sent()) {
            // Throw exception
            return;
        }

        // Set header
        header("Content-Type: $this->type");
        header("HTTP/1.1 $this->status");

        echo $data;
        die();
    }

    public function json($data)
    {
        $this->type = self::JSON;
        $this->send(json_encode($data));
    }

    public function redirect($url)
    {
        header("Location: $url");
        die();
    }

    public function status($status)
    {
        $this->status = $status;

        return $this;
    }

    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    public function error($status, $message)
    {
        $this->status($status);
        $this->send($message);
    }
}
