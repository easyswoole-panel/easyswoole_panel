# easyswoole_admin部署教程

① 上传源码  composer install 

② 开设网站  指向目录 public目录 纯静态 不加载php

③ es安装 修改dev.php mysql配置  

④ 导出mysql  在public目录下的sql文件

⑤ public/nepadmin/config.js搜索 requestUrl  请求url换成你自己的

⑥ EasySwooleEvent.php  106行 设置跨域  填写加入 第二步开设的域名  新增

⑦ 管理员账号 1001 123456   测试账号 100083 123456   可以看到测试账号的菜单只有权限管理，点击查看缓存、清除缓存会提示没有权限  （页面权限和接口权限是两回事）

⑧ layui调试模式  在public/index.html 
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