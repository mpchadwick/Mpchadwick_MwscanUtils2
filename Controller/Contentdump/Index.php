<?php

namespace Mpchadwick\MwscanUtils\Controller\Contentdump;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magento\Config\Model\ResourceModel\Config\Data\Collection as ConfigDataCollection;
use Magento\Cms\Api\Data\PageInterface as CmsPage;
use Magento\Cms\Api\Data\BlockInterface as CmsBlock;

class Index extends \Magento\Framework\App\Action\Action
{
    const SEPARATOR = PHP_EOL . PHP_EOL . '----' . PHP_EOL . PHP_EOL;

    protected $configDataCollection;
    protected $cmsPage;
    protected $cmsBlock;

    protected $paths = [
        'design/head/includes',
        'design/footer/absolute_footer'
    ];

    public function __construct(
        Context $context,
        ConfigDataCollection $configDataCollection,
        CmsPage $cmsPage,
        CmsBlock $cmsBlock
    ) {
        parent::__construct($context);
        $this->configDataCollection = $configDataCollection;
        $this->cmsPage = $cmsPage;
        $this->cmsBlock = $cmsBlock;
    }

    public function execute()
    {
        $content = $this->configDataCollection
            ->addFieldToFilter('path', ['in' => $this->paths])
            ->getColumnValues('value');

        $raw = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $raw->setContents(implode(self::SEPARATOR, $content));
        $raw->setHeader('Content-Type', 'text/plain', true);

        return $raw;
    }
}
