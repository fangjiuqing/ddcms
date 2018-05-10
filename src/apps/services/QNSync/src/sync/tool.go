package main

import (
	"../helper"
	"log"
	"os"
	"path/filepath"
	"strings"
)

/**
 * 目录遍历
 * @param {[type]} dirPth [description]
 * @param {[type]} suffix string)       (files []string, err error [description]
 */
func WalkDir(dirPth, suffix string) (files []string, err error) {
	files = make([]string, 0, 30)
	suffix = strings.ToUpper(suffix)
	err = filepath.Walk(dirPth, func(filename string, fi os.FileInfo, err error) error {
		if fi.IsDir() { // 忽略目录
			return nil
		}
		if strings.HasSuffix(strings.ToUpper(fi.Name()), suffix) {
			files = append(files, filename)
		}
		return nil
	})
	return files, err
}

/**
 * 执行同步
 * tool /path/to/files
 * @return {[type]} [description]
 */
func main() {
	distDir := os.Args[1]
	prefix := os.Args[2]
	if !filepath.IsAbs(os.Args[1]) {
		dst, err := filepath.Abs(os.Args[1])
		if err == nil {
			distDir = dst
		}
	}
	files, _ := WalkDir(distDir, ".jpg")
	log.Println("Dist\t", distDir)

	for k, sPath := range files {
		sKey, _ := filepath.Rel(distDir, sPath)
		sKey = prefix + "/" + sKey
		uploader := (&helper.UploaderHelper{}).Init()
		_, err := uploader.PutFile(sKey, sPath)
		if err != nil {
			log.Println(err)
		} else {
			log.Println("Success\t", len(files), " - ", k+1, "\t", sKey)
		}
	}
	return
}
