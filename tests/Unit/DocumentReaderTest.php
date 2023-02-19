<?php

namespace Tests\Unit;

use App\Services\Api\V1\DocumentReader\ExcelDocumentReader;
use App\Services\Api\V1\DocumentReader\ReadDocument;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;


class DocumentReaderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testFactoryReturnsClassNameAndReturnsExcel()
    {
        $excelDocumentReader = (new ReadDocument)->resolveFactory('excel');
        $this->assertInstanceOf(ExcelDocumentReader::class, $excelDocumentReader);
    }

    public function testFactoryReturnsErrors()
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Factory name could not be resolved.');
        $this->getExpectedException(400);
        (new ReadDocument)->resolveFactory('pdf');
    }

    public function testDocumentReaderReturnsCorrectArrayKeys()
    {
        $filePath = public_path('app') . '/AppTestingData.xlsx';
        $columnKeys = (new ReadDocument)->readDocument('readFile', ['facadeName' => 'excel', 'filePath' => $filePath]);
        $this->assertIsArray($columnKeys);
        $this->assertArrayHasKey('data_re_arranged', $columnKeys);
        $this->assertArrayHasKey('data_keys', $columnKeys);
        $this->assertArrayHasKey('migration_columns', $columnKeys);
    }

    public function testDocumentReaderReturnsCorrectData()
    {
        $filePath = public_path('app') . '/AppTestingData.xlsx';
        $columnKeys = (new ReadDocument)->readDocument('readFile', ['facadeName' => 'excel', 'filePath' => $filePath]);
        $this->assertEquals([
            'd_codigo' => '20000',
            'd_asenta' => 'Aguascalientes Centro',
            'd_tipo_asenta' => 'Colonia',
            'D_mnpio' => 'Aguascalientes',
            'd_estado' => 'Aguascalientes',
            'd_ciudad' => 'Aguascalientes',
            'd_CP' => '20001',
            'c_estado' => '01',
            'c_oficina' => '20001',
            'c_CP' => null,
            'c_tipo_asenta' => '09',
            'c_mnpio' => '001',
            'id_asenta_cpcons' => '0001',
            'd_zona' => 'Urbano',
            'c_cve_ciudad' => '01',
            "" => null,
        ], $columnKeys['data_re_arranged']['Aguascalientes'][2]);
    }

    public function testDocumentReaderReturnsCorrectColumnKeysForMigrations()
    {
        $filePath = public_path('app') . '/AppTestingData.xlsx';
        $columnKeys = (new ReadDocument)->readDocument('readFile', ['facadeName' => 'excel', 'filePath' => $filePath]);
        $this->assertEquals(collect([
            'A' => 'd_codigo',
            'B' => 'd_asenta',
            'C' => 'd_tipo_asenta',
            'D' => 'D_mnpio',
            'E' => 'd_estado',
            'F' => 'd_ciudad',
            'G' => 'd_CP',
            'H' => 'c_estado',
            'I' => 'c_oficina',
            'J' => 'c_CP',
            'K' => 'c_tipo_asenta',
            'L' => 'c_mnpio',
            'M' => 'id_asenta_cpcons',
            'N' => 'd_zona',
            'O' => 'c_cve_ciudad',
        ]), collect($columnKeys['migration_columns'])->filter());
    }
}
