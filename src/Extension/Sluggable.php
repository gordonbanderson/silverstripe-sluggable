<?php


namespace Suilven\Sluggable\Extension;


use SilverStripe\Core\Config\Config_ForClass;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\Parsers\URLSegmentFilter;
use Suilven\Sluggable\Helper\SluggableHelper;

class Sluggable extends DataExtension
{
    /**
     * @var array $db Slug is where the slug is stored
     */
    private static $db = [
        'Slug' => 'Varchar(255)'
    ];

    private static $indexes = [
        'SlugIndex' => [
            'type' => 'unique',
            'columns' => ['Slug'],
        ],
    ];


    /**
     * Convert the configured field and it's associated value into a slug
     * e.g. Liverpool Football Club => liverpool-football-club
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        error_log('++ IN SLUGGABLE ++');

        /** @var Config_ForClass $config */
        $config = $this->owner->config();

        /** @var string $fieldName */
        $fieldName = $config->get('slug');

        /** @var string $fieldValue */
        $fieldValue = $this->owner->$fieldName;

        $helper = new SluggableHelper();

        /** @var string $slug */
        $slug = $helper->getSlug($fieldValue);

        // save the slug in the Slug field
        $this->owner->Slug = $slug;
    }
}
