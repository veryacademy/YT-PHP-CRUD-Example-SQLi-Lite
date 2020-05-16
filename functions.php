<?php
require 'db_connection.php';

//Index Page

function get_all_data(){

global $conn;
$result = mysqli_query($conn,"SELECT * FROM posts");

    if(mysqli_num_rows($result) > 0){

        echo '<div class="col-12 pt-5"><h1>All Posts</h1></div>';        
        
        while($row = mysqli_fetch_assoc($result)){  
        echo'
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" src="https://via.placeholder.com/150x100" alt="Card image cap">
                <div class="card-body">
                    <h4 class=""><a class="text-secondary" href="single.php?id='.$row['id'].'">'.$row['title'].'</a></h4>
                     <p class="card-text">'. htmlspecialchars_decode(substr($row['content'],0,100)) .'...</p>
                    <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                    <a href="single.php?id='.$row['id'].'" class="btn btn-sm btn-outline-primary" role="button" aria-pressed="true">View</a>
                    <a href="update.php?id='.$row['id'].'" class="btn btn-sm btn-outline-secondary" role="button" aria-pressed="true">Edit</a>
                    </div>
                    <small class="text-muted">9 mins</small>
                  </div>
                </div>
              </div>
            </div>
            ';
        }

    }

    else{
        echo "<h3>No posts added yet - come back later</h3>";
    }

}

function get_all_edit_data(){
    global $conn;
    $get_data = mysqli_query($conn,"SELECT * FROM posts");
    if(mysqli_num_rows($get_data) > 0){
        echo '<table>
              <tr>
                <th><h2>Edit Data</h2></th>
              </tr>';
        while($row = mysqli_fetch_assoc($get_data)){
           
            echo '<tr>
            <td>'.$row['title'].'</td>
            <td>
            <a href="update.php?id='.$row['id'].'">Edit</a> |
            <a href="delete.php?id='.$row['id'].'">Delete</a>
            </td>
            </tr>';

        }
        echo '</table>';
    }else{
        echo "<h3>Please add some more posts</h3>";
    }
}

//Insert.php - Insert Data

if(isset($_POST['title']) && isset($_POST['content'])){

    // check title and content empty or not
    if(!empty($_POST['title']) && !empty($_POST['content'])){

        // Escape special characters.
        $title = mysqli_real_escape_string($conn, htmlspecialchars($_POST['title']));
        $content = mysqli_real_escape_string($conn, htmlspecialchars($_POST['content']));  

        // Check if title already exists
        $check_content = mysqli_query($conn, "SELECT 'title' FROM posts WHERE content = '$title'"); 

        if(mysqli_num_rows($check_content) > 0){    
            echo "<h3>This title already exists - please try a different title name</h3>";
        }else{

        // Insert data into database
        $insert_query = mysqli_query($conn,"INSERT INTO posts(title,content) VALUES('$title','$content')");

            //Now check if data has been inserted
            if($insert_query){
                echo "<script>alert('Data inserted');window.location.href = 'index.php';</script>";
                exit;
            }else{
                echo "<h3>Data was not inserted!</h3>";
            }
        }

    }else{
        echo "<h4>Please fill all fields</h4>";
    }

}

//Update.php - Collect Data

function update_get(){
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    global $conn;
    $id = $_GET['id'];
    $get_id = mysqli_query($conn,"SELECT * FROM posts WHERE id='$id'");
        if(mysqli_num_rows($get_id) === 1){
            $row = mysqli_fetch_assoc($get_id);
            return($row);
        }
    } 
}

//Update.php - Update data

if(isset($_POST['update_title']) && isset($_POST['update_content'])){

//check if items are empty

if(!empty($_POST['update_title']) && !empty($_POST['update_content'])){

    // Escape special characters.

    $title = mysqli_real_escape_string($conn, htmlspecialchars($_POST['update_title']));
    $content = mysqli_real_escape_string($conn, htmlspecialchars($_POST['update_content']));

    $id = $_GET['id'];
                        
    $update_query = mysqli_query($conn,"UPDATE posts SET title='$title',content='$content' WHERE id=$id");

    if($update_query){
        echo "<script>alert('Post Updated');window.location.href = 'index.php';</script>";
        exit;
    }else{
        echo "<h3>Sorry, that didn't work</h3>";
    }
}else{
    echo "<h4>Please fill all fields</h4>";
    }
}

//Delete.php

function delete(){
    global $conn;
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        
        $userid = $_GET['id'];
        $delete_user = mysqli_query($conn,"DELETE FROM posts WHERE id='$userid'");
        
        if($delete_user){
            echo "<script>alert('Data Deleted');window.location.href = 'insert.php';</script>";
            exit;
            
        }else{
        echo "I think something went wrong"; 
        }
    }
}
