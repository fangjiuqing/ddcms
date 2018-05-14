package helper

import (
	"context"
	"github.com/qiniu/api.v7/auth/qbox"
	"github.com/qiniu/api.v7/storage"
	"log"
)

/**
 * 上传助手
 */
type UploaderHelper struct {
	FUploader *storage.FormUploader
	BMgr      *storage.BucketManager
	token     string
	mac       *qbox.Mac
	policy    *storage.PutPolicy
}

/**
 * 获取上传助手
 */
func (helper *UploaderHelper) Init() *UploaderHelper {
	helper.policy = &storage.PutPolicy{
		Scope:   "ddzz",
		Expires: 86400000,
	}

	helper.mac = qbox.NewMac("u_JjrlzWfKefeyKPfsINZWWi1RUT7lh_I1S2dazn", "Nsvra06C8FZc37Jg7YA8SAKPBFm34avv5EnCJMjW")
	helper.token = helper.policy.UploadToken(helper.mac)
	helper.FUploader = storage.NewFormUploader(&storage.Config{})
	helper.BMgr = storage.NewBucketManager(helper.mac, &storage.Config{})
	return helper
}

/**
 * 上传文件
 * @param  {[type]} helper *UploaderHelper) putFile (fileKey, filePath string) (code int, err error [description]
 * @return {[type]}        [description]
 */
func (helper *UploaderHelper) PutFile(fileKey, filePath string) (code int, err error) {
	ret := storage.PutRet{}
	err = helper.FUploader.PutFile(context.Background(), &ret, helper.token, fileKey, filePath, nil)
	if err != nil {
		log.Println(err)
		return
	}
	return
}

/**
 * 删除文件
 * @param  {[type]} helper *UploaderHelper) putFile (fileKey, filePath string) (code int, err error [description]
 * @return {[type]}        [description]
 */
func (helper *UploaderHelper) DelFile(fileKey string) (err error) {
	err = helper.BMgr.Delete("ddzz", fileKey)
	if err != nil {
		log.Println(err)
		return
	}
	return err
}

/**
 * helo
 */
func (helper *UploaderHelper) Helo() string {
	return "Jack Ma"
}
