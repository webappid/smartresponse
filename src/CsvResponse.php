<?php
/**
 * Created by PhpStorm.
 */

namespace WebAppId\SmartResponse;

/**
 * @author: Dyan Galih<dyan.galih@gmail.com>
 * Date: 28/02/2021
 * Time: 22.45
 * Class CsvResponse
 * @package WebAppId\SmartResponse
 */
class CsvResponse
{
    public function export(array $data, string $fileName = "download.csv", string $separator = ",", string $enclosure = "'", string $escape="\\")
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function () use ($data, $separator, $enclosure, $escape) {
            $file = fopen('php://output', 'w');

            foreach ($data as $row) {
                fputcsv($file, $row, $separator, $enclosure, $escape);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
