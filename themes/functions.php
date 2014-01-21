<?php
/**
 * Helpers for theming, available for all themes in their template files and functions.php.
 * This file is included right before the themes own functions.php
 */
 

/**
 * Print debuginformation from the framework.
 */
function get_debug() {
  // Only if debug is wanted.
  $ka = CKarin::Instance();  
  if(empty($ka->config['debug'])) {
    return;
  }
  
  // Get the debug output
  $html = null;
  if(isset($ka->config['debug']['db-num-queries']) && $ka->config['debug']['db-num-queries'] && isset($ka->db)) {
    $flash = $ka->session->GetFlash('database_numQueries');
    $flash = $flash ? "$flash + " : null;
    $html .= "<p>Database made $flash" . $ka->db->GetNumQueries() . " queries.</p>";
  }    
  if(isset($ka->config['debug']['db-queries']) && $ka->config['debug']['db-queries'] && isset($ka->db)) {
    $flash = $ka->session->GetFlash('database_queries');
    $queries = $ka->db->GetQueries();
    if($flash) {
      $queries = array_merge($flash, $queries);
    }
    $html .= "<p>Database made the following queries.</p><pre>" . implode('<br/><br/>', $queries) . "</pre>";
  }    
  if(isset($ka->config['debug']['timer']) && $ka->config['debug']['timer']) {
    $html .= "<p>Page was loaded in " . round(microtime(true) - $ka->timer['first'], 5)*1000 . " msecs.</p>";
  }    
  if(isset($ka->config['debug']['karin']) && $ka->config['debug']['karin']) {
    $html .= "<hr><h3>Debuginformation</h3><p>The content of CLydia:</p><pre>" . htmlent(print_r($ka, true)) . "</pre>";
  }    
  if(isset($ka->config['debug']['session']) && $ka->config['debug']['session']) {
    $html .= "<hr><h3>SESSION</h3><p>The content of CKarin->session:</p><pre>" . htmlent(print_r($ka->session, true)) . "</pre>";
    $html .= "<p>The content of \$_SESSION:</p><pre>" . htmlent(print_r($_SESSION, true)) . "</pre>";
  }    
  return $html;
}


/**
 * Get messages stored in flash-session.
 */
function get_messages_from_session() {
  $messages = CKarin::Instance()->session->GetMessages();
  $html = null;
  if(!empty($messages)) {
    foreach($messages as $val) {
      $valid = array('info', 'notice', 'success', 'warning', 'error', 'alert');
      $class = (in_array($val['type'], $valid)) ? $val['type'] : 'info';
      $html .= "<div class='$class'>{$val['message']}</div>\n";
    }
  }
  return $html;
}


/**
 * Login menu. Creates a menu which reflects if user is logged in or not.
 */
function login_menu() {
  $ka = CKarin::Instance();
  if($ka->user['isAuthenticated']) {
    $items = "<a href='" . create_url('user/profile') . "'><img class='gravatar' src='" . get_gravatar(20) . "' alt=''> " . $ka->user['acronym'] . "</a> ";
    if($ka->user['hasRoleAdministrator']) {
      $items .= "<a href='" . create_url('acp') . "'>acp</a> ";
    }
    $items .= "<a href='" . create_url('user/logout') . "'>logout</a> ";
  } else {
    $items = "<a href='" . create_url('user/login') . "'>login</a> ";
  }
  return "<nav id='login-menu'>$items</nav>";
}


/**
 * Get a gravatar based on the user's email.
 */
function get_gravatar($size=null) {
  return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim(CKarin::Instance()->user['email']))) . '.jpg?r=pg&amp;d=wavatar&amp;' . ($size ? "s=$size" : null);
}


/**
 * Prepend the base_url.
 */
function base_url($url=null) {
  return CKarin::Instance()->request->base_url . trim($url, '/');
}


/**
 * Create a url to an internal resource.
 *
 * @param string the whole url or the controller. Leave empty for current controller.
 * @param string the method when specifying controller as first argument, else leave empty.
 * @param string the extra arguments to the method, leave empty if not using method.
 */
function create_url($urlOrController=null, $method=null, $arguments=null) {
  return CKarin::Instance()->request->CreateUrl($urlOrController, $method, $arguments);
}


/**
 * Prepend the theme_url, which is the url to the current theme directory.
 */
function theme_url($url) {
  $ka = CKarin::Instance();
  return "{$ka->request->base_url}themes/{$ka->config['theme']['name']}/{$url}";
}


/**
 * Return the current url.
 */
function current_url() {
  return CKarin::Instance()->request->current_url;
}


/**
 * Render all views.
 */
function render_views() {
  return CKarin::Instance()->views->Render();
}