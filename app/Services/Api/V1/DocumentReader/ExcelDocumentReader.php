<?php

namespace App\Services\Api\V1\DocumentReader;

use App\Services\Api\V1\DocumentReader\DocumentInterface;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelDocumentReader implements DocumentInterface
{
    public function readFile(...$options): array
    {
        if (!array_key_exists('filePath', $options)) {
            throw new Exception("Error Processing Request, missing [?'filePath']", Response::HTTP_BAD_REQUEST);
        }

        return $this->parser($options['filePath'], $options);
    }

    public function parser(string $filePath, ...$options)
    {
        $data = $this->getDataFromFile($filePath, $options);

        return $this->reArrangeData($data);
    }

    public function getDataFromFile(string $filePath, array ...$options): array
    {
        $spreadsheet = IOFactory::load($filePath);

        $tabs = $spreadsheet->getSheetNames();

        $dataArray = [];
        foreach ($tabs as $tab) {
            $spreadsheet->setActiveSheetIndexByName($tab);
            $dataArray[$tab] = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        }

        return $dataArray;
    }

    public function reArrangeData(array $data)
    {
        $dataKeys = $this->getDataKeys($data);
        $dataReArranged = [];
        foreach ($data as $keyParent => $tabFileData) {
            foreach ($tabFileData as $keyChild => $rowValue) {
                if ($keyChild !== 1) {
                    $dataReArranged[$keyParent][$keyChild] = $this->setProperKeysInValue($dataKeys[$keyParent], $rowValue);
                }
            }
        }

        return ['data_re_arranged' => $dataReArranged, 'data_keys' => $dataKeys, 'migration_columns' => $this->getDataKeysForColumnMigration($dataKeys)];
    }

    public function setProperKeysInValue($keys, $dataRowValue)
    {
        $newValue = [];
        foreach ($keys as $key => $value) {
            if (count($keys) === count($dataRowValue)) {
                $newValue[$value] = $dataRowValue[$key];
            }
        }

        return $newValue;
    }

    public function getDataKeys(array $data)
    {
        $dataKeys = [];
        foreach ($data as $key => $fileColumnData) {
            $dataKeys[$key] = $fileColumnData[1];
        }

        return $dataKeys;
    }

    public function getDataKeysForColumnMigration(array $data)
    {
        foreach ($data as $key => $fileColumnData) {
            return $fileColumnData;
        }
    }
}
