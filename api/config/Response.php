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

        switch ($type) {
            case 'json':
                self::json($data);
                break;
            case 'xml':
                self::xml($data);
                break;
            case 'plain':
                self::plain($data);
                break;
            case 'query':
                self::query($data);
                break;
            case 'csv':
                self::csv($data);
                break;
            case 'dump':
                print_r($data);
                break;
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
        header('Content-Type: application/xml');
        $xml = new SimpleXMLElement('<response></response>');
        self::arrayToXml($data, $xml);
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
        echo $data;
    }

    public static function query($data)
    {
        header('Content-Type: application/x-www-form-urlencoded');
        echo http_build_query($data);
    }

    public static function csv($data)
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="data.csv"');

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
