<<<<<<< HEAD
---
title: 短网址
tags: PHP,动态存库,短网址
grammar_cjkRuby: true
---

**目录**
 - config.php               配置文件
 - index.html               配置错误提示页
 - index.php                首页
 - redirect.php             路由转发
 - short.php                 短网址处理
 - htaccess                转发规则


**安装**

    1. 安装PHP集成环境（Xampp,phpstudy等）
 
    2.克隆项目到本地
 
    3.在Apache  httpd-vhosts.conf  配置项目路径
 
    4.config.php配置数据库，是否缓存（启用缓存需要在根目录创建cache文件夹）
  
    5.根据配置文件创建数据库
  
    6.hosts        127.0.0.1   url.cn（例）
  
    7.访问 ceeety.com

**API**

**短链接生成**
  this.com/shorten/[URL_ENCODE地址]
  结果返回
  {"short_id":"94wWx2","short_url":"http:\/\/this.com\/94wWx2","long_url":"https:\/\/www.hao123.com\/?tn=90009619_s_hao_pg"}
  
**短链接跳转**
  this.com/94wWx2
=======
# shortUrl
短网址
>>>>>>> 0250913058a4c924c5a72980af348e005f1669cd
