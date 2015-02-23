<?php

App::uses('AppController', 'Controller');

class BlogsAppController extends AppController {
	/**
	 * 現在時刻を返す。テストしやすくするためにメソッドに切り出した。
	 * @return int
	 */
	protected function getNow() {
		return time();
	}

}
