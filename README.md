# DeepL Client
Simple PHP DeepL API client that supports PHP 8.

## Installation
`composer require tinyapps/deepl-client`

## Usage

```php
use TinyApps\DeepL\Translator;
use TinyApps\DeepL\Options;
use TinyApps\DeepL\TargetLanguage;

$translator = new Translator('your_api_key');
$result = $translator->translate(
	text: 'Hello World',
	source: null, // let's DeepL auto-detect the source language
	target: TargetLanguage::GERMAN,
	preserveFormatting: false,
	splitSentences: Options::SPLIT_SENTENCES_DEFAULT,
	formality: Options::FORMALITY_DEFAULT,
);

$result->getText(); // translated text
$result->getDetectedSourceLanguage(); // EN
```

## Unit Test

Run `DEEPL_AUTH_KEY=[your key] composer test`
