<?php

namespace Mpchadwick\MwscanUtils\Controller\Contentdump;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Context;
use Magento\Config\Model\ResourceModel\Config\Data\Collection as ConfigDataCollection;
use Magento\Cms\Api\Data\PageInterface as CmsPage;
use Magento\Cms\Api\Data\BlockInterface as CmsBlock;
use Magento\Framework\DataObjectFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    const SEPARATOR = PHP_EOL . PHP_EOL . '----' . PHP_EOL . PHP_EOL;

    protected $configDataCollection;
    protected $cmsPage;
    protected $cmsBlock;
    protected $dataObjectFactory;

    protected $paths = [
        'design/head/includes',
        'design/footer/absolute_footer'
    ];

    public function __construct(
        Context $context,
        ConfigDataCollection $configDataCollection,
        CmsPage $cmsPage,
        CmsBlock $cmsBlock,
        DataObjectFactory $dataObjectFactory
    ) {
        parent::__construct($context);
        $this->configDataCollection = $configDataCollection;
        $this->cmsPage = $cmsPage;
        $this->cmsBlock = $cmsBlock;
        $this->dataObjectFactory = $dataObjectFactory;
    }

    public function execute()
    {
        $content = array_merge(
            $this->configDataCollection
                ->addFieldToFilter('path', ['in' => $this->paths])
                ->getColumnValues('value'),
            $this->cmsPage
                ->getCollection()
                ->getColumnValues('content'),
            $this->cmsBlock
                ->getCollection()
                ->getColumnValues('content')
        );

        $container = $this->dataObjectFactory->create();
        $container->setContent($content);
        $this->_eventManager->dispatch(
            'mpchadwick_mwscanutils_dump_content_before',
            ['container' => $container]
        );

        $raw = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $raw->setContents(implode(self::SEPARATOR, $container->getContent()));
        $raw->setHeader('Content-Type', 'text/plain', true);

        return $raw;
    }
}
