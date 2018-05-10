package main

import (
	"./libs"
	"database/sql"
	"encoding/json"
	"github.com/go-redis/redis"
	_ "github.com/go-sql-driver/mysql"
	"log"
	"strconv"
	"time"
    "os"
    "io"
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
 * 发送短信
 * @param  {[type]} db  *sql.DB       [description]
 * @param  {[type]} qs  *libs.QQSMS   [description]
 * @param  {[type]} msg string        [description]
 * @return {[type]}     [description]
 */
func sendSMS(db *sql.DB, qs *libs.QQSMS, msg string) {
	row := make(map[string]interface{})
	json.Unmarshal([]byte(msg), &row)
	data := row["data"].(map[string]interface{})
	for k, v := range data {
		switch vv := v.(type) {
		case int:
			data[k] = strconv.Itoa(vv)
		case int64:
			data[k] = strconv.FormatInt(vv, 10)
		case float64:
			data[k] = strconv.FormatFloat(vv, 'f', 0, 64)
		}
	}
	log.Println("Send SMS  \t", data["mobile"])
	// 更新任务状态
	db.Exec("update pre_task set task_status = 4 where task_id =?", row["id"])
	rs := qs.SendVerify(data["tpl_id"].(string), data["mobile"].(string), data["code"].(string), data["ttl"].(string))
	if rs {
		t := time.Now()
		db.Exec("update pre_task set task_status = 10, task_cdate =?, task_result =? where task_id =?", t.Unix(), "Success", row["id"])
		log.Println("Success \t", data["mobile"])
	} else {
		log.Println("@@@Fail \t", data["mobile"])
	}
}

func main() {
    if PathExists("./pid") {
        log.Println("SMS service has already started")
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
	log.Println("SMS Service started")

	pubsub := client.Subscribe("RMQ_sms")
	db, err := getDB()
	if err != nil {
		panic(err)
	}

	defer pubsub.Close()
	defer client.Close()
	defer db.Close()

	QS := &libs.QQSMS{
		"1400089340",
		"6f640b1db75ab8ed76bcc2f654b593e6",
		"道达智装",
	}
	for {
		msg, err := pubsub.ReceiveMessage()
		if err != nil {
			break
		}
		log.Println("Received \t", msg.Payload, "Channel ", msg.Channel)
		go sendSMS(db, QS, msg.Payload)
	}

	return
}
