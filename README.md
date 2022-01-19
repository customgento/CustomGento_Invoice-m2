# CustomGento_Invoice (Magento 2)
This Magento 2 module extends the default purchase order payment method by a customer group and admin filter. You can use it to allow the payment method only for specific customer groups or disable it in the checkout and use it only in the admin area.

## Description
This extension for Magento 2 extends the default purchase order payment method by two new configuration options:

* Define that the payment method should only be available for specific customer groups.
* Define that the payment method should only be available in the backend.

## Compatibility
* Magento >= 2.3.3

## Installation Instructions
The installation procedure highly depends on your setup. In any case, you should use a version control system like git and test the installation on a development system.

### Composer Installation
1. `composer require customgento/module-invoice-m2`
2. `bin/magento module:enable CustomGento_Invoice`
3. `bin/magento setup:upgrade`
4. `bin/magento setup:di:compile`
5. `bin/magento cache:flush`

### Manual Installation
1. unzip the downloaded files
2. create the directory `app/code/CustomGento/Invoice/`: `mkdir -p app/code/CustomGento/Invoice/`
3. copy the unzipped files to the newly created directory `app/code/CustomGento/Invoice/`
4. `bin/magento module:enable CustomGento_Invoice`
5. `bin/magento setup:upgrade`
6. `bin/magento setup:di:compile`
7. `bin/magento cache:flush`

## Uninstallation
The installation procedure depends on your setup:

### Uninstallation After Composer Installation
1. `bin/magento module:uninstall CustomGento_Invoice`
2. `bin/magento setup:di:compile`
3. `bin/magento cache:flush`

### Uninstallation After Manual Installation
1. `bin/magento module:disable CustomGento_Invoice`
2. `bin/magento setup:di:compile`
3. `bin/magento cache:flush`
4. `rm -r app/code/CustomGento/Invoice`

## Support
If you have any issues with this extension, feel free to [open an issue on GitHub](https://github.com/customgento/CustomGento_Invoice-m2/issues).

## Licence
[Open Software License 3.0](https://opensource.org/licenses/OSL-3.0)

## Copyright
(c) 2018-2020 CustomGento / Simon Sprankel
