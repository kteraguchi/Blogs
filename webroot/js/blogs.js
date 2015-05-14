/**
 * Blogs.edit Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $modalStack)} Controller
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
        body2: ''
      };
    });

NetCommonsApp.controller('Blogs.Entries',
    function($scope) {
      $scope.selectStatus = 0;
      $scope.selectCategory = 0;
      $scope.selectYearMonth = 0;
      $scope.frameId = 0;

      $scope.init = function(frameId) {
        $scope.frameId = frameId;
      };


      $scope.filterStatus = function() {
        // requestUrlにstatus:1 って感じにselectStatus付けてフィルタリングする
        // リダイレクト
        var url = '/blogs/blog_entries/index/' +
            $scope.frameId + '/status:' + $scope.selectStatus;
        location.href = url;
      };

      $scope.filterCategory = function() {
        var url = '/blogs/blog_entries/index/' +
            $scope.frameId + '/category_id:' + $scope.selectCategory;
        location.href = url;

      };

      $scope.moveYearMonth = function() {
        var url = '/blogs/blog_entries/year_month/' +
            $scope.frameId + '/year_month:' + $scope.selectYearMonth;
        location.href = url;

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
