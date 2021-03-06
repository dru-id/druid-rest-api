<?php namespace Genetsis\Druid\Rest;

use Genetsis\Druid\Rest\Resources\Apps;
use Genetsis\Druid\Rest\Resources\Brand;
use Genetsis\Druid\Rest\Resources\Entrypoint;
use Genetsis\Druid\Rest\Resources\TypologyFields;

final class ApiTest extends InitTest
{

    public function testGetBrands() {
        $brands = $this->api->getBrands();
        $this->assertIsArray($brands->getResources('brands'));
        $this->assertEquals(1,count($brands->getResources('brands')));
        $this->assertInstanceOf(Brand::class, $brands->getResources('brands')[0]);
    }


    public function testGetApps() {
        $apps = $this->api->getApps();
        $this->assertIsArray($apps->getResources('apps'));
        $this->assertInstanceOf(Apps::class, $apps->getResources('apps')[0]);
    }

    public function testGetAllTypologyFields() {
        $typology_fields = $this->api->getTypologyFields();
        $this->assertIsArray($typology_fields->getResources('typologyFields'));
        $this->assertInstanceOf(TypologyFields::class, $typology_fields->getResources('typologyFields')[0]);
    }


    public function testGetAllEntrypoints() {
        $entrypoints = $this->api->getEntrypoints();
        $this->assertIsArray($entrypoints->getResources('entrypoints'));
        $this->assertInstanceOf(Entrypoint::class, $entrypoints->getResources('entrypoints')[0]);
    }

    public function testGetAllEntrypointsByApp() {
        $entrypoints = $this->api->searchEntrypointsBy(['app' => $this->app_id]);
        $this->assertIsArray($entrypoints->getResources('entrypoints'));

        foreach ($entrypoints->getResources('entrypoints') as $entrypoint) {
            $this->assertInstanceOf(Entrypoint::class, $entrypoint);
        }
    }

    public function testGetEntrypointsEmptyIFAppNotExist() {
        $entrypoints = $this->api->searchEntrypointsBy(['app' => 'XXXXXXXX']);
        $this->assertIsArray($entrypoints->getResources('entrypoints'));
        $this->assertEmpty($entrypoints->getResources('entrypoints'));
    }

    public function testGetEntrypointsByKey() {
        $entrypoints = $this->api->searchEntrypointsBy(['key' => $this->entrypoint_key]);
        $this->assertInstanceOf(Entrypoint::class, $entrypoints->getData());

        $entrypoint = $entrypoints->getData();

        print_r($entrypoint->getLinkByType('self'));
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetBadMethod() {
        $this->api->getFail();
    }

}
