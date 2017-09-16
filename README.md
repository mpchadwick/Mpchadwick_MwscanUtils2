# Mpchadwick_MwscanUtils2

[![Build Status](https://travis-ci.org/mpchadwick/Mpchadwick_MwscanUtils2.svg?branch=master)](https://travis-ci.org/mpchadwick/Mpchadwick_MwscanUtils2)

A set of utilities for use in tandem with [magento-malware-scanner](https://github.com/gwillem/magento-malware-scanner) for Magento 2.

Magento 1 version available [here](https://github.com/mpchadwick/Mpchadwick_MwscanUtils).

## Installation

```
composer require mpchadwick/mwscanutils2:dev-master
module:enable Mpchadwick_MwscanUtils
bin/magento setup:upgrade
```

## Features

### Content Dump Endpoint

Adds an endpoint at `/mwscanutils/contentdump` which returns a `text/plain` response including...

- Content from ALL CMS pages
- Content from ALL CMS blocks
- Miscellaneous Scripts
- Miscellaneous HTML

From a scanning location, you should send the output of this to mwscan.

```
curl --silent https://example.com/mwscanutils/contentdump > content && grep -Erlf mwscan.txt content
```

Additional content can be appended as needed by observing the `mpchadwick_mwscanutils_dump_content_before` event

**events.xml**

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Event/etc/events.xsd">
    <event name="mpchadwick_mwscanutils_dump_content_before">
        <observer name="foo_bar_observer_example" instance="Foo\Bar\Observer\Example" />
    </event>
</config>
```

**Example.php**

```php
public function execute(EventObserver $observer)
{
    $container = $observer->getEvent()->getContainer();
    $content = $container->getContent();
    $content[] = 'Dump this too.';
    $container->setContent($content);
}
```
