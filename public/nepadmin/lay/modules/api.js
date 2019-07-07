//请求URL
layui.define([], function (exports) {
    exports('api', {
        login: 'users/login',

        getMenu: 'auths/get_menu',
        getGoods: 'json/goods.js',

        // 权限管理
        getAuthList: 'auths/get_tree_list',
        saveAuthList: 'auths/save_tree_list',
        addAuth: 'auths/add',
        getAllAuth: 'auths/getAll',

        // 系统管理
        clearCache: 'system/clearCache',
        showCache: 'system/showCache',

    });
});