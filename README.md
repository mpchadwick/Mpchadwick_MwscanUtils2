# Mpchadwick_MwscanUtils2

[![Build Status](https://travis-ci.org/mpchadwick/Mpchadwick_MwscanUtils2.svg?branch=master)](https://travis-ci.org/mpchadwick/Mpchadwick_MwscanUtils2)

A set of utilities for use in tandem with [magento-malware-scanner](https://github.com/gwillem/magento-malware-scanner) for Magento 2 to [level up your malware scans](https://maxchadwick.xyz/blog/magento-external-malware-scan).

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
