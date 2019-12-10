<?php
namespace Suilven\Sluggable\Tests;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Core\Kernel;
use SilverStripe\Core\Startup\ScheduledFlushDiscoverer;
use SilverStripe\Dev\SapphireTest;
use Suilven\Sluggable\Extension\Sluggable;
use Suilven\Sluggable\Helper\SluggableHelper;
use Suilven\Sluggable\Tests\Model\SluggestTestObject;

class SluggableObjectTest extends SapphireTest
{
    protected static $extra_dataobjects = [
        SluggestTestObject::class
    ];

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        /**
         * @todo How does one add an extension during tests?
        \Page::add_extension(Sluggable::class);
        $kernel = Injector::inst()->get(Kernel::class);
        ScheduledFlushDiscoverer::scheduleFlush($kernel);
         * */
    }

    public function testLowerCase()
    {
        $this->assertEquals('this-is-lower-case', $this->getSlugFromDataObject('this is lower case'));
    }

    public function testUpperCase()
    {
        $this->assertEquals('this-is-upper-case', $this->getSlugFromDataObject('THIS IS UPPER CASE'));
    }

    public function textMixedCase()
    {
        $this->assertEquals('this-is-mixed-case', $this->getSlugFromDataObject('THIs-Is-Mixed-case'));
    }

    public function testEmptyString()
    {
        $this->assertEquals('', $this->getSlugFromDataObject(''));
    }

    private function getSlugFromDataObject($title)
    {
        $object = new SluggestTestObject();
        $object->DisplayName = $title;
        $object->write();
        $slug = $object->Slug;
        error_log('SLUGGING: ' . $title . '--> ' . $slug);
        return $slug;
    }
}
