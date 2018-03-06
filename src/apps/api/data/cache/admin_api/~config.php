<?php
/**
 * app api config file 
 * @modified by RGX v1.0.0
 */
 return array (
  'app' => 
  array (
    'lang' => 'zh_cn',
    'timezone' => 8,
  ),
  'tpl' => 
  array (
    'style' => 'default',
    '404_tpl' => '404.tpl',
    'msg_tpl' => 'msg.tpl',
    'ob' => true,
    'native' => false,
    'tpl_pre' => '{',
    'tpl_suf' => '}',
    'cmod' => false,
    'charset' => 'utf-8',
    'allow_php' => false,
  ),
  'cache' => 
  array (
    'type' => 'file',
    'pre' => 'rgx_',
    'file' => 
    array (
    ),
  ),
  'route' => 
  array (
    'def_mod' => 'index',
    'def_act' => 'index',
    'ma_sep' => '/',
    'ap_sep' => '?',
    'pg_sep' => '&',
    'pp_sep' => '=',
    'suf' => '.html',
    'rewrite' => false,
    '404_tpl' => '404.tpl',
  ),
  'log' => 
  array (
    'type' => 'file',
    'file' => 
    array (
      'dev' => false,
    ),
  ),
  'db' => 
  array (
    'pre' => 'pre_',
    'type' => 'mysql',
    'mysql' => 
    array (
      'default' => 'host=192.168.2.188;port=3306;db=ddzz;user=root;passwd=123456;charset=utf8mb4;profiling=1',
    ),
  ),
  'sess' => 
  array (
    'type' => 'php',
    'php' => 
    array (
      'ttl' => 600,
    ),
  ),
);