package libs

import (
	"bytes"
	"crypto/sha256"
	"encoding/hex"
	"encoding/json"
	"io/ioutil"
	"math/rand"
	"net/http"
	"strconv"
	"time"
)

type QQSMS struct {
	Id   string
	Key  string
	Sign string
}

func (qs *QQSMS) SendVerify(tpl string, mobile string, code string, ttl string) bool {
	now := time.Now().Unix()
	nowStr := strconv.FormatInt(time.Now().Unix(), 10)
	r := rand.New(rand.NewSource(now))
	random := strconv.Itoa(r.Int())

	signstr := "appkey=" + qs.Key + "&random=" + random + "&time=" + nowStr + "&mobile=" + mobile

	post := "{" +
		"\"ext\": \"\"," +
		"\"extend\": \"\"," +
		"\"params\": [" +
		"\"" + code + "\"," +
		"\"" + string(ttl) + "\"" +
		"]," +
		"\"sig\": \"" + sha256Encoding(signstr) + "\"," +
		"\"sign\": \"" + qs.Sign + "\"," +
		"\"tel\": {" +
		"\"mobile\": \"" + mobile + "\"," +
		"\"nationcode\": \"86\"" +
		"}," +
		"\"time\": " + nowStr + "," +
		"\"type\": 0," +
		"\"tpl_id\":" + tpl +
		"}"

	url := "https://yun.tim.qq.com/v5/tlssmssvr/sendsms?sdkappid=" + qs.Id + "&random=" + random

	jsonStr := []byte(post)
	req, err := http.NewRequest("POST", url, bytes.NewBuffer(jsonStr))
	req.Header.Set("Content-Type", "application/json")

	client := &http.Client{}
	resp, err := client.Do(req)
	if err != nil {
		panic(err)
	}
	defer resp.Body.Close()

	body, err := ioutil.ReadAll(resp.Body)
	if err != nil {
		panic(err)
	}
	result := make(map[string]interface{})
	json.Unmarshal([]byte(string(body)), &result)

	return result["errmsg"] == "OK"
}

func sha256Encoding(str string) (ret string) {
	h := sha256.New()
	h.Write([]byte(str))
	return hex.EncodeToString(h.Sum(nil))
}
