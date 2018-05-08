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
		Expires: 36000,
	}

	helper.mac = qbox.NewMac("u_JjrlzWfKefeyKPfsINZWWi1RUT7lh_I1S2dazn", "Nsvra06C8FZc37Jg7YA8SAKPBFm34avv5EnCJMjW")
	helper.token = helper.policy.UploadToken(helper.mac)
	helper.FUploader = storage.NewFormUploader(&storage.Config{})
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
 * helo
 */
func (helper *UploaderHelper) Helo() string {
	return "Jack Ma"
}
