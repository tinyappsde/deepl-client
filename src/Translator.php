<?php

namespace TinyApps\DeepL;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use TinyApps\DeepL\Exceptions\InvalidAuthKeyException;
use TinyApps\DeepL\Exceptions\InvalidRequestException;

class Translator {

	const BASE_URI = 'https://api.deepl.com/v2/';

	protected Client $client;
	protected string $authKey;

	/**
	 * Initialize DeepL client
	 *
	 * @param string $authKey
	 */
	public function __construct(string $authKey) {
		$this->authKey = $authKey;

		$this->client = new Client([
			'base_uri' => self::BASE_URI,
			'headers' => [
				'Accept' => 'application/json',
				'Content-Type' => 'application/json',
			],
			'query' => [
				'auth_key' => $authKey,
			],
		]);
	}

	/**
	 * Translate text
	 *
	 * @param string $text
	 * @param string|null $source
	 * @param string $target
	 * @param boolean $preserveFormatting
	 * @param string $splitSentences
	 * @param string $formality
	 *
	 * @throws InvalidAuthKeyException
	 * @throws InvalidRequestException
	 *
	 * @return Result
	 */
	public function translate(
		string $text,
		?string $source = null,
		string $target = 'en',
		bool $preserveFormatting = false,
		string $splitSentences = Options::SPLIT_SENTENCES_DEFAULT,
		string $formality = Options::FORMALITY_DEFAULT
	): Result {
		try {
			$params = [
				'auth_key' => $this->authKey,
				'text' => $text,
				'target_lang' => $target,
				'preserve_formatting' => $preserveFormatting ? 1 : 0,
				'split_sentences' => $splitSentences,
				'formality' => $formality,
			];

			if ($source) {
				$params['source_lang'] = $source;
			}

			$res = $this->client->request('GET', 'translate', ['query' => $params]);
			return Result::fromJSON($res->getBody());
		} catch (ClientException $e) {
			switch ($e->getResponse()->getStatusCode()) {
				case 403:
					throw new InvalidAuthKeyException();
					break;

				case 400:
					throw new InvalidRequestException($e->getResponse()->getBody());
					break;

				default:
					throw $e;
			}
		}
	}
}
