<?php
declare( strict_types=1 );

namespace MediaWiki\Extension\EmbedVideo\EmbedService;

final class PeertubeWbPlaylist extends AbstractEmbedService {
	protected $urlArgs = [
		'warningTitle' => '0',
		'p2p' => '0',
	];

	protected $additionalIframeAttributes = [
		'sandbox' => 'allow-same-origin allow-scripts allow-popups allow-forms',
	];

	public function getBaseUrl(): string {
		return 'https://peertube.wirenboard.com/video-playlists/embed/%1$s';
	}

	public function getDefaultWidth(): int {
		return 560;
	}

	public function getDefaultHeight(): int {
		return 315;
	}

	protected function getUrlRegex(): array {
		return [
			'#peertube\.wirenboard\.com/video-playlists/embed/([\w-]+)(?:\?[\w=-]+)?#i',
		];
	}

	protected function getIdRegex(): array {
		return [ '#^([\w-]+)$#i' ];
	}

	public function parseVideoID( $id ): string {
		$parsedId = parent::parseVideoID( $id );

		$query = parse_url( $id, PHP_URL_QUERY );
		if ( !empty( $query ) ) {
			parse_str( $query, $params );
			if ( !empty( $params ) ) {
				$this->setUrlArgs( $params );
			}
		}

		// Privacy defaults must always win: a playlist URL must not be able to
		// re-enable P2P or the warning title through its query string.
		$this->urlArgs['warningTitle'] = '0';
		$this->urlArgs['p2p'] = '0';

		return $parsedId;
	}

	public function getCSPUrls(): array {
		return [
			'https://peertube.wirenboard.com',
			'https://static.peertube.wirenboard.com',
		];
	}
}
