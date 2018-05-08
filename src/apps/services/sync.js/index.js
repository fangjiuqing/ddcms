var path = require('path')
var chokidar = require('chokidar')
var watcher = null
var ready = false
const qiniu = require("qiniu")
const proc = require("process")
const prefix = path.resolve('../../api/data/attachment') + '/'
const bucketName = 'ddzz'
const aKey = 'u_JjrlzWfKefeyKPfsINZWWi1RUT7lh_I1S2dazn'
const sKey = 'Nsvra06C8FZc37Jg7YA8SAKPBFm34avv5EnCJMjW'
var helper = {

  // 获取token
  getToken: function () {
    var mac = new qiniu.auth.digest.Mac(aKey, sKey)
    var putPolicy = new qiniu.rs.PutPolicy({
       scope: bucketName,
       expires: 600
    })
    return putPolicy.uploadToken(mac)
  },

  // 获取上传助手
  getUploader: function () {
    return new qiniu.form_up.FormUploader(new qiniu.conf.Config())
  },

  // 添加文件
  putFile: function (key, localFile) {
    this.getUploader().putFile(this.getToken(), key, localFile, null, function(err, body, info) {
      if (err) {
        console.log(err)
      }

      if (info.statusCode == 200) {
        console.log('Success => ' + body.key);
      } else {
        console.log(body)
      }
    })
  },

  // 删除文件
  rmFile: function (key) {
    bucketManager = new qiniu.rs.BucketManager(
      new qiniu.auth.digest.Mac(aKey, sKey), 
      new qiniu.conf.Config()
    )
    bucketManager.delete(bucketName, key, function (err, body, info) {
      if (err) {
        console.log(err)
      }
      else if (info.statusCode == 200) {
        console.log('Success => ' + key);
      } else {
        console.log(body)
      }
    })
  }
}


var watch = function (helper) {

  // 文件新增时
  function addFileListener(path_) {
    if (ready) {
      key = path_.replace(prefix, '')
      console.log('add task => ' + key)
      helper.putFile(key, path_)
    }
  }

  // 文件内容改变时
  function fileChangeListener(path_) {
      console.log('File', path_, 'has been changed')
  }

  // 删除文件时，需要把文件里所有的用例删掉
  function fileRemovedListener(path_) {
      key = path_.replace(prefix, '')
      console.log('remove task => ' + key)
      helper.rmFile(key)
  }

  if (!watcher) {
    watcher = chokidar.watch(prefix)
  }

  watcher
    .on('add', addFileListener)
    .on('unlink', fileRemovedListener)
    .on('error', function (error) {
      log.info('Error happened', error);
    })
    .on('ready', function () {
      console.info('Initial scan complete. Ready for changes.');
      ready = true
    })
}
watch(helper)