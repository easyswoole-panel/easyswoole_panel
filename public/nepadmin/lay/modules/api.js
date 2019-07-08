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

        // 角色管理
        addRole: 'roles/add',
        getAllRole: 'roles/getAll',
        getRoleInfo: 'roles/getOne',
        ediRole: 'roles/update',
        delRole: 'roles/delete',

        // 系统管理
        clearCache: 'system/clearCache',
        showCache: 'system/showCache',

        // 用户管理
        getUserlist: 'users/getAll',
        addUser: 'users/add',


    });
});