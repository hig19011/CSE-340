<?php 

  session_start();

  /**
   * This function takes the initial parameters for the page and applies them to the template
   * 
   * @param string $pTitle  The title of the page (i.e. show in the tab).
   * @param string $pContentPath  The path the pages body content.
   * @param string $templatePath  The path to the template to apply to the page.
   */

  function init($title, $contentPath, $templatePath){
    $_SESSION['pageTitle'] = $title;
    $_SESSION['contentPath'] = $_SERVER['DOCUMENT_ROOT'].$contentPath;
    $_SESSION['contentPath'] = $_SERVER['DOCUMENT_ROOT'].'/phpmotors/'.$contentPath;
   
    include($_SERVER['DOCUMENT_ROOT'].'/phpmotors/'.$templatePath);
  }

?>