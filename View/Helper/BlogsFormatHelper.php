<?php
/**
 * Created by PhpStorm.
 * User: ryuji
 * Date: 15/03/06
 * Time: 14:57
 */
App::uses('AppHelper', 'View/Helper');

class BlogsFormatHelper extends AppHelper {

/**
 * @param $datetime
 * @return bool|string
 */
	public function publishedDatetime($datetime) {
		// ε(　　　　 v ﾟωﾟ)　＜NetCommons.Dateを使うように差し替え
		return date('Y-m-d H:i', strtotime($datetime));
	}

}