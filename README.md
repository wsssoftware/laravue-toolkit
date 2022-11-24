# A laravel and vue toolkit

[![Latest Version on NPM](https://img.shields.io/npm/v/laravue-toolkit/alpha)](https://npmjs.com/package/laravue-toolkit)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/wsssoftware/laravue-toolkit.svg?style=flat-square)](https://packagist.org/packages/wsssoftware/laravue-toolkit)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/wsssoftware/laravue-toolkit/run-tests?label=tests)](https://github.com/wsssoftware/laravue-toolkit/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/wsssoftware/laravue-toolkit/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/wsssoftware/laravue-toolkit/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
![npm](https://img.shields.io/npm/dt/laravue-toolkit?label=npm%20downloads)
![Packagist Downloads](https://img.shields.io/packagist/dt/wsssoftware/laravue-toolkit?label=packagist%20downloads)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require wsssoftware/laravue-toolkit
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravue-toolkit-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravue-toolkit-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravue-toolkit-views"
```


### Important
You must configure the [maska](https://www.npmjs.com/package/maska) npm package to work with your vue application.

```js
const app = Vue.createApp({...})
// use as plugin
app.use(Maska);
// or as directive
// app.directive('maska', Maska.maska);
app.mount('#app');
```

## Usage

```php
$laravueToolkit = new Laravue\LaravueToolkit();
echo $laravueToolkit->echoPhrase('Hello, Laravue!');
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

- [Allan Carvalho](https://github.com/wsssoftware)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
