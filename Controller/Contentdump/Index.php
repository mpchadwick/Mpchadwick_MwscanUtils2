<?php

namespace Mpchadwick\MwscanUtils\Controller\Contentdump;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $raw = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $raw->setContents('Hello world');
        $raw->setHeader('Content-Type', 'text/plain', true);
        return $raw;
    }
}
