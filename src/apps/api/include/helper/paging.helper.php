<?php
namespace re\rgx;

/**
 * 分页类
 */
class paging_helper extends rgx {
    
    /**
     * 最大页数
     *
     * @var unknown_type
     */
    public $max = 0;
    
    /**
     * 每页显示条数
     *
     * @var unknown_type
     */
    public $psize = 10;
    
    /**
     * 当前页码
     *
     * @var unknown_type
     */
    public $pn = 1;
    
    /**
     * 共计条数
     *
     * @var unknown_type
     */
    public $total = 0;
    
    /**
     * sql limit
     *
     * @var unknown_type
     */
    public $limit = 0;
    
    /**
     * url 页码变量名称
     *
     * @var unknown_type
     */
    public $varName = 'pn';
    
    /**
     * 是否反转排序 (倒序分页法)
     *
     * @var unknown_type
     */
    public $rev = false;
    
    /**
     * 页面url
     *
     * @var unknown_type
     */
    public $url = '';
    
    /**
     * 倒序分页排序方式
     *
     * @var unknown_type
     */
    public $desc = 'desc';
    
    /**
     * 前后页变量 , 内容为pn
     *
     * @var unknown_type
     */
    public $link = array ();
    
    /**
     * 上一页
     * @var unknown
     */
    public $prev = 0;
    
    /**
     * 下一页
     * @var integer
     */
    public $next = 0;
    
    /**
     * 架构函数
     *
     * @param Integer $total
     * @param String $varName
     * @param Integer $pid
     * @param Integer $psize
     * @param String $desc
     */
    public function __construct ($tab, $pn, $psize = 12, $desc = 'desc', $var = 'pn', $size = 5, $url = null) {
        $this->var   = $var;
        $this->total = is_numeric($tab) ? intval($tab) : $tab->keep()->count();
        $this->total = $this->total > $tab->total_limit && $tab->total_limit ? $tab->total_limit : $this->total;
        $this->psize = $psize;
        $this->pn    = intval($pn);
        $this->desc  = $desc;
        $this->url   = $url;
        if (empty($this->url)) {
            $this->url = preg_replace('/\-?' . preg_quote($var) . '(\-|\_|\=)\d+/ui', "", router::get_current_url());
        }
        $this->url = urldecode($this->url);
        $this->init();
        $this->link($size);
        if (!is_numeric($tab)) {
            $tab->limit($this->limit);
        }
    }
    
    /**
     * 初始化
     */
    public function init () {
        // 初始化总页数
        if ($this->total % $this->psize == 0) {
            $this->max = $this->total / $this->psize;
        }
        else {
            $this->max = intval($this->total / $this->psize) + 1;
        }
        // 页码控制
        if ($this->pn >= $this->max) {
            $this->pn = $this->max;
        }
        elseif ($this->pn <= 0) {
            $this->pn = 1;
        }
        // 初始化SQL参数
        $this->limit = ($this->pn - 1) * $this->psize . "," . $this->psize;
        if ($this->total <= 0) {
            $this->limit = "0,0";
        }
        // 使用倒序分页法
        if (0 && $this->pn >= intval($this->max / 2) && $this->max > 100) {
            $this->limit = (($this->max - $this->pn) * $this->psize) . "," . $this->psize;
            $this->desc = $this->desc == 'desc' ? 'asc' : 'desc';
            $this->rev = TRUE;
        }
        if ($this->pn < $this->max) {
            $this->next = $this->pn + 1;
        }
        if ($this->pn > 1) {
            $this->prev = $this->pn - 1;
        }
    }
    
    /**
     * 获取前后页
     *
     * @param unknown_type $size
     */
    public function link ($size) {
        if ($this->max > 8) {
            $m = ceil($size / 2);
            $start = ($this->pn - $m >= 2) ? ($this->pn - $m + 1) : 2;
            $end = ($this->pn + $size - $m) < $this->max ? $start + $size : $this->max;
            $end = $end < $this->max ? $end : $this->max;
            if ($end - $start < $size) {
                $start = $start - ($size - $end + $start);
            }
            $start = $start > 1 ? $start : 2;
            if ($start > 2) {
                $this->link[] = null;
            }
            for ($i = $start; $i < $end; $i ++) {
                $this->link[$i] = $i;
            }
            if ($end <= $this->max - 1) {
                $this->link[] = null;
            }
        }
        else {
            for ($i = 2; $i < $this->max; $i ++) {
                $this->link[] = $i;
            }
        }
    }
    
    /**
     * 转换成数组
     *
     * @return unknown
     */
    public function to_array () {
        return get_object_vars($this);
    }

    /**
     * 获取基本信息
     * @return [type] [description]
     */
    public function base () {
        return [
            'pn'    => $this->pn,
            'max'   => $this->max,
            'total' => $this->total,
            'psize' => $this->psize,
            'url'   => $this->url,
            'link'  => $this->link,
            'var'   => $this->var
        ];
    }
}