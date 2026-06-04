<?php
declare( strict_types=1 );

namespace MediaWiki\Extension\EmbedVideo\EmbedService;

final class PeertubeWb extends AbstractEmbedService {
	protected $urlArgs = [ 'warningTitle' => '0', 'p2p' => '0' ];

	protected $additionalIframeAttributes = [
		'sandbox' => 'allow-same-origin allow-scripts allow-popups allow-forms',
	];

	public function getBaseUrl(): string {
		return 'https://peertube.wirenboard.com/videos/embed/%1$s';
	}

	public function getDefaultWidth(): int { return 560; }
	public function getDefaultHeight(): int { return 315; }

	protected function getUrlRegex(): array {
		return [
			'#peertube\.wirenboard\.com/(?:videos/embed|w)/([\w-]+)#i',
		];
	}

	protected function getIdRegex(): array {
		return [ '#^([\w-]+)$#i' ];
	}

	public function getCSPUrls(): array {
		return [
			'https://peertube.wirenboard.com',
			'https://static.peertube.wirenboard.com',
		];
	}
}
