# Content Parser - Laravel 5 package for automatically detecting a content on custom web pages.

With this package, you can easily detect main content on different web pages and grab it.
This package provides also follow features:

* Expandable architecture. You can easily add support for new APIs
* Code cleaning. The package can automatically clean CSS and style attributes. Thus you always will receive clean and good HTML content.

The package use automatic algorithms for grabbing data from web pages.
You'll receive the title and the content on a web page.

## Requirements

The package requires follow solutions:

* Laravel 5.x
* PHP 7.x
* [Graby](https://github.com/j0k3r/graby)
* [Curl](https://github.com/ixudra/curl)

## Installation

You can install the package with Composer.
Just run:

php composer require deepslam/content_parser

Further, you have to add service provider in your config/app.php:

```php
...
Deepslam\ContentParser\ContentParserServiceProvider::class,
...
```

Next step is creating alias in your config/app.php:

```php
'ContentParser' => Deepslam\ContentParser\ContentParser::class,
```

After it you need to publish configs:

```console
php artisan vendor:publish --provider="Deepslam\ContentParser\ContentParserServiceProvider"
```

Do not forget to run config:cache command:

```console
php artisan config:cache
```

That's all!

## Settings

There are two different parsers:

* Standalone parser - [graby](https://github.com/j0k3r/graby/) which uses by default.
* MarcuryContentParser which uses [Mercury API](https://mercury.postlight.com/web-parser/)

Thus you have 3 configs:

* /config/deepslam/parser.php - common config for all parsers. Here you can configure such options as necessary of cleaning code, stripping tags and set allow tags list.
* /config/deepslam/mercury-tools.php - There is only one settings - API key for service
* /config/deepslam/graby.php - This is the copy of original settings of [graby](https://github.com/j0k3r/graby/) parser. You can read about it on [developer's page](https://github.com/j0k3r/graby/).

## Usage

You can easily use ContentParser:

```php
$parser = ContentParser::create($extras->grab_url);
```

This configuration will use "Graby" parser. If you need to use another one, you can specify it as second parameter:

```php
$parser = ContentParser::create($extras->grab_url, 'mercury');
```

As result, you will receive ContentParser object.
For getting result of parsing there is one method:

**getResult** - Returns needle ParsingResult object

There are a few methods in this object:

**setTitle** - Set new title
**setContent** - Set new content
**getTitle**  - The title of result
**getContent** - The content of result. It can be already cleaned if you specify it in configs.
**isEmpty** - Is it empty object (without data) or not?
**stripContent** - Manually strip content from tags
**cleanContent** - Manually clean content from strange classes, ID's and style blocks in the parsed HTML

## Extending

If you want to add the new package you must create the new class and inherit it from Deepslam\ContentParser\ContentParser class.
You must realise the only one method - parse which must return ParsingResult object with data.

After it, you must specific your new class in the /config/deepslam/parser.php parsers array.

To use you parser specify it when you call ContentParser as shows below:

```php
$parser = ContentParser::create($extras->grab_url, '<your alias of parser>');
```

## Full example

```php
        $parser = ContentParser::create('<url to grab>');
        $result = $parser->getResult();
        <your_model>->name = $result->getTitle();
        <your_model>->description = $result->getContent();
```

## Support

If you find bug or have question\suggestion you can send e-mail to me: [me@ivanovdmitry.com]me@ivanovdmitry.com