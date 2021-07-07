<?php 
session_start();

if(isset($_POST['product_cat'])) {
  $baseTerm = filter_var($_POST['base_term'], FILTER_SANITIZE_STRING);
  // Define the base URL to use with the search terms
  $baseURL = "/product-category/".$baseTerm;
  if($baseURL) {
    // Lets get the queried terms
    if(!empty($_POST['product_cat'])) {
      $_SESSION['search_terms'] = $_POST['product_cat'];
      //implode with each havubg a 
      $searchQuery = implode(',', $_POST['product_cat']);
      //$searchQuery = implode('+', $_POST['product_cat']);      
      // Redirect to the base url with the search terms
      $location = rawurlencode($baseURL.'/'.$searchQuery.'/');
      header('Location: '.rawurldecode($location));
    }
    else {
      $_SESSION['search_terms'] = [];
      // Return back to the current URL
      header('Location:'.rawurldecode($baseURL));
    }
  }
} else {
    $baseTerm = filter_var($_POST['base_term'], FILTER_SANITIZE_STRING);
    $baseURL = "/product-category/".$baseTerm.'/';
    header('Location:'.rawurldecode($baseURL));
}
