<?php

namespace TinyApps\DeepL;

class Result {

	protected string $text;
	protected ?string $detectedSourceLanguage;

	public function __construct(string $text, ?string $detectedSourceLanguage = null) {
		$this->text = $text;
		$this->detectedSourceLanguage = $detectedSourceLanguage;
	}

	/**
	 * Returns new instance from API response JSON
	 *
	 * @param string $json
	 *
	 * @return self
	 */
	public static function fromJSON(string $json): self {
		$response = json_decode($json);
		return new self($response->translations[0]->text, $response->translations[0]->detected_source_language);
	}

	/**
	 * Get the translated text
	 *
	 * @return string
	 */
	public function getText(): string {
		return $this->text;
	}

	/**
	 * Get the detected source language (if auto detection enabled)
	 *
	 * @return string|null
	 */
	public function getDetectedSourceLanguage(): ?string {
		return $this->detectedSourceLanguage;
	}
}
