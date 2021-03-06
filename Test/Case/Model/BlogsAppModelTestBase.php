<?php
/**
 * BlogsAppModelTestBase
 *
 * @author   Ryuji AMANO <ryuji@ryus.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for Tag Test Case
 */
class BlogsAppModelTestBase extends CakeTestCase {

/**
 * Trackableビヘイビアで必用な関連モデルが増えすぎるので除去する
 *
 * @param Model $Model Trackableを引きはがすモデル
 * @return void
 */
	protected function _unloadTrackable(Model $Model) {
		$Model->Behaviors->unload('NetCommons.Trackable');
		$Model->unbindModel(array('belongsTo' => array('TrackableCreator', 'TrackableUpdater')), false);
	}

/**
 * ダミーテスト
 *
 * @return void
 */
	public function testIndex() {
	}
}
