/**
 * Blogs edit Javascript
 */
NetCommonsApp.requires.push('datetimepicker');
NetCommonsApp.config(
    [
      'datetimepickerProvider',
      function(datetimepickerProvider) {
        datetimepickerProvider.setOptions({
          locale: moment.locale('ja'),  // ε(　　　　 v ﾟωﾟ)　＜ 多言語対応時は書き換えてね
          format: 'YYYY-MM-DD HH:mm',
          sideBySide: true,
          stepping: 5
        });
      }
    ]
);
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
