<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use TinyApps\DeepL\TargetLanguage;
use TinyApps\DeepL\Translator;

final class TranslatorTest extends TestCase {
	/**
	 * Test translation
	 *
	 * @return void
	 */
	public function testTranslation(): void {
		$authKey = getenv('DEEPL_AUTH_KEY');
		$this->assertNotFalse($authKey, 'DeepL auth key environment variable no set.');

		$translator = new Translator($authKey);
		$this->assertEquals(
			'Hallo Welt',
			$translator->translate('Hello World', null, TargetLanguage::GERMAN)->getText(),
			'Translated text not matching'
		);
	}
}
