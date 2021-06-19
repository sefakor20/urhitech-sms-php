# Urhitech SMS PHP SDK

The Urhitech SMS PHP SDK provides a suitable approach to the USMSGH API from applications written in PHP. It includes pre-defined set of classes and functions for API resource that initialize themeselves from  API responses.

The library provides other features. For Example:
1. Easy configuration path for fast setup and use
2. Helpers for pagination.

You can sign up for a USMSGH account at [usmsgh.com](https://www.usmsgh.com)

# Prerequisites
PHP 5.6.0  and later

# Installation
Via [Composer](http://getcomposer.org/)
```
$ composer require urhitech/urhitech-sms-php
```

Via Git Bash
```
git clone https://github.com/sefakor20/urhitech-sms-php.git
```

# Usage

### Step 1:
If you install the Urhitech SMS PHP SDK via Git Clone then load the Urhitech SMS PHP API class file and use namespace.

```
require_once '/path/to/src/Usms.php';
use UrhitechSMSPHP\UrhitechSMSPHPAPI;
```

If you install Urhitech SMS PHP SDK via [Composer](http://getcomposer.org/) the Require the autoload.php file in the index.php of your project or whatever file you need to use Urhitech SMS PHP API classes.

```
require 'vendor/autoload.php';
use UrhitechSMSPHP\UrhitechSMSPHPAPI;
```



