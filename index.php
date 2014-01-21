<?php
/**
 * All requests routed through here. This is an overview of what actaully happens during
 * a request.
 *
 * @package KarinCore
 */

// ---------------------------------------------------------------------------------------
//
// PHASE: BOOTSTRAP
//
define('KARIN_INSTALL_PATH', dirname(__FILE__));
define('KARIN_SITE_PATH', KARIN_INSTALL_PATH . '/site');

require(KARIN_INSTALL_PATH.'/src/bootstrap.php');

$ka = CKarin::Instance();


// ---------------------------------------------------------------------------------------
//
// PHASE: FRONTCONTROLLER ROUTE
//
$ka->FrontControllerRoute();


// ---------------------------------------------------------------------------------------
//
// PHASE: THEME ENGINE RENDER
//
$ka->ThemeEngineRender();
