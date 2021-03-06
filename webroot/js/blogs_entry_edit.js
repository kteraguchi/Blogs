/**
 * Blogs edit Javascript
 */
NetCommonsApp.controller('Blogs',
    function($scope, NetCommonsWysiwyg, $filter) {
      /**
       * tinymce
       *
       * @type {object}
       */
      $scope.tinymce = NetCommonsWysiwyg.new();

      $scope.writeBody2 = false;

      $scope.init = function(data) {
        if (data.BlogEntry) {
          $scope.blogEntry = data.BlogEntry;
          if ($scope.blogEntry.body2 !== null) {
            if ($scope.blogEntry.body2.length > 0) {
              $scope.writeBody2 = true;
            }
          }
        }
      };

      $scope.blogEntry = {
        body1: '',
        body2: '',
        published_datetime: ''
      };
    }
);
