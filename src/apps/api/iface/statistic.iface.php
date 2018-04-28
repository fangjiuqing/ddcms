<?php
namespace re\rgx;

/**
 * 数据统计接口类
 */

class statistic_iface extends base_iface {
    /**
     * 获取统计数据
     * @id [int] 要获取设计师的id
     */
    public function get_action () {
        $this->success('', CACHE('statistic@get' , function () {
            # 获取截止到当前月的数据
            $month = date('m' , REQUEST_TIME);
            $today   = date('Ymd');
            $_3days   = date('Ymd' , strtotime('-3 days'));

            # 顾客统计 今日新增 3日新增 总数
            $cus_tab = OBJ('customer_table');
            $out['customerStatistic'] = [
                'total'    =>    $cus_tab->count(),
                'today'    =>    $cus_tab->where("FROM_UNIXTIME(pc_atime , '%Y%m%d') = {$today}")->count(),
                '3days'    =>    $cus_tab->where("FROM_UNIXTIME(pc_atime , '%Y%m%d') >= {$_3days}")->count()
            ];

            # 资讯统计
            $art_tab = OBJ('article_table');
            $out['newsStatistic'] = [
                'total'    =>    $art_tab->count(),
                'today'    =>    $art_tab->where("FROM_UNIXTIME(article_adate , '%Y%m%d') = {$today}")->count(),
                '3days'    =>    $art_tab->where("FROM_UNIXTIME(article_adate , '%Y%m%d') >= {$_3days}")->count()
            ];

            # 案例统计
            $case_tab = OBJ('case_table');
            $out['caseStatistic'] = [
                'total'    =>    $case_tab->count(),
                'today'    =>    $case_tab->where("FROM_UNIXTIME(case_adate , '%Y%m%d') = {$today}")->count(),
                '3days'    =>    $case_tab->where("FROM_UNIXTIME(case_adate , '%Y%m%d') >= {$_3days}")->count()
            ];

            # 浏览统计
            $view_tab = OBJ('stat_table');
            $out['viewStatistic'] = [
                'total'    =>    $view_tab->count(),
                'today'    =>    $view_tab->where("FROM_UNIXTIME(stat_adate , '%Y%m%d') = {$today}")->count(),
                '3days'    =>    $view_tab->where("FROM_UNIXTIME(stat_adate , '%Y%m%d') >= {$_3days}")->count()
            ];

            if ( $month > 1 ) {
                for ( $m=1 ; $m<=$month; $m++ ) {
                    if ( $m < 10 ) {
                        $_m = date('Y') .'0' . $m;
                    }else{
                        $_m = date('Y') . $m;
                    }
                    $out['customerStatistic']['xAxis'][$m] = $out['newsStatistic']['xAxis'][$m] = $out['caseStatistic']['xAxis'][$m] = $out['viewStatistic']['xAxis'][$m]= $m . '月';

                    $out['customerStatistic']['data'][$m] = $cus_tab->where("FROM_UNIXTIME(pc_atime , '%Y%m') = {$_m}")->count();
                    $out['newsStatistic']['data'][$m] = $art_tab->where("FROM_UNIXTIME(article_adate , '%Y%m') = {$_m}")->count();
                    $out['caseStatistic']['data'][$m] = $case_tab->where("FROM_UNIXTIME(case_adate , '%Y%m') = {$_m}")->count();
                    $out['viewStatistic']['data'][$m] = $view_tab->where("FROM_UNIXTIME(stat_adate , '%Y%m') = {$_m}")->count();
                }
            }
            return $out;
        }, 300));
    }
}