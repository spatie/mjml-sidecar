# Compile MJML to HTML using Sidecar

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/mjml-sidecar.svg?style=flat-square)](https://packagist.org/packages/spatie/mjml-sidecar)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/spatie/mjml-sidecar/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/spatie/mjml-sidecar/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/spatie/mjml-sidecar/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/spatie/mjml-sidecar/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/mjml-sidecar.svg?style=flat-square)](https://packagist.org/packages/spatie/mjml-sidecar)

This is a companion package to [mjml-php](https://github.com/spatie/mjml-php) that runs compilation through [Sidecar](https://hammerstone.dev/sidecar) instead.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/mjml-sidecar.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/mjml-sidecar)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/mjml-sidecar
```

Register the `MjmlFunction` in your `sidecar.php` config file.

```php
/*
 * All of your function classes that you'd like to deploy go here.
 */
'functions' => [
    \Spatie\MjmlSidecar\MjmlFunction::class,
],
```

Deploy the Lambda function by running:

```shell
php artisan sidecar:deploy --activate
```

See the [Sidecar documentation](https://hammerstone.dev/sidecar/docs/main/functions/deploying) for details.

## Usage

For usage, check the [mjml-php](https://github.com/spatie/mjml-php) documentation.

All the methods are available, just make sure to add `->sidecar()`, for example:

```php
Mjml::new()->sidecar()->toHtml($mjml);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Rias](https://github.com/spatie)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
