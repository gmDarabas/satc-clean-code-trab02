<?php

namespace Config;

use Aws\S3\S3Client;

class Storage
{
    private static ?S3Client $client = null;

    public static function getClient(): S3Client
    {
        if (self::$client === null) {
            self::$client = new S3Client([
                'version' => 'latest',
                'region' => 'us-east-1',
                'endpoint' => 'http://' . $_ENV['MINIO_ENDPOINT'],
                'use_path_style_endpoint' => true,
                'credentials' => [
                    'key' => $_ENV['MINIO_ACCESS_KEY'],
                    'secret' => $_ENV['MINIO_SECRET_KEY'],
                ],
                'http' => [
                    'verify' => false
                ]
            ]);
        }

        return self::$client;
    }

    public static function getBucket(): string
    {
        return $_ENV['MINIO_BUCKET'] ?? 'torrent-files';
    }
}
