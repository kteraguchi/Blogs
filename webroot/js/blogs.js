/**
 * Blogs Javascript
 */
NetCommonsApp.controller('Blogs.Entries',
    function($scope) {
      $scope.selectStatus = 0;
      $scope.selectCategory = 0;
      $scope.selectYearMonth = 0;
      $scope.frameId = 0;

      $scope.init = function(frameId) {
        $scope.frameId = frameId;
      };
    }
);

NetCommonsApp.controller('Blogs.Entries.Entry',
    function($scope) {
      $scope.isShowBody2 = false;

      $scope.showBody2 = function() {
        $scope.isShowBody2 = true;
      };
      $scope.hideBody2 = function() {
        $scope.isShowBody2 = false;

      };
    }
);

// ε(　　　　 v ﾟωﾟ)　＜ 設定画面用？
//NetCommonsApp.controller('Blogs.Entry', function($scope) {
//
//  /**
//   * Use like button
//   *
//   * @return {void}
//   */
//  $scope.useLike = function() {
//    var likeElement = $('#BbsSettingUseLike');
//    var unlikeElement = $('#BbsSettingUseUnlike');
//
//    if (likeElement[0].checked) {
//      unlikeElement[0].disabled = false;
//    } else {
//      unlikeElement[0].disabled = true;
//    }
//  };
//});
