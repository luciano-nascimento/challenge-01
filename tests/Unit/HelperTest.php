<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Http\UploadedFile;

class HelperTest extends TestCase
{
    const PERSON_TYPE = 'person';
    const PERSON_XML_DATA = '<?xml version="1.0" encoding="utf-8"?>
                        <people>
                            <person>
                            <personid>1</personid>
                            <personname>Name 1</personname>
                            <phones>
                                <phone>2345678</phone>
                                <phone>1234567</phone>
                            </phones>
                            </person>
                        </people>';
    const PERSON_NAME_IN_XML_DATA = 'Name 1';                    

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_should_retrieve_data_type()
    { 
        $dataType = getXMLDataType(self::PERSON_XML_DATA);         
        $this->assertEquals($dataType, self::PERSON_TYPE);
    }

    public function test_should_parse_xml_data_to_array()
    {
        $parsedXMLDataArray = convertXMLDataTypeToArray(self::PERSON_XML_DATA);
        $this->assertContains(SELF::PERSON_NAME_IN_XML_DATA, $parsedXMLDataArray);
    }
}
