# V3版本更名Panel 

开发中！开发中！开发中！开发中！

请下载打了tag到 V1 V2版本  看最下方的安装教程

## V3 Introduction

核心 :pushpin:  可视化管理一切

- :sparkles: 插件市场，提供插件的安装和管理，是panel的核心内置组件
- :pencil2: 数据库备份管理
- :hammer: IP限流器（可视化配置，总限流、分组限流、账号token限流等）
- :page_facing_up: fast-cache面板，一键开启数据落地(无需再像以前一样写上百行代码了)，在线查看管理数据
- :page_facing_up: CURD在线生成，解放你的双手
- :page_facing_up: EasySwoole服务在线管理，重载、重启、关闭服务(调试不再那么痛苦)
- :page_facing_up: 连接池使用率  如ORM REDIS 等连接池 可以实时看到状态、分析使用情况
- :page_facing_up: 基于注解的API文档 在线生成查看
 


# easyswoole_admin部署教程


v1版本使用mysqli组件+pool

v2版本使用orm组件 建议


下载地址：https://github.com/xuanyanwow/easyswoole_admin/tags

下载源码压缩包 

① 上传源码，并执行 composer install

② es安装  php vendor/easyswoole/easyswoole/bin/easyswoole install  所有提示都输入n 回车

③ 修改dev.php mysql配置  导入mysql结构数据(在public目录下的sql文件)

④ public/nepadmin/config.js搜索 requestUrl  请求url换成你自己的es服务地址  IP:Port

⑤ 访问 IP:Port 自动进入index.html页面

⑥ 管理员账号 1001 123456   测试账号 100083 123456   可以看到测试账号的菜单只有权限管理，点击查看缓存、清除缓存会提示没有权限  （页面权限和接口权限是两回事）

⑦ layui调试模式开关 在public/index.html 
```
// version: Date.parse(new Date()),
debug: false
```

# 作者

Siam - 宣言 - QQ 59419979

可以在easyswoole 1群、2群(管理员)找到俺

# 截图演示

![Image text](./public/temimg/easysiam.jpg)
![Image text](./public/temimg/easysiam2.jpg)
![Image text](./public/temimg/easysiam3.jpg)

# 权限控制dom
在权限页面有三个按钮
```html

<button class="layui-btn" data-siam-auth="!testtets">没有testtets权限则显示</button>
<button class="layui-btn" data-siam-auth="/api/*">有/api/*权限则显示</button>
<button class="layui-btn" data-siam-auth="/admin/*">有/admin/*权限则显示</button>
```

在dom中使用 data-siam-auth='规则名'  视图显示时候则可自动移除没权限的dom

也可以手动调用验证
```javascript
// 手动调用验证权限
if ( layui.siam.vifAuth('/api/system/clearCache')){
    layer.msg('有/api/system/clearCache的权限');
}else{
    layer.msg('没有/api/system/clearCache的权限');
}
```
