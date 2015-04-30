/**
 * Created by ryuji on 15/04/30.
 */
NetCommonsApp.controller('Blogs.BlogTagEdit',
  function ($scope, $filter) {
    var where = $filter('filter');

    $scope.tags = [];
    $scope.newTag = '';

    $scope.init = function(tags){
      $scope.tags = (tags) ? tags : [];
    }

    $scope.addTag = function () {
      if($scope.newTag.length > 0){
        $scope.tags.push({
          name: $scope.newTag
        });
        $scope.newTag = '';
      }
    }
    // 任意の tag を削除
    $scope.removeTag = function (currentTag) {
      $scope.tags = where($scope.tags, function (tag) {
        return currentTag !== tag;
      });
    };
  }
)
