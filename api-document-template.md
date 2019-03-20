
API document `（version:1.0.1,auth:myzero1,date:2019/03/20）`
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
        - [1.2.4. api 示例](#124-api-示例)
            - [1.2.4.1. 错误吗说明](#1241-错误吗说明)
            - [1.2.4.2. get list](#1242-get-list)
            - [1.2.4.3. post item](#1243-post-item)
            - [1.2.4.4. get item](#1244-get-item)
            - [1.2.4.5. put item](#1245-put-item)
            - [1.2.4.6. delete item](#1246-delete-item)

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



### 1.2.4. api 示例

实际的api测试用例如下



[&Uparrow;&Uparrow;&Uparrow;&Uparrow;&Uparrow;](#1-tables)

#### 1.2.4.1. 错误吗说明

|        状态码    |            详情                        |
|-----------------|:----------------------------------------:|
|  0 | 返回正确  |
| 4XX | 客户错误  |
| 5XX | 服务端错误  |



[&Uparrow;&Uparrow;&Uparrow;&Uparrow;&Uparrow;](#1-tables)

#### 1.2.4.2. get list

|  类别 |  详情     |
|-------|:---------:|
|  用途 | 根据参数获取列表  |
|  方式 | GET  |
|  接口 | /v1/host/user  |
|  示例 | /v1/host/user?page=1&page_size=30 |

参数
```
page=1&page_size=30&name=woogle
```

参数说明
```
非特殊说明参数都没可选,带星号的为必填。

page*： 1 // 第几页
page_size： 20 //每一页多少条记录
name: "woogle" // 用户名称
```

返回
```
{
    "code": 0,
    "msg": "成功"，
    "data": {
        "total": 30,
        "page": 1,
        "page_size": 20,
        "items": [
            {
                "id": 1,
                "name": "woogle"
            },
            {
                "id": 1,
                "name": "woogle"
            },
            ......

        ]
    }
}

```

返回说明
```
id: 用户id
name： 用户名称

```



[&Uparrow;&Uparrow;&Uparrow;&Uparrow;&Uparrow;](#1-tables)



#### 1.2.4.3. post item

|  类别 |  详情     |
|-------|:---------:|
|  用途 | 添加单条数据  |
|  方式 | POST  |
|  接口 | /v1/host/user/  |
|  示例 | /v1/host/user |

参数
```
{
  "name": "myzero1"
}
```

参数说明
```
非特殊说明参数都没可选,带星号的为必填。

name*: 用户名
```

返回
```
{
    "code": 0,
    "msg": "成功"，
    "data": {
        "id": 2,
        "name": "myzero1"
    }
}

```

返回说明
```
id: 用户id
name： 用户名称

```



[&Uparrow;&Uparrow;&Uparrow;&Uparrow;&Uparrow;](#1-tables)



#### 1.2.4.4. get item

|  类别 |  详情     |
|-------|:---------:|
|  用途 | 获取单条详细数据  |
|  方式 | GET  |
|  接口 | /v1/host/user/{id}  |
|  示例 | /v1/host/user/1 |

参数
```
1
```

参数说明
```
非特殊说明参数都没可选,带星号的为必填。

{id}*: 用户id，此处为数字
```

返回
```
{
    "code": 0,
    "msg": "成功"，
    "data": {
        "id": 1,
        "name": "woogle"
    }
}

```

返回说明
```
id: 用户id
name： 用户名称

```



[&Uparrow;&Uparrow;&Uparrow;&Uparrow;&Uparrow;](#1-tables)




#### 1.2.4.5. put item

|  类别 |  详情     |
|-------|:---------:|
|  用途 | 修改单条数据  |
|  方式 | PUT  |
|  接口 | /v1/host/user/{id}  |
|  示例 | /v1/host/user/1 |

参数
```
{
  "name": "myzero2"
}
```

参数说明
```
非特殊说明参数都没可选,带星号的为必填。

{id}*: 用户id，此处为数字
```

返回
```
{
    "code": 0,
    "msg": "成功"，
    "data": {
        "id": 1,
        "name": "myzero2"
    }
}

```

返回说明
```
id: 用户id
name： 用户名称

```



[&Uparrow;&Uparrow;&Uparrow;&Uparrow;&Uparrow;](#1-tables)

#### 1.2.4.6. delete item

|  类别 |  详情     |
|-------|:---------:|
|  用途 | 删除单条数据  |
|  方式 | DELETE  |
|  接口 | /v1/host/user/{id}  |
|  示例 | /v1/host/user/1 |

参数
```
/1
```

参数说明
```
非特殊说明参数都没可选,带星号的为必填。

{id}*: 用户id，此处为数字
```

返回
```
{
    "code": 0,
    "msg": "成功"，
    "data": []
}

```

返回说明
```
删除时data我空数组

```



[&Uparrow;&Uparrow;&Uparrow;&Uparrow;&Uparrow;](#1-tables)
