<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetApiDocumentation;

/**
 * Class GetApiDocumentationRequest
 *
 * @package App\Application\Domain\UseCase\GetApiDocumentation
 */
readonly class GetApiDocumentationRequest {

	public function __construct(
		private string $projectDictionary,
		private array  $exclude = ['tests'],
		private string $pattern = '*.php'
	) {
	}

	public function getProjectDictionary(): string {
		return $this->projectDictionary;
	}

	public function getExclude(): array {
		return $this->exclude;
	}

	public function getPattern(): string {
		return $this->pattern;
	}

}
