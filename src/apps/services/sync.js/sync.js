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
       expires: 600000
    })
    return putPolicy.uploadToken(mac)
  },

  // 获取上传助手
  getUploader: function () {
    var config = new qiniu.conf.Config()
    return new qiniu.form_up.FormUploader(config)
  },

  // 添加文件
  putFile: function (key, localFile, callback) {
    this.getUploader().putFile(this.getToken(), key, localFile, null, function(err, body, info) {
      if (err) {
        console.log(err)
      }

      if (info.statusCode == 200) {
        //console.log('Success => ' + body.key);
        callback && callback()
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


var fs = require("fs")
const dist = path.resolve('../../api/data/attachment/pic') + '/'
var task = []

fs.readdirSync(dist).forEach((ele, i) => {
  task.push(prefix + 'pic/' + ele)
})
const task_len = task.length
console.log('Task Length => ' + task_len);
var exec = () => {
  if (task.length > 0) {
    var local_file = task.pop()
    helper.putFile(local_file.replace(prefix, ''), local_file, exec)
    console.clear()
    console.log((task_len - task.length) + ' / ' + task_len);
  }
}
exec()