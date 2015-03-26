/**
 * Blogs.edit Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, $modalStack)} Controller
 */
NetCommonsApp.controller('Blogs',
    function($scope, NetCommonsWysiwyg, $filter) {

        // お知らせで他に渡してたもの
        //NetCommonsBase, ,
        //    NetCommonsTab, NetCommonsUser, NetCommonsWorkflow

        /////**
        // * tab
        // *
        // * @type {object}
        // */
        //$scope.tab = NetCommonsTab.new();
        //
        ///**
        // * show user information method
        // *
        // * @param {number} users.id
        // * @return {string}
        // */
        //$scope.user = NetCommonsUser.new();

        /**
         * tinymce
         *
         * @type {object}
         */
        $scope.tinymce = NetCommonsWysiwyg.new();

        $scope.writeBody2 = false;

        $scope.init = function(data){
            $scope.blogEntry = data.BlogEntry;
            $scope.tags = (data.BlogTag) ? data.BlogTag : [];
            if($scope.blogEntry.body2){
                $scope.writeBody2 = true;
            }
        }

        $scope.blogEntry = {
            body1 :'',
            body2 : ''
        }

        var where = $filter('filter');

        $scope.tags = [];
        $scope.newTag = '';
        $scope.addTag = function(){
            $scope.tags.push({
                name: $scope.newTag
            });
            $scope.newTag = '';
        }
        // 任意の tag を削除
        $scope.removeTag = function (currentTag) {
            $scope.tags = where($scope.tags, function (tag) {
                return currentTag !== tag;
            });
        };        ///**
        // * workflow
        // *
        // * @type {object}
        // */
        //$scope.workflow = NetCommonsWorkflow.new($scope);
        //
        ///**
        // * serverValidationClear method
        // *
        // * @param {number} users.id
        // * @return {string}
        // */
        //$scope.serverValidationClear = NetCommonsBase.serverValidationClear;
        //
        ///**
        // * form
        // *
        // * @type {form}
        // */
        //// $scope.form = {};
        //
        ///**
        // * master
        // *
        // * @type {object}
        // */
        //// $scope.master = {};
        //
        ///**
        // * Initialize
        // *
        // * @return {void}
        // */
        //$scope.initialize = function(data) {
        //    // $scope.form = form;
        //    $scope.announcements = angular.copy(data.announcements);
        //    // console.debug(typeof data.announcements.id == 'undefined');
        //    // console.debug($scope.announcements.id);
        //};
        //
        ///**
        // * dialog save
        // *
        // * @param {number} status
        // * - 1: Publish
        // * - 2: Approve
        // * - 3: Draft
        // * - 4: Disapprove
        // * @return {void}
        // */
        //$scope.save = function(status) {
        //    console.debug(2);
        //    // $scope.master = angular.copy($scope.announcement);
        //    // $scope.announcement.status = status;
        //    // $scope.workflow.editStatus = status;
        //    // $scope.comment = $scope.workflow.input.comment;
        //    // console.debug($scope.announcement.status);
        //
        //    // NetCommonsBase.save(
        //    //     $scope,
        //    //     $scope.form,
        //    //     $scope.plugin.getUrl('token', $scope.frameId + '.json'),
        //    //     $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
        //    //     $scope.edit,
        //    //     function(data) {
        //    //       angular.copy(data.results.announcement, $scope.announcement);
        //    //     });
        //    // NetCommonsBase.post(
        //    //   $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
        //    //   $scope.edit
        //    // );
        //};
        //
        //// $scope.reset = function() {
        ////   $scope.user = angular.copy($scope.master);
        //// };
        //
        //// $scope.reset();
    });
NetCommonsApp.controller('Blogs.Index.Entry',
    function($scope) {
        $scope.isShowBody2 = false;

        $scope.showBody2 = function(){
            $scope.isShowBody2 = true;
        }
        $scope.hideBody2 = function (){
            $scope.isShowBody2 = false;

        }
    }
)
