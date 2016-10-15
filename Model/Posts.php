<?php
/**
 * Created by Compa for the CompaApp project
 * Date: 13/09/2016
 */

 class Posts
 {
     public $PostId;
     public $Name;
     public $UserId;
     public $UserName;
     public $Category;
     public $Content;
     public $EventDate;
     public $Public;

     public function GetPosts()
     {
         global $DB;
         $stmt = $DB->prepare('SELECT p.PostId, p.Name, p.UserId, p.PostDate, p.Category, p.Content,
         p.Public, p.EventDate, CONCAT (u.FirstName, " ", u.LastName) as UserName
         FROM posts as p
         INNER JOIN users as u ON u.UserId = p.UserId');

         $stmt->setFetchMode(PDO::FETCH_CLASS, 'Posts');
         $stmt->execute();
         return $stmt->fetchAll();
    
     }


 }