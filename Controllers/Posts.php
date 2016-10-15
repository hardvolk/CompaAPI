<?php
/**
 * Created by Compa for the CompaApp project
 * Date: 13/09/2016
 */

 require_once dirname(__DIR__) . "/Model/Model.php";

 $Posts = new Posts();
 $allPosts = $Posts->GetPosts();
 echo json_encode($allPosts);
 