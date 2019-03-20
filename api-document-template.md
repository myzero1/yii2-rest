
`API document`
------

# 1. tables
<!-- TOC -->

- [1. tables](#1-tables)
    - [1.1. 使用说明](#11-使用说明)
        - [1.1.1. 使用title](#111-使用title)
        - [1.1.2. 跳回顶部的说明](#112-跳回顶部的说明)
        - [1.1.3. 标题下面的内容说明](#113-标题下面的内容说明)
    - [1.2. 模板使用](#12-模板使用)
        - [1.2.1. 安装插件](#121-安装插件)
        - [1.2.2. 使用模板](#122-使用模板)
        - [1.2.3. 使用ajax测试api](#123-使用ajax测试api)

<!-- /TOC -->

## 1.1. 使用说明

主要的说明都将写在这部分

[&Uparrow;&Uparrow;&Uparrow;&Uparrow;&Uparrow;](#1-tables)



### 1.1.1. 使用title

* 一级标题被table站在用了
* 二级以下标题才是真正的标题

[&Uparrow;&Uparrow;&Uparrow;&Uparrow;&Uparrow;](#1-tables)



### 1.1.2. 跳回顶部的说明

跳回顶部规定价值每个标题下面内容的最后，且和下一个标题直接空3行，和本标题下的内空一行。

[&Uparrow;&Uparrow;&Uparrow;&Uparrow;&Uparrow;](#1-tables)

### 1.1.3. 标题下面的内容说明

```
内容于本标题空一行，内容与回到顶部

```

## 1.2. 模板使用



安装相应的插件（markdown toc），复制模板。

[&Uparrow;&Uparrow;&Uparrow;&Uparrow;&Uparrow;](#1-tables)



### 1.2.1. 安装插件

在vscode中可以直接搜索 markdown toc，并安装就可以了。使用时，鼠标右键选择相应的功能即可

[&Uparrow;&Uparrow;&Uparrow;&Uparrow;&Uparrow;](#1-tables)



### 1.2.2. 使用模板

直接复制本模板到markdown文件中，安装说明，进行相应的编辑就可以了。

[&Uparrow;&Uparrow;&Uparrow;&Uparrow;&Uparrow;](#1-tables)



### 1.2.3. 使用ajax测试api

```js
var url = "http://172.16.62.242:8735/v1/auth/info";
var type = "get"//POST、PUT、DELETE
var authorization = "Bearer Y057DL29xjEwXHAGOVXW9PfGF-xsSIoW_1552974468";
var data = {};

$.ajax({
    url: url,
    type: type,//POST、PUT、DELETE
	//data:JSON.stringify(myData),//你要传的参数
	data: data,//你要传的参数
	processData:false,//是否对参数进行序列化，会把{name:'huang',sex:1}序列化name='huang'&sex=1,默认为true。
	contentType:"application/json",//这里是Header中自带的contentType
    beforeSend: function (xhr) { 
        xhr.setRequestHeader("Authorization", authorization);//你要传的参数
    },
    success: function (data) {
        console.log(data);
    },
    error: function (xhr, textStatus, errorThrow) {
        alert("error:"+xhr.readyState);
    }
});
```

[&Uparrow;&Uparrow;&Uparrow;&Uparrow;&Uparrow;](#1-tables)
