<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" {if $_config.manager_direction EQ 'rtl'}dir="rtl"{/if} lang="{$_config.manager_lang_attribute}" xml:lang="{$_config.manager_lang_attribute}">
<head>
<title>MODX :: {if $_pagetitle}{$_pagetitle}{else}{$_config.site_name}{/if}</title>
<meta http-equiv="Content-Type" content="text/html; charset={$_config.modx_charset}" />

{if $_config.manager_favicon_url}<link rel="shortcut icon" type="image/x-icon" href="{$_config.manager_favicon_url}" />{/if}

<link rel="stylesheet" type="text/css" href="{$_config.manager_url}min/?f={$_config.manager_url}assets/ext3/resources/css/ext-all-notheme-min.css,{$_config.manager_url}templates/default/css/xtheme-modx.css,{$_config.manager_url}templates/default/css/index.css" />

<script src="{$_config.manager_url}min/?f={$_config.manager_url}assets/ext3/adapter/ext/ext-base.js,{$_config.manager_url}assets/ext3/ext-all.js,{$_config.manager_url}assets/modext/core/modx.js" type="text/javascript"></script>
<script src="{$_config.connectors_url}lang.js.php?ctx=mgr&topic=topmenu,file,resource,{$_lang_topics}&action={$smarty.get.a|strip_tags}" type="text/javascript"></script>
<script src="{$_config.connectors_url}layout/modx.config.js.php?action={$smarty.get.a|strip_tags}{if $_ctx}&wctx={$_ctx}{/if}" type="text/javascript"></script>

{$maincssjs}
{foreach from=$cssjs item=scr}
{$scr}
{/foreach}

<!--[if IE]>
<style type="text/css">body { behavior: url("{$_config.manager_url}templates/default/css/csshover3.htc"); }</style>
<link rel="stylesheet" type="text/css" href="{$_config.manager_url}templates/default/css/ie.css" />
<![endif]-->
</head>
<body id="modx-body-tag">

<div id="modx-browser"></div>
<div id="modx-container">
    <div id="modx-mainpanel">
        <div id="modx-header">
            <div id="modx-topbar">
                <div id="modx-logo"><a href="http://modx.com" onclick="window.open(this.href); return false;"><img src="templates/default/images/style/modx-logo-header.png" alt="" /></a></div>
                <div id="modx-site-name">
                    {$_config.site_name}
                    <span class="modx-version">MODX Revolution {$_config.settings_version} ({$_config.settings_distro})</span>
                </div>
            </div>
            <div id="modx-navbar">
                <div id="rightlogin">
                <span>
                    <a class="modx-logout" href="javascript:;" onclick="MODx.logout();">{$_lang.logout}</a>
                    <a id="modx-login-user" href="?a={$profileAction}">{$username}</a>
                </span>
                </div>
                {include file="navbar.tpl"}
            </div>
        </div>
        
        <div id="modAB"></div>
        <div id="modx-leftbar"></div>
        <div id="modx-content">
            <div id="modx-panel-holder"></div>
