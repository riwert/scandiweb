<?php

namespace SWAPI\config;
use SimpleXMLElement;

class Response
{
    public static function cors()
    {
        // Restrict Allowed Origin
        $origin = getenv('CORS_ORIGIN') ? getenv('CORS_ORIGIN') : '*';

        // Set CORS headers
        header('Access-Control-Allow-Origin: '.$origin);
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

        // Handle preflight OPTIONS request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }

    public static function handle($data, $code = 500, $type = 'json')
    {
        self::cors();

        if (!is_numeric($code)) {
            $code = 500;
        }

        http_response_code($code);

        if ($type == 'json') {
            self::json($data);
        } else if ($type == 'xml') {
            self::xml($data);
        } else if ($type == 'plain') {
            self::plain($data);
        } else if ($type == 'csv') {
            self::csv($data);
        } else if ($type == 'dump') {
            print_r($data);
        }
        exit();
    }

    public static function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public static function xml($data)
    {
        $xml = new SimpleXMLElement('<response></response>');
        self::arrayToXml($data, $xml);
        header('Content-Type: application/xml');
        echo $xml->asXML();
    }

    public static function arrayToXml($data, &$xml) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $subNode = $xml->addChild($key);
                self::arrayToXml($value, $subNode);
            } else {
                $value = ($value) ? htmlspecialchars($value) : '';
                $xml->addChild($key, $value);
            }
        }
    }

    public static function plain($data)
    {
        header('Content-Type: text/plain');
        echo http_build_query($data);
    }

    public static function csv($data)
    {
        // Create a temporary file handle
        $tempFile = fopen('php://temp', 'w');

        // Write the array data to the CSV file handle
        foreach ($data as $row) {
            fputcsv($tempFile, $row);
        }

        // Rewind the file pointer to the beginning
        rewind($tempFile);

        // Read the CSV data from the file handle
        $csvData = stream_get_contents($tempFile);

        // Close the file handle
        fclose($tempFile);

        // Output the CSV data
        echo $csvData;
    }
}
