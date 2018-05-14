package main

import (
	"../helper"
	"database/sql"
	"encoding/json"
	"github.com/go-redis/redis"
	_ "github.com/go-sql-driver/mysql"
	"log"
	"os"
	"time"
	"io"
	"strconv"
)

/**
 * 获取数据库操作链接对象
 * @param  {[type]} ) (*sql.DB,     error [description]
 * @return {[type]}   [description]
 */
func getDB() (*sql.DB, error) {
	dsn := "root:123456@tcp(188.server:3306)/ddzz?charset=utf8&autocommit=true"
	return sql.Open("mysql", dsn)
}

/**
 * 文件同步
 * @param  {[type]} db       *sql.DB         [description]
 * @param  {[type]} uploader *UploaderHelper [description]
 * @param  {[type]} msg      string          [description]
 * @return {[type]}          [description]
 */
func syncFile(db *sql.DB, uploader *helper.UploaderHelper, msg string) {
	row := make(map[string]interface{})
	json.Unmarshal([]byte(msg), &row)
	data := row["data"].(map[string]interface{})
	sKey := data["key"].(string)
	sPath := data["path"].(string)

	log.Println("Sync File  \t", sKey, " => ", sPath)
	// 更新任务状态
	db.Exec("update pre_task set task_status = 4 where task_id =?", row["id"])

	_, err := uploader.PutFile(sKey, sPath)
	t := time.Now()
	if err != nil {
		log.Println(err)
		db.Exec("update pre_task set task_status = 1, task_cdate =?, task_result =? where task_id =?", t.Unix(), "Fail", row["id"])
		log.Println("Sync Fail\t", sKey)
	} else {
		db.Exec("update pre_task set task_status = 10, task_cdate =?, task_result =? where task_id =?", t.Unix(), "Success", row["id"])
		log.Println("Sync Success\t", sKey)
	}
}

/**
 * 判断目录或文件是否存在
 * @param {[type]} path string) (bool [description]
 */
func PathExists(path string) bool {
	_, err := os.Stat(path)
	if err == nil {
		return true
	}
	if os.IsNotExist(err) {
		return false
	}
	return false
}

/**
 * 文件同步删除
 * @param  {[type]} db       *sql.DB         [description]
 * @param  {[type]} uploader *UploaderHelper [description]
 * @param  {[type]} msg      string          [description]
 * @return {[type]}          [description]
 */
func delFile(db *sql.DB, uploader *helper.UploaderHelper, msg string) {
	row := make(map[string]interface{})
	json.Unmarshal([]byte(msg), &row)
	data := row["data"].(map[string]interface{})
	sKey := data["key"].(string)
	sPath := data["path"].(string)

	log.Println("Delete File  \t", sKey, " => ", sPath)
	// 更新任务状态
	db.Exec("update pre_task set task_status = 4 where task_id =?", row["id"])

	err := uploader.DelFile(sKey)
	if err != nil {
		log.Println(err)
	} else {
		if PathExists(sPath) {
			os.Remove(sPath)
			log.Println("Delete local file \t", sPath)
		}
		t := time.Now()
		db.Exec("update pre_task set task_status = 10, task_cdate =?, task_result =? where task_id =?", t.Unix(), "Success", row["id"])
		log.Println("Delete Success\t", sKey)
	}
}

func main() {
    if PathExists("./pid") {
        log.Println("Sync service has already started")
        os.Exit(0)
    }

    f, _ := os.OpenFile("./pid", os.O_WRONLY | os.O_CREATE, os.ModePerm)
    f.Truncate(0)
    io.WriteString(f, strconv.Itoa(os.Getpid()))
    f.Close()

	client := redis.NewClient(&redis.Options{
		Addr:     "188.server:6379",
		Password: "",
		DB:       0,
	})
	_, err := client.Ping().Result()
	if err != nil {
		panic(err)
	}
	log.Println("Sync Service started ")

	pubsub := client.PSubscribe("RMQ_sync*")
	db, err := getDB()
	if err != nil {
		panic(err)
	}

	defer pubsub.Close()
	defer client.Close()
	defer db.Close()

	uploader := (&helper.UploaderHelper{}).Init()
	for {
		msg, err := pubsub.ReceiveMessage()
		if err != nil {
			break
		}
		log.Println("Received \t", msg.Payload, "Channel ", msg.Channel)
		if msg.Channel == "RMQ_sync_add" {
			go syncFile(db, uploader, msg.Payload)
		} else if msg.Channel == "RMQ_sync_del" {
			go delFile(db, uploader, msg.Payload)
		}
	}

	return
}
