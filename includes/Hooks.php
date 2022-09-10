<?php
namespace MediaWiki\Extension\SteamDBChart;

use MediaWiki\Hook\ParserFirstCallInitHook;
use Html;
use Parser;
use PPFrame;
use Sanitizer;

class Hooks implements ParserFirstCallInitHook {
	public function onParserFirstCallInit( $parser ) {
		$parser->setHook( 'steamdb', [ $this, 'steamdbTagHook' ] );
	}

	public function steamdbTagHook( $input, array $args, Parser $parser, PPFrame $frame ) {
		if ( isset( $args['appid'] ) && preg_match( '/^[0-9]+$/', $args['appid'] ) ) {
			$appid = $args['appid'];
		} else {
			return '<strong class="error">' . wfMessage( 'steamdb-chart-no-appid' )->parse() . '</strong>';
		}

		$attr['src'] = 'https://steamdb.info/embed/?appid=' . $appid;
		$attr['height'] = "389";
		$attr['style'] = "border:0;overflow:hidden;width:100%";
		$attr['loading'] = "lazy";

		$html = Html::element( 'iframe', $attr, 'SteamDB' );

		return $html;
	}
}
